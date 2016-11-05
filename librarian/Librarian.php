<?php
require ('../includes/conn.php');

class Librarian {
	
	public function isLoggedIn() {
  
  if (isset($_SESSION['lib']) and $_SESSION['lib'][1]==2) {
    return 1;
  }

    else {
      return 0;
    }
  }  

  public function addBook($b_title,$b_author,$b_publisher,$b_pubDate,$b_genere,$b_cover,$b_disc,$b_count) {

		global $pdo;

		if(!empty($b_title)&&!empty($b_author)&&!empty($b_publisher)&&!empty($b_pubDate)&&!empty($b_genere)&&!empty($b_disc)&&!empty($b_count)) {

                        $query=$pdo->prepare("SELECT count(*) FROM book WHERE Book_Title='$b_title' and Book_Author='$b_author' and Book_Publisher='$b_publisher'");
                        $query->execute();
                        
                        if($query->fetchColumn())
                           {
                               return 1;
                           }
                        else
                           {
                            
                           $query=$pdo->prepare("INSERT INTO book VALUES ('','$b_title','$b_author','$b_publisher','$b_pubDate','$b_genere','$b_cover','$b_disc','$b_count')");

                            if ($query->execute()) {
                            return 0;	 
                        } 
                        else {
                        	print_r($query->errorInfo());
                        }
           
                            
                
                           }
                    }

                    else
                    {
                    	return 2;
                    }
		}

	}
?>