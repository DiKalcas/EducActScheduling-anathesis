<?php
  //τυπώνει πιθανό μήνυμα που υπάρχει στην παράμετρο msg του $_GET (στο URL))
  function echo_msg() {
    if (isset($_GET['msg']))
      echo '<p style="color:red;">'.$_GET['msg'].'</p>';
  }
?>

