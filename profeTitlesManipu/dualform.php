<?php

  
  require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
  require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
  require('../errors.php');   //μυνήματα λάθους


  
      // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ UPDATE
  if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) {


    $title='μεταβολή εγγραφής πίνακα από διαχειριστή!';

    $professorTitleID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε

    //εύρεση εγγραφής που θέλουμε να μεταβάλουμε
    try {
      //αρχικοποίηση PDO
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
      //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
      $sql = "SELECT * FROM professortitles WHERE professorTitleID=:professorTitleID LIMIT 1";
      //compile ερωτήματος στον database server
      $statement= $pdoObject->prepare($sql);
      //πέρασμα τιμών στις παραμέτρους και εκτέλεση
      $statement->execute( array( ':professorTitleID'=>$professorTitleID ));
      //περιμένουμε ΜΙΑ ΜΟΝΟ εγγραφή στα αποτελέσματα
      if ($record= $statement->fetch()) { //εφόσον βρέθηκε η εγγραφή
        //το σημειώνουμε για μετά
        $record_exists=true;
        //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας
        //$businessID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
        $titleName=        $record['titleName'];
        $weekTeachHours=   $record['weekTeachHours'];
        $isStanding=       $record['isStanding'];
        $otherDetails=     $record['otherDetails'];
               
      } else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
      //κλείσιμο PDO
      $statement->closeCursor();
      $pdoObject= null;
    } catch (PDOException $e) {
        print "Database Error: " . $e->getMessage();
        // η εντολή die παρακάτω, διακόπτει την εκτέλεση του κώδικα με βίαιο τρόπο
        // και τυπώνει τυχόν κείμενο - καλύτερα όμως ανακατεύθυνση σε σελίδα error
        die("Αδυναμία δημιουργίας PDO Object");
    }

    //Αν δε βρέθηκε η εγγραφή πρέπει να αποφασίσουμε τι θα κάνουμε. Προφανώς
    //δεν μπορούμε να κάνουμε update. Έστω ανακατευθύνουμε....
    if (!$record_exists) {
      header('Location: index.php?msg=Record does not exist.');
      exit();
    }
  }
      //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
  if ( isset($_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
    $title='εισαγωγή εγγραφής πίνακα από διαχειριστή!';
    //καταχωρούμε τις τρέχουσες τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $professorTitleID= '';
    $titleName= '';
    $weekTeachHours= 1;
    $isStanding= 'ΟΧΙ';
    $otherDetails= 'Τίτλος εκπαιδευτικού προσωπικού';
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΝΕΟΣ ΤΙΤΛΟΣ ΚΑΘΗΓΗΤΗ</title>
  <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
  <div id="container">

    <h2 class="center"><?php echo $title; ?></h2>
    <br />

    <fieldset><legend>Εισαγωγή ΕΓΓΡΑΦΗΣ του πίνακα των ΤΙΤΛΩΝ ΚΑΘΗΓΗΤΩΝ Τ.Ε.Ι.</legend>
    <form name="form1" action="dualformhandler.php" method="post">

    <?php
      //βάζουμε πεδίο κειμένου για το businessID μόνο στο update (το χρειαζόμαστε!)
      //επίσης το κάνουμε read-only γιατί δεν πρέπει να μεταβληθεί.
      if ($_GET['mode'] == 'update') { ?>

        <p>Κωδικός: <input name="professorTitleID" value="<?php echo $professorTitleID; ?>" readonly="readonly" /></p>

    <?php  //ΕΔΩ ΚΛΕΙΝΕΙ ΤΟ ΠΡΟΗΓΟΥΜΕΝΟ IF

      //ΠΡΟΣΟΧΗ: 

     } ?>


      <p>Ονομασία τίτλου            : <input type="text"   name="titleName"      value="<?php echo $titleName; ?>" /></p>
      <p>Ώρες εβδομαδιαίας εργασίας : <input type="number" name="weekTeachHours" value="<?php echo $weekTeachHours; ?>"/></p>
      <p>Μονιμότητα                 : <input type="radio" name="isStanding"     value="ΟΧΙ"  />            ΟΧΙ
                                      <input type="radio" name="isStanding"      value="ΝΑΙ" />            ΝΑΙ         </p>
      <p>Λεπτομέριες                : <input type="text"   name="otherDetails"   value="<?php echo $otherDetails; ?>" /></p>
                                        
      
      <p> <input type="reset"/><input type="submit"/></p>
    </form>
    </fieldset>

    <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>

  </div>
</body>
</html>
