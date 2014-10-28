<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
                  // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
 if ( isset($_GET['mode'], $_GET['id1'], $_GET['id2'] ) &&  $_GET['mode']=='update'  ) 
 {
  $title='μεταβολή εγγραφής πίνακα από διαχειριστή!';
  $schoolID= $_GET['id1'];            //το ID της εγγραφής
  $locationAddressID= $_GET['id2'];  //  που θα μεταβάλλουμε
      //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
  try {         //αρχικοποίηση PDO
   $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
   $sql1= "SELECT * FROM schools WHERE schoolID=:schoolID LIMIT 1";
   $sql2= "SELECT * FROM locationaddresses WHERE locationAddressID=:locationAddressID LIMIT 1";
         //compile ερωτήματος στον database server
   $statement1= $pdoObject->prepare($sql1);
   $statement2= $pdoObject->prepare($sql2);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
   $statement1->execute( array( ':schoolID'=>$schoolID ));
   $statement2->execute( array( ':locationAddressID'=>$locationAddressID ));
             //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement1->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
         //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$businessID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $schoolSectionName= $record[ 'schoolSectionName' ];
    
   }
   else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
               //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
   if ( $record= $statement2->fetch() ) 
   {   //εφόσον βρέθηκε η εγγραφή
      //το σημειώνουμε για μετά
    $record_exists=true;
         //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$businessID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
     $locationAddressID= $record['locationAddressID'];
     $area= $record[ 'area' ];
     $city= $record[ 'city' ];
     $address= $record[ 'address' ];
   }
   else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
         //κλείσιμο PDO
      $statement2->closeCursor();
      $pdoObject= null;
  }
   catch ( PDOexception $e ) { 
   print "Database Error: " . $e->getMessage();
         // η εντολή die παρακάτω, διακόπτει την εκτέλεση του κώδικα με βίαιο τρόπο
        // και τυπώνει τυχόν κείμενο - καλύτερα όμως ανακατεύθυνση σε σελίδα error
   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
                  //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
 if ( isset($_GET['mode'] ) &&  $_GET['mode']=='insert'  ) {
    $title='Εισαγωγή';
    //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $schoolID='';
    $schoolSectionName='';
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟ ΤΜΗΜΑ ΣΧΟΛΗΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΕΙΣΑΓΩΓΗ ΕΓΓΡΑΦΗΣ - ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ΤΕΙ</legend>
  <form name="form1" action="dualformhandler.php" method="post">

<?php  //βάζουμε πεδίο κειμένου για το ID μόνο στο update (το χρειαζόμαστε!)
      //επίσης το κάνουμε read-only γιατί δεν πρέπει να μεταβληθεί.
 if ($_GET['mode'] == 'update') 
  { 
?>

<p>Κωδικός: <input name="schoolID" value="<?php echo $schoolID; ?>" readonly="readonly" /></p>

<?php  //ΕΔΩ ΚΛΕΙΝΕΙ ΤΟ ΠΡΟΗΓΟΥΜΕΝΟ IF 
  }
?>

  <p>Τίτλος Τμήματος σχολής Τ.Ε.Ι.(ΣΧΟΛΗ): <input type="text"  size="44"  name="schoolSectionName"      value="<?php echo $schoolSectionName; ?>" /></p>
  <p> <input type="reset"/><input type="submit"/></p>
  </form>  
  </fieldset>
  <fieldset><legend>ΕΙΣΑΓΩΓΗ ΕΓΓΡΑΦΗΣ - ΔΙΕΥΘΗΝΣΗΣ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ΤΕΙ</legend>
  <form name="form1" action="dualformhandler.php" method="post">

<?php  //βάζουμε πεδίο κειμένου για το ID μόνο στο update (το χρειαζόμαστε!)
      //επίσης το κάνουμε read-only γιατί δεν πρέπει να μεταβληθεί.
 if ($_GET['mode'] == 'update') 
  { 
?>

<p>Κωδικός: <input name="locationAddressID" value="<?php echo $locationAddressID; ?>" readonly="readonly" /></p>

<?php  //ΕΔΩ ΚΛΕΙΝΕΙ ΤΟ ΠΡΟΗΓΟΥΜΕΝΟ IF 
  }
?>

  <p>Πόλη που εδρεύει το Τμήμα σχολής: <input type="text"  size="44"  name="city" value="<?php echo $city; ?>" /></p>
  <p>Περιοχή της πόλης του Τμήματος:   <input type="text"  size="44"  name="area" value="<?php echo $area; ?>" /></p>
  <p>Διεύθηνση του Τμήματος:       <input type="text"  size="44"   name="address" value="<?php echo $address; ?>" /></p>  
  <p> <input type="reset"/><input type="submit"/></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div> 
</body>
</html>
