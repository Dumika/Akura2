<?php
include 'Constants.php';
$response = array();
//Check for mandatory parameter movie_id
if(isset($_POST['MId'])){
	$MId = $_POST['MId'];
	$query = "DELETE FROM maintenance WHERE MId=?";
	if($stmt = $con->prepare($query)){
		//Bind movie_id parameter to the query
		$stmt->bind_param("s",$MId);
		$stmt->execute();
		//Check if the movie got deleted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Maintenance record got deleted successfully";
			
		}else{
			$response["success"] = 0;
			$response["message"] = "Maintenance record not found";
		}					
	}else{
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}
 
}else{
	$response["success"] = 0;
	$response["message"] = "missing parameter Maintenance Id";
}
echo json_encode($response);
?>