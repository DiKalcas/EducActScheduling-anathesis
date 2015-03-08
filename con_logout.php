<?php
                        //logout and redirect at home with messg
  session_start();     //  connect to the session
  session_destroy();  //    and destroy it
  header("Location: index.php?msg=Επιτυχής Αποσύνδεση!");
  exit();
  
?>