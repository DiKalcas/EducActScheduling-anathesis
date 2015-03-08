<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΔΙΑΘΕΣΙΜΟΙ ΚΑΘΗΓΗΤΕΣ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div id="head">λεπτομερή λίστα διαθέσιμων για παραγωγή εκπαιδευτικού έργου καθηγητών τεχνολ.εκπ.ιδρ.</div>

<div id="results">
  <p class="center"><b>
     id[ ΟΝΟΜΑΤΕΠΩΝΥΜΟ | ΤΑΥΤΟΤΗΤΑ | ΙΔΙΟΤΗΤΑ | ΑΡ.ΦΟΡΟΛ.ΜΗΤ | ΔΙΕΥΘΗΝΣΗ | ΤΗΛΕΦΩΝΟ | EMAIL ] 
  </b></p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql =' SELECT professorID, professorFullName, identityCardCode, titleName, nationalTaxNum,
                   city, area, address, phoneNumber, emailAddress
                    
              FROM professors 
                LEFT JOIN professortitles ON professorTitleID_ofProfessorTitles = professorTitleID
                LEFT JOIN locationaddresses ON locationAddressID_ofLocationAddresses = locationAddressID
                
          ';
    
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">' 
         . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['professorID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~ ' . $record[ 'professorID' ] .'</span>' 
         . '[ ' . $record[ 'professorFullName' ]
         . ' | ' . $record[ 'identityCardCode' ]  
         . ' | ' . $record[ 'titleName' ]
         . ' | ' . $record[ 'nationalTaxNum' ]  . '<br>'                
         . ' &nbsp&nbsp ' . $record[ 'city' ]
         . ' | ' . $record[ 'address' ]
         . ' | ' . $record[ 'phoneNumber' ]
         . ' | ' . $record[ 'emailAddress' ]
         
         .  ' ]<span>..' . '<a href="dualform.php?mode=update&id=' . $record['professorID'] .'"><img src="../editButton.png"/></a></span>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
   
     echo 'PDO Exception: '.$e->getMessage();
    
   }
?>

<p><?php echo_msg(); ?></p>
<p id="commands"><span><a href="../pageOfRecruiter.php" title="Επιστροφή στην Σελίδα τοθ Στρατολογητή"><b>home&nbsp;Recruiter</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="dualform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>

</body>
</html>
