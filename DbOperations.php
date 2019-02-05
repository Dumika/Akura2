
 <?php 
 
    class DbOperations{
 
        private $con; 
 
        function __construct(){
 
            require_once dirname(__FILE__).'/DbConnect.php';
 
            $db = new DbConnect();
 
            $this->con = $db->connect();
 
        }
 
        /*CRUD -> C -> CREATE */
 
         function createUser($fullname, $username, $password){
            if($this->isUserExist($username, $password)){
                return 0; 
            }else{    
                $password = md5($password);
                $stmt = $this->con->prepare("INSERT INTO `users` (`userid`, `fullname`, `username`, `password`) VALUES (NULL, ?, ?, ?);");
                $stmt->bind_param("sss",$fullname, $username, $password);
 
                if($stmt->execute()){
                    return 1; 
                }else{
                    return 2; 
                }
		 }}
		 public function userLogin($username, $password){
            $password = md5($password);
            $stmt = $this->con->prepare("SELECT userid FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss",$username,$password);
            $stmt->execute();
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
		public function getUserByUsername($username){
            $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s",$username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
		
			 private function isUserExist($username, $password){
            $stmt = $this->con->prepare("SELECT userid FROM users WHERE username = ? OR password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
       }
	   
	   
  //handle user login
  
    /*   public function userLogin($username, $pass){
            $password = md5($pass);
            $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("si",$username,$password);
            $stmt->execute();
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
		
		//get user details after login
 
        public function getUserByUsername($username){
            $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s",$username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
         
 
        private function isUserExist($username, $password){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
 
    }*/