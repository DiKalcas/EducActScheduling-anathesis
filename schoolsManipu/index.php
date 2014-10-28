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

<div class="center"><?php echo_msg(); ?></div>

<div id="results">
 <p class="center">
    [ ΚΩΔΙΚΟΣ - ΟΝΟΜΑΣΙΑ_ΤΜΗΜΑΤΟΣ_ΣΧΟΛΗΣ ] - [ ΠΕΡΙΟΧΗ - ΠΟΛΗ - ΚΩΔΙΚΟΣ ]
    
<?php
   // ενσωμάτωση παραμέτρων σύνδεσης στην database
 require_once('..\parameteDB.php');
 try {          // ενεργοποίηση της υποδομής PDO για διασύνδεση PHP και MySQL
  $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
  $pdoObject->exec('set names utf8');
             // διατύπωση SQL ερωτήματος - ΧΩΡΙΣ PDO μεταβλητές
            //professorTitleID, titleName, weekTeachHours, isStanding, otherDetails
  $sql = 'SELECT schoolID, schoolSectionName, locationAddressID, area, city 
          FROM locationaddresses INNER JOIN schools 
          ON schools.locatAddressID_byLocationAddresses = locationaddresses.locationAddressID';
       // απευθείας εκτέλεση του ερωτήματος - χωρίς PDO μεταβλητές και prepare
      // Δεν κάνουμε prepare γιατί δεν υπάρχουν παράμετροι προερχόμενες από
     // εξωτερικό χρήστη ώστε να απαιτούνται μέτρα προστασίας από sql injection
  $statement= $pdoObject->query($sql);
      // στο αντικέιμενο $statement υπάρχουν τα αποτελέσματα του ερωτήματος
     // κατανάλωση απότελεσμάτων - θα τυπώσουμε λίστα με τα καταστήματα
  $recoCounter= 0;
  while ( $record= $statement->fetch() ) {
       // μια τυπική γραμμή που θέλουμε να φτιάξουμε είναι η ακόλουθη
      // <p class="result">Όλυμπος - Ταβέρνα <a href="dualform.php?mode=update&id=2"><img src="edit.png"/></a> </p>
  $recoCounter++;
  echo '<p class="result">' 
   . '<a href="deleteRecord.php?mode=delete&id=' . $record['schoolID'] .'"><img src="../deleteButton.png"/></a>' 
   . '~ [' . $record[ 'schoolID' ] 
   . ' - ' . $record[ 'schoolSectionName' ]
   . ' - ' . $record[ 'area' ]
   . ' -'  . $record[ 'city' ]
   . ' - ' . $record[ 'locationAddressID' ]
   .  ']..' . '<a href="dualform.php?mode=update&id1=' . $record['schoolID'] .'&id2=' . $record['locationAddressID'] .'"><img src="../editButton.png"/></a>
            </p>';
  }
       // κλείσιμο αποτελεσμάτων ερωτήματος
  $statement->closeCursor();
     // κλείσιμο σύνδεσης με database
  $pdoObject = null;  
 }
 catch (PDOException $e) {
     //σε φάση ανάπτυξης, τυπώνουμε το πρόβλημα
  echo 'PDO Exception: '.$e->getMessage();
   //σε φάση λειτουργίας καλύτερα να τυπώσουμε κάτι λιγότερο τεχνικό
 }    
?>  

 <p id="commands"> Σύνολο <?php echo $recoCounter; ?> Εγγραφών<a href="dualform.php?mode=insert"> Προσθήκη ΝΕΑΣ εγγραφής</a></p>  
 </p>
</div>

</body>
</html>
