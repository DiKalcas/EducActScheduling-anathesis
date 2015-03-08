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

<div id="head">λίστα ενεργών τμημάτων-σχολών και έδρα τμήματος τεχνολογ.εκπαιδ.ιδρύμ.</div>


<div id="results">
 <p class="center"><b>
    [ id | ΟΝΟΜΑΣΙΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ] - [ ΤΑΧ. ΚΩΔ. | ΔΙΕΥΘΗΝΣΗ | ΠΕΡΙΟΧΗ | ΠΟΛΗ | id ]
 </b></p>
    
<?php
 require_once('..\parameteDB.php');//the database connection param.
 try {        
  $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject->exec('set names utf8');

  $sql = 'SELECT schoolID, schoolSectionName, locationAddressID, city, area, address
          FROM locationaddresses INNER JOIN schools 
          ON schools.locatAddressID_byLocationAddresses = locationaddresses.locationAddressID
          ORDER BY schoolID';

  $statement= $pdoObject->query($sql);

  $recoCounter= 0;
  while ( $record= $statement->fetch() ) {

  $recoCounter++;
  echo '<p class="result">' 
   . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['schoolID'] .'"><img src="../deleteButton.png"/></a>' 
   . '~</span>[ ' . $record[ 'schoolID' ] 
   . ' | ' . $record[ 'schoolSectionName' ] . '' 
   . ' ] - [' . $record[ 'address' ] 
   . ' | '. $record[ 'area' ] 
   . ' | '  . $record[ 'city' ]
   . ' | ' . $record[ 'locationAddressID' ]
   . ' ]<span>..' . '<a href="dualform.php?mode=update&id1=' . $record['schoolID'] .'&id2=' . $record['locationAddressID'] .'"><img src="../editButton.png"/></a></span>
      </p>';
  }

  $statement->closeCursor();//query results closing
  $pdoObject = null;       //database connection closing
 }
 catch (PDOException $e) {
    
  echo 'PDO Exception: '.$e->getMessage();
  
 }    
?> 
 
<p><?php 
     echo_msg(); 
    ?>
</p>

<p id="commands"><span><a href="../pageOfResourcer.php" title="Επιστροφή στην Σελίδα των Εκπαιδ.Πόρων"><b>home&nbsp;Resourcer</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="dualform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>



</body>
</html>
