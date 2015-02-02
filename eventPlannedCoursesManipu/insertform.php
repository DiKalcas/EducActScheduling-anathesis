<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους

  if ( isset($_GET['mode'] ) &&  $_GET['mode']=='insert'  ) {
    $title='επιλογή εγγραφής μαθήματος σε τμήμα από διαχειριστή!';
             //καταχωρούμε τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $schoolID_ofSchools=            '';
    $subjectID_ofSubjects=          '';
    $teachMethodID_ofTeachMethods= '';
    $secretaryCode=                 '';
    $ECTS=                          '';
    $otherDetails=                  '';
  }  
  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟ ΜΑΘΗΜΑ ΣΧΟΛΗΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΜΑΘΗΜΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ΤΕΙ</legend>
  <form name="form1" action="inserthandler.php" method="post">



  <p>Τμήμα Σχολής: <select name="schoolID_ofSchools">
          <?php load_options('schools', $schoolID_ofSchools) ?>
        </select>
  </p>
  <p>Θέμα μαθήματος: <select name="subjectID_ofSubjects">
          <?php load_options('subjects', $subjectID_ofSubjects) ?>
        </select>
  </p>
  <p>Μέθοδος διδασκαλίας: <select name="teachMethodID_ofTeachMethods">
          <?php load_options('teachMethods', $teachMethodID_ofTeachMethods) ?>
        </select>
  </p>  
  <p>Κωδ. μαθήματος Γραμματείας: <input type="number" size="3" name="secretaryCode" value="<?php echo $secretaryCode; ?>"/> &nbsp|&nbsp  E C T S : <input type="number" size="3" name="ECTS" value="<?php echo $ECTS; ?>"/></p>
   
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div> 
</body>
</html>

