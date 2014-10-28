<?php



function load_options($table, $selected) {
  //Πρώτα θα φτιάξουμε την ψευδοεπιλογή.
  //Αποφασίζουμε αν θα την προεπιλέξουμε:
  if ($selected == -1) 
    $extra_attribute='selected="selected"';
  else $extra_attribute='';
  //Γράφουμε τον HTML κώδικα της ψευδοεπιλογής
  echo '<option value="-1" '.$extra_attribute.'>--επιλέξτε--</option>';

  //Τώρα θα φτιάξουμε τα <options> που αντιστοιχούν στις
  //εγγραφές του πίνακα $table (παράμετρος της συνάρτησης)
  try {
    //ενσωμάτωση παραμέτρων σύνδεσης
    require('db_params.php');    
    //ενεργοποίηση PDO και δημιουργία ερωτήματος
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);   
    $pdoObject -> exec('set names utf8');
    $sql = "SELECT * FROM $table";
    //ακολουθεί απευθείας εκτέλεση του ερωτήματος καθώς δεν υπάρχουν
    //δεδομένα από εξωτερικό χρήστη ώστε να απαιτούνται παράμετροι και prepare
    $statement = $pdoObject->query($sql);
    //ακολουθεί loop "κατανάλωσης" αποτελεσμάτων ερωτήματος
    while ( $record = $statement->fetch() ) {
      //αποφασίζουμε αν θα προεπιλέξουμε αυτό το <option>
      if ($record[0]==$selected)      
        $extra_attribute='selected="selected"';
      else $extra_attribute='';
      //και τελικά γράφουμε το <option>
      echo '<option value="'.$record[0].'" '.$extra_attribute.'>'.$record[1].'</option>';
      //ΣΗΜΕΙΩΣΗ: προσέξτε πώς χρησιμοποιήσαμε τον πίνακα του $record
      //με αριθμητικούς δείκτες και όχι την associative εκδοχή με τους 
      //λεκτικούς δείκτες γιατί έτσι η συνάρτηση αυτή θα δουλεύει για πολλούς 
      //πίνακες, δεδομένου και του ότι ο πίνακας περνά ως παράμετρος
      //στην κλίση της συνάρτησης.
    }
    //εκκαθάριση PDO
    $statement->closeCursor();
    $pdoObject=null;
  } catch (PDOException $e) {   //block για exception handling
      header('Location: index.php?msg=Πρόβλημα στις Κατηγορίες: '. $e->getMessage());
      exit();
  } 
}
?>

