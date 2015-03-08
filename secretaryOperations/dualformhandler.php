<?php
  require('../parameteDB.php'); //database connection parameters
 
     //insert or update determination
    //if the form sent  $_POST['fieldID']  this is an update
   
      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset($_POST['eventPlaCourseScarceResouParticiGroupID']) )  
    $mode='update'; 
  else $mode='insert';

      // in case of update function handler
  if ($mode == 'update') { 
        //check if the data sent is complete
    if ( !isset($_POST['eventPlannedCourseID'], $_POST['scarceResourceID'], $_POST['schoolStudentGroupProfessorID'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }  

      //in case of insert function handler
  if ($mode == 'insert') {
        //check if the data sent is complete
    if ( !isset($_POST['eventPlannedCourseID'], $_POST['scarceResourceID'], $_POST['schoolStudentGroupProfessorID'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }
  
  //αν έχει επιλεγεί η ψευδοεπιλογή από τις κατηγορίες έχουμε πρόβλημα
  if ($_POST['categoryID']=='-1') {     
    header('Location: index.php?msg=ERROR: invalid categoryID (-1)');
    exit();
  }



    //create a Flag variable to check the query result
   //init. this Flag negativily in order to start the procedure
  $myResult=false;
  
  try { //database connection using PDObject
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');

     //sql query parameters differentiation  
    //in case of insert function handler
    if ($mode == 'insert') {
    
        //secondary query for tableAbbrev. column insert
      $sql1=' SELECT CONCAT( `daySlotStart`,"_",`city`,"_",`slotEndNumber`," ",
                               `subjectAbbrev`,"_",`teachMethodTitle`," ",
                                `schoolSectionAbbrev`,`studentGroupAbbrev`," ",
                                 `professorShortName` ) as `concated` ,       
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
 ON ( `eventplannedcourses`.`eventPlannedCourseID` = :eventPlannedCourseID 
  AND `scarceresources`.`scarceResourceID` =  :scarceResourceID 
  AND `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID` = :schoolStudentGroupProfessorID     )
  
  LEFT JOIN `schools` ON `schoolID` = `schoolID_ofSchools`
  LEFT JOIN `subjects` ON `subjectID` = `subjectID_ofSubjects`
  LEFT JOIN `teachmethods` ON `teachMethodID` = `teachMethodID_ofTeachMethods`
  LEFT JOIN `professors` ON `professorID` = `professorID_byProfessors`
  LEFT JOIN `studentgroups` ON `studentGroupID` = `studentGroupID_byStudentGroups`  

  LEFT JOIN `locationaddresses` ON `locationAddressID` = `locationAddressID_byLocationAddresses`
  LEFT JOIN `buildingfloorrooms` ON `buildingFloorRoomID` = `buildingFloorRoomID_byBuildingFloorRooms`
  LEFT JOIN `timeslots` ON `timeSlotID` = `timeSlotID_byTimeSlots`            ';
     $statement1= $pdoObject->prepare($sql1);

      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
  $myResult1= $statement1->execute( array( ':eventPlannedCourseID'=>$_POST['eventPlannedCourseID'],
                                           ':scarceResourceID'=>$_POST['scarceResourceID'],
                                           ':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID'] ) );   
  $record= $statement1->fetch();
    
      //main query for insert new record
      $sql='INSERT INTO eventplannedcourse_scarceresource_participantgroup_combis 
          ( eventPlaCourseScarceResouParticiGroupAbbrev, eventPlannedCourseID, scarceResourceID, schoolStudentGroupProfessorID )
    VALUES ( :eventPlaCourseScarceResouParticiGroupAbbrev, :eventPlannedCourseID, :scarceResourceID, :schoolStudentGroupProfessorID )';
      $statement = $pdoObject->prepare($sql);
      //use the Flag to save the query result status
      $myResult= $statement->execute( array( ':eventPlaCourseScarceResouParticiGroupAbbrev'=>$record[ 'concated' ],
                                             ':eventPlannedCourseID'=>$_POST['eventPlannedCourseID'],
                                             ':scarceResourceID'=>$_POST['scarceResourceID'],
                                             ':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID']
                                              ) );
    }

    //in case of update function handler
    if ($mode == 'update') {
    
    //secondary query for tableAbbrev. column insert
      $sql1='  SELECT CONCAT( `daySlotStart`,"_",`city`,"_",`slotEndNumber`," ",
                               `subjectAbbrev`,"_",`teachMethodTitle`," ",
                                `schoolSectionAbbrev`,`studentGroupAbbrev`," ",
                                 `professorShortName` ) as concated ,
      
 eventPlaCourseScarceResouParticiGroupID,       
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
      
WHERE eventPlaCourseScarceResouParticiGroupID = :eventPlaCourseScarceResouParticiGroupID
             
                                                                                ';
     $statement1= $pdoObject->prepare($sql1);

      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
  $myResult1= $statement1->execute( array( ':eventPlaCourseScarceResouParticiGroupID'=>$_POST['eventPlaCourseScarceResouParticiGroupID'] ) );   
  $record= $statement1->fetch(); 

    
        $sql= 'UPDATE eventplannedcourse_scarceresource_participantgroup_combis
               SET eventPlaCourseScarceResouParticiGroupAbbrev = :eventPlaCourseScarceResouParticiGroupAbbrev, 
                   eventPlannedCourseID = :eventPlannedCourseID, scarceResourceID = :scarceResourceID, schoolStudentGroupProfessorID = :schoolStudentGroupProfessorID
              WHERE eventPlaCourseScarceResouParticiGroupID = :eventPlaCourseScarceResouParticiGroupID';
        $statement= $pdoObject->prepare($sql);
        //use the Flag to save the query result status
        $myResult= $statement->execute( array( ':eventPlaCourseScarceResouParticiGroupAbbrev'=>$record[ 'concated' ],
                                               ':eventPlannedCourseID'=>$_POST['eventPlannedCourseID'],
                                               ':scarceResourceID'=>$_POST['scarceResourceID'],
                                               ':schoolStudentGroupProfessorID'=>$_POST['schoolStudentGroupProfessorID'],
                                               ':eventPlaCourseScarceResouParticiGroupID'=>$_POST['eventPlaCourseScarceResouParticiGroupID']
                                                         ) );
    }





    //  closing of the query statement and clearin the PDObject
    $statement->closeCursor();
    $pdoObject = null;
  } 
  catch (PDOException $e) {
     
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }
  
  
  if ( !$myResult ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
   
    header('Location: index.php?msg=ALL well done!');
    exit();
  }


 ?>