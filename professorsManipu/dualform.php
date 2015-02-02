<?php

  
  require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
  require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
  require('../errors.php');   //μυνήματα λάθους


  
      // determination of the function use, case of update
  if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) {

    $professorID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε

    $title="μεταβολή εγγραφής Νο $professorID από διαχειριστή!";
    // finding of the record to update it
    try {
      //initialization of PDObject
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
      // parameterized query with data sent by user
      $sql = "SELECT * FROM professors WHERE professorID = :professorID LIMIT 1";
      //compile ερωτήματος στον database server
      $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
      $statement->execute( array( ':professorID'=>$professorID ));
      // one record for query result
      if ($record= $statement->fetch()) { //upon record finding
        // save the result for later
        $record_exists=true;
        // pass the recorded fields to the init. values
        //$~~~ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
        $professorLastName     = $record['professorLastName'];
        $professorMiddleName    = $record['professorMiddleName'];
        $professorFirstName     = $record['professorFirstName'];
        $professorShortName     = $record[ 'professorShortName' ];
        $professorTitleID_ofProfessorTitles=$record[ 'professorTitleID_ofProfessorTitles' ];
        $phoneNumber           =$record['phoneNumber'];
        $identityCardCode       =$record['identityCardCode'];
        $nationalTaxNum       =$record['nationalTaxNum'];
        $emailAddress       =$record['emailAddress'];        
        $locationAddressID_ofLocationAddresses=$record['locationAddressID_ofLocationAddresses'];        
        $jobTitleID_ofJobTitles=$record[ 'jobTitleID_ofJobTitles' ];
        $otherDetails         =$record['otherDetails'];
               
      } else $record_exists=false;  // not existing record Flag state
      // closing of query statement and clearing of PDObject
      $statement->closeCursor();
      $pdoObject= null;
    } catch (PDOException $e) {
        print "Database Error: " . $e->getMessage();

        die("Αδυναμία δημιουργίας PDO Object");
    }


    if (!$record_exists) {
      header('Location: index.php?msg=Record does not exist.');
      exit();
    }
  }
      // determination of the function use, case of insert
  if ( isset($_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
    $title='εισαγωγή ΝΕΑΣ εγγραφής από διαχειριστή!';
    // pass the recorded fields to the init. values 
    $professorID        = '';
    $professorLastName   = '';
    $professorMiddleName  = '';
    $professorFirstName  = ''; 
    $professorShortName   = 'Επίθετ.Πατ.Ονομ.';       
    $phoneNumber         = '';    
    $identityCardCode    = '';
    $nationalTaxNum      = '';
    $emailAddress       = 'name@domain.end';
    $otherDetails      = 'άλλα ατομικά στοιχεία';
    $locationAddressID_ofLocationAddresses   = -1;
    $professorTitleID_ofProfessorTitles     = -1;
    $jobTitleID_ofJobTitles                = -1;
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΝΕΟΣ ΚΑΘΗΓΗΤΗΣ</title>
  <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
  <div id="container">

    <h2 class="center"><?php echo $title; ?></h2>
    <br />

    <fieldset><legend>Εισαγωγή ΕΓΓΡΑΦΗΣ του πίνακα των ΚΑΘΗΓΗΤΩΝ ΤΕΙ</legend>
    <form name="form1" action="dualformhandler.php" method="post">

    <?php
      //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
      if ($_GET['mode'] == 'update') { ?>

       <input name="professorID" value="<?php echo $professorID; ?>" readonly="readonly" hidden />

    <?php                            } ?>  

      <p>Επώνυμο: (κεφαλ.)    <input type="text" size="24"   name="professorLastName"     value="<?php echo $professorLastName; ?>" /></p>
      <p>Πατρόνυμο: (του..)  <input type="text" size="18"     name="professorMiddleName"  value="<?php echo $professorMiddleName; ?>" /></p>
      <p>Όνομα :     <input type="text" size="18" name="professorFirstName"  value="<?php echo $professorFirstName; ?>"/>
         Συντομογραφία Καθηγητή: <input type="text" size="18" name="professorShortName"  value="<?php echo $professorShortName; ?>"/></p>
      <p>Ιδιότητα :
        <select name="professorTitleID_ofProfessorTitles">
          <?php load_options('professortitles', $professorTitleID_ofProfessorTitles) ?>
        </select>
      </p>  
      <p>Κωρικός δελτίου ταυτότ.: <input type="text"  size="11"  name="identityCardCode"  placeholder="ΖΖ 999999"  value="<?php echo $identityCardCode; ?>" /></p>
      <p>Αριθμ. φορολογ. μητρόου: <input type="text"  size="10"  name="nationalTaxNum"  placeholder="999999999" value="<?php echo $nationalTaxNum; ?>" /></p>
      
      <p>Διεύθηνση κατοικίας:
        <select name="locationAddressID_ofLocationAddresses">
          <?php load_options('locationaddresses', $locationAddressID_ofLocationAddresses) ?>
        </select>
      </p>
      <p>Τηλέφωνο επικοινωνίας  : <input type="text"  size="12"  name="phoneNumber" placeholder="9999 999999" value="<?php echo $phoneNumber; ?>" /></p>
      <p>email επικοινωνίας     : <input type="text"  size="32"  name="emailAddress"   value="<?php echo $emailAddress; ?>" /></p>
      
      
      <p>Θέση εργασίας Τεχν.Εκπ.Ιδρ.:
        <select name="jobTitleID_ofJobTitles">
          <?php load_options('jobtitles', $jobTitleID_ofJobTitles) ?>
        </select>
      </p>    
                                  
      <p>Λεπτομέριες: <input type="text"  size="64"  name="otherDetails"   value="<?php echo $otherDetails; ?>" /></p>
                                        
      
      <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
    </form>
    </fieldset>

    <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>

  </div>
</body>
</html>
