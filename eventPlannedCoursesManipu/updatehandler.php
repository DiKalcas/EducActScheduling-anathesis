<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 


      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['eventPlannedCourseID'] ) )     $mode='update'; 
  
      //αν κάνουμε update
  if ($mode == 'update') { 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['schoolID_ofSchools'], $_POST['subjectID_ofSubjects'], $_POST['teachMethodID_ofTeachMethods'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }
  



  $myResult1=false;
  $myResult2=false;
  
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 

    
    //περίπτωση UPDATE
    if ($mode == 'update') {
    
      $sql1='  SELECT CONCAT(`schoolSectionAbbrev`," | ",`teachMethodTitle`," | ",`subjectAbbrev`) as concated
               
           FROM  `eventplannedcourses`,`schools`, `subjects`, `teachmethods` 
           WHERE `schoolID` = :schoolID_ofSchools
              AND `subjectID` = :subjectID_ofSubjects 
              AND `teachMethodID` = :teachMethodID_ofTeachMethods  '; 
     $statement1= $pdoObject->prepare($sql1);   
     $myResult1= $statement1->execute( array( ':schoolID_ofSchools'=>$_POST['schoolID_ofSchools'],                                                                
                                             ':subjectID_ofSubjects'=>$_POST['subjectID_ofSubjects'],
                                             ':teachMethodID_ofTeachMethods'=>$_POST['teachMethodID_ofTeachMethods'] ) );    
     $record= $statement1->fetch();   

    
        $sql2= ' UPDATE eventplannedcourses
                SET  eventPlannedCourseAbbrev = :eventPlannedCourseAbbrev,
                 schoolID_ofSchools = :schoolID_ofSchools,  
                 subjectID_ofSubjects = :subjectID_ofSubjects, 
                 teachMethodID_ofTeachMethods = :teachMethodID_ofTeachMethods,
                 secretaryCode = :secretaryCode, ECTS = :ECTS
                WHERE eventPlannedCourseID = :eventPlannedCourseID ';
        $statement2= $pdoObject->prepare($sql2);                     
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult2= $statement2->execute( array( ':eventPlannedCourseAbbrev'=>$record[ 'concated' ],
                                               ':schoolID_ofSchools'=>$_POST['schoolID_ofSchools'],
                                               ':subjectID_ofSubjects'=>$_POST['subjectID_ofSubjects'],
                                               ':teachMethodID_ofTeachMethods'=>$_POST['teachMethodID_ofTeachMethods'],
                                               ':secretaryCode'=>$_POST['secretaryCode'],
                                               ':ECTS'=>$_POST['ECTS'],
                                               ':eventPlannedCourseID'=>$_POST['eventPlannedCourseID']   ) );
    }  
    // κλείσιμο PDO
    $statement1->closeCursor();
    $statement2->closeCursor();
    $pdoObject= null;
  }  
  catch (PDOException $e) {
      
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }

 
  if ( !$myResult1 || !$myResult2 ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
  
    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>