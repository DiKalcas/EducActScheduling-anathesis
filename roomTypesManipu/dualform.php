<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
      // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
 if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) 
 {
  $title='μεταβολή εγγραφής πίνακα από διαχειριστή!';
  $roomTypeID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε
      //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
  try 
  {
         //αρχικοποίηση PDO
   $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
   $sql = "SELECT * FROM roomtypes WHERE roomTypeID=:roomTypeID LIMIT 1";
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
   $statement->execute( array( ':roomTypeID'=>$roomTypeID ));
         //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
            //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$businessID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $roomTitle=    $record['roomTitle'];
    $roomCapacity= $record['roomCapacity'];
    $roomEquipment= $record['roomEquipment'];
    $otherDetails=  $record['otherDetails'];
   } else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
      //κλείσιμο PDO
    $statement->closeCursor();
    $pdoObject= null;
  }
   catch ( PDOexception $e )
  { 
   print "Database Error: " . $e->getMessage();
         // η εντολή die παρακάτω, διακόπτει την εκτέλεση του κώδικα με βίαιο τρόπο
        // και τυπώνει τυχόν κείμενο - καλύτερα όμως ανακατεύθυνση σε σελίδα error
   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
     //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
 if ( isset($_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
  $title='εισαγωγή εγγραφής πίνακα από διαχειριστή!';
    //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
  $roomTypeID=    '';
  $roomTitle=     '';
  $roomCapacity=  3;
  $roomEquipment= 'Βασικός';
  $otherDetails=  'Γενικός τύπος Αίθουσας διδασκαλίας';
    
 }  
?> 

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟΣ ΤΥΠΟΣ ΑΙΘΟΥΣΑΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΕΙΣΑΓΩΓΗ ΕΓΓΡΑΦΗΣ - ΤΥΠΩΝ ΑΙΘΟΥΣΩΝ ΔΙΔΑΣΚΑΛΙΑΣ</legend>
  <form name="form1" action="dualformhandler.php" method="post">

<?php  //βάζουμε πεδίο κειμένου για το ID μόνο στο update (το χρειαζόμαστε!)
      //επίσης το κάνουμε read-only γιατί δεν πρέπει να μεταβληθεί.
 if ($_GET['mode'] == 'update') 
  { 
?>

<p>Κωδικός: <input name="roomTypeID" value="<?php echo $roomTypeID; ?>" readonly="readonly" /></p>

<?php  //ΕΔΩ ΚΛΕΙΝΕΙ ΤΟ ΠΡΟΗΓΟΥΜΕΝΟ IF 
  }
?>

  <p>Ονομασία τύπου αίθουσας: <input type="text"  size="58"  name="roomTitle"      value="<?php echo $roomTitle; ?>" /></p>
  <p>Δυνατότητα φιλοξενίας φοιτητών (θέσεις): <input type="number" size="4" name="roomCapacity" value="<?php echo $roomCapacity; ?>"/></p>
  <p>Εξοπλισμός χώρου για διδασκαλία: <input type="text" size="52" name="roomEquipment"     value="<?php echo $roomEquipment; ?>"  />                     </p>
  <p>Λεπτομέριες: <input type="text"  size="70"  name="otherDetails"   value="<?php echo $otherDetails; ?>" /></p>
  <p> <input type="reset"/><input type="submit"/></p>

  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div>  
</body>
</html>