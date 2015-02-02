<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['schoolID'], $_POST['locatAddressID_byLocationAddresses']) )  
    $mode='update'; 
  else $mode='insert';
  
      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset( $_POST['schoolID'], $_POST['schoolSectionName'], $_POST['schoolSectionAbbrev'], $_POST['locatAddressID_byLocationAddresses'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }
  
      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset( $_POST['schoolSectionName'], $_POST['schoolSectionAbbrev'], $_POST['locatAddressID_byLocationAddresses'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }
 

    //create a Flag variable to check the query result
   //init. this Flag negativily in order to start the procedure
  $myResult=false;
  
  try { //database connection using PDObject
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //sql query parameters differentiation  

    //in case of insert function handler
    if ($mode == 'insert') {
      $sql='INSERT INTO schools  ( schoolSectionName, schoolSectionAbbrev, locatAddressID_byLocationAddresses )
            VALUES               ( :schoolSectionName, :schoolSectionAbbrev, :locatAddressID_byLocationAddresses )';
      $statement= $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array( ':schoolSectionName'=>$_POST['schoolSectionName'],
                                             ':schoolSectionAbbrev'=>$_POST['schoolSectionAbbrev'],
                                             ':locatAddressID_byLocationAddresses'=>$_POST['locatAddressID_byLocationAddresses'] ) );                                                                                      
      $lastid= $pdoObject->lastInsertId();
       
    }
    //in case of update function handler
    if ($mode == 'update') {
        $sql= 'UPDATE schools
                SET schoolSectionName = :schoolSectionName, 
                    schoolSectionAbbrev = :schoolSectionAbbrev,
                    locatAddressID_byLocationAddresses = :locatAddressID_byLocationAddresses
                WHERE schoolID = :schoolID';
        $statement= $pdoObject->prepare($sql);                     
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':schoolSectionName'=>$_POST['schoolSectionName'],
                                               ':schoolSectionAbbrev'=>$_POST['schoolSectionAbbrev'],
                                               ':locatAddressID_byLocationAddresses'=>$_POST[ 'locatAddressID_byLocationAddresses' ],
                                               ':schoolID'=>$_POST[ 'schoolID' ]  ) );
    }  
    //  closing of the query statement and clearin the PDObject
    $statement->closeCursor();
    $pdoObject= null;
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
   
    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>