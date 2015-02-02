<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['locationAddressID']) )    $mode='update'; 
  else $mode='insert';

      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset($_POST['locationAddressID'], $_POST['city'], $_POST['area'], $_POST['address'],
                $_POST['zipPostCode'], $_POST['province'], $_POST['address'], $_POST[ 'otherDetails' ] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset( $_POST['city'], $_POST['area'], $_POST['address'],
                $_POST['zipPostCode'], $_POST['province'], $_POST['address'], $_POST[ 'otherDetails' ] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }
  


    //create a Flag variable to check the query result
   //init. this Flag negativily in order to start the procedure
  $myResult=false;
  
  try { //database connection using PDObject
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');
    
    $locatAddreConcat= $_POST[ 'city' ] . " | " . $_POST[ 'area' ] . " | " . $_POST[ 'address' ] . " | " . $_POST['zipPostCode'];
    
    //sql query parameters differentiation  

    //in case of insert function handler
    if ($mode == 'insert') {
      $sql='INSERT INTO locationaddresses (locatAddreConcat, city, area, address, zipPostCode, province, country, otherDetails)
            VALUES                (:locatAddreConcat, :city, :area, :address, :zipPostCode, :province, :country, :otherDetails)';
            
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array(  ':locatAddreConcat'=>$locatAddreConcat,
                                              ':city'=>$_POST['city'],
                                              ':area'=>$_POST['area'],
                                              ':address'=>$_POST['address'],
                                              ':zipPostCode'=>$_POST['zipPostCode'],
                                              ':province'=>$_POST['province'],
                                              ':country'=>$_POST['country'],                                             
                                              ':otherDetails'=>$_POST['otherDetails']  ) );
    }

    //in case of update function handler
    if ($mode == 'update') {
        $sql= 'UPDATE locationaddresses
               SET 	locatAddreConcat = :locatAddreConcat, city = :city, area = :area, address = :address, 
               zipPostCode = :zipPostCode, province = :province, country = :country,  otherDetails = :otherDetails
              WHERE locationAddressID = :locationAddressID';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':locatAddreConcat'=>$locatAddreConcat,
                                               ':city'=>$_POST['city'],
                                               ':area'=>$_POST['area'],
                                               ':address'=>$_POST['address'],
                                               ':zipPostCode'=>$_POST['zipPostCode'],
                                               ':province'=>$_POST['province'],
                                               ':country'=>$_POST['country'],                                             
                                               ':otherDetails'=>$_POST['otherDetails'],
                                               ':locationAddressID'=>$_POST[ 'locationAddressID' ] ) );
    }

    //  closing of the query statement and clearin the PDObject
    $statement->closeCursor();
    $pdoObject = null;
  } 
  catch (PDOException $e) {
     
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }
  
 
  if ( !$myResult ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
  
    header('Location: index.php?msg=ALL well done!');
    exit();
  }


 ?>