<?php
require ($CLASS_CONNECTION);

class Member {
	
  public function isLoggedIn() {
  
    if (isset($_SESSION['lib']) and $_SESSION['lib'][1]==3) {
      return 1;
    }

      else {
        return 0;
      	} }

  private function checkLimit($userId) {
    global $pdo;

    if(!empty($userId)) {
      $query=$pdo->prepare("SELECT Borrow_count FROM user WHERE User_Id='$userId'");
      if($query->execute()) {
        $item=$query->fetch();
        if ($item) {
          return $item['Borrow_count'];
        } else {
          return 'error';
        }
      }
    } else {
      return 'error';
    } }

  private function grantRequest($userId,$bookId) {
    global $pdo;
  	$timestamp=time();
  	$query=$pdo->prepare("INSERT INTO book_request VALUES ('','$userId','$bookId','$timestamp')");
          
    if ($query->execute()) {
      return 0;	 
    } 
    else {
  	 print_r($query->errorInfo());
    } }

  private function updateBorrowCount($userId,$borrow_count_new) {
    global $pdo;
    $query=$pdo->prepare("UPDATE user SET Borrow_count=$borrow_count_new WHERE User_Id=$userId");
    if ($query->execute()) {
      return 0;	
    } 
    else {
  			print_r($query->errorInfo());
      } }

  private function deleteFromBorrowed($borrowId) {

    global $pdo;

          if(!empty($borrowId)) {
              $query=$pdo->prepare("DELETE FROM book_borrowed WHERE Borrow_Id='$borrowId'");
              if($query->execute()) {
                  echo '<br>deleted from borrow table';
                  } else {
                      echo '<br>error - detele from borrow query';
                  }
              } 
            }

  private function returnReq($userId,$bookId,$timestamp) {
    global $pdo;
    $query=$pdo->prepare("INSERT INTO book_return VALUES ('','$userId','$bookId','$timestamp')");
          
    if ($query->execute()) {
      return 0;  
      } 
      
    else {
      return 1;
      }
    }
  
  public function requestBook($userId,$bookId) {
    $borrow_count=$this->checkLimit($userId);

    if($borrow_count<3) {
      $borrow_count_new=(int)$borrow_count+1;
      $grant=$this->grantRequest($userId,$bookId);

      if($grant==0) {
        $updateBorrowCount=$this->updateBorrowCount($userId,$borrow_count_new);

        if($updateBorrowCount==0) {
          return 0; //success
        }
      }
    }
    else {
      return 1; //borrow count exceeded
    } } 

  public function returnBook($borrowId,$userId,$bookId) {
    $delete=$this->deleteFromBorrowed($borrowId);
    $timestamp=time();
    $returnReq=$this->returnReq($userId,$bookId,$timestamp);
    if($returnReq==0) {
      return 0;
    }
    else if($returnReq==1) {
      return 1;
    } }


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

  public function fetchBorrow($id) {
    global $pdo;
    $sql = "SELECT BR.Borrow_Id,BR.B_User,BR.B_Book,B.Book_Title FROM book_borrowed BR,book B WHERE BR.B_Book=B.Book_Id AND BR.B_User='$id'";
     $query=$pdo->prepare($sql);

     if($query->execute()) {
                $item=$query->fetchAll();
                if ($item) {
                    return $item;
                } else {
                    return 1; //no item
                }
            } 
          }


  }
?>  