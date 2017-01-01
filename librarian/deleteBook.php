<?php 
require_once('../config.php'); 
include($CLASS_LIBRARIAN);

$librarian=new Librarian;

$id=$_GET['id'];

$delete=$librarian->deleteBook($id);
header('Location:index.php?bdelete='.$delete);