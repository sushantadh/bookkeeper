<?php 
require('../config.php');
include($CLASS_LIBRARIAN);
$librarian=new Librarian;

$loggedin=$librarian->isLoggedIn();

$id=$_SESSION['lib'][0];
  $getname=$librarian->fetchByField ('User_Fname','user','User_Id',$id);
  $name=$getname['User_Fname'];
  
$requests=$librarian->fetchRequests();
$return_data=$librarian->fetchReturn();
$books=$librarian->fetchBooks();

if(isset($_GET['issue'])) {
  $issue=$_GET['issue'];
}

if(isset($_GET['return'])) {
  $return=$_GET['return'];
}

if(isset($_GET['deny'])) {
  $deny=$_GET['deny'];
}

if(isset($_GET['bdelete'])) {
  $bdelete=$_GET['bdelete'];
}
?>

<html lang="en">
    <head>
    <title>Online Library - Librarian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../stylesheet/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="page-header myhead"><Center>ONLINE LIBRARY</Center></div>

    <?php $librarian->nav(); ?>
      <div class="img-head"> 
      <img class="img-responsive" src="../assets/head.jpg">
    </div>
<!-- --------------------END OF HEADER ----------------------------------- !-->

    <div class="container">
      <?php if ($loggedin==0) {
      echo'<div id="legend">
      <legend class="ctitle">Please Login as Librarian</legend>
      </div><div></div><div class="panel panel-default">
  <div class="panel-body"> <center>Onine Library &copy; 2016 </center></div>
    </div>'; 
    die();
    } ?>
    <div id="legend">
      <legend class="ctitle"><?php echo 'Welcome '.$name; ?></legend>
      </div> 

      <?php
        if (isset($issue) and $issue==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Book not avilable !</strong></div> '; }

        else if (isset($issue) and $issue==0) {
          echo '<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Book Issued !</strong></div> '; }
      ?>

      <?php
        if (isset($return) and $return==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Return not successful </strong></div> '; }

        else if (isset($return) and $return==0) {
          echo '<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Return Successful </strong></div> '; }
      ?>

      <?php
        if (isset($deny) and $deny==0) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Request Denied! </strong></div> '; }
      ?>

      <?php
        if (isset($bdelete) and $bdelete==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Could Not delete Book !</strong></div> '; }

        else if (isset($bdelete) and $bdelete==0) {
          echo '<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Book Deleted !</strong></div> '; }
      ?>

     <div class="col-md-3"> 
  <ul class="nav nav-pills nav-stacked">
  <li class="active"><a data-toggle="tab" href="#books">Book List</a></li>
  <li><a data-toggle="tab" href="#borrow">Borrow Requests</a></li>
  <li><a data-toggle="tab" href="#return">Return Requests</a></li>
</ul>
</div>

<div class="col-md-9"> 
<div class="tab-content">
  
<div id="books" class="tab-pane fade in active">
    <h3>Book List</h3>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>Genere</th>
        <th>Total Count</th>
        <th>Avilable Now</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($books==1) {
      echo '<tr><td>No Books </td></tr>';
    }
    else{
    foreach($books as $item) {
      echo'<tr>
      <td>'.$item['Book_Title'].'</td> 
      <td>'.$item['Book_Author'] .'</td>
      <td>'.$item['Book_Publisher'].'</td>
      <td>'.$item['Boook_Genere'].'</td>
      <td>'.$item['Max_Avilable'].'</td>
      <td>'.$item['Book_Count'].'</td>
      <td> <a href="../librarian/deleteBook.php?id='.$item['Book_Id'].'"><button type="button" class="btn btn-danger btn-md">Delete</button></a></td>';
    }
  }

     ?>
    </tbody>
    </table>
  </div>

  <div id="borrow" class="tab-pane fade in">
    <h3>Borrow Requests</h3>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Member Id</th>
        <th>Member Name</th>
        <th>Book Title</th>
        <th>Request Date</th>
        <th>Avilable</th>
        <th>Approve</th>
        <th>Deny</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($requests==1) {
      echo '<tr><td>No Requests </td></tr>';
    }
    else{
    foreach($requests as $item) {
      echo'<tr>
      <td>'.$item['R_User'].'</td> 
      <td>'.$item['User_Fname'] .'</td>
      <td>'.$item['Book_Title'].'</td>
      <td>'.date('M jS Y',$item['Requested_Date']).'</td>
      <td>'.$item['Book_Count'].'</td>
      <td> <a href="../librarian/issueBook.php?rid='.$item['Request_Id'].'&uid='.$item['R_User'].'&bid='.$item['R_Book'].'&id='.$id.'"><button type="button" class="btn btn-default btn-md">Issue Book</button></a></td>
      <td> <a href="../librarian/deny.php?rid='.$item['Request_Id'].'&uid='.$item['R_User'].'&bid='.$item['R_Book'].'&id='.$id.'"><button type="button" class="btn btn-danger btn-md">Deny</button></a></td>
      </tr>';
    }
  }

     ?>
    </tbody>
    </table>
  </div>
  <div id="return" class="tab-pane fade">
    <h3>Return Requests</h3>
    
        <table class="table table-striped">
    <thead>
      <tr>
        <th>Member Id</th>
        <th>Member Name</th>
        <th>Book Title</th>
        <th>Return Date</th>
        <th>Approve</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($return_data==1) {
      echo '<tr><td>No Requests </td></tr>';
    }
    else{
    foreach($return_data as $ritem) {
      echo'<tr>
      <td>'.$ritem['R_User'].'</td> 
      <td>'.$ritem['User_Fname'] .'</td>
      <td>'.$ritem['Book_Title'].'</td>
      <td>'.date('M jS Y',$ritem['Return_Date']).'</td>
      <td> <a href="../librarian/returnBook.php?rid='.$ritem['Return_Id'].'&uid='.$ritem['R_User'].'&bid='.$ritem['R_Book'].'&id='.$id.'"><button type="button" class="btn btn-default btn-md">Return Book</button></a></td>
      </tr>';
    }
  }

     ?>
    </tbody>
    </table>

  </div>
</div>

    </div>
    </div>
    <div class="panel panel-default">
  <div class="panel-body"> <center>Onine Library &copy; 2016 </center></div>
    </div>
  </body>
  </html>