<?php 
require_once('config.php'); 
include($CLASS_CATALOG);

$catalog=new Catalog;
$item=$catalog->fetchField("Boook_Genere",'book');
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
        <li><a href="index.php">Home</a></li>
        <li><a href="titles.php">Titles</a></li>
        <li><a href="authors.php">Authors</a></li> 
        <li><a href="publishers.php">Publishers</a></li>
        <li class="active"><a href="generes.php">Geners</a></li> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <?php if (isset($_SESSION['lib'])) { 
            echo '<li><a href="redirect.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';} 
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
      <legend class="ctitle">Avilable Generes</legend>
      </div> 
      <div class="row">
      <?php
      foreach($item as $book)	
      echo '<h3><p>'.$book['Boook_Genere'].'</a> 
      </p></h3>';
      ?>
      </div>
      </div>
	   
     <div class="panel panel-default">
  <div class="panel-body"> <center>Onine Library &copy; 2016 </center></div>
    </div>
  </body>

</html>