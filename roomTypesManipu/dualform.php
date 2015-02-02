<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
      // determination of the function use, case of update
 if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) 
 {
  $title='μεταβολή εγγραφής πίνακα από διαχειριστή!';
  $roomTypeID=$_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε
      // finding of the record to update it
  try 
  {
         //initialization of PDObject
   $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      // parameterized query with data sent by user
   $sql = "SELECT * FROM roomtypes WHERE roomTypeID=:roomTypeID LIMIT 1";
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
   $statement->execute( array( ':roomTypeID'=>$roomTypeID ));
         // one record for query result
   if ( $record= $statement->fetch() ) 
   {   //upon record finding
      // save the result for later
    $record_exists=true;
            // pass the recorded fields to the init. values
        //$businessID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $roomTitle=    $record['roomTitle'];
    $roomCapacity= $record['roomCapacity'];
    $roomEquipment= $record['roomEquipment'];
    $otherDetails=  $record['otherDetails'];
   } else $record_exists=false;  // not existing record Flag state
      // closing of query statement and clearing of PDObject
    $statement->closeCursor();
    $pdoObject= null;
  }
   catch ( PDOexception $e )
  { 
   print "Database Error: " . $e->getMessage();

   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
     // determination of the function use, case of insert
 if ( isset($_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
  $title='εισαγωγή εγγραφής πίνακα από διαχειριστή!';
    // pass the recorded fields to the init. values 
  $roomTypeID=    '';
  $roomTitle=     'ΑΙΘΟΥΣΑ ΔΙΔΑΣΚΑΛΙΑΣ';
  $roomCapacity=  3;
  $roomEquipment= 'Βασικός';
  $otherDetails=  'Γενικός τύπος Αίθουσας διδασκαλίας';
    
 }  
?> 

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟΣ ΤΥΠΟΣ ΑΙΘΟΥΣΑΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΕΙΣΑΓΩΓΗ ΕΓΓΡΑΦΗΣ - ΤΥΠΩΝ ΑΙΘΟΥΣΩΝ ΔΙΔΑΣΚΑΛΙΑΣ</legend>
  <form name="form1" action="dualformhandler.php" method="post">

<?php  //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
 if ($_GET['mode'] == 'update') 
  { 
?>

<p>Κωδικός: <input name="roomTypeID" value="<?php echo $roomTypeID; ?>" readonly="readonly" /></p>

<?php  //ΕΔΩ ΚΛΕΙΝΕΙ ΤΟ ΠΡΟΗΓΟΥΜΕΝΟ IF 
  }
?>

  <p>Ονομασία τύπου αίθουσας: <input type="text"  size="58"  name="roomTitle"      value="<?php echo $roomTitle; ?>" /></p>
  <p>Δυνατότητα φιλοξενίας φοιτητών (θέσεις): <input type="number" size="4" name="roomCapacity" value="<?php echo $roomCapacity; ?>"/></p>
  <p>Εξοπλισμός χώρου για διδασκαλία: <input type="text" size="52" name="roomEquipment"     value="<?php echo $roomEquipment; ?>"  />                     </p>
  <p>Λεπτομέριες: <input type="text"  size="70"  name="otherDetails"   value="<?php echo $otherDetails; ?>" /></p>
  <p> <input type="reset"/><input type="submit"/></p>

  </form>  
  </fieldset>
  <p class="right"><a href="index.php">Αρχική Σελίδα</a></p>
 </div>  
</body>
</html>