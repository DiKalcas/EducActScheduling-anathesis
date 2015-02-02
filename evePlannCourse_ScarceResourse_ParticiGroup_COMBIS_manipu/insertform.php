<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους

                  //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
 if ( isset($_GET['mode'] ) &&  $_GET['mode']=='insert'  ) {
    $title='συνδιασμός προγραμματ.μαθήματος σε συγκεκριμένη αίθουσα-ώρα με ομάδα φοιτητών-καθηγητή';
             //καταχωρούμε τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $eventPlannedCourseID=        '';
    $scarceResourceID=             '';
    $schoolStudentGroupProfessorID= '';

    
  }  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΑ ΑΝΑΘΕΣΗ ΔΙΔΑΣΚΑΛΙΑΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΣΥΝΔΙΑΣΜΟΣ ΠΟΡΩΝ ΓΙΑ ΕΚΤΕΛΕΣΗ ΕΚΠΑΙΔΕΥΤΙΚΟΥ ΕΡΓΟΥ</legend>
  <form name="form1" action="inserthandler.php" method="post">



  <p> Προγραμματισμένο μάθημα εξαμήνου: </p><p align="center"><select name="eventPlannedCourseID">
          <?php load_options('eventplannedcourses', $eventPlannedCourseID) ?>
        </select>
  </p>
  <p> Αίθουσα την συγκεκριμένη ώρα: </p><p align="center"><select name="scarceResourceID">
          <?php load_options('scarceresources', $scarceResourceID) ?>
        </select>
  </p>
  <p> Ομάδα φοιτητών με Καθηγητή: </p><p align="center"><select name="schoolStudentGroupProfessorID">
          <?php load_options('schoolstudentgroup_professor_links', $schoolStudentGroupProfessorID) ?>
        </select>
  </p>  
  
   
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div> 
</body>
</html>

