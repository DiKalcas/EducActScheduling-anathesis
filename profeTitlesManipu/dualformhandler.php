<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['professorTitleID']) )  
    $mode='update'; 
  else $mode='insert';

      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset($_POST['professorTitleID'], $_POST['titleName'], $_POST['weekTeachHours'], $_POST['isStanding']) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset( $_POST['titleName'], $_POST['weekTeachHours'], $_POST['isStanding'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
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
      $sql='INSERT INTO professortitles (titleName, weekTeachHours, isStanding, otherDetails)
            VALUES                    (:titleName, :weekTeachHours, :isStanding, :otherDetails)';
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array(  ':titleName'=>$_POST['titleName'],
                                              ':weekTeachHours'=>$_POST['weekTeachHours'],
                                              ':isStanding'=>$_POST['isStanding'],
                                              ':otherDetails'=>$_POST['otherDetails']
                                              ) );
    }

    //in case of update function handler
    if ($mode == 'update') {
        $sql= 'UPDATE professortitles
               SET 	titleName=:titleName, weekTeachHours=:weekTeachHours, isStanding=:isStanding, otherDetails=:otherDetails
              WHERE professorTitleID=:professorTitleID';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':titleName'=>$_POST['titleName'],
                                               ':weekTeachHours'=>$_POST['weekTeachHours'],
                                               ':isStanding'=>$_POST['isStanding'],
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':professorTitleID'=>$_POST['professorTitleID']  ) );
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