<?php
  require('../parameteDB.php');
  
       // προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ  DELETE
   if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='delete'  ) {
       $title='Διαγραφή επιλεγμένης ΕΓΓΡΑΦΗΣ από πίνακα';
       $profTitleCode=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε
  
         //εύρεση εγγραφής που θέλουμε να διαγραψουμε
    try {
       //αρχικοποίηση PDO
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
       //παραμετρικό ερώτημα γιατί ενσωματώνουμε data που έστειλε ο χρήστης
      $sql = "DELETE FROM professortitles WHERE professorTitleID = '$profTitleCode'   LIMIT 1";
          //  DELETE FROM `eduschedul`.`professortitles` WHERE `professortitles`.`professorTitleID` = 
      if ($statement= $pdoObject->query($sql)) {
          $record_exists=true;          
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
    else  header('Location: index.php?msg=Record already erased.'); 
  
  }
?>