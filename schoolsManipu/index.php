<?php
 require('..\functions.php');
 require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΣΧΟΛΕΣ-ΤΜΗΜΑΤΑ Τ.Ε.Ι.</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>

<body>

<div id="results">
 <p class="center">
    [ id | ΟΝΟΜΑΣΙΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ] - [ ΤΑΧ. ΚΩΔ. | ΔΙΕΥΘΗΝΣΗ | ΠΕΡΙΟΧΗ | ΠΟΛΗ | id ]
    
<?php
 require_once('..\parameteDB.php');//the database connection param.
 try {        
  $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject->exec('set names utf8');

  $sql = 'SELECT schoolID, schoolSectionName, locationAddressID, city, area, address
          FROM locationaddresses INNER JOIN schools 
          ON schools.locatAddressID_byLocationAddresses = locationaddresses.locationAddressID';

  $statement= $pdoObject->query($sql);

  $recoCounter= 0;
  while ( $record= $statement->fetch() ) {

  $recoCounter++;
  echo '<p class="result">' 
   . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['schoolID'] .'"><img src="../deleteButton.png"/></a>' 
   . '~ [ ' . $record[ 'schoolID' ] 
   . ' | ' . $record[ 'schoolSectionName' ] . '</span>' 
   . ' ]<span> - </span>[<span>' . $record[ 'address' ] 
   . ' | '. $record[ 'area' ] 
   . ' | '  . $record[ 'city' ]
   . ' | ' . $record[ 'locationAddressID' ]
   . ' ]..' . '<a href="dualform.php?mode=update&id1=' . $record['schoolID'] .'&id2=' . $record['locationAddressID'] .'"><img src="../editButton.png"/></a>
            </span></p>';
  }

  $statement->closeCursor();//query results closing
  $pdoObject = null;       //database connection closing
 }
 catch (PDOException $e) {
    
  echo 'PDO Exception: '.$e->getMessage();
  
 }    
?>  

 <p id="commands"> Σύνολο <?php echo $recoCounter; ?> Εγγραφών<a href="dualform.php?mode=insert"> Προσθήκη ΝΕΑΣ εγγραφής</a></p>  
 </p>
</div>

<div><?php echo_msg(); 
                   if( isset($_GET['lastid']) ) {echo  $_GET['lastid']; } ?>
</div>

</body>
</html>
