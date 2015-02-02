<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 
    

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['eventPlannedCourseID_new'], $_POST['scarceResourceID_new'], $_POST['schoolStudentGroupProfessor_new'] ) )  
      $mode='update'; 

      //αν κάνουμε update
  if ($mode == 'update') { 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['eventPlannedCourseID_old'], $_POST['scarceResourceID_old'], $_POST['schoolStudentGroupProfessorID_old'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }
    


  $myResult=false;
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    

        $sql= ' UPDATE eventplannedcourse_scarceresource_participantgroup_combis
                SET eventPlannedCourseID = :eventPlannedCourseID_new,  
                    scarceResourceID = :scarceResourceID_new, 
                        schoolStudentGroupProfessorID = :schoolStudentGroupProfessor_new
                   
                WHERE eventPlannedCourseID = :eventPlannedCourseID_old 
                     AND scarceResourceID = :scarceResourceID_old 
          AND schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID_old ';
        $statement= $pdoObject->prepare($sql);                     
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult= $statement->execute( array( ':eventPlannedCourseID_new'=>$_POST['eventPlannedCourseID_new'],
                                               ':scarceResourceID_new'=>$_POST['scarceResourceID_new'],
                                               ':schoolStudentGroupProfessor_new'=>$_POST['schoolStudentGroupProfessor_new'],
                                              
                                               ':eventPlannedCourseID_old'=>$_POST['eventPlannedCourseID_old'],
                                               ':scarceResourceID_old'=>$_POST['scarceResourceID_old'],
                                               ':schoolStudentGroupProfessorID_old'=>$_POST['teachMethodID_byTeachMethods_old'] ) );
 
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