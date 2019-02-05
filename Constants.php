<?php 
    define('DB_NAME','android');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_HOST','localhost');
	
	//define('DB_NAME','assets_tracker');
    //define('DB_USER','root');
    //define('DB_PASSWORD','udara@fl');
    //define('DB_HOST','206.189.18.132');
	
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
// Check connection
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>