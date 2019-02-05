<?php
include 'Constants.php';
$response = array();
//Check for mandatory parameter movie_id
if(isset($_POST['SerialNo'])){
	$SerialNo = $_POST['SerialNo'];
	$query = "DELETE FROM item WHERE SerialNo=?";
	if($stmt = $con->prepare($query)){
		//Bind movie_id parameter to the query
		$stmt->bind_param("s",$SerialNo);
		$stmt->execute();
		//Check if the movie got deleted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Item got deleted successfully";
			
		}else{
			$response["success"] = 0;
			$response["message"] = "Item not found";
		}					
	}else{
		$response["success"] = 0;
		$response["message"] = mysqli_error($con);
	}
 
}else{
	$response["success"] = 0;
	$response["message"] = "missing parameter Serial No";
}
echo json_encode($response);
?>