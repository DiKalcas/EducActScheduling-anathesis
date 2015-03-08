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
  <script>
   function changeScreenSize(w,h)
     {
       window.resizeTo( w,h )
     }
  </script>
</head>
<body onload="changeScreenSize(1280,660)">

<div id="head">λεπτομερή λίστα διαθέσιμων θεμάτων διδασκαλίας για μαθήματα τεχνολογ.εκπαιδ.ιδρύμ.</div>


<div id="results">
  <p class="center"><b>
    [ id | ΟΝΟΜΑΣΙΑ ΘΕΜΑΤΟΣ ΔΙΔΑΣΚ. | ΠΕΡΙΓΡΑΦΗ ΘΕΜΑΤΟΣ | ΕΒΔ.ΑΚΑΔ.ΩΡΕΣ ]-[ ΕΠΙΠΕΔΟ ΦΟΙΤΗΣΗΣ | id ]
  </b></p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql ='SELECT subjectID, subjectName, description, weekTeach, otherDetails, 
                    levels.levelID, levelTitle FROM levels 
                                        INNER JOIN subjects
           ON subjects.levelID = levels.levelID
           ORDER BY subjectID';
    
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">' 
         . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['subjectID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~</span>[ ' . $record[ 'subjectID' ] 
         . ' | ' . $record[ 'subjectName' ]  
         . ' | ' . $record[ 'description' ]         
         . ' | ' . $record[ 'weekTeach' ]
         . ' | ' . $record[ 'levelTitle' ]
         . ' | ' . $record[ 'levelID' ]
         .  ' ]<span>..' . '<a href="dualform.php?mode=update&id=' . $record['subjectID'] .'"><img src="../editButton.png"/></a></span>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
  
     echo 'PDO Exception: '.$e->getMessage();
  
   }
?>

<P><?php echo_msg(); ?></P>
<p id="commands"><span><a href="../pageOfDepositary.php" title="Επιστροφή στην Σελίδα του Θεματοφύλακα"><b>home&nbsp;Depositary</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="dualform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>

</body>
</html>
