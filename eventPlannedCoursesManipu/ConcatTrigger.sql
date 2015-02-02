SELECT 
  article.a_id, 
  article.title, 
  GROUP_CONCAT(article_image.image  SEPARATOR ',') AS images
FROM article 
LEFT JOIN article_image ON article.a_id = article_image.a_id
GROUP BY article.a_id, 
         article.title;
         
SELECT article.a_id, article.title, article_image.image FROM article
INNER JOIN article_iamge ON article.a_id = article_image.a_id

 SELECT CONCAT(`schoolSectionAbbrev`, `subjectAbbrev`, `teachMethodTitle`)
                            
           FROM  `eventplannedcourses` 
  LEFT JOIN `schools` ON `schoolID` = `schoolID_ofSchools`
  LEFT JOIN `subjects` ON `subjectID` = `subjectID_ofSubjects`
  LEFT JOIN `teachmethods` ON `teachMethodID` = `teachMethodID_ofTeachMethods`
           
           WHERE `eventPlannedCourseID` = 9

SELECT FirstName AS First_Name
     , LastName AS Last_Name
     , CONCAT(ContactPhoneAreaCode1, ContactPhoneNumber1) AS Contact_Phone 
  FROM TABLE1
  
SELECT FirstName AS First_Name
     , LastName AS Last_Name
     , CONCAT_WS('', ContactPhoneAreaCode1, ContactPhoneNumber1) AS Contact_Phone 
  FROM TABLE1
  

  
DELIMITER $$

CREATE TRIGGER new_loaner_added 
AFTER INSERT ON `total_loaner` for each row
begin
INSERT INTO available_loaner (Kind, Type, Sno, Status)
Values (new.Kind, new.Type, new.Sno, 'Available');
END$$

DELIMITER ;

-----------------------------------------------------------------------

 SELECT CONCAT(`schoolSectionAbbrev`, `subjectAbbrev`, `teachMethodTitle`), 
                 `schoolID`, `schoolID_ofSchools`, `subjectID`, `subjectID_ofSubjects`, 
                 `teachMethodID`, `teachMethodID_ofTeachMethods`
           FROM  `eventplannedcourses`,`schools`, `subjects`, `teachmethods` 
           WHERE `schoolID` = `schoolID_ofSchools`
              AND `subjectID` = `subjectID_ofSubjects` 
              AND `teachMethodID` = `teachMethodID_ofTeachMethods` 
              
-------------------------------------------------------------------------

 SELECT CONCAT(`schoolSectionAbbrev`, `subjectAbbrev`, `teachMethodTitle`)
               
           FROM  `eventplannedcourses`,`schools`, `subjects`, `teachmethods` 
           WHERE `schoolID` = `schoolID_ofSchools`
              AND `subjectID` = `subjectID_ofSubjects` 
              AND `teachMethodID` = `teachMethodID_ofTeachMethods` 
              
----------------------------------------------------------------------------

