<?php
  include ('Librarian.php');
  include('../includes/functions.php');
  $Librarian=new Librarian;
  $Function=new Functions;

  if(isset($_POST['btitle'])&&isset($_POST['bauthor'])&&isset($_POST['bpublisher'])&&isset($_POST['pdate'])&&isset($_POST['bgenere'])&&isset($_POST['bcount'])&&isset($_POST['bdic'])&&isset($_FILES['file']))
    { 
       $btitle=$_POST['btitle'];
       $bauthor=$_POST['bauthor'];
       $bpublisher=$_POST['bpublisher'];
       $pdate=$_POST['pdate'];
       $bgenere=$_POST['bgenere'];
       $bcount=$_POST['bcount'];
       $bdic=$_POST['bdic'];

      $name = $_FILES['file']['name'];
      $type= $_FILES['file']['type'];
      $temp_name = $_FILES['file']['tmp_name'];
      $ext = pathinfo($name, PATHINFO_EXTENSION);
      $max_size = 5000000;
      $size = $_FILES['file']['size'];

      $upload=$Function->uploadCover($name,$size,$type,$temp_name,$ext,$max_size);
      echo 'upload status: '.$upload;
      
      if ($upload==2) {
        $result=2;
      }
      
      else {
        $result=$Librarian->addBook($btitle,$bauthor,$bpublisher,$pdate,$bgenere,$upload,$bdic,$bcount); 
      }
       
        }
?>

<html lang="en">
    <head>
    <title>Online Library - Add a book</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../stylesheet/style.css" />
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>

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
    <!-- <div class="ctitle">USER SIGN UP</div>  -->
    <div id="legend">
      <legend class="ctitle">ADD A BOOK</legend>
      </div>
      <div class="col-sm-8">
        <br>
        <div class="message">
        <?php 

        if(isset($result) and $result==0) {
          echo '<div class="alert alert-success fade in" >
        <a href="#" class="close" data-dismiss="alert" aria-lebel="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Book added successfully!</strong> </div>" '; }

      else if (isset($result) and $result==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Book Already Exists!</strong></div> '; }

        else if (isset($result) and $result==2) {
          echo '<div class="alert alert-info fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Please select a cover photo for the book! </strong></div> '; } 
        ?>

        </div>  
        <form class="form-horizontal" role="form" method="post" action="add_book.php" enctype="multipart/form-data">
          
          <div class="form-group">
            <label class="control-label col-sm-2" for="Title">Book Title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="btitle" name="btitle" placeholder="Enter Book Title">
    </div>
  </div>

  <div class="form-group">
            <label class="control-label col-sm-2" for="author">Book Author</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bauthor" name= "bauthor" placeholder="Enter Book author">
    </div>
  </div>

  <div class="form-group">
            <label class="control-label col-sm-2" for="publisher">Book Publisher</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bpublisher" name= "bpublisher" placeholder="Enter Book publisher">
    </div>
  </div>

  <div class="form-group">
            <label class="control-label col-sm-2" for="pubdate">Published Date</label>
   
    <div class="col-sm-10">
<div class='input-group date' id='datetimepicker'>
                    <input type='text' class="form-control" id="datepicker" name="pdate" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
  </div>
  </div>

  <div class="form-group">
            <label class="control-label col-sm-2" for="genere">Book Genere</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bgenere" name= "bgenere" placeholder="Enter Book Genere">
    </div>
  </div>

  <div class="form-group">
            <label class="control-label col-sm-2" for="publisher">Book Count</label>
    <div class="col-sm-10">
      <input type="number" min=1 class="form-control" id="bcount" name= "bcount" placeholder="Enter Book Count">
    </div>
  </div>

    <div class="form-group">
            <label class="control-label col-sm-2" for="cover">Book Cover</label>
    
    <div class="col-sm-10">
      <input type="file" name="file">
  </div>
</div>

<div class="form-group">
            <label class="control-label col-sm-2" for="publisher">Book Discription</label>
    
    <div class="col-sm-10">
      <textarea class="form-control" rows="5" name="bdic"></textarea>
  </div>
</div>

         
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Add Book</button>
    </div>
  </div>
</form>
</div>
</div>
  </body>
  </html>