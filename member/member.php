<?php
require ('../includes/conn.php');

class Member {
	
	public function isLoggedIn() {
  
  if (isset($_SESSION['lib']) and $_SESSION['lib'][1]==3) {
    return 1;
  }

    else {
      return 0;
    	}
 	}
 }  