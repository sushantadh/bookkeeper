<?php 

include ($CLASS_CONNECTION);

class Functions {
	
	public function login($email,$password) {
		global $pdo;
		if(!empty($email) and !empty($password)) {
			$query=$pdo->prepare("SELECT User_Id,User_Type from user WHERE User_Email='$email' and User_Password='$password'");
			$query->execute();
			$result=$query->fetch();
			if($result) {
			$_SESSION['lib']=array($result['User_Id'],$result['User_Type']);
			 return 0;
			}	
			else if(!$result){

				return 1;
			}
		}
		}

	public function uploadCover($name,$size,$type,$temp_name,$ext,$max_size) {
		   if(!empty ($name)and !empty ($size) and !empty ($type) and !empty ($temp_name) and !empty ($ext) and !empty ($max_size))
	    {
	    	$ext=strtolower($ext);

	        if (($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'||$ext=='bmp')and $size<$max_size and ($type=='image/jpeg' or $type=='image/png' or $type=='image/gif'))
	        {
	        $root=$_SERVER['DOCUMENT_ROOT'];	        	
	        $cover='/library/assets/cover/';
	        $location=$root.$cover;
	        $url='http://localhost';
	       	move_uploaded_file($temp_name,$location.$name);
	        return $url.$cover.$name;
	        }
	        
	    else
	    {
	        return 2;
	    }
	}
	
	}


}
?>