<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 
 
 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['eventPlannedCourseID'], $_POST['scarceResourceID'], $_POST['schoolStudentGroupProfessorID'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  



  $myResult=false;
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 



      $sql='INSERT INTO eventplannedcourse_scarceresource_participantgroup_combis  
             ( eventPlannedCourseID, scarceResourceID, schoolStudentGroupProfessorID )
      VALUES  ( :eventPlannedCourseID, :scarceResourceID, :schoolStudentGroupProfessorID )';
      $statement= $pdoObject->prepare($sql);
      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
      $myResult= $statement->execute( array( ':eventPlannedCourseID'=>$_POST['eventPlannedCourseID'],                    
                                       ':scarceResourceID'=>$_POST['scarceResourceID'],
             ':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID'],  ) );                                                                                      
            
  
      
    // κλείσιμο PDO
    $statement->closeCursor();
    $pdoObject= null;
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

    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>