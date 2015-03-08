<p><strong>Ανατεθημμένα Μαθήματα</strong></p>
<?php

  sleep(0.25);
  
  require('../parameteDB.php');  

  try {

    $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql= " SELECT eventPlaCourseScarceResouParticiGroupAbbrev                  
              FROM eventplannedcourse_scarceresource_participantgroup_combis 
                WHERE eventplannedcourse_scarceresource_participantgroup_combis.schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID ";

    $statement= $pdoObject->prepare($sql);

    $statement->execute( array(':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID']));
    
    while ( $record= $statement->fetch() ) {

          
      echo '<p>'.$record['eventPlaCourseScarceResouParticiGroupAbbrev'].'</p>';
      
    }
        
    $statement->closeCursor();

    $pdoObject = null;  
  } catch (PDOException $e) {
   
      die("Database Error: " . $e->getMessage());
    }
?>
