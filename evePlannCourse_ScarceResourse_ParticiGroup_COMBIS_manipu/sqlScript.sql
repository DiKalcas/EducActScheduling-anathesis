$preview = substr($whole_field, 0, 50); 
mb_substr($utf8string,0,5,'UTF-8')

         . '~ [ ' . mb_substr($record[ 'schoolSectionName' ], 0, 18, 'UTF-8') 
         . ' | ' . $record[ 'subjectName' ]
         . ' | ' . mb_substr($record[ 'teachMethodTitle' ], 0, 6, 'UTF-8')

         . ' | ' . mb_substr($record[ 'studentGroupName' ], 0, 24, 'UTF-8')
         . ' | ' . $record[ 'professorLastName' ]
         . ' | ' . $record[ 'professorMiddleName' ]
         . ' | ' . $record[ 'professorFirstName' ]


LEFT(str, len) 

SELECT substring(biography, 1, 100)   ...
SELECT id, SUBSTRING(full_name,1, 32), ...
UPDATE merry_parents SET mobile=SUBSTRING(mobile, 1, 10)


 ----------------------------------------------------------------------------------
          
         
SELECT `schools`.`schoolID`, `schoolSectionName`, `subjectName`, `subjects`.`subjectID`, 
       `teachMethodID_byTeachMethods`, `teachMethodTitle` 
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `schools`, `eventplannedcourses`, `subjects`, `teachmethods` 
 WHERE `eventplannedcourses`.`eventPlannedCourseID` = `eventtimeunit_locationroom_participantgroup_combis`.`eventPlannedCourseID` 
   AND `schools`.`schoolID` = `eventplannedcourses`.`schoolID` 
   AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID` 
   AND `teachMethodID` = `teachMethodID_byTeachMethods`         
   
   
 ----------------------------------------------------------------------------------
 

SELECT `locationAddressID`, `city`, `roomTitle`, `roomTypeID` 
        
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `locationaddresses`, `locationaddresses_roomtypes_links`, `roomtypes` 
   WHERE `locationaddresses_roomtypes_links`.`locatAddressRoomTypeID` = `eventtimeunit_locationroom_participantgroup_combis`.`LocatAddressRoomTypeID` 
   AND `locationaddresses`.`locationAddressID` = `locationAddressID_fromLocationAddresses` 
   AND `roomtypes`.`roomTypeID` = `roomTypeID_fromRoomTypes` 
         
         
 ----------------------------------------------------------------------------------      
 

SELECT `professorID` , `professorLastName` , `professorFirstName` , `schoolSectionName` , `schools`.`schoolID` , 
       `studentGroupID_byStudentGroups` , `studentGroupName` 
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `professors`, `schoolstudentgroups_professors_links`, `schools`, `studentgroups` 
  WHERE `schoolstudentgroups_professors_links`.`SchoolStudentGroupProfessorID` = `eventtimeunit_locationroom_participantgroup_combis`.`SchoolStudentGroupProfessorID` 
   AND `professorID` = `professorID_byProfessors` 
   AND `schools`.`schoolID` = `schoolID_bySchools` 
   AND `studentGroupID` = `studentGroupID_byStudentGroups`          
   
   
 ----------------------------------------------------------------------------------
 ----------------------------------------------------------------------------------
   

(SELECT `schools`.`schoolID`, `schoolSectionName`, `subjectName`, `subjects`.`subjectID`, 
       `teachMethodID_byTeachMethods`, `teachMethodTitle` 
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `schools`, `eventplannedcourses`, `subjects`, `teachmethods` 
 WHERE `eventplannedcourses`.`eventPlannedCourseID` = `eventtimeunit_locationroom_participantgroup_combis`.`eventPlannedCourseID` 
   AND `schools`.`schoolID` = `eventplannedcourses`.`schoolID` 
   AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID`                        
   AND `teachMethodID` = `teachMethodID_byTeachMethods`                                  )
   
UNION

(SELECT `professorID` , `professorLastName` , `professorFirstName` , `schoolSectionName` , `schools`.`schoolID` , 
       `studentGroupID_byStudentGroups` , `studentGroupName` 
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `professors`, `schoolstudentgroups_professors_links`, `schools`, `studentgroups` 
  WHERE `schoolstudentgroups_professors_links`.`SchoolStudentGroupProfessorID` = `eventtimeunit_locationroom_participantgroup_combis`.`SchoolStudentGroupProfessorID` 
   AND `professorID` = `professorID_byProfessors` 
   AND `schools`.`schoolID` = `schoolID_bySchools` 
   AND `studentGroupID` = `studentGroupID_byStudentGroups`  )

#1222 - The used SELECT statements have a different number of columns 




 SELECT `schools`.`schoolID`, `schoolSectionName`, `subjectName`, `subjects`.`subjectID`, 
       `teachMethodID_byTeachMethods`, `teachMethodTitle`,
       `professorID` , `professorLastName` , `professorFirstName` , `schoolSectionName` , `schools`.`schoolID` , 
       `studentGroupID_byStudentGroups` , `studentGroupName` 
  FROM `eventtimeunit_locationroom_participantgroup_combis` 
       JOIN `schools`, `eventplannedcourses`, `subjects`, `teachmethods` 
       JOIN `professors`, `schoolstudentgroups_professors_links`, `studentgroups` 
 WHERE `eventplannedcourses`.`eventPlannedCourseID` = `eventtimeunit_locationroom_participantgroup_combis`.`eventPlannedCourseID` 
   AND  `schoolstudentgroups_professors_links`.`SchoolStudentGroupProfessorID` = `eventtimeunit_locationroom_participantgroup_combis`.`SchoolStudentGroupProfessorID` 
   
   AND `schools`.`schoolID` = `eventplannedcourses`.`schoolID` 
   AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID` 
   AND `teachMethodID` = `teachMethodID_byTeachMethods`   

   AND `professorID` = `professorID_byProfessors` 
   AND `schools`.`schoolID` = `schoolID_bySchools` 
   AND `studentGroupID` = `studentGroupID_byStudentGroups`      
 
 

    
  `eventplannedcourse_scarceresourse_participantgroup_combis`.`scarceResourceID`,
   
   `timeSlotID_byTimeSlots`, `daySlotStart`
   
   JOIN `locationaddresses`, `scarceresources`, `buildingfloorrooms`, `timeslots`
   
   AND `locationAddressID` = `locationAddressID_byLocationAddresses`
   AND `buildingFloorRoomID` = `buildingFloorRoomID_byBuildingFloorRooms`
   AND `timeSlotID` = `timeSlotID_byTimeSlots` 
   
-------REFACTORING--------------
 `schools`.`schoolID`, `schoolSectionName`, `subjectName`, `subjects`.`subjectID`, 
       `teachMethodID_ofTeachMethods`, `teachMethodTitle`,
       `professorID` , `professorLastName` , `professorFirstName` , `schoolSectionName` , `schools`.`schoolID` , 
       `studentGroupID_byStudentGroups` , `studentGroupName` 
 
 
 SELECT * 
  FROM `eventplannedcourse_scarceresource_participantgroup_combis` 
       JOIN `schools`, `eventplannedcourses`, `subjects`, `teachmethods`, 
               `professors`, `schoolstudentgroup_professor_links`, `studentgroups`
        JOIN `locationaddresses`,`scarceresources`,`buildingfloorrooms` 
 WHERE `eventplannedcourses`.`eventPlannedCourseID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID` 
   AND  `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID` 
   
   AND `schools`.`schoolID` = `eventplannedcourses`.`schoolID_ofSchools` 
   AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID_ofSubjects` 
   AND `teachMethodID` = `teachMethodID_ofTeachMethods`   

   AND `professorID` = `professorID_byProfessors` 
   AND `schools`.`schoolID` = `schoolID_bySchools` 
   AND `studentGroupID` = `studentGroupID_byStudentGroups`     
   
// the result is NOT what expected to be
---------------------------------------------------------------------------------



 SELECT *
       
  FROM 
      `eventplannedcourse_scarceresource_participantgroup_combis` 
       JOIN `eventplannedcourses`
       JOIN `scarceresources`
       JOIN `schoolstudentgroup_professor_links`
       
 WHERE 
 `eventplannedcourses`.`eventPlannedCourseID` =   `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID` 
   AND `scarceresources`.`scarceResourceID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID`
   AND `schoolstudentgroup_professor_links`.`SchoolStudentGroupProfessorID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`SchoolStudentGroupProfessorID` 

        --------

 SELECT `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID`,
        `eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID`,
        `eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID`,
        
        `eventplannedcourses`.`eventPlannedCourseID`,
        `schoolID_ofSchools`,`subjectID_ofSubjects`,`teachMethodID_ofTeachMethods`,
        `schoolSectionName`,
        
        `scarceresources`.`scarceResourceID`,
        `locationAddressID_byLocationAddresses`,`buildingFloorRoomID_byBuildingFloorRooms`,`timeSlotID_byTimeSlots`,
        
        `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID`,
        `schoolID_bySchools`,`studentGroupID_byStudentGroups`,`professorID_byProfessors`
        
       
  FROM 
      `eventplannedcourse_scarceresource_participantgroup_combis`, 
        `eventplannedcourses`, 
        `scarceresources`,
        `schoolstudentgroup_professor_links`,                JOIN   `schools`
       
 WHERE 
       `eventplannedcourses`.`eventPlannedCourseID` =   `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID` 
   AND `scarceresources`.`scarceResourceID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID`
   AND `schoolstudentgroup_professor_links`.`SchoolStudentGroupProfessorID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`SchoolStudentGroupProfessorID` 
 
--------------------------------------------------------------------------

SELECT * 
 FROM `eventplannedcourse_scarceresource_participantgroup_combis` 
  LEFT JOIN (`eventplannedcourses` CROSS JOIN `scarceresources` CROSS JOIN `schoolstudentgroup_professor_links`)
 ON ( `eventplannedcourses`.`eventPlannedCourseID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID` 
  AND `scarceresources`.`scarceResourceID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`scarceResourceID` 
  AND `schoolstudentgroup_professor_links`.`schoolStudentGroupProfessorID` = `eventplannedcourse_scarceresource_participantgroup_combis`.`schoolStudentGroupProfessorID` )
       ---------

SELECT * 
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
            ------------
            
SELECT `eventplannedcourse_scarceresource_participantgroup_combis`.`eventPlannedCourseID`,
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
    
  `locationAddressID_byLocationAddresses`, `locationAddressID`, `area`,
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

    
  