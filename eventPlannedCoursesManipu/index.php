<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΜΑΘΗΜΑΤΑ ΤΜΗΜΑΤΟΣ ΣΧΟΛΗΣ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div class="center"><?php echo_msg(); ?></div>

<div id="results">
  <p class="center">
    [ <b>ΤΜΗΜΑ ΣΧΟΛΗΣ ΤΕΙ + ΟΝΟΜΑΣΙΑ ΘΕΜΑΤΟΣ ΔΙΔΑΣΚ. + ΕΚΠΑΙΔΕΥΤΙΚΗ ΜΕΘΟΔΟΣ</b> | ΚΩΔΙΚ.ΓΡΑΜΜΑΤΕΙΑΣ | ECTS ]
  </p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql =' SELECT `eventPlannedCourseID`, `schoolID`, `schoolSectionName`, `subjectName`, `subjectID`, 
                 `teachMethodID_ofTeachMethods`, `teachMethodTitle`, `secretaryCode`, `ECTS`
           FROM  `eventplannedcourses`,`schools`, `subjects`, `teachmethods` 
           WHERE `schoolID` = `schoolID_ofSchools`
              AND `subjectID` = `subjectID_ofSubjects` 
              AND `teachMethodID` = `teachMethodID_ofTeachMethods` 
                    ORDER BY eventPlannedCourseID ';
   
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">'            
         . '<a href="deleteRecord.php?mode=delete&id=' . $record['eventPlannedCourseID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~ [ ' . $record[ 'schoolSectionName' ] 
         . ' | ' . $record[ 'subjectName' ]
         . ' | ' . $record[ 'teachMethodTitle' ]
         . ' | ' . $record[ 'secretaryCode' ]
         . ' | ' . $record[ 'ECTS' ]          
         .  ' ]..' . '<a href="updateform.php?mode=update&id=' . $record['eventPlannedCourseID'] .'"><img src="../editButton.png"/></a>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {

     echo 'PDO Exception: '.$e->getMessage();

   }
?>

<p id="commands">Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <a href="insertform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></p>

</div>

</body>
</html>
