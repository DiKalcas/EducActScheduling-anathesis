combine the scripts:

(SELECT * 
 FROM  `schools`, `eventplannedcourses`, `subjects`  
 WHERE `schools`.`schoolID` = `eventplannedcourses`.`schoolID`
   AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID`)



(SELECT * FROM `eventplannedcourses` WHERE SELECT * 
 FROM  `teachmethods`, `eventplannedcourses`
 WHERE `teachMethodID` = `teachMethodID_byTeachMethods`)



in one script:

SELECT * 
FROM  `eventtypes`, `schools`, `eventplannedcourses`, `subjects`, `teachmethods` 
WHERE `schools`.`schoolID` = `eventplannedcourses`.`schoolID`
  AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID`
  AND `eventtypes`.`eventTypeID` = `eventplannedcourses`.`eventTypeID` 
  AND `teachMethodID` = `teachMethodID_byTeachMethods`
  
  
  
SELECT `schoolSectionName`, `subjectName`, `teachMethodTitle`
FROM  `schools`, `eventplannedcourses`, `subjects`, `teachmethods` 
WHERE `schools`.`schoolID` = `eventplannedcourses`.`schoolID`
  AND `subjects`.`subjectID` = `eventplannedcourses`.`subjectID` 
  AND `teachMethodID` = `teachMethodID_byTeachMethods`
  
  
  
UPDATE `eduschedul`.`eventplannedcourses` 
SET `schoolID` = '12', `teachMethodID_byTeachMethods` = '12' 
WHERE `eventplannedcourses`.`schoolID` = 11 AND `eventplannedcourses`.`subjectID` = 11 AND `eventplannedcourses`.`teachMethodID_byTeachMethods` = 11;  