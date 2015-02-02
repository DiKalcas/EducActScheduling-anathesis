<?php
  require('../parameteDB.php'); //παράμετροι σύνδεσης στην database
 
      //θα σημειώσουμε το αποτέλεσμα του ελέγχου σε μια μεταβλητή για μετέπειτα χρήση
  if ( !isset( $_POST['scarceResourceID'] ) )  
          $mode='insert';
  
  
      //αν κάνουμε insert
  if ($mode == 'insert') {
        //αν δεν έχει οριστεί κάτι από τα ακόλουθα έχουμε πρόβλημα
    if ( !isset( $_POST['locationAddressID_byLocationAddresses'], $_POST['buildingFloorRoomID_byBuildingFloorRooms'], $_POST['timeSlotID_byTimeSlots'] ) ) { 
      header('Location: index.php?msg=ERROR: missing data (trying insert)');
      exit();
    }  
  }

  $myResult1= false;
  $myResult2= false;
  
  try { //σύνδεση με PDO
    $pdoObject= new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    //ανάλογα τι κάνουμε, διαφοροποιούμε το sql query και τις παραμέτρους του 

    //περίπτωση INSERT
    if ($mode == 'insert') {
    
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
 
    
      $sql2='INSERT INTO scarceresources( scarceResourceAbbrev, locationAddressID_byLocationAddresses, buildingFloorRoomID_byBuildingFloorRooms, timeSlotID_byTimeSlots )
            VALUES                           ( :scarceResourceAbbrev, :locationAddressID_byLocationAddresses, :buildingFloorRoomID_byBuildingFloorRooms, :timeSlotID_byTimeSlots )';
      $statement2= $pdoObject->prepare($sql2);
      //αποθηκεύουμε το αποτέλεσμα στη μεταβλητή $myResult
      $myResult2= $statement2->execute( array(  ':scarceResourceAbbrev'=>$record[ 'concated' ],
                                             ':locationAddressID_byLocationAddresses'=>$_POST['locationAddressID_byLocationAddresses'],                    
                                             ':buildingFloorRoomID_byBuildingFloorRooms'=>$_POST['buildingFloorRoomID_byBuildingFloorRooms'],
                                             ':timeSlotID_byTimeSlots'=>$_POST['timeSlotID_byTimeSlots']
                                             
                                              ) );                                                                                      
            
    }
      
    // κλείσιμο PDO
    $statement2->closeCursor();
    $pdoObject= null;
  }  
  catch (PDOException $e) {

      header('Location: index.php?msg=PDO Exception: '.$e->getMessage());
      exit();
  }


  if ( !$myResult2 || !$myResult1 ) {
    header('Location: index.php?msg=ERROR: failed to execute sql query');
    exit();
  }
  else {

    header("Location: index.php?msg=ALL well done!&lastid=$lastid");
    exit();
  } 
  
?>