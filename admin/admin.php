<?php 
require ('../config.php');
require ($CLASS_CONNECTION);


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
		} }

  public function isLoggedIn() {
  
  if (isset($_SESSION['lib']) and $_SESSION['lib'][1]==1) {
    return 1;
  }

    else {
      return 0;
    }
  }

  public function fetchByField ($tfield,$table,$field,$arg) {
        global $pdo;
        if(!empty($tfield)&&!empty($table)&&!empty($field)&&!empty($arg)) {
            $query=$pdo->prepare("SELECT $tfield FROM $table WHERE $field='$arg'");
            if($query->execute()) {
                $item=$query->fetch();
                if ($item) {
                    return $item;
                } else {
                    return 1;
                }
            }
        } else {
            return 2;
        } } 

  public function fetchUsers() {
    global $pdo;
        
            $query=$pdo->prepare("SELECT  User_Id, User_Fname,User_Lname,User_Email,User_Type FROM user");
            if($query->execute()) {
                $item=$query->fetchAll();
                if ($item) {
                    return $item;
                } else {
                    return 1;
                }
            }
        } 

  public function deleteUser($id) {
    global $pdo;
        if(!empty($id)) {
            $query=$pdo->prepare("DELETE FROM user WHERE  User_Id='$id'");
            if($query->execute()) {
                return 0;
                } else {
                    return 1;
                }
            }
      } 
  }
?> 