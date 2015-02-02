<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
                  // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
 if ( isset($_GET['mode'], $_GET['id1'], $_GET['id2'], $_GET['id3'] ) &&  $_GET['mode']=='update'  ) 
 {
  
  $eventPlannedCourseID_old=        $_GET['id1'];   //το ID της εγγραφής
  $scarceResourceID_old=            $_GET['id2'];  //  που θα μεταβάλλουμε
  $schoolStudentGroupProfessorID_old= $_GET['id3'];
  
  $title=  "συνδιασμός $eventPlannedCourseID_old-$scarceResourceID_old-$schoolStudentGroupProfessorID_old προς μεταβολή";
      //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
  try {         //initialization of PDObject
   $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
   $sql= "SELECT * FROM eventplannedcourses WHERE eventPlannedCourseID = :eventPlannedCourseID 
                                           AND scarceResourceID = :scarceResourceID 
                      AND schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID  ";
                      // χρειάζεται ισοδύναμο του sql  LΙΜΙΤ 1  για έλεγχο διπλοεγγραφων
                      
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
   $statement->execute( array( ':eventPlannedCourseID'=>$eventPlannedCourseID_old, 
                                 ':scarceResourceID'=>$scarceResourceID_old, 
                   ':schoolStudentGroupProfessorID'=>$schoolStudentGroupProfessorID_old ));
             //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
         //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$___ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL

    
   }
   else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
         //κλείσιμο PDO
      $statement->closeCursor();
      $pdoObject= null;
  }
   catch ( PDOexception $e ) { 
   print "Database Error: " . $e->getMessage();
        
   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΑΛΛΑΓΗ ΑΝΑΘΕΣΗΣ ΔΙΔΑΣΚΑΛΙΑΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΣΥΝΔΙΑΣΜΟΣ ΠΟΡΩΝ ΓΙΑ ΕΚΤΕΛΕΣΗ ΕΚΠΑΙΔΕΥΤΙΚΟΥ ΕΡΓΟΥ</legend>
  <form name="form1" action="updatehandler.php" method="post">

<?php  
 if ($_GET['mode'] == 'update') { ?>

  <input name="eventPlannedCourseID_old" value="<?php echo $eventPlannedCourseID_old; ?>" readonly="readonly" hidden />
  <input name="scarceResourceID_old" value="<?php echo $scarceResourceID_old; ?>" readonly="readonly" hidden />
  <input name="schoolStudentGroupProfessorID_old" value="<?php echo $schoolStudentGroupProfessorID_old; ?>" readonly="readonly" hidden />

<?php   }  ?>

      <p> Προγραμματισμένο μάθημα εξαμήνου: </p><p align="center"><select name="eventPlannedCourseID_new">
          <?php load_options('eventplannedcourses', $eventPlannedCourseID_old) ?>
        </select></p>
  <p> Αίθουσα την συγκεκριμένη ώρα: </p><p align="center"><select name="scarceResourceID_new">
          <?php load_options('scarceresources', $scarceResourceID_old) ?>
        </select></p>
  <p> Μέθοδος διδασκαλίας: </p><p align="center"><select name="schoolStudentGroupProfessor_new">
          <?php load_options('schoolstudentgroup_professor_links', $schoolStudentGroupProfessorID_old) ?>
        </select></p>  

   
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div> 
</body>
</html>

