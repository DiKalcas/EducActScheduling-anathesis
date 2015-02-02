<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
                  // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
 if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) 
 {
  
  $schoolStudentGroupProfessorID= $_GET['id'];   //το ID της εγγραφής  που θα μεταβάλλουμε
 

  $title=  "εγγραφή No $schoolStudentGroupProfessorID μεταβολή από διαχειριστή!";
      //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
  try {         //initialization of PDObject
   $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
   $sql= "SELECT * FROM schoolstudentgroup_professor_links 
          WHERE schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID  LIMIT 1";
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
   $statement->execute( array( ':schoolStudentGroupProfessorID'=>$schoolStudentGroupProfessorID ));
             //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
         //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$___ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $schoolID_bySchools=  $record[ 'schoolID_bySchools' ];
    $studentGroupID_byStudentGroups=   $record[ 'studentGroupID_byStudentGroups' ];
    $professorID_byProfessors=  $record[ 'professorID_byProfessors' ];
    
   }
   else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
         //κλείσιμο PDO
      $statement->closeCursor();
      $pdoObject= null;
  }
   catch ( PDOexception $e ) { 
   print "Database Error: " . $e->getMessage();
         // η εντολή die παρακάτω, διακόπτει την εκτέλεση του κώδικα με βίαιο τρόπο
        // και τυπώνει τυχόν κείμενο - καλύτερα όμως ανακατεύθυνση σε σελίδα error
   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΕΝΗΜΝΕΡΩΣΗ ΣΥΝΔΙΑΣΜΟΥ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ ΜΕ ΚΑΘΗΓΗΤΗ</legend>
  <form name="form1" action="updatehandler.php" method="post">

<?php  //βάζουμε πεδίο κειμένου για το ID μόνο στο update (το χρειαζόμαστε!)
      //επίσης το κάνουμε read-only γιατί δεν πρέπει να μεταβληθεί.
 if ($_GET['mode'] == 'update') { ?>

  <input name="schoolStudentGroupProfessorID" value="<?php echo $schoolStudentGroupProfessorID; ?>" readonly="readonly" hidden />



<?php   }  ?>

  <p>Τμήμα Σχολής: <select name="schoolID_bySchools">
          <?php load_options('schools', $schoolID_bySchools) ?>
        </select>
  </p>
  <p>Ομάδα Φοιτητών: <select name="studentGroupID_byStudentGroups">
          <?php load_options('studentgroups', $studentGroupID_byStudentGroups) ?>
        </select>
  </p>
  <p>Καθηγητής: <select name="professorID_byProfessors">
          <?php load_options('professors', $professorID_byProfessors) ?>
        </select>
  </p>  
   
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div> 
</body>
</html>

