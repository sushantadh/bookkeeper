<?php 
require('config.php');
include($CLASS_CONNECTION);
if($_SESSION['lib'][1]==1) {
            header('Location:admin/index.php?id='.$_SESSION['lib'][0]);
         }
         else if ($_SESSION['lib'][1]==2) {
            header('Location:librarian/index.php?id='.$_SESSION['lib'][0]);
         }

         else if ($_SESSION['lib'][1]==3) {
            header('Location:member/index.php?id='.$_SESSION['lib'][0]);
         }
      ?>