<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους
                  // determination of the function use, case of update
 if ( isset($_GET['mode'], $_GET['id1'], $_GET['id2'] ) &&  $_GET['mode']=='update'  ) 
 {
  
  $schoolID=                           $_GET['id1'];   //το ID της εγγραφής
  $locatAddressID_byLocationAddresses= $_GET['id2'];  //  που θα μεταβάλλουμε
  $title=  "εγγραφή No $schoolID μεταβολή από διαχειριστή!";
      // finding of the record to update it
  try {         //initialization of PDObject
   $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
   $pdoObject->exec('set names utf8');
      // parameterized query with data sent by user
   $sql= "SELECT * FROM schools WHERE schoolID=:schoolID LIMIT 1";
         //compile ερωτήματος στον database server
   $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
   $statement->execute( array( ':schoolID'=>$schoolID ));
             // one record for query result
   if ( $record= $statement->fetch() ) 
   {   //upon record finding
      // save the result for later
    $record_exists=true;
         // pass the recorded fields to the init. values
        //$___ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $schoolSectionName=                  $record[ 'schoolSectionName' ];
    $schoolSectionAbbrev=                $record[ 'schoolSectionAbbrev' ];
    $locatAddressID_byLocationAddresses= $record[ 'locatAddressID_byLocationAddresses' ];
    
   }
   else $record_exists=false;  // not existing record Flag state
         // closing of query statement and clearing of PDObject
      $statement->closeCursor();
      $pdoObject= null;
  }
   catch ( PDOexception $e ) { 
   print "Database Error: " . $e->getMessage();

   die("Αδυναμία δημιουργίας PDO Object");
  }
 }
                  // determination of the function use, case of insert
 if ( isset($_GET['mode'] ) &&  $_GET['mode']=='insert'  ) {
    $title='εισαγωγή εγγραφής τμήματος(σχολής) από διαχειριστή!';
             //pass default values to form init. variables 
    $schoolID=                           '';
    $schoolSectionName=                  '';
    $schoolSectionAbbrev=                '';
    $locatAddressID_byLocationAddresses= '';
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟ ΤΜΗΜΑ ΣΧΟΛΗΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΟΝΟΜΑΣΙΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ ΤΕΙ</legend>
  <form name="form1" action="dualformhandler.php" method="post">

<?php  //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
 if ($_GET['mode'] == 'update') { ?>

  <input name="schoolID" value="<?php echo $schoolID; ?>" readonly="readonly" hidden />

<?php   }  ?>

  <p>Τίτλος Τμήματος σχολής Τ.Ε.Ι.(ΣΧΟΛΗ): <input type="text"  size="82"  name="schoolSectionName"  
     placeholder="ΣΧΕΔΙΑΣΜΟΥ ΚΑΙ ΤΕΧΝΟΛΟΓΙΑΣ ΞΥΛΟΥ ΚΑΙ ΕΠΙΠΛΟΥ Τ.Ε. Τμήμα(ΣΤΕΦ)"   value="<?php echo $schoolSectionName; ?>" /></p>
  <p>Συντομογραφία τίτλου σχολής: <input type="text"  size="32"  name="schoolSectionAbbrev"  
     placeholder="Σχεδιασ.Τεχνολ.Ξύλου&Επίπλου"   value="<?php echo $schoolSectionAbbrev; ?>" /></p>

   <input type="radio" name="locatAddressID_byLocationAddresses"    value="1001"  checked     />  Έδρα σχολής Λάρισα &nbsp&nbsp|&nbsp  

<?php if ( $locatAddressID_byLocationAddresses == 1002 ) { ?>  
                          <input type="radio" name="locatAddressID_byLocationAddresses"     value="1002" checked    />  Έδρα σχολής Τρίκαλα &nbsp&nbsp|&nbsp 
<?php } else { ?>
                          <input type="radio" name="locatAddressID_byLocationAddresses"      value="1002"          />   Έδρα σχολής Τρίκαλα &nbsp&nbsp|&nbsp   
<?php        } ?>

<?php  if ( $locatAddressID_byLocationAddresses == 1003 ) { ?>  
                          <input type="radio" name="locatAddressID_byLocationAddresses"     value="1003" checked    />   Έδρα σχολής Καρδίτσα 
<?php } else { ?>
                          <input type="radio" name="locatAddressID_byLocationAddresses"      value="1003"          />    Έδρα σχολής Καρδίτσα   
<?php        } ?>
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php" title="Επιστροφή χωρίς καμία λειτουργία φόρμας"><b>go.back</b></a></p>
 </div> 
</body>
</html>

