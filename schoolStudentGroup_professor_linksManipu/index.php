<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΦΟΙΤΗΤΕΣ ΜΕ ΚΑΘΗΓΗΤΗ ΣΥΝΔΙΑΣΜΟΣ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div id="head">λίστα συνδιασμών ομάδας φοιτητών--καθηγητής έτοιμων προς ανάθεση εκπαιδευτικού έργου</div>


<div id="results">
  <p class="center">
    [ <b> ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ + ΚΑΘΗΓΗΤΗΣ </b> ]
  </p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql ='SELECT  schoolStudentGroupProfessorID, schoolID, studentGroupID,
                  `schoolSectionName`,  `studentGroupName`, 
                 `professorLastName`, `professorMiddleName` ,`professorFirstName`                  
           FROM  `schools`, `studentgroups`, `schoolstudentgroup_professor_links`,  `professors` 
           WHERE `schoolID_bySchools` = `schools`.`schoolID`
              AND `studentGroupID_byStudentGroups` = `studentGroupID` 
              AND `professorID_byProfessors` = `professorID`
            ORDER BY `schoolID`,`studentGroupID`                       ';
   
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">'            
         . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['schoolStudentGroupProfessorID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~</span>[ ' . $record[ 'schoolSectionName' ] 
         . ' | ' . $record[ 'studentGroupName' ]    
         . ' | ' . $record[ 'professorLastName' ]
         . ' ' .  mb_substr($record[ 'professorMiddleName' ], 0, 1, 'UTF-8')  . '.'
         . ' ' . $record[ 'professorFirstName' ]
                   
         .  ' ]<span>..' . '<a href="updateform.php?mode=update&id=' . $record['schoolStudentGroupProfessorID'] .'"><img src="../editButton.png"/></a></span>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
   
     echo 'PDO Exception: '.$e->getMessage();
    
   }
?>

<p><?php echo_msg(); ?></p>
<p id="commands"><span><a href="../pageOfCombiner.php" title="Επιστροφή στην Σελίδα του Συνδιαστή"><b>home&nbsp;Combiner</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="insertform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>

</body>
</html>
