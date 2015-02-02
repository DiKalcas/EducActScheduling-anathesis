<?php

  
  require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
  require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
  require('../errors.php');   //μυνήματα λάθους


  
      // determination of the function use, case of update
  if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) {

    $locationAddressID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε

    $title="μεταβολή εγγραφής Νο $locationAddressID από διαχειριστή!";
    // finding of the record to update it
    try {
      //initialization of PDObject
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
      // parameterized query with data sent by user
      $sql = "SELECT * FROM locationaddresses WHERE locationAddressID = :locationAddressID LIMIT 1";
      //compile ερωτήματος στον database server
      $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
      $statement->execute( array( ':locationAddressID'=>$locationAddressID ));
      // one record for query result
      if ($record= $statement->fetch()) { //upon record finding
        // save the result for later
        $record_exists=true;
        // pass the recorded fields to the init. values
        //$~ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
        $city=            $record['city'];
        $area=              $record['area'];
        $address=         $record['address'];
        $zipPostCode=      $record['zipPostCode'];
        $province=         $record['province'];
        $country=         $record['country'];        
        $otherDetails=     $record['otherDetails'];
               
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
  if ( isset( $_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
    $title='εισαγωγή ΝΕΑΣ εγγραφής από διαχειριστή!';
    // pass the recorded fields to the init. values 
    $locationAddressID=  '';
    $city=               '';
    $area=               '';
    $address=            '';
    $zipPostCode=        '';
    $province=           'Θεσσαλία';
    $country=            'Ελλάδα';   
    $otherDetails=       'άλλα στοιχεία τοποθεσίας';
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΝΕΑ ΔΙΕΥΘΗΝΣΗ</title>
  <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
  <div id="container">

    <h2 class="center"><?php echo $title; ?></h2>
    <br />

    <fieldset><legend>Εισαγωγή ΕΓΓΡΑΦΗΣ του πίνακα των ΔΙΕΥΘΗΝΣΕΩΝ</legend>
    <form name="form1" action="dualformhandler.php" method="post">

    <?php
      //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
      if ($_GET['mode'] == 'update') { ?>

       <input name="locationAddressID" value="<?php echo $locationAddressID; ?>" readonly="readonly" hidden />

    <?php     } ?>  

      <p> Πόλη διεύθηνσης: (κεφ.) <input type="text" size="32"   name="city"     value="<?php echo $city; ?>" /></p>
      <p> Περιοχή διεύθηνσης :  <input type="text"  size="48"     name="area"     value="<?php echo $area; ?>"/></p>
      <p> Διεύθηνση τοποθεσίας:  <input type="text"  size="64"     name="address"     value="<?php echo $address; ?>"/></p>
      <p> Ταχυδρομ. κώδικας :  <input type="text"  size="6"  placeholder="99999"   name="zipPostCode"     value="<?php echo $zipPostCode; ?>"/></p>
      <p> Επαρχία: <input type="text"  size="32"     name="province"     value="<?php echo $province; ?>"/></p>
      <p> Χώρα : <input type="text"  size="32"     name="country"     value="<?php echo $country; ?>"/></p>
      <p> Λεπτομέριες: <input type="text"  size="64"  name="otherDetails"   value="<?php echo $otherDetails; ?>" /></p>
                                        
      
      <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
    </form>
    </fieldset>

    <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>

  </div>
</body>
</html>
