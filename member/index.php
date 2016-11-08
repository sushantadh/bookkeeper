<?php 
require('../config.php');
include($CLASS_MEMBER);
$member=new member;

$loggedin=$member->isLoggedIn();


  $id=$_SESSION['lib'][0];
  $getname=$member->fetchByField ('User_Fname','user','User_Id',$id);
  $name=$getname['User_Fname'];

$borrow_data=$member->fetchBorrow($id);

if(isset($_GET['return'])) {
  $return=$_GET['return'];
}
?>

<html lang="en">
    <head>
    <title>Online Library - Member</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../stylesheet/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="page-header myhead"><Center>ONLINE LIBRARY</Center></div>

    <nav class="navbar navbar-default">
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
      <?php if (isset($_SESSION['lib'])) { 
            echo '<li><a href="../redirect.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
            <li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';} 
            else echo '<li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>'; ?>
      </ul>
    </div>
  </div>
</nav>
    <div class="img-head"> 
      <img class="img-responsive" src="../assets/head.jpg">
    </div>
<!-- --------------------END OF HEADER ----------------------------------- !-->

    <div class="container">

    <?php if ($loggedin==0) {
      echo'<div id="legend">
      <legend class="ctitle">Please Login as Member</legend>
      </div><div></div><div class="panel panel-default">
  <div class="panel-body"> <center>Onine Library &copy; 2016 </center></div>
    </div>'; 
    die();
    } ?>

    <div id="legend">
      <legend class="ctitle"><?php echo 'Welcome '.$name; ?></legend>
      </div> 

      <?php
        if (isset($return) and $return==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span></strong></div> '; }

        else if (isset($return) and $return==0) {
          echo '<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Book Return Requested !</strong></div> '; }
      ?>


    <h3>Books Borrowed</h3>
    <table class="table table-striped">
    <thead>
        <tr>
        <th>Book Title</th>
        <th>Return Request</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($borrow_data==1) {
      echo '<tr><td>No Books Borrowed </td></tr>';
    }
    else{
    foreach($borrow_data as $item) {
      echo'<tr>
      <td>'.$item['Book_Title'].'</td>
      <td> <a href="returnRequest.php?brid='.$item['Borrow_Id'].'&uid='.$item['B_User'].'&bid='.$item['B_Book'].'&id='.$id.'"><button type="button" class="btn btn-default btn-md">Return Book</button></a></td>
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
    </div> 
    <div class="panel panel-default">
  <div class="panel-body"> <center>Onine Library &copy; 2016 </center></div>
    </div>
  </body>
  </html>