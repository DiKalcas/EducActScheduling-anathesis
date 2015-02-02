<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΑΝΑΘΕΣΗ ΕΚΠΑΙΔΕΥΤ.ΕΡΓΟΥ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
</head>
<body>

<div class="center"><?php echo_msg(); ?></div>

<div id="results">
  <p class="center">[ <b>ΠΡΟΓΡΑΜΜΑΤΙΣΜΕΝΟ ΜΑΘΗΜΑ + ΠΟΛΗ ΠΕΡΙΟΧΗ<strike> ΑΙΘΟΥΣΑ </strike>ΤΗΝ ΗΜΕΡΑ & ΩΡΑ + ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ & ΚΑΘΗΓΗΤΗΣ</b> ]</p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

     // SELECT      ... αυτο ειχε βγήκε έξω 
    //   
   //       
    $sql= ' SELECT        
`eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID`,
`eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID`,
`eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID`,
  `eventplannedcourses`.`eventPlannedCourseID`,
  `scarceresources`.`scarceResourceID`,
  `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID`,
  
`schoolID_ofSchools`, `schoolID`,`schoolSectionAbbrev`,
`subjectID_ofSubjects`, `subjectID`,`subjectAbbrev`, 
`teachMethodID`, `teachMethodID_ofTeachMethods`,`teachMethodTitle`,
  `studentGroupID_byStudentGroups`, `studentGroupID`, `studentGroupAbbrev`, 
  `professorID_byProfessors`, `professorID`, `professorShortName`,
    
`locationAddressID_byLocationAddresses`, `locationAddressID`, `city`, `area`,
`buildingFloorRoomID`, `buildingFloorRoomID`, `roomName`,
`timeSlotID_byTimeSlots`, `timeSlotID`, `daySlotStart`    
         
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
         ORDER BY `eventPlaCourseScarceResouParticiGroupID` ';
   
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">'            
         . '<a href="deleteRecord.php?mode=delete&id1=' . $record['eventPlannedCourseID'] .'&id2=' . $record['scarceResourceID'] .'&id3=' . $record['schoolStudentGroupProfessorID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~ [ ' . $record[ 'schoolSectionAbbrev' ] 
         . ' | ' . $record[ 'subjectAbbrev' ]
         . ' | ' . $record[ 'teachMethodTitle' ]

         . ' | ' . $record[ 'city' ]
      
         . ' | ' . $record[ 'roomName' ]
         
         . ' | ' . $record[ 'daySlotStart' ]
         . ' | ' . $record[ 'studentGroupAbbrev' ]
         . ' | ' . $record[ 'professorShortName' ]
         
                   
         .  ' ]..' . '<a href="updateform.php?mode=update&id1=' . $record['eventPlannedCourseID'] .'&id2='  . $record['scarceResourceID'] .'&id3=' . $record['schoolStudentGroupProfessorID'] .'"><img src="../editButton.png"/></a>
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
