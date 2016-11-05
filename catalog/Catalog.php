<?php
include ('../includes/conn.php');
class catalog {
	


	public function fetchByField ($field,$arg) {

		global $pdo;

		if(!empty($field)&&!empty($arg)) {

                        $query=$pdo->prepare("SELECT * FROM book WHERE $field='$arg'");
                 
                        if($query->execute()) {
                        	$item=$query->fetchAll();
                        	if ($item) {
                        		foreach ($item as $book) {
                        			echo $book['Book_Title'];
                        		 }
                        		}   
                        		
                        	else {
                        		echo 'No results found';
                        	}
                        	}
                        	else {
                        		echo 'error excecuting query';
                        	}
                        }
                    }

    public function fetchById ($arg) {

		global $pdo;

		if(!empty($arg)) {

                        $query=$pdo->prepare("SELECT * FROM book WHERE Book_Id='$arg'");
                 
                        if($query->execute()) {
                        	$item=$query->fetch();
                        	if ($item) {
                           			echo $item['Book_Title'];
                        	            		}   
                        		
                        	else {
                        		echo 'No results found';
                        	}
                        	}
                        	else {
                        		echo 'error excecuting query';
                        	}
                        }
                    }




                }

?>