<?php
  require('..\functions.php');
  require('..\errors.php')
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΑΙΘΟΥΣΑ-ΔΙΑΘΕΣΙΜΗ ΩΡΑ</title>
  <link rel="stylesheet" type="text/css" href="..\styles.css"/>
  <script>
   function changeScreenSize(w,h)
     {
       window.resizeTo( w,h )
     }
  </script>
</head>
<body onload="changeScreenSize(1280, 660)">

<div id="head">λεπτομερή λίστα συνδιασμών αίθουσα-ώρα διαθέσιμων για μαθήματα τεχνολ.εκπ.ιδρ.</div>


<div id="results">
  <p class="center">
    [ <b>ΔΙΕΥΘΗΝΣΗ ΣΧΟΛΗΣ + <strike>ΤΥΠΟΣ ΑΙΘΟΥΣΑΣ</strike> + ΔΙΑΘΕΣΙΜΗ ΩΡΑ</b> ]
  </p>

<?php
  require_once('..\parameteDB.php');//the database connection param.

  try {// activation of PDO
    $pdoObject =new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $sql ='SELECT `scarceResourceID`, 
                  `city`, `area`, `address`, 
                  `floorLevelName`, `roomName`, `buildingName`, 
                  `daySlotStart`, `slotEndNumber`, `dayName`, `eventTypeName`                                
             FROM  `scarceresources`, `locationaddresses`,  `buildingfloorrooms`, `timeslots`, `days`, `eventtypes`                        
            WHERE `locationAddressID` = `locationAddressID_byLocationAddresses`
              AND `buildingFloorRoomID` = `buildingFloorRoomID_byBuildingFloorRooms`
              AND `timeSlotID` = `timeSlotID_byTimeSlots` 
              AND `days`.`dayID` = `timeslots`.`dayID`
              AND `timeslots`.`eventTypeID` = `eventtypes`.`eventTypeID` 
                 ORDER BY `locationAddressID_byLocationAddresses`, `timeSlotID_byTimeSlots` ASC                              ';
   
    $statement= $pdoObject->query($sql);
 
    $recoCounter= 0;
    while ( $record= $statement->fetch() ) {

      $recoCounter++;
      echo '<p class="result">'            
         . '<span><a href="deleteRecord.php?mode=delete&id=' . $record['scarceResourceID'] .'"><img src="../deleteButton.png"/></a>' 
         . '~[ ' . $record[ 'city' ] 
         . ' | ' . $record[ 'area' ]
         . ' | ' . $record[ 'address' ] .'</span>'        
         . ' ' . $record[ 'floorLevelName' ]      
         . ' | ' . $record[ 'roomName' ] 
         . '<span>' . $record[ 'daySlotStart' ]
         . ' | ' . $record[ 'dayName' ]           
         . ' | ' . $record[ 'slotEndNumber' ]  
         . ' | ' . $record[ 'eventTypeName' ]     
         .  ' ]..' . '<a href="updateform.php?mode=update&id=' . $record['scarceResourceID'] .'"><img src="../editButton.png"/></a></span>
            </p>';
    }

    $statement->closeCursor();//query results closing
    $pdoObject = null;       //database connection closing

   } catch (PDOException $e) {
    
     echo 'PDO Exception: '.$e->getMessage();
  
   }
?>  
 
<p><?php echo_msg(); ?></p>
<p id="commands"><span><a href="../pageOfCombiner.php" title="Επιστροφή στην Σελίδα του Συνδιαστή"><b>home&nbsp;Combiner</b></a></span>&ensp;Σύνολο <?php echo $recoCounter; ?> ΕΓΓΡΑΦΩΝ <span><a href="insertform.php?mode=insert">Προσθήκη ΝΕΑΣ εγγραφής</a></span></p>

</div>

</body>
</html>
