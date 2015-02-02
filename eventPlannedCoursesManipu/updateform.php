<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
                  // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
 if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) 
 {
  
    $eventPlannedCourseID=  $_GET['id'];   //το ID της εγγραφής   που θα μεταβάλλουμε

    $title=  "μεταβολή συνδιασμού εγγραφών από γραμματεία!";
  
      //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
  try {         //initialization of PDObject
   $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
   $sql= "SELECT * FROM eventplannedcourses 
               WHERE eventPlannedCourseID = :eventPlannedCourseID    LIMIT 1";
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
   $statement->execute( array( ':eventPlannedCourseID'=>$eventPlannedCourseID ));
             //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
         //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$___ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $schoolID_ofSchools=          $record[ 'schoolID_ofSchools' ];
    $subjectID_ofSubjects=         $record[ 'subjectID_ofSubjects' ];
    $teachMethodID_ofTeachMethods=  $record[ 'teachMethodID_ofTeachMethods' ];
    
    $secretaryCode=  $record[ 'secretaryCode' ];
    $ECTS=           $record[ 'ECTS' ];
    $otherDetails=   $record[ 'otherDetails' ];
    
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
 <title>ΝΕΟ ΜΑΘΗΜΑ ΣΧΟΛΗΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΜΑΘΗΜΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ΤΕΙ</legend>
  <form name="form1" action="updatehandler.php" method="post">

<?php  
     
 if ($_GET['mode'] == 'update') { ?>

  <input name="eventPlannedCourseID" value="<?php echo $eventPlannedCourseID; ?>" readonly="readonly" hidden />

<?php   }  ?>

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

