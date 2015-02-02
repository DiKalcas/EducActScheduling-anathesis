<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset( $_POST['schoolStudentGroupProfessorID'] ) )   $mode='update'; 
  
      //αν κάνουμε update
  if ($mode == 'update') { 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['schoolID_bySchools'], $_POST['studentGroupID_byStudentGroups'], $_POST['professorID_byProfessors'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }
  

    //καθαρίζουμε τυχόν spaces στην αρχή ή στο τέλος του αλφαριθμητικού
   //ΠΑΝΤΑ το κάνουμε αυτό σε πεδία κειμένου συμπληρωμένα από χρήστες
   //$schoolSectionName=  trim($_POST[ '$schoolSectionName' ]);

  // ---- ΤΕΛΟΣ ΕΛΕΓΧΩΝ - ΣΥΝΕΧΙΖΟΥΜΕ ΜΕ ΤΟ INSERT ή το UPDATE ----

    //ορίζουμε μια μεταβλητή για παρακολούθηση του τι έγινε συνολικά και την
   //αρχικοπιούμε σε false, δεδομένου ότι ακόμη δεν έγινε το ζητούμενο.
  $myResult1=false;
  $myResult2=false;
  
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 

    
    //περίπτωση UPDATE
    if ($mode == 'update') {
    
      $sql1='  SELECT CONCAT(`schoolSectionAbbrev`," | ",`studentGroupAbbrev`," | ",`professorShortName`) as concated
               
           FROM  `schools`,`studentgroups`, `professors`
           WHERE `schoolID` = :schoolID_bySchools
              AND `studentGroupID` = :studentGroupID_byStudentGroups 
              AND `professorID` = :professorID_byProfessors  ';
     $statement1= $pdoObject->prepare($sql1);

      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
  $myResult1= $statement1->execute( array( ':schoolID_bySchools'=>$_POST['schoolID_bySchools'],                                                                
                                             ':studentGroupID_byStudentGroups'=>$_POST['studentGroupID_byStudentGroups'],
                                             ':professorID_byProfessors'=>$_POST['professorID_byProfessors'] ) );   

  $record= $statement1->fetch();
         
    
        $sql2= 'UPDATE schoolstudentgroup_professor_links
                SET  schoolStudGroupProfesAbbrev = :schoolStudGroupProfesAbbrev,
                              schoolID_bySchools = :schoolID_bySchools,  
                  studentGroupID_byStudentGroups = :studentGroupID_byStudentGroups, 
                        professorID_byProfessors = :professorID_byProfessors                     
                WHERE schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID';
        $statement2= $pdoObject->prepare($sql2);                     
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult2= $statement2->execute( array(
                          ':schoolStudGroupProfesAbbrev'=>$record[ 'concated' ],
                                ':schoolID_bySchools'=>$_POST['schoolID_bySchools'],
         ':studentGroupID_byStudentGroups'=>$_POST['studentGroupID_byStudentGroups'],
                      ':professorID_byProfessors'=>$_POST['professorID_byProfessors'],
         ':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID'] ) );
    }  
    // κλείσιμο PDO
    $statement1->closeCursor();
    $statement2->closeCursor();
    $pdoObject= null;
  }  
  catch (PDOException $e) {
      //ας κάνουμε κάτι διαφορετικό από το σύνηθες των slide
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }

  // αναφορά πιθανού προβλήματος στην εκτέλεση του SQL
  if ( !$myResult1 || !$myResult2 ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
    //ALL DONE!
    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>