<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 
     //Πρώτα θα προσδιορίσουμε αν θα επιχειρηθεί INSERT ή UPDATE. Θα βασιστούμε
    //στην ύπαρξη ή όχι του $_POST['businessID'] δεδομένου ότι αυτό θα υπάρχει
   //μόνο στο UPDATE (γιατί έτσι έχουμε φτιάξει τη φόρμα).

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['professorTitleID']) )  
    $mode='update'; 
  else $mode='insert';

      //αν κάνουμε update
  if ($mode == 'update') { 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset($_POST['professorTitleID'], $_POST['titleName'], $_POST['weekTeachHours'], $_POST['isStanding']) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //αν κάνουμε insert
  if ($mode=='insert') {
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset($_POST['titleName'], $_POST['weekTeachHours'], $_POST['isStanding']) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }
  
  //αν έχει επιλεγεί η ψευδοεπιλογή από τις κατηγορίες έχουμε πρόβλημα
//   if ($_POST['categoryID']=='-1') {     
//     header('Location: index.php?msg=ERROR: invalid categoryID (-1)');
//     exit();
//   }

    //καθαρίζουμε τυχόν spaces στην αρχή ή στο τέλος του αλφαριθμητικού
   //ΠΑΝΤΑ το κάνουμε αυτό σε πεδία κειμένου συμπληρωμένα από χρήστες
  $professorTitleID= trim($_POST['$professorTitleID']);

   //αν δεν έχει δώσει επωνυμία έχουμε πρόβλημα
  if ( $professorTitleID == '' ) {
    header('Location: index.php?msg=ERROR: invalid basic field for ident. (empty string)');
    exit();
  }

  // ---- ΤΕΛΟΣ ΕΛΕΓΧΩΝ - ΣΥΝΕΧΙΖΟΥΜΕ ΜΕ ΤΟ INSERT ή το UPDATE ----

    //ορίζουμε μια μεταβλητή για παρακολούθηση του τι έγινε συνολικά και την
   //αρχικοπιούμε σε false, δεδομένου ότι ακόμη δεν έγινε το ζητούμενο.
  $myResult=false;
  
  try { //σύνδεση με PDO
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 

    //περίπτωση INSERT
    if ($mode == 'insert') {
      $sql='INSERT INTO professortitles (titleName, weekTeachHours, isStanding, otherDetails)
            VALUES                    (:titleName, :weekTeachHours, :isStanding, :otherDetails)';
      $statement = $pdoObject->prepare($sql);
      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
      $myResult= $statement->execute( array(  ':titleName'=>$_POST['titleName'],
                                              ':weekTeachHours'=>$_POST['weekTeachHours'],
                                              ':isStanding'=>$_POST['isStanding'],
                                              ':otherDetails'=>$_POST['otherDetails']
                                              ) );
    }

    //περίπτωση UPDATE
    if ($mode == 'update') {
        $sql= 'UPDATE professortitles
               SET 	titleName=:titleName, weekTeachHours=:weekTeachHours, isStanding=:isStanding, otherDetails=:otherDetails
              WHERE professorTitleID=:professorTitleID';
        $statement= $pdoObject->prepare($sql);
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult= $statement->execute( array( ':titleName'=>$_POST['titleName'],
                                               ':weekTeachHours'=>$_POST['weekTeachHours'],
                                               ':isStanding'=>$_POST['isStanding'],
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':professorTitleID'=>$_POST['professorTitleID']  ) );
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