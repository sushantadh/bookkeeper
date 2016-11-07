<?php 
require('../config.php');
include($CLASS_ADMIN);
$admin=new LibAdmin;

  $id=$_SESSION['lib'][0];
  $getname=$admin->fetchByField ('User_Fname','user','User_Id',$id);
  $name=$getname['User_Fname'];
  
$users=$admin->fetchUsers();

if(isset($_GET['return'])) {
  $return=$_GET['return'];
}
?>




<html lang="en">
    <head>
    <title>Online Library - Admin</title>
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
        <li><a href="#">Page 1</a></li>
        <li><a href="#">Page 2</a></li> 
        <li><a href="#">Page 3</a></li> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Add User</a></li>
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
    <div class="img-head"> 
      <img class="img-responsive" src="../assets/head.jpg">
    </div>
<!-- --------------------END OF HEADER ----------------------------------- !-->

    <div class="container">
    
      <div class="col-sm-4">
      <div class="container">
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
          <strong><span class="glyphicon glyphicon-ok-sign"></span> User Deleted Successfully !</strong></div> '; }
      ?>


    <h3>User List</h3><br>
    <table class="table table-striped">
    <thead>
        <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>User Type</th>
        <th>Delete User</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($users==1) {
      echo '<tr><td>No Users</td></tr>';
    }
    else{
    foreach($users as $item) {
      echo'<tr>
      <td>'.$item['User_Fname'].'</td>
      <td>'.$item['User_Lname'].'</td>
      <td>'.$item['User_Email'].'</td>
      <td>'.$item['User_Type'].'</td>
      <td> <a href="deleteUser.php?uid='.$item['User_Id'].'"><button type="button" class="btn btn-danger btn-md">Delete</button></a></td>
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
  

  </body>
  </html>