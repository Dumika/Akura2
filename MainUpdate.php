<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(isset($_POST['MId'])&&isset($_POST['Type'])&&isset($_POST['SProvider'])&&isset($_POST['Date'])&&isset($_POST['Payment'])&&isset($_POST['Description'])){
	$MId = $_POST['MId'];
	$Type = $_POST['Type'];
	$SProvider = $_POST['SProvider'];
	$Date = $_POST['Date'];
	$Payment = $_POST['Payment'];
	$Description = $_POST['Description'];
	
	//Query to update a movie
	$query = "UPDATE maintenance SET Type=?,SProvider=?,Date=?,Payment=?,Description=? WHERE MId=?";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("sssiss",$Type,$SProvider,$Date,$Payment,$Description,$MId);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got updated
		if($stmt->affected_rows ==1){
			$response["success"] = 1;			
			$response["message"] = "Maintenance record successfully updated";
			
		}else{
			//When movie is not found
			$response["success"] = 0;
			$response["message"] = "Maintenance record not found";
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