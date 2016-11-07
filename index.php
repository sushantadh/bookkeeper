<?php 
require_once('config.php'); 
include($CLASS_CATALOG);

$catalog=new Catalog;
$item=$catalog->fetchLatest('Book_Id,Book_Cover,Book_Title','book','Date_Added','DESC');
?>
<html lang="en">
	<head>
	  <title>Online Library</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <link rel="stylesheet" type="text/css" href="stylesheet/style.css" />
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
			<img class="img-responsive" src="assets/head.jpg">
		</div>
<!--------------------------------END OF HEADER------------------------------------------!-->

<div class="container">
    <div id="legend">
      <legend class="ctitle">Latest Arrivals</legend>
      </div> 
      <div class="row">
      <?php
      foreach($item as $book)	
      echo '<div class="col-sm-4"><a href="catalog/book.php?id='.$book['Book_Id'].'">
      <img src="'.$book['Book_Cover'].'"class="img-thumbnail" alt="'.$book['Book_Title'].'" width="150" height="150"></a> 
      </div>';
      ?>
      </div>
	</body>

</html>