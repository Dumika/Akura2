<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(empty($_POST['MId'])||empty($_POST['Type'])||empty($_POST['SProvider'])||empty($_POST['Date'])||empty($_POST['Payment'])||empty($_POST['Description'])){
	//Mandatory parameters are missing
	$response["success"] = 0;
	$response["message"] = "missing mandatory parameters";
 
}else{
	
	$MId = $_POST['MId'];
	$Type = $_POST['Type'];
	$SProvider = $_POST['SProvider'];
	$Date = $_POST['Date'];
	$Payment = $_POST['Payment'];
	$Description = $_POST['Description'];
	
	//Query to insert a movie
	$query = "INSERT INTO maintenance( MId, Type, SProvider, Date, Payment, Description) VALUES (?,?,?,?,?,?)";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("ssssis",$MId,$Type,$SProvider,$Date,$Payment,$Description);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got inserted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Maintenance Successfully Added ";			
			
		}else{
			//Some error while inserting
			$response["success"] = 0;
			$response["message"] = "Error while adding soft asset";
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