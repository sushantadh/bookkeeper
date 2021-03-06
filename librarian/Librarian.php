<?php
require ($CLASS_CONNECTION);

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

                          $time=time();
                          $query=$pdo->prepare("SELECT count(*) FROM book WHERE Book_Title='$b_title' and Book_Author='$b_author' and Book_Publisher='$b_publisher'");
                          $query->execute();
                          
                          if($query->fetchColumn())
                             {
                                 return 1;
                             }
                          else
                             {
                              
                             $query=$pdo->prepare("INSERT INTO book VALUES ('','$b_title','$b_author','$b_publisher','$b_pubDate','$b_genere','$b_cover','$b_disc','$b_count','$b_count','$time')");

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

  private function checkBookCount($bookId) {
    global $pdo;

          if(!empty($bookId)) {
              $query=$pdo->prepare("SELECT Book_Count FROM book WHERE Book_Id='$bookId'");
              if($query->execute()) {
                  $item=$query->fetch();
                   if ($item) {
                      return $item['Book_Count'];
                  } else {
                      echo '<br>error - no book count';
                  }
              }
          } else {
               echo '<br>error - book count query';
          }
    }

  private function removeRequest($requestId) {
    global $pdo;

          if(!empty($requestId)) {
              $query=$pdo->prepare("DELETE FROM book_request WHERE Request_Id='$requestId'");
              if($query->execute()) {
                  return 0;
                  } else {
                      return 1;
                  }
              }
            }

  private function removeReturn($returnId) {
    global $pdo;

          if(!empty($returnId)) {
              $query=$pdo->prepare("DELETE FROM book_return WHERE   Return_Id='$returnId'");
              if($query->execute()) {
                  echo '<br>deleted from return table';
                  } else {
                      echo '<br>error - detele from return query';
                  }
              }
            }

  private function grantRequest($userId,$bookId,$bdate,$ddate) {
    global $pdo;
    $query=$pdo->prepare("INSERT INTO book_borrowed VALUES ('','$userId','$bookId','$bdate','$ddate')");
          
    if ($query->execute()) {
      echo'request granted';  
      } 
      
    else {
      print_r($query->errorInfo());
      }
    }

  private function updateBookCount($bookId,$newBookCount) {
    global $pdo;

        $query=$pdo->prepare("UPDATE book SET Book_Count=$newBookCount WHERE Book_Id=$bookId");

        if ($query->execute()) {
                echo '<br>book count decremented';  
      } 
      
      else {
        print_r($query->errorInfo());
      }
    }

    private function checkMaxCount($bookId) {
      global $pdo;
      if(!empty($bookId)) {
              $query=$pdo->prepare("SELECT Max_Avilable FROM book WHERE Book_Id='$bookId'");
              if($query->execute()) {
                  $item=$query->fetch();
                   if ($item) {
                      return $item['Max_Avilable'];
                  } else {
                      echo '<br>error - no max count';
                  }
              }
          } else {
               echo '<br>error - max count query';
          }

      }

  private function getBorrowCount($userId) {
    global $pdo;
          if(!empty($userId)) {
              $query=$pdo->prepare("SELECT Borrow_count FROM user WHERE User_Id='$userId'");
              if($query->execute()) {
                  $item=$query->fetch();
                   if ($item) {
                      return $item['Borrow_count'];
                  } else {
                      echo '<br>error - no borrow count';
                  }
              }
          } else {
               echo '<br>error -  borrow count query';
          }
        }

  private function decreaseBorrowCount($userId, $newBorrowCount) {
    global $pdo;

        $query=$pdo->prepare("UPDATE user SET Borrow_count=$newBorrowCount WHERE User_Id=$userId");

        if ($query->execute()) {
                echo '<br>request count decremented';  
      } 
      
      else {
        print_r($query->errorInfo());
      }
    }

  public function denyRequest($requestId,$userId) {
    $borrowCount=$this->getBorrowCount($userId);

      $newBorrowCount=(int)$borrowCount-1;
      if ($newBorrowCount<0) {
        $newBorrowCount=0;
      }

      $decBorrow=$this->decreaseBorrowCount($userId, $newBorrowCount); 
      $removeRequest=$this->removeRequest($requestId);
      return 0;
  }

  public function issueBook($requestId,$userId,$bookId) {
    $bookCount=$this->checkBookCount($bookId);
    // echo '<br>Book count '. $bookCount;
        
    if($bookCount<=0) {
      // echo 'Book not avilable';
      $deny=$this->denyRequest($requestId,$userId);      
      return 1;
    } 

    else {
        $removeRequest=$this->removeRequest($requestId);
        $bdate=time();
        $ddate=(int)$bdate+(15*24*60*60);
        
        $grantRequest=$this->grantRequest($userId,$bookId,$bdate,$ddate);
        $newBookCount=(int)$bookCount-1;
        if($newBookCount<0) {
          $newBookCount=0;
        }
        $updateBookCount=$this->updateBookCount($bookId,$newBookCount);
        return 0;
        //successful
      }
    } 

  public function approveReturn($returnId,$userId,$bookId) {
    $removeReturn=$this->removeReturn($returnId);
    $bookCount=$this->checkBookCount($bookId);
    $maxCount=$this->checkMaxCount($bookId);
    $newBookCount=(int)$bookCount+1;
    if($newBookCount>$maxCount) {
      $newBookCount=$maxCount;
    }
    $this->updateBookCount($bookId,$newBookCount);
    $borrowCount=$this->getBorrowCount($userId);
    $newBorrowCount=(int)$borrowCount-1;
    if ($newBorrowCount<0) {
      $newBorrowCount=0;
    }

    $decBorrow=$this->decreaseBorrowCount($userId, $newBorrowCount); 
    return 0;
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

  public function fetchRequests() {
    global $pdo;
    $sql = "SELECT BR.Request_Id,BR.R_User,BR.R_Book,BR.Requested_Date,B.Book_Title,B.Book_Count,U.User_Fname FROM book_request BR,book B,user U WHERE BR.R_Book=B.Book_Id AND BR.R_User=U.User_Id ORDER BY BR.Requested_Date ASC";
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

  public function fetchReturn() {
    global $pdo;
    $sql = "SELECT BR.Return_Id,BR.R_User,BR.R_Book,BR.Return_Date,B.Book_Title,U.User_Fname FROM book_return BR,book B,user U WHERE BR.R_Book=B.Book_Id AND BR.R_User=U.User_Id ORDER BY BR.Return_Date ASC";
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

  public function fetchBooks() {
    global $pdo;
    $sql = "SELECT * FROM book ORDER BY Date_Added DESC";
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


  public function deleteBook($Id) {
    global $pdo;

          if(!empty($Id)) {
              $query=$pdo->prepare("DELETE FROM book WHERE Book_Id='$Id'");
              if($query->execute()) {
                  return 0;
                  } else {
                      return 1;
                  }
              }
            }

  public function nav() {
    if($this->isLoggedIn()==1) {

      echo'<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="../titles.php">Titles</a></li>
        <li><a href="../authors.php">Authors</a></li> 
        <li><a href="../publishers.php">Publishers</a></li>
        <li><a href="../generes.php">Geners</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
        <li><a href="add_book.php"><span class="glyphicon glyphicon-book"></span> Add Book</a></li>
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>';
    }

    else {
        echo'<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="../titles.php">Titles</a></li>
        <li><a href="../authors.php">Authors</a></li> 
        <li><a href="../publishers.php">Publishers</a></li>
        <li><a href="../generes.php">Geners</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>';
    }

}
}
?>