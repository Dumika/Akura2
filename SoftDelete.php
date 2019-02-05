<?php
include 'Constants.php';
$response = array();
//Check for mandatory parameter movie_id
if(isset($_POST['SerialNo'])){
	$SerialNo = $_POST['SerialNo'];
	$query = "DELETE FROM soft WHERE SerialNo=?";
	if($stmt = $con->prepare($query)){
		//Bind movie_id parameter to the query
		$stmt->bind_param("s",$SerialNo);
		$stmt->execute();
		//Check if the movie got deleted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Soft asset got deleted successfully";
			
		}else{
			$response["success"] = 0;
			$response["message"] = "Soft asset not found";
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