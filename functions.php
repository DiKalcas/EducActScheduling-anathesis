<?php

function load_options($table, $selected) {
    // virtual choise creator
   //  choose if it will be prechosen
  if ($selected == -1) 
    $extra_attribute='selected="selected"';
  else $extra_attribute='';
   // this is the view of the virtual choise
  echo '<option value="-1" '.$extra_attribute.'>--επιλέξτε--</option>';

    // generate of  <options> 
   //  records of  $table  (as a parameter of function)
  try {
    require('../parameteDB.php'); //database connect parameters    
     //initialization of PDObject and query creator
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);   
    $pdoObject -> exec('set names utf8');
    $sql = "SELECT * FROM $table";
      // instant query to sql because
     //  no input given from user
    $statement = $pdoObject->query($sql);
     // repetitive get of the results from the statement
    while ( $record = $statement->fetch() ) {
       // case of preselected  <option>
      if ($record[0]==$selected)      
        $extra_attribute='selected="selected"';
      else $extra_attribute='';
      //display of the <option>
      echo '<option value="'.$record[0].'" '.$extra_attribute.'>'.$record[1].'</option>';
     
    }
    // clearance of the PDObject
    $statement->closeCursor();
    $pdoObject=null;
  } catch (PDOException $e) {   //block για exception handling
      header('Location: index.php?msg=Πρόβλημα στις Κατηγορίες: '. $e->getMessage());
      exit();
  } 
}
?>

