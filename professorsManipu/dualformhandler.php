<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['professorID']) )  
    $mode='update'; 
  else $mode='insert';

      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset( $_POST['professorID'], 
                 $_POST['professorLastName'], $_POST['professorMiddleName'], $_POST['professorFirstName'],  $_POST['professorShortName'],  $_POST['professorTitleID_ofProfessorTitles'], 
                 $_POST['identityCardCode'], $_POST['nationalTaxNum'],  
                  $_POST['phoneNumber'], $_POST['emailAddress'],  $_POST['locationAddressID_ofLocationAddresses'],
                   $_POST['otherDetails'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset( $_POST['professorLastName'], 
                 $_POST['professorMiddleName'], 
                 $_POST['professorFirstName'],  
                 $_POST['professorShortName'],
                 $_POST['phoneNumber'], 
                 $_POST['identityCardCode'], 
                 $_POST['nationalTaxNum'],
                 $_POST['emailAddress'],  
                 $_POST['otherDetails'], 
                 $_POST['locationAddressID_ofLocationAddresses'],
                 $_POST['professorTitleID_ofProfessorTitles'] 
                 ) ) { 
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

    $professorFullName= $_POST[ 'professorLastName' ] . " " . $_POST[ 'professorMiddleName' ] . " " . $_POST['professorFirstName'];

    //sql query parameters differentiation  
    //in case of insert function handler
    if ($mode == 'insert') {
      $sql= ' INSERT INTO professors (professorFullName, professorLastName, professorMiddleName, professorFirstName,
                                    professorShortName, identityCardCode, nationalTaxNum, phoneNumber, emailAddress, 
                                    locationAddressID_ofLocationAddresses, professorTitleID_ofProfessorTitles,
                                     otherDetails)
            VALUES              ( :professorFullName, :professorLastName, :professorMiddleName, :professorFirstName,
                                  :professorShortName, :identityCardCode, :nationalTaxNum, :phoneNumber, :emailAddress,
                                  :locationAddressID_ofLocationAddresses, :professorTitleID_ofProfessorTitles,
                                   :otherDetails ) ';
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array(  ':professorFullName'=>$professorFullName,
                                              ':professorLastName'=>$_POST['professorLastName'],
                                              ':professorMiddleName'=>$_POST['professorMiddleName'],
                                              ':professorFirstName'=>$_POST['professorFirstName'],
                                              ':professorShortName'=>$_POST['professorShortName'],
                                              ':identityCardCode'=>$_POST['identityCardCode'],
                                              ':nationalTaxNum'=>$_POST['nationalTaxNum'],
                                              ':phoneNumber'=>$_POST['phoneNumber'],
                                              ':emailAddress'=>$_POST['emailAddress'],
                                              ':locationAddressID_ofLocationAddresses'=>$_POST['locationAddressID_ofLocationAddresses'],
                                              ':professorTitleID_ofProfessorTitles'=>$_POST['professorTitleID_ofProfessorTitles'],
                                              
                                              ':otherDetails'=>$_POST['otherDetails']  ) );
    }

    //in case of update function handler
    if ($mode == 'update') {
        $sql= ' UPDATE professors
                SET  professorFullName = :professorFullName, professorLastName = :professorLastName, 
              professorMiddleName = :professorMiddleName,  professorFirstName = :professorFirstName, professorShortName = :professorShortName,
              identityCardCode = :identityCardCode, nationalTaxNum = :nationalTaxNum, phoneNumber = :phoneNumber, emailAddress = :emailAddress,
              locationAddressID_ofLocationAddresses = :locationAddressID_ofLocationAddresses, professorTitleID_ofProfessorTitles = :professorTitleID_ofProfessorTitles,
               otherDetails = :otherDetails
            WHERE professorID = :professorID ';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':professorFullName'=>$professorFullName,
                                              ':professorLastName'=>$_POST['professorLastName'],
                                              ':professorMiddleName'=>$_POST['professorMiddleName'],
                                              ':professorFirstName'=>$_POST['professorFirstName'],
                                              ':professorShortName'=>$_POST['professorShortName'],
                                              ':identityCardCode'=>$_POST['identityCardCode'],
                                              ':nationalTaxNum'=>$_POST['nationalTaxNum'],
                                              ':phoneNumber'=>$_POST['phoneNumber'],
                                              ':emailAddress'=>$_POST['emailAddress'],
                                              ':locationAddressID_ofLocationAddresses'=>$_POST['locationAddressID_ofLocationAddresses'],
                                              ':professorTitleID_ofProfessorTitles'=>$_POST['professorTitleID_ofProfessorTitles'],
                                              
                                              ':otherDetails'=>$_POST['otherDetails'],
                                              ':professorID'=>$_POST[ 'professorID' ] ) );
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