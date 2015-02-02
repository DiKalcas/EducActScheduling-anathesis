<?php
  // prints possible message from the msg-parameter of  $_GET (στο URL))
  function echo_msg() {
    if (isset($_GET['msg']))
      echo '<p style="color:red;">' . $_GET['msg'] . '</p>';
  }
?>

