<?php

  
  require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
  require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
  require('../errors.php');   //μυνήματα λάθους


  
      // determination of the function use, case of update
  if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) {

    $subjectID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε

    $title="μεταβολή εγγραφής Νο $subjectID από διαχειριστή!";
    // finding of the record to update it
    try {
      //initialization of PDObject
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
      // parameterized query with data sent by user
      $sql = "SELECT * FROM subjects WHERE subjectID=:subjectID LIMIT 1";
      //compile ερωτήματος στον database server
      $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
      $statement->execute( array( ':subjectID'=>$subjectID ));
      // one record for query result
      if ($record= $statement->fetch()) { //upon record finding
        // save the result for later
        $record_exists=true;
        // pass the recorded fields to the init. values
        //$~~~ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
        $subjectName   =$record['subjectName'];
        $description   =$record['description'];
        $levelID       =$record['levelID'];
        $weekTeach     =$record['weekTeach'];
        $otherDetails  =$record['otherDetails'];
        $levelID=$record['levelID'];
               
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
    $subjectID   ='';
    $subjectName ='Θέμα διδασκαλίας';
    $description ='Θέμα διδασκαλίας ΤΕΙ μαθήματος';    
    $weekTeach   =2;
    $otherDetails='Τίτλος εκπαιδευτικού μαθήματος';
    $levelID     =-1;
  }  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΝΕΟΣ ΤΙΤΛΟΣ ΜΑΘΗΜΑΤΟΣ</title>
  <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
  <div id="container">

    <h2 class="center"><?php echo $title; ?></h2>
    <br />

    <fieldset><legend>Εισαγωγή ΕΓΓΡΑΦΗΣ του πίνακα των ΤΙΤΛΩΝ ΜΑΘΗΜΑΤΩΝ ΤΕΙ</legend>
    <form name="form1" action="dualformhandler.php" method="post">

    <?php
      //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
      if ($_GET['mode'] == 'update') { ?>

       <input name="subjectID" value="<?php echo $subjectID; ?>" readonly="readonly" hidden />

    <?php                            } ?>  

      <p>Ονομασία θέματος:            <input type="text" size="64"   name="subjectName"     value="<?php echo $subjectName; ?>" /></p>
      <p>Περιγραφή θέματος:            <input type="text" size="88"   name="description"     value="<?php echo $description; ?>" /></p>
      <p>Ώρες εβδομαδιαίου μαθήματος: <input type="number" size="3" name="weekTeach" value="<?php echo $weekTeach; ?>"/></p>
      
      <p>Κατηγορία:
        <select name="levelID">
          <?php load_options('levels', $levelID) ?>
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
