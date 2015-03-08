<p><strong>Ενοποιημμένες Ομάδες</strong></p>
<?php

  sleep(0.25);
  
  require('../parameteDB.php');   

  try {
    //creating PDObject
    $pdoObject= new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //creating parameterized query 
    $sql = "SELECT * FROM schoolstudentgroup_professor_links WHERE professorID_byProfessors = :professorID_byProfessors ORDER BY schoolStudGroupProfesAbbrev ASC";
    //query preparing for avoiding SQL Injection
    $statement= $pdoObject->prepare($sql);
    //passing of the value in placeholders
    $statement->execute( array(':professorID_byProfessors'=>$_POST['professorID']));
    
    //query results loop for display
    while ( $record= $statement->fetch() ) {
      //για κάθε record αποτελέσματος κάνε το ακόλουθο
      
      $schooStudeGroupProfID= $record['schoolStudentGroupProfessorID'];
      $sql2 = " SELECT COUNT(schoolStudentGroupProfessorID) AS rowCounter  
                   FROM eventplannedcourse_scarceresource_participantgroup_combis 
                    WHERE schoolStudentGroupProfessorID = $schooStudeGroupProfID "; 
       $statement2= $pdoObject->query($sql2);
       $record2=  $statement2->fetch();
      if ( $record2['rowCounter'] > 0 ) 
      { echo '<p> - '.'<a href="#" onclick="myAJAXCallPlus('.$record['schoolStudentGroupProfessorID'].');">' .$record['schoolStudGroupProfesAbbrev'].'</a>'.'<img src="../checked.png"/><sup>x'.$record2['rowCounter'].'</sup></p>'; } 
      else  
      { echo '<p> - '.$record['schoolStudGroupProfesAbbrev'].'</p>'; };
      $statement2->closeCursor();
      
      echo '<p> - '.$record['schoolStudGroupProfesAbbrev'].'</p>'; 
      
    }
             
    $statement->closeCursor();  //closing results dataset
   
    $pdoObject = null;        // database connect. ending
    echo '<p>* Οι τσεκαρισμένες είναι ανατεθημμένες ομάδες τουλάχιστο μια φορα.</p>';
  } catch (PDOException $e) {
     
      die("Database Error: " . $e->getMessage());
    }
?>
