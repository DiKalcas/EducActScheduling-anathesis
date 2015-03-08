<?php 
     // if user haven't login, redirect him with messg 
  require('../con_is_logged_in.php');

?>

<?php
  
  require('..\functions.php');
  require('..\errors.php')
 
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php  
  echo'<title>'.$_SESSION['schoolSectionName'].'</title>'                    ?>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
  <script>
   function changeScreenSize(w,h)
     {
       window.resizeTo( w,h )
     }
  </script>
</head>
<body onload="changeScreenSize(1280, 660)">

<?php
echo'<div id="head">αναθέσεις διδασκαλίας '.$_SESSION['schoolSectionName'].' σε καθηγήτές</div>';
                                                                                  ?>
<div id="results">
  <p class="center">[ <b>ΗΜΕΡΑ & ΩΡΑ + ΠΡΟΓΡΑΜΜΑΤΙΣΜΕΝΟ ΜΑΘΗΜΑ + ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ & ΚΑΘΗΓΗΤΗΣ</b> ]</p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

     // SELECT      ... αυτο ειχε βγήκε έξω 
    //   
   //       
   $schoolID= $_SESSION['schoolID'];
    $sql= " SELECT eventPlaCourseScarceResouParticiGroupID,       
`eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID`,
`eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID`,
`eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID`,
  `eventplannedcourses`.`eventPlannedCourseID`,
  `scarceresources`.`scarceResourceID`,
  `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID`,
  
`schoolID_ofSchools`, `schoolID`,`schoolSectionAbbrev`,
`subjectID_ofSubjects`, `subjectID`,`subjectName`, 
`teachMethodID`, `teachMethodID_ofTeachMethods`,`teachMethodTitle`,
  `studentGroupID_byStudentGroups`, `studentGroupID`, `studentGroupAbbrev`, 
  `professorID_byProfessors`, `professorID`, `professorShortName`,
    
`locationAddressID_byLocationAddresses`, `locationAddressID`, `city`, `area`,
`buildingFloorRoomID`, `buildingFloorRoomID`, `roomName`,
`timeSlotID_byTimeSlots`, `timeSlotID`, `daySlotStart`, `slotEndNumber`    
         
            FROM `eventplannedcourse_scarceresource_participantgroup_combis` 
      INNER JOIN (`eventplannedcourses` CROSS JOIN `scarceresources` CROSS JOIN `schoolstudentgroup_professor_links`)
 ON ( `eventplannedcourses`.`eventPlannedCourseID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID` 
  AND `scarceresources`.`scarceResourceID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID` 
  AND `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID` )
  
  LEFT JOIN `schools` ON `schoolID` = `schoolID_ofSchools`
  LEFT JOIN `subjects` ON `subjectID` = `subjectID_ofSubjects`
  LEFT JOIN `teachmethods` ON `teachMethodID` = `teachMethodID_ofTeachMethods`
  LEFT JOIN `professors` ON `professorID` = `professorID_byProfessors`
  LEFT JOIN `studentgroups` ON `studentGroupID` = `studentGroupID_byStudentGroups`  

  LEFT JOIN `locationaddresses` ON `locationAddressID` = `locationAddressID_byLocationAddresses`
  LEFT JOIN `buildingfloorrooms` ON `buildingFloorRoomID` = `buildingFloorRoomID_byBuildingFloorRooms`
  LEFT JOIN `timeslots` ON `timeSlotID` = `timeSlotID_byTimeSlots`
         
  WHERE `schoolID` = '$schoolID'      
         ORDER BY `scarceresources`.`scarceResourceID`               ";
   
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">'            
         .'<span><a href="deleteRecord.php?mode=delete&id=' . $record['eventPlaCourseScarceResouParticiGroupID'] .'"><img src="../deleteButton.png" title="διαγραγή ανάθεσης" /></a>'
         .'~ [ <b>' .$record[ 'daySlotStart' ]
         .' | ' .$record[ 'slotEndNumber' ] .'</b></span>'

         .$record[ 'subjectName' ]
         . ' | ' .$record[ 'teachMethodTitle' ] 

         .'<span>' . $record[ 'studentGroupAbbrev' ]
         . ' | ' . $record[ 'professorShortName' ] 
         
                   
         .  ' ]..' . '<a href="dualform.php?mode=update&id=' . $record['eventPlaCourseScarceResouParticiGroupID'] .'"><img src="../editButton.png" title="μεταβολή ανάθεσης" /></a></span></p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {

     echo 'PDO Exception: '.$e->getMessage();

   }
?>



<p><?php echo_msg(); ?></p>
<p id="commands"><span>
<a href="../pageOfSecretary.php" title="Επιστροφή στην Σελίδα της Γραμματείας"><b>home&nbsp;Secretary</b></a>
</span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ 
<span><?php echo '<a href="dualform.php?mode=insert">' .'<b>προσθήκη ΝΕΑΣ ανάθεσης</b>' .'</a>'; ?></span>
</p>

</div>

</body>
</html>

<?php 
     //print_r($_SESSION); 

      //&id=' .$_SESSION["schoolID"] .'          
       //<?php echo '<a href="dualform.php?mode=insert">' .'Προσθήκη ΝΕΑΣ εγγραφής' .'</a>'; ?>    