<?php 

     // if user haven't login, redirect him with messg 
  require('con_is_logged_in.php');

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>ΕΠΙΜΕΛΗΤΗΣ</title>
  <link rel="stylesheet" type="text/css" href="stylesPlus.css"/>
</head>
<body>

  <div id="container">


    <div id="header">
      <h1>επιθεώρηση αναθέσεων εκπαιδευτικού έργου</h1>
    </div>
    
    <div id="leftsidebar">
      <ul class="menu">
        <li><a href="#">home</a></li>
        <li><a href="#">grant option</a></li>
        <li><a href="#">Σελίδα Χρήστη</a></li>

        <?php if ( isset($_SESSION['username']) ) { ?>

           <!-- η επιλογή logout δίνεται μόνο σε όσους έχουν κάνει login -->
           <!-- η ανάγκη για session_start() έχει καλυφθεί στα αρχεία-σελίδες -->
           <li><a href="con_logout.php">logout</a></li>
           
        <?php } ?>

      </ul>

    </div>
    

    <?php require('errors.php'); ?>
    <div id="main">
       <h2>Σελίδα Επιμελητή</h2>
       <?php echo_msg(); ?>
       
      <br ><ul class='main'>
      <br ><li><a href='\EduSchedule\OverviewSchoolSubjects\'>      ΤΜΗΜΑ ΣΧΟΛΗΣ > ΘΕΜΑ ΜΑΘΗΜΑΤΟΣ > ΑΝΑΘΕΣΗ </a></li>
      <br ><li><a href="\EduSchedule\OverviewSchoolStudeGrouProf\"> ΤΜΗΜΑ ΣΧΟΛΗΣ > ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ > ΑΝΑΘΕΣΗ </a></li>
      <br ><li><a href="/EduSchedule/OverviewProfessoStudGroups/">  ΚΑΘΗΓΗΤΗΣ > ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ > ΑΝΑΘΕΣΗ </a></li> 
    
    </div>

    <div id="footer">
      <div id="leftfooter">Τεχνολογικό Εκπαιδευτικό Ι. Θεσσαλίας</div>
      <div id="rightfooter">Διοικητικές Υπηρεσίες</div>
    </div>


  </div>  <!-- div of container -->

</body>
</html>
