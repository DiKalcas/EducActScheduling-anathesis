<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους

                  //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
 if ( isset($_GET['mode']) && isset($_GET['id']) &&  $_GET['mode']=='insert'  ) {
    $title='συνδιασμ. ομάδας φοιτητών με καθηγητή από γραμματ.!';
             //καταχωρούμε τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $schoolID_bySchools           =  $_GET['id'];
    $studentGroupID_byStudentGroups= '';
    $professorID_byProfessors     =  '';

    
  }  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟΣ ΣΥΝΔΙΑΣΜΟΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ ΜΕ ΚΑΘΗΓΗΤΗ</legend>
  <form name="form1" action="inserthandler2.php" method="post">



  <p>Τμήμα Σχολής: <select name="schoolID_bySchools">
          <?php load_options('schools', $schoolID_bySchools) ?>
        </select>&nbsp<img src="../attention.png" title="παρακαλώ αφήστε το ίδιο"/>
  </p>
  <p>Ομάδα Φοιτητών: <select name="studentGroupID_byStudentGroups">
          <?php load_options('studentgroups', $studentGroupID_byStudentGroups) ?>
        </select>
  </p>
  <p>Καθηγητής: <select name="professorID_byProfessors">
          <?php load_options('professors', $professorID_byProfessors) ?>
        </select>
  </p>  
   
  
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
<p class="right"><a href="dualform.php?mode=insert" title="Επιστροφή χωρίς καμία λειτουργία φόρμας"><b>go.back</b></a></p>
 </div> 
</body>
</html>

