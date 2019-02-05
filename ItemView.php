<?php
include 'Constants.php';
$itemArray = array();
$response = array();

//Check for mandatory parameter movie_id
if(isset($_GET['SerialNo'])){
	$SerialNo = $_POST['SerialNo'];
	//Query to fetch movie details
	$query = "SELECT SerialNo, Type, Section, PersonInCharge,Quantity,Supplier FROM item WHERE SerialNo=?";
	
	
	if($stmt = $con->prepare($query)){
		//Bind movie_id parameter to the query
		$stmt->bind_param("s",$SerialNo);
		$stmt->execute();
		
		//Bind fetched result to variables $movieName, $genre, $year and $rating
		$stmt->bind_result($SerialNo,$Type,$Section,$PersonInCharge,$Quantity,$Supplier);
		//Check for results		
		if($stmt->fetch()){
			//Populate the movie array
			$itemArray["SerialNo"] = $SerialNo;
			$itemArray["Type"] = $Type;
			$itemArray["Section"] = $Section;
			$itemArray["PersonInCharge"] = $PersonInCharge;
			$itemArray["Quantity"] = $Quantity;
			$itemArray["Supplier"] = $Supplier;
			
			$response["success"] = 1;
			$response["data"] = $itemArray;
		
		
		}else{
			//When movie is not found
			$response["success"] = 0;
			$response["message"] = "Item not found";
		}
		$stmt->close();
 
 
	}else{
		//Whe some error occurs
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
		
	}
 
}else{
	//When the mandatory parameter movie_id is missing
	$response["success"] = 0;
	$response["message"] = "missing parameter Serial No";
}
//Display JSON response
echo json_encode($response);
?>