<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(isset($_POST['SerialNo'])&&isset($_POST['Software'])&&isset($_POST['ProductKey'])&&isset($_POST['RDate'])&&isset($_POST['Warranty'])&&isset($_POST['PDate'])&&isset($_POST['PDetails'])){
	$SerialNo = $_POST['SerialNo'];
	$Software = $_POST['Software'];
	$ProductKey = $_POST['ProductKey'];
	$RDate = $_POST['RDate'];
	$Warranty = $_POST['Warranty'];
	$PDate = $_POST['PDate'];
	$PDetails = $_POST['PDetails'];
	
	//Query to update a movie
	$query = "UPDATE soft SET Software=?,ProductKey=?,RDate=?,Warranty=?,PDate=?,PDetails=? WHERE SerialNo=?";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("sssisss",$Software,$ProductKey,$RDate,$Warranty,$PDate,$PDetails,$SerialNo);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got updated
		if($stmt->affected_rows ==1){
			$response["success"] = 1;			
			$response["message"] = "Soft asset successfully updated";
			
		}else{
			//When movie is not found
			$response["success"] = 0;
			$response["message"] = "Soft asset not found";
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