<?php 
  
    // if user haven't login, redirect him with messg 
  require('con_is_logged_in.php'); 
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>ΣΤΡΑΤΟΛΟΓΗΤΗΣ</title>
  <link rel="stylesheet" type="text/css" href="stylesPlus.css"/>
</head>
<body>

  <div id="container">


    <div id="header">
      <h1>διαχείριση διαθέσιμων καθηγητών&emsp;Roster</h1>
    </div>
    
    <div id="leftsidebar">
      <ul class="menu">
        <li><a href="#">home</a></li>
        <li><a href="#">grant option</a></li>
        <li><a href="#">Σελίδα Χρήστη</a></li>

        <?php if ( isset($_SESSION['username']) ) { ?>

           <!-- logout option at users have already logedin -->
           <li><a href="con_logout.php">logout</a></li>
           
        <?php } ?>

      </ul>

    </div>
    

    <?php require('errors.php'); ?>
    <div id="main">
       <h2>Σελίδα Στρατολογητή</h2>
       <?php echo_msg(); ?>
       
      <br ><ul class='main'>
      <br ><li><a href='\EduSchedule\professorsManipu\index.php'>ΔΙΑΧΕΙΡΙΣΗ ΣΤΟΙΧΕΙΩΝ ΤΩΝ ΚΑΘΗΓΗΤΩΝ Τ.Ε.Ι.</a></li>
      
       
    </div>

    <div id="footer">
      <div id="leftfooter">Τεχνολογικό Εκπαιδευτικό Ι. Θεσσαλίας</div>
      <div id="rightfooter">Γραμματειακές Υπηρεσίες</div>
    </div>


  </div>  <!-- div of container -->

</body>
</html>
