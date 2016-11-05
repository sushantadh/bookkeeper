<?php 
require ('../includes/conn.php');

class LibAdmin {
	
	public function addUser($f_name,$l_name,$email,$password,$pass_again,$utype) {
		global $pdo;

		if(!empty($email)&&!empty($password)&&!empty($pass_again)&&!empty($f_name)&&!empty($l_name)) {
			
			if($password!=$pass_again)
                    {
                        return 1;
                    }
                    else
                    {
                        $query=$pdo->prepare("SELECT count(*) FROM user WHERE User_Email='$email'");
                        $query->execute();
                        
                        if($query->fetchColumn())
                           {
                               return 2;
                           }
                        else
                           {
                             $password_hash=md5($password);
                            
                            $query=$pdo->prepare("INSERT INTO user VALUES ('','$f_name','$l_name','$email','$password_hash','$utype','')");
                            if ($query->execute()) {
                            return 0;	 
                        } 
                        else {
                        	print_r($query->errorInfo());
                        }
           
                            
                
                           }
                    }
		}
  }

public function isLoggedIn() {
  
  if (isset($_SESSION['lib']) and $_SESSION['lib'][1]==1) {
    return 1;
  }

    else {
      return 0;
    }
  } 
}
?> 