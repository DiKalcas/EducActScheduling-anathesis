<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΔΙΕΥΘΥΝΣΕΙΣ-ΤΟΠΟΘΕΣΙΕΣ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div id="head">διευθύνσεις σχολών και καθηγητών τεχνολογικού εκπαιδευτ. ιδρύμ.</div>

<div id="results">
  <p class="center">
    id[ ΠΟΛΗ | ΠΕΡΙΟΧΗ | ΤΑΧ.ΚΩΔΙΚΟΣ | ΔΙΕΥΘΥΝΣΗ ]
  </p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');

    $sql = 'SELECT *   FROM locationaddresses';
    
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">' 
         . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['locationAddressID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~</span>' . $record[ 'locationAddressID' ] 
         . ' [ ' . $record[ 'city' ] 
         . ' | ' . $record[ 'area' ]
         . ' | ' . $record[ 'zipPostCode' ]          
         . ' | ' . $record[ 'address' ]

         .  ' ]<span>..' . '<a href="dualform.php?mode=update&id=' . $record['locationAddressID'] .'"><img src="../editButton.png"/></a></span>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
   
     echo 'PDO Exception: '.$e->getMessage();
    
   }
?>
<p><?php echo_msg(); ?></p>
<p id="commands"><span><a href="../pageOfResourcer.php" title="Επιστροφή στην Σελίδα του Συνδιαστή"><b>home&nbsp;Combiner</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="dualform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>

</body>
</html>
