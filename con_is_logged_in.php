<?php
   // in case of not login then redirects at index.php with message
  session_start(); // χρειάζεται για πρόσβαση στο session
  if (!isset($_SESSION['username'])) {
     header("Location: index.php?msg=Πρέπει να κάνεις login!");
     exit();
  }   
 ?>