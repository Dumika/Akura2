<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(isset($_POST['SerialNo'])&&isset($_POST['Type'])&&isset($_POST['Section'])&&isset($_POST['PersonInCharge'])&&isset($_POST['Quantity'])&&isset($_POST['Supplier'])){
	$SerialNo = $_POST['SerialNo'];
	$Type = $_POST['Type'];
	$Section = $_POST['Section'];
	$PersonInCharge = $_POST['PersonInCharge'];
	$Quantity = $_POST['Quantity'];
	$Supplier = $_POST['Supplier'];
	
	//Query to update a movie
	$query = "UPDATE item SET Type=?,Section=?,PersonInCharge=?,Quantity=?,Supplier=? WHERE SerialNo=?";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("sssiss",$Type,$Section,$PersonInCharge,$Quantity,$Supplier,$SerialNo);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got updated
		if($stmt->affected_rows ==1){
			$response["success"] = 1;			
			$response["message"] = "Movie successfully updated";
			
		}else{
			//When movie is not found
			$response["success"] = 0;
			$response["message"] = "Movie not found";
		}					
	}else{
		//Some error while updating
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}
 
}else{
	//Mandatory parameters are missing
	$response["success"] = 0;
	$response["message"] = "missing mandatory parameters";
}
//Displaying JSON response
echo json_encode($response);
?>