<?php
 require('../parameteDB.php'); //database connection parameters
 
         //insert or update determination
        
      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
 if ( isset($_POST['roomTypeID']) )  
  $mode='update'; 
 else $mode='insert';

        // in case of update function handler      
 if ($mode=='insert') {   //in case of insert function handler
                         //check if the data sent is complete
  if ( !isset($_POST['roomTitle'], $_POST['roomCapacity'], $_POST['roomEquipment']) ) { 
   header('Location: index.php?msg=ERROR: missing data (trying insert)');
   exit();
  }  
 }



 try { //database connection using PDObject
  $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject -> exec('set names utf8');
      //sql query parameters differentiation  
     //in case of insert function handler
 if ( $mode == 'insert' ) {
  $sql='INSERT INTO roomtypes (roomTitle, roomCapacity, roomEquipment, otherDetails)
            VALUES                    (:roomTitle, :roomCapacity, :roomEquipment, :otherDetails)';
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array(  ':roomTitle'=>$_POST['roomTitle'],
                                              ':roomCapacity'=>$_POST['roomCapacity'],
                                              ':roomEquipment'=>$_POST['roomEquipment'],
                                              ':otherDetails'=>$_POST['otherDetails']
                                              ) );
    }
    //in case of update function handler
 if ( $mode == 'update' ) {
  $sql= 'UPDATE roomtypes
         SET 	roomTitle=:roomTitle, roomCapacity=:roomCapacity, roomEquipment=:roomEquipment, otherDetails=:otherDetails
              WHERE roomTypeID=:roomTypeID';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':roomTitle'=>$_POST['roomTitle'],
                                               ':roomCapacity'=>$_POST['roomCapacity'],
                                               ':roomEquipment'=>$_POST['roomEquipment'],
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':roomTypeID'=>$_POST['roomTypeID']  ) );
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