<?php 
require_once('../config.php'); 
include($CLASS_LIBRARIAN);

$librarian=new Librarian;

$requestId=$_GET['rid'];
$userId=$_GET['uid'];
$bookId=$_GET['bid'];
$id=$_GET['id'];

$issue=$librarian->issueBook($requestId,$userId,$bookId);
header('Location:index.php?id='.$id.'&issue='.$issue);
?>