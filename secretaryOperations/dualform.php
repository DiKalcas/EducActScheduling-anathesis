<?php 
     // if user haven't login, redirect him with messg 
  require('../con_is_logged_in.php');

?>

<?php
  
  require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
  require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
  require('../errors.php');   //μυνήματα λάθους

  $schoolID= $_SESSION['schoolID'];
  $title='ανάθεση έργου';
  
      // determination of the function use, case of update
  if ( isset($_GET['mode'], $_GET['id'] ) &&  $_GET['mode']=='update'  ) {

    $eventPlaCourseScarceResouParticiGroupID= $_GET['id'];  //το ID της εγγραφής που θα μεταβάλλουμε

    $title="μεταβολή εγγραφής $eventPlaCourseScarceResouParticiGroupID Ανάθεσης Έργου";
    // finding of the record to update it
    try {
      //initialization of PDObject
      $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
      $pdoObject -> exec('set names utf8');
      // parameterized query with data sent by user
      $sql = "SELECT * FROM eventplannedcourse_scarceresource_participantgroup_combis 
               WHERE eventPlaCourseScarceResouParticiGroupID = :eventPlaCourseScarceResouParticiGroupID LIMIT 1";
      //compile ερωτήματος στον database server
      $statement= $pdoObject->prepare($sql);
      // passing values at parameters placeholders and execute
      $statement->execute( array( ':eventPlaCourseScarceResouParticiGroupID'=>$eventPlaCourseScarceResouParticiGroupID ));
      // one record for query result
      if ($record= $statement->fetch()) { //upon record finding
        // save the result for later
        $record_exists=true;
        // pass the recorded fields to the init. values
        //$~~~ID=  το έχουμε ήδη ορίσει παραπάνω - το ξέρουμε από το URL
    $eventPlaCourseScarceResouParticiGroupAbbrev= $record['eventPlaCourseScarceResouParticiGroupAbbrev'];
    $eventPlannedCourseID                         = $record['eventPlannedCourseID'];
    $scarceResourceID                                 = $record['scarceResourceID'];
    $schoolStudentGroupProfessorID       = $record['schoolStudentGroupProfessorID'];
               
      } else $record_exists=false;  // not existing record Flag state
      // closing of query statement and clearing of PDObject
      $statement->closeCursor();
      $pdoObject= null;
    } catch (PDOException $e) {
        print "Database Error: " . $e->getMessage();

        die("Αδυναμία δημιουργίας PDO Object");
    }

    if (!$record_exists) {
      header('Location: index.php?msg=Record does not exist.');
      exit();
    }
  }
      // determination of the function use, case of insert
  if ( isset($_GET['mode'] ) &&  $_GET['mode'] == 'insert'  ) {
    $title='εισαγωγή Ανάθεσης Έργου από γραμματεία';
    // pass the recorded fields to the init. values 
    $eventPlaCourseScarceResouParticiGroupID    = '';
    $eventPlaCourseScarceResouParticiGroupAbbrev= '';
    
    if ( isset($_GET['lastid1']) )   { $eventPlannedCourseID= $_GET['lastid1']; }
    else                                $eventPlannedCourseID= '';
    
    $scarceResourceID                           = '';
    
    if ( isset($_GET['lastid2']) )   { $schoolStudentGroupProfessorID= $_GET['lastid2']; }
    else                                $schoolStudentGroupProfessorID= '';
            
  }  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΜΗΧΑΝΙΚΩΝ ΠΛΗΡΟΦΟΡΙΚΗΣ</title>
  <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
  <div id="container">

    <h2 class="center"><?php echo $title; ?></h2>
    <br />

    

    <fieldset><legend>ΣΥΝΔΙΑΣΜΟΣ ΠΟΡΩΝ ΓΙΑ ΕΚΤΕΛΕΣΗ ΕΚΠΑΙΔΕΥΤΙΚΟΥ ΕΡΓΟΥ</legend>
    <form name="form1" action="dualformhandler.php" method="post">

    <?php
      //in case of update, pass the ~ID to the form field of it
      //the form field have read-only and hidden attributes
      if ($_GET['mode'] == 'update') { ?>

       <input name="eventPlaCourseScarceResouParticiGroupID" value="<?php echo $eventPlaCourseScarceResouParticiGroupID; ?>" readonly="readonly" hidden />

    <?php                            } ?>  
      
  <p> Προγραμματισμένο μάθημα εξαμήνου: </p>
  <p align="center"><select name="eventPlannedCourseID">
          <?php load_options_under_condition('eventplannedcourses', $eventPlannedCourseID, 'schoolID_ofSchools', $schoolID) ?>
        </select>
        <?php if($_GET['mode'] == "insert" ){
                 echo '<span><a href="insertform1.php?mode=insert&id='.$_SESSION["schoolID"].'">';                
                 echo '<img src="../add.png" title="προσθήκη νεου μαθήματος σε τμήμα"/></a></span>'; } ?>
  </p>
  <p> Αίθουσα την συγκεκριμένη ώρα: </p><p align="center"><select name="scarceResourceID">
          <?php load_options('scarceresources', $scarceResourceID) ?>
        </select>
  </p>
  <p> Ομάδα φοιτητών με Καθηγητή: </p><p align="center"><select name="schoolStudentGroupProfessorID">
          <?php load_options_under_condition('schoolstudentgroup_professor_links', $schoolStudentGroupProfessorID, 'schoolID_bySchools', $schoolID) ?>
        </select>
        <?php if($_GET['mode'] == "insert" ){
                 echo '<span><a href="insertform2.php?mode=insert&id='.$_SESSION["schoolID"].'">';                
                 echo '<img src="../add.png" title="προσθήκη νέας ομάδας σε τμήμα"/></a></span>'; } ?>
                 
  </p>
     
                                        
      <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
    </form>
    </fieldset>

    <p><?php echo_msg(); ?></p>
    <p class="right"><a href="index.php" title="Επιστροφή χωρίς καμία λειτουργία φόρμας"><b>go.back</b></a></p>

  </div>
</body>
</html>
