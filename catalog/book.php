<?php 
require_once('../config.php'); 
include($CLASS_CATALOG);
include ($CLASS_MEMBER);
$book_id=$_GET['id'];
$catalog=new Catalog;
$member=new Member;

$item=$catalog->fetchById ($book_id);
$memLoggedIn=$member->isLoggedIn();

$title=$item['Book_Title'];
$author=$item['Book_Author'];
$publisher=$item['Book_Publisher'];
$date=$item['Book_Pub_Date'];
$genere=$item['Boook_Genere'];
$cover=$item['Book_Cover'];
$discription=$item['Book_Discription'];

if(isset($_GET['req'])) {
  $req=$_GET['req'];
}
?>
<html lang="en">
<meta charset="UTF-8">
	<head>
	  <title>Online Library</title>
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
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Titles</a></li>
        <li><a href="#">Authors</a></li> 
        <li><a href="#">Publishers</a></li>
        <li><a href="#">Geners</a></li> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <?php if (isset($_SESSION['lib'])) { 
      			echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';} 
      			else echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>'; ?>
      </ul>
    </div>
  </div>
</nav>
		<div class="img-head"> 
			<img class="img-responsive" src="../assets/head.jpg">
		</div>
<!--------------------------------END OF HEADER------------------------------------------!-->

<div class="container">
    <div id="legend">
      <legend class="ctitle"><?php echo $title; ?></legend>
      </div> 

      <?php
        if (isset($req) and $req==1) {
          echo '<div class="alert alert-warning fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-info-sign"></span> Request Limit Exceeded ! </strong></div> '; }

        else if (isset($req) and $req==0) {
          echo '<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><span class="glyphicon glyphicon-ok-sign"></span> Rquest Granted !</strong></div> '; }
      ?>
      <div class="col-sm-4">
      <div class="row">
        <img src="<?php echo $cover;?>" class="img-thumbnail" width="200" height="150">
        </div>
        <div class="row"><br/><br/></div>
        <div class="row">
        <?php if ($memLoggedIn==1) {
          echo '<a href="../member/request.php?bid='.$book_id.'"><button type="button" class="btn btn-default btn-md">Request Book</button></a>';
        } 

        ?>
        </div>
        <div class="row"><br/><br/></div>
      </div>

      <div class="col-sm-8"> 
      <div class="row"><p><strong>Author:</strong> <?php echo $author; ?> </p></div>
      <div class="row"><p><strong>Publisher: </strong><?php echo $publisher; ?> </p></div>
      <div class="row"><p><strong>Published Date: </strong><?php echo $date; ?> </p></div>
      <div class="row"><p><strong>Genere: </strong><?php echo $genere; ?> </p></div> 
      <div class="row"><p><strong>Discription: </strong></div>
      <div class="row well"><p><?php echo $discription;?></p></div> 
      

      </div>

      </div>
	</body>

</html>