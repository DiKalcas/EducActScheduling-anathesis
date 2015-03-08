<?php 
  
    // if user haven't login, redirect him with messg 
  require('con_is_logged_in.php'); 
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>ΣΥΝΔΙΑΣΤΗΣ ΠΟΡΩΝ</title>
  <link rel="stylesheet" type="text/css" href="stylesPlus.css"/>
</head>
<body>

  <div id="container">


    <div id="header">
      <h1>συνδιασμός πόρων για προετοιμασία ανάθεσης</h1>
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
       <h2>Σελίδα Συνδιαστή πόρων</h2>
       <?php echo_msg(); ?>
       
      <br ><ul class='main'>
      <br ><li><a href='\EduSchedule\eventPlannedCoursesManipu\index.php'>ΣΥΝΔΙΑΣΜΟΣ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ--ΜΑΘΗΜΑΤΩΝ</a></li>
      <br ><li><a href='\EduSchedule\scarceResourcesManipu\index.php'>ΣΥΝΔΙΑΣΜΟΣ ΑΙΘΟΥΣΑΣ-ΩΡΩΝ ΔΙΔΑΣΚΑΛΙΑΣ</a></li>
      <br ><li><a href='\EduSchedule\schoolStudentGroup_professor_linksManipu\index.php'>ΣΥΝΔΙΑΣΜΟΣ ΟΜΑΔΑΣ ΦΟΙΤΗΤΩΝ--ΚΑΘΗΓΗΤΗΣ</a></li> 
    </div>

    <div id="footer">
      <div id="leftfooter">Τεχνολογικό Εκπαιδευτικό Ι. Θεσσαλίας</div>
      <div id="rightfooter">Γραμματειακές Υπηρεσίες</div>
    </div>


  </div>  <!-- div of container -->

</body>
</html>
