<?php
 require('../parameteDB.php');
            // specify the calling of the deletion script
 if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='delete'  ) {
  $title= 'Διαγραφή επιλεγμένης ΕΓΓΡΑΦΗΣ από πίνακα';
  $schoolStudentGroupProfessorID= $_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε
  
 }
         //finding of the record to be erased
 try {  //initialization of PDObject
  $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject -> exec('set names utf8');
      
  $sql = "DELETE FROM schoolstudentgroup_professor_links WHERE schoolStudentGroupProfessorID = '$schoolStudentGroupProfessorID'  LIMIT 1";
       //  DELETE FROM `eduschedul`.`~~` WHERE `~~`.`~~` = 
  if ( $statement= $pdoObject->query($sql) ) { $record_exists=true; } 
  else                                         $record_exists=false;  // not existing record Flag state
  // closing of query statement and clearing of PDObject
  $statement->closeCursor();
  $pdoObject= null;  
 }
 catch ( PDOException $e ) {
  print "Database Error: " . $e->getMessage();
      
  die("Αδυναμία δημιουργίας PDO Object");
 }
   
 if (!$record_exists) {
  header('Location: index.php?msg=Record does not exist.');
  exit();
 }
 else  header('Location: index.php?msg=Record already erased.'); 
?>