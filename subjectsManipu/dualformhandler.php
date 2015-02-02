<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update
   
      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['subjectID']) )  
    $mode='update'; 
  else $mode='insert';

      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset($_POST['subjectID'], $_POST['subjectName'], $_POST['description'], $_POST['weekTeach'], $_POST['otherDetails'], $_POST['levelID']) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset( $_POST['subjectName'], $_POST['description'], $_POST['weekTeach'], $_POST['otherDetails'], $_POST['levelID'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }
  
  //αν έχει επιλεγεί η ψευδοεπιλογή από τις κατηγορίες έχουμε πρόβλημα
  if ($_POST['categoryID']=='-1') {     
    header('Location: index.php?msg=ERROR: invalid categoryID (-1)');
    exit();
  }



    //create a Flag variable to check the query result
   //init. this Flag negativily in order to start the procedure
  $myResult=false;
  
  try { //database connection using PDObject
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');
    //sql query parameters differentiation  

    //in case of insert function handler
    if ($mode == 'insert') {
      $sql='INSERT INTO subjects (subjectName, description, weekTeach, otherDetails, levelID)
            VALUES               (:subjectName, :description, :weekTeach, :otherDetails, :levelID)';
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array(  ':subjectName'=>$_POST['subjectName'],
                                              ':description'=>$_POST['description'],
                                              ':weekTeach'=>$_POST['weekTeach'],
                                              ':otherDetails'=>$_POST['otherDetails'],
                                              ':levelID'=>$_POST['levelID']
                                              ) );
    }

    //in case of update function handler
    if ($mode == 'update') {
        $sql= 'UPDATE subjects
               SET  subjectName=:subjectName, description=:description, weekTeach=:weekTeach, otherDetails=:otherDetails, levelID=:levelID
              WHERE subjectID=:subjectID';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':subjectName'=>$_POST['subjectName'],
                                               ':description'=>$_POST['description'],
                                               ':weekTeach'=>$_POST['weekTeach'],
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':levelID'=>$_POST['levelID'],
                                               ':subjectID'=>$_POST['subjectID'] ) );
    }

    //  closing of the query statement and clearin the PDObject
    $statement->closeCursor();
    $pdoObject = null;
  } 
  catch (PDOException $e) {
     
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }
  
  
  if ( !$myResult ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
   
    header('Location: index.php?msg=ALL well done!');
    exit();
  }


 ?>