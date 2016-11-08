<?php
include ($CLASS_CONNECTION);
class Catalog {
	
    public function fetchField($tfield,$table) {
        global $pdo;
        if(!empty($tfield)&&!empty($table)) {
            $query=$pdo->prepare("SELECT DISTINCT $tfield FROM $table");
            if($query->execute()) {
                $item=$query->fetchAll();
                if ($item) {
                    return $item;
                } else {
                    return 1;
                }
            }
        } else {
            return 2;
        } }

    public function fetchByField ($tfield,$table,$field,$arg) {
        global $pdo;
        if(!empty($tfield)&&!empty($table)&&!empty($field)&&!empty($arg)) {
            $query=$pdo->prepare("SELECT $tfield FROM $table WHERE $field='$arg'");
            if($query->execute()) {
                $item=$query->fetchAll();
                if ($item) {
                    return $item;
                } else {
                    return 1;
                }
            }
        } else {
            return 2;
        } }
         
    

    public function fetchById ($arg) {

		global $pdo;

		if(!empty($arg)) {

                        $query=$pdo->prepare("SELECT * FROM book WHERE Book_Id='$arg'");
                 
                        if($query->execute()) {
                        	$item=$query->fetch();
                        	if ($item) {
                           			return $item;
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


    public function fetchLatest($tfield,$table,$sfield,$arg) {
        global $pdo;
        if(!empty($tfield)&&!empty($table)&&!empty($sfield)&&!empty($arg)) {
            $query=$pdo->prepare("SELECT $tfield FROM $table ORDER BY $sfield $arg LIMIT 3");
            if($query->execute()) {
                $item=$query->fetchAll();
                if ($item) {
                    return $item;
                } else {
                    return 1;
                }
            }
        } else {
            return 2;
        } 

    }
} 

?>