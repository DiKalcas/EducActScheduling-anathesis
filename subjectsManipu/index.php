<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΤΙΤΛΟΙ ΘΕΜΑΤΩΝ Τ.Ε.Ι.</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div class="center"><?php echo_msg(); ?></div>

<div id="results">
  <p class="center">
    [ id | ΟΝΟΜΑΣΙΑ ΘΕΜΑΤΟΣ ΔΙΔΑΣΚ. | ΠΕΡΙΓΡΑΦΗ ΘΕΜΑΤΟΣ | ΕΒΔ.ΑΚΑΔ.ΩΡΕΣ ]-[ ΕΠΙΠΕΔΟ ΦΟΙΤΗΣΗΣ | id ]
  </p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql ='SELECT subjectID, subjectName, description, weekTeach, otherDetails, 
                    levels.levelID, levelTitle FROM levels 
                                        INNER JOIN subjects
           ON subjects.levelID = levels.levelID';
    
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">' 
         . '<a href="deleteRecord.php?mode=delete&id=' . $record['subjectID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~ [ ' . $record[ 'subjectID' ] 
         . ' | ' . $record[ 'subjectName' ]  
         . ' | ' . $record[ 'description' ]         
         . ' | ' . $record[ 'weekTeach' ]
         . ' | ' . $record[ 'levelTitle' ]
         . ' | ' . $record[ 'levelID' ]
         .  ' ]..' . '<a href="dualform.php?mode=update&id=' . $record['subjectID'] .'"><img src="../editButton.png"/></a>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
  
     echo 'PDO Exception: '.$e->getMessage();
  
   }
?>

<p id="commands">Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <a href="dualform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></p>

</div>

</body>
</html>
