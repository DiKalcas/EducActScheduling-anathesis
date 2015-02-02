<?php
 require('..\functions.php');
 require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΤΥΠΟΙ ΑΙΘΟΥΣΩΝ ΔΙΔΑΣΚΑΛΙΑΣ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>

<div class="center"><?php echo_msg(); ?></div>

<div id="results">
 <p class="center">
    [ ΚΩΔΙΚΟΣ - ΟΝΟΜ_ΤΥΠΟΟΥ_ΑΙΘΟΥΣΑΣ - ΘΕΣΕΙΣ_ΦΟΙΤΗΤΩΝ - ΕΞΟΠΛΙΣΜΟΣ_ΔΙΔΑΣΚΑΛΙΑΣ - ΛΕΠΤΟΜΕΡΙΕΣ ]
    
<?php
 require_once('..\parameteDB.php');//the database connection param.
 try {          
  $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject->exec('set names utf8');

  $sql = 'SELECT * FROM roomtypes';

  $statement= $pdoObject->query($sql);

  $recoCounter= 0;
  while ( $record= $statement->fetch() ) {

  $recoCounter++;
  echo '<p class="result">' 
   . '<a href="deleteRecord.php?mode=delete&id=' . $record['roomTypeID'] .'"><img src="../deleteButton.png"/></a>' 
   . '~ [' . $record[ 'roomTypeID' ] 
   . ' - ' . $record[ 'roomTitle' ]
   . ' - ' . $record[ 'roomCapacity' ] 
   . ' - ' . $record[ 'roomEquipment' ]
   . ' - ' . $record[ 'otherDetails' ]
   .  ']..' . '<a href="dualform.php?mode=update&id=' . $record['roomTypeID'] .'"><img src="../editButton.png"/></a>
            </p>';
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

</body>
</html>
