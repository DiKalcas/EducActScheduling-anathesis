<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database

      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( isset( $_POST['scarceResourceID'] ) )  
      $mode='update'; 
  
      //αν κάνουμε update
  if ($mode == 'update') { 
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['locationAddressID_byLocationAddresses'], $_POST['buildingFloorRoomID_byBuildingFloorRooms'], $_POST['timeSlotID_byTimeSlots'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying update)');
      exit();
    }  
  }
  


 
  $myResult1=false;
  $myResult2=false;
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 

    
    //περίπτωση UPDATE
    if ($mode == 'update') {

      $sql1='  SELECT CONCAT(`city`," | ",`roomNAme`," | ",`daySlotStart`," | ",`slotEndNumber`) as concated
               
           FROM  `scarceresources`,`locationaddresses`, `buildingfloorrooms`, `timeslots` 
           WHERE `locationAddressID` = :locationAddressID_byLocationAddresses
              AND `buildingFloorRoomID` = :buildingFloorRoomID_byBuildingFloorRooms 
              AND `timeSlotID` = :timeSlotID_byTimeSlots  ';
     $statement1= $pdoObject->prepare($sql1);

      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
  $myResult1= $statement1->execute( array( ':locationAddressID_byLocationAddresses'=>$_POST['locationAddressID_byLocationAddresses'],                                                                
                                             ':buildingFloorRoomID_byBuildingFloorRooms'=>$_POST['buildingFloorRoomID_byBuildingFloorRooms'],
                                             ':timeSlotID_byTimeSlots'=>$_POST['timeSlotID_byTimeSlots'] ) );   
  $record= $statement1->fetch();

    
        $sql2= ' UPDATE scarceresources
                SET scarceResourceAbbrev = :scarceResourceAbbrev,
                    locationAddressID_byLocationAddresses = :locationAddressID_byLocationAddresses, 
                    buildingFloorRoomID_byBuildingFloorRooms = :buildingFloorRoomID_byBuildingFloorRooms, 
                    timeSlotID_byTimeSlots = :timeSlotID_byTimeSlots                     
                WHERE scarceResourceID = :scarceResourceID ';
        $statement2= $pdoObject->prepare($sql2);                     
        //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
        $myResult2= $statement2->execute( array( 
         ':scarceResourceAbbrev'=>$record[ 'concated' ],
         ':locationAddressID_byLocationAddresses'=>$_POST['locationAddressID_byLocationAddresses'],
         ':buildingFloorRoomID_byBuildingFloorRooms'=>$_POST['buildingFloorRoomID_byBuildingFloorRooms'],
         ':timeSlotID_byTimeSlots'=>$_POST['timeSlotID_byTimeSlots'],
         ':scarceResourceID'=>$_POST['scarceResourceID'] ) );
    }  
    // κλείσιμο PDO
    $statement1->closeCursor();
    $statement2->closeCursor();
    $pdoObject= null;
  }  
  catch (PDOException $e) {
     
      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }

 
  if ( !$myResult1 || !$myResult2 ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {
   
    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>