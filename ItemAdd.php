<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(empty($_POST['SerialNo'])||empty($_POST['Type'])||empty($_POST['Section'])||empty($_POST['PersonInCharge'])||empty($_POST['Quantity'])||empty($_POST['Supplier'])){
	//Mandatory parameters are missing
	$response["success"] = 0;
	$response["message"] = "missing mandatory parameters";
 
}else{
	
	$SerialNo = $_POST['SerialNo'];
	$Type = $_POST['Type'];
	$Section = $_POST['Section'];
	$PersonInCharge = $_POST['PersonInCharge'];
	$Quantity = $_POST['Quantity'];
	$Supplier = $_POST['Supplier'];
	
	//Query to insert a movie
	$query = "INSERT INTO item( SerialNo, Type, Section, PersonInCharge, Quantity, Supplier) VALUES (?,?,?,?,?,?)";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("ssssis",$SerialNo,$Type,$Section,$PersonInCharge,$Quantity,$Supplier);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got inserted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Item Successfully Added ";			
			
		}else{
			//Some error while inserting
			$response["success"] = 0;
			$response["message"] = "Error while adding item";
		}					
	}else{
		//Some error while inserting
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}
	
	
	
}
//Displaying JSON response
echo json_encode($response);    


?>