<p><strong>Ενοποιημένες ομάδες</strong></p>
<?php

  sleep(0.25);
  
  require('../parameteDB.php');   

  try {
    //creating PDObject
    $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //creating parameterized query 
    $sql = "SELECT * FROM schoolstudentgroup_professor_links WHERE schoolID_bySchools = :schoolID_bySchools ORDER BY schoolStudGroupProfesAbbrev ASC";
    //query preparing for avoiding SQL Injection
    $statement= $pdoObject->prepare($sql);
    //passing of the value in placeholders
    $statement->execute( array(':schoolID_bySchools'=>$_POST['schoolID']));
    
    //query results loop for display
    while ( $record= $statement->fetch() ) {
      //για κάθε record αποτελέσματος κάνε το ακόλουθο
      
      $schoolStudentGroupProfessorID= $record['schoolStudentGroupProfessorID'];
      $sql2 = " SELECT COUNT(schoolStudentGroupProfessorID) AS rowCounter  
                   FROM eventplannedcourse_scarceresource_participantgroup_combis 
                    WHERE schoolStudentGroupProfessorID = $schoolStudentGroupProfessorID "; 
       $statement2= $pdoObject->query($sql2);
       $record2=  $statement2->fetch();
      if ( $record2['rowCounter'] > 0 ) 
      { echo '<p> - '.'<a href="#" onclick="myAJAXCallPlus('.$record['schoolStudentGroupProfessorID'].');">' .$record['schoolStudGroupProfesAbbrev'].'</a>'.'<img src="../checked.png"/><sup>x'.$record2['rowCounter'].'</sup></p>'; } 
      else  
      { echo '<p> - '.$record['schoolStudGroupProfesAbbrev'].'</p>'; };
      $statement2->closeCursor();   
      
        //echo '<a href="#" onclick="myAJAXCallPlus('.$record['eventPlannedCourseID'].');">' .$record['eventPlannedCourseAbbrev'].'</a>'  
        //echo '<p> - '.'<a href="#" onclick="myAJAXCallPlus('.$record['eventPlannedCourseID'].');">' .$record['eventPlannedCourseAbbrev'].'</a>'.'<img src="../checked.png"/><sup>x</sup>'.$record2['rowCounter'].'</p>';
    
    }
        
    $statement->closeCursor();   //closing results dataset

    $pdoObject = null;         // database connect. ending
    echo '<p>* Οι τσεκαρισμένες έχουν ανατεθημμένα μαθήματα τουλάχιστο μια φορα.</p>';
  } catch (PDOException $e) {
     
      die("Database Error: " . $e->getMessage());
    }
?>
