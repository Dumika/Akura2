<?php
include 'Constants.php';
$response = array();
 
//Check for mandatory parameters
if(empty($_POST['Name'])||empty($_POST['AType'])||empty($_POST['Start'])||empty($_POST['End'])||empty($_POST['Quantity'])||empty($_POST['Grade'])||empty($_POST['Period'])){
	//Mandatory parameters are missing
	$response["success"] = 0;
	$response["message"] = "missing mandatory parameters";
 
}else{
	
	$Name = $_POST['Name'];
	$AType = $_POST['AType'];
	$Start = $_POST['Start'];
	$End = $_POST['End'];
	$Quantity = $_POST['Quantity'];
	$Grade = $_POST['Grade'];
	$Period = $_POST['Period'];
	
	//Query to insert a movie
	$query = "INSERT INTO genres( Name, AType, Start, End, Quantity, Grade, Period) VALUES (?,?,?,?,?,?,?)";
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("ssssiss",$Name,$AType,$Start,$End,$Quantity,$Grade,$Period);
		//Exceting MySQL statement
		$stmt->execute();
		//Check if data got inserted
		if($stmt->affected_rows == 1){
			$response["success"] = 1;			
			$response["message"] = "Reservation Successfully Submitted ";			
			
		}else{
			//Some error while inserting
			$response["success"] = 0;
			$response["message"] = "Error while submitting";
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