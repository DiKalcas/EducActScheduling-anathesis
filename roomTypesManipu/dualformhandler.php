<?php
 require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 
         //Πρώτα θα προσδιορίσουμε αν θα επιχειρηθεί INSERT ή UPDATE. Θα βασιστούμε
        //στην ύπαρξη ή όχι του $_POST['businessID'] δεδομένου ότι αυτό θα υπάρχει
       //μόνο στο UPDATE (γιατί έτσι έχουμε φτιάξει τη φόρμα).
      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
 if ( isset($_POST['roomTypeID']) )  
  $mode='update'; 
 else $mode='insert';
//        //αν κάνουμε update
//  if ( $mode == 'update' ) 
//  {    //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
//   if ( !isset( $_POST['roomTypeID'], $_POST['roomTitle'], $_POST['roomCapacity'] ) ) 
//   { 
//    header('Location: index.php?msg=ERROR: missing data (trying update)');
//    exit();
//   }  
//  }       
 if ($mode=='insert') {   //αν κάνουμε insert
                         //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
  if ( !isset($_POST['roomTitle'], $_POST['roomCapacity'], $_POST['roomEquipment']) ) { 
   header('Location: index.php?msg=ERROR: missing data (trying insert)');
   exit();
  }  
 }
     //καθαρίζουμε τυχόν spaces στην αρχή ή στο τέλος του αλφαριθμητικού
    //ΠΑΝΤΑ το κάνουμε αυτό σε πεδία κειμένου συμπληρωμένα από χρήστες
//  $roomTypeID= trim($_POST['$roomTypeID']);
//       //αν δεν έχει δώσει επωνυμία έχουμε πρόβλημα
//  if ( $roomTypeID == '' ) {
//     header('Location: index.php?msg=ERROR: invalid basic field for ident. (empty string)');
//     exit();
//   }

  // ---- ΤΕΛΟΣ ΕΛΕΓΧΩΝ - ΣΥΝΕΧΙΖΟΥΜΕ ΜΕ ΤΟ INSERT ή το UPDATE ---- 

 try { //σύνδεση με PDO
  $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject -> exec('set names utf8');
      //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 
     //περίπτωση INSERT
 if ( $mode == 'insert' ) {
  $sql='INSERT INTO roomtypes (roomTitle, roomCapacity, roomEquipment, otherDetails)
            VALUES                    (:roomTitle, :roomCapacity, :roomEquipment, :otherDetails)';
      $statement = $pdoObject->prepare($sql);
      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
      $myResult= $statement->execute( array(  ':roomTitle'=>$_POST['roomTitle'],
                                              ':roomCapacity'=>$_POST['roomCapacity'],
                                              ':roomEquipment'=>$_POST['roomEquipment'],
                                              ':otherDetails'=>$_POST['otherDetails']
                                              ) );
    }
    //περίπτωση UPDATE
 if ( $mode == 'update' ) {
  $sql= 'UPDATE roomtypes
         SET 	roomTitle=:roomTitle, roomCapacity=:roomCapacity, roomEquipment=:roomEquipment, otherDetails=:otherDetails
              WHERE roomTypeID=:roomTypeID';
        $statement= $pdoObject->prepare($sql);
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult= $statement->execute( array( ':roomTitle'=>$_POST['roomTitle'],
                                               ':roomCapacity'=>$_POST['roomCapacity'],
                                               ':roomEquipment'=>$_POST['roomEquipment'],
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':roomTypeID'=>$_POST['roomTypeID']  ) );
 }
      // κλείσιμο PDO
  $statement->closeCursor();
  $pdoObject = null;
 } 
 catch (PDOException $e) {
      //ας κάνουμε κάτι διαφορετικό από το σύνηθες των slide
 header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
 exit();
 }
       // αναφορά πιθανού προβλήματος στην εκτέλεση του SQL
 if ( !$myResult ) {
  header('Location: index.php?msg=ERROR: failed to execute sql query');
  exit();
 }
 else {
   //ALL DONE!
  header('Location: index.php?msg=ALL well done!');
 exit();
 }
?>