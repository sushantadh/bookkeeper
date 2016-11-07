<?php 
require_once('../config.php'); 
include($CLASS_ADMIN);

$admin=new LibAdmin;

$id=$_GET['id'];

$delete=$admin->deleteUser($id);
header('Location:index.php?id='.$id.'&return='.$delete);
?>