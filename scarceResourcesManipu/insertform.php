<?php 
 require('../parameteDB.php'); //για στοιχεία σύνδεσης σε MySQL
 require('../functions.php'); //βοηθητική συνάρτηση πλήρωσης λίστας από πίνακα
 require('../errors.php');   //μυνήματα λάθους

                  //προσδιορισμός λειτουργίας φόρμας - ΠΕΡΙΠΤΩΣΗ INSERT
 if ( isset($_GET['mode'] ) &&  $_GET['mode']=='insert'  ) {
    $title='συνδιασμ. διαθέσιμης αίθουσας την συγκεκριμένη ώρα της ημέρας';
             //καταχωρούμε τιμές στις μεταβλητές αρχικοποίησης της φόρμας 
    $locationAddressID_byLocationAddresses=      '';
    $buildingFloorRoomID_byBuildingFloorRooms=   '';
    $timeSlotID_byTimeSlots=                     '';
    $city=                                     '';
    $area=                                    '';
    $address=                                '';
    $roomName=                              '';
    $floorLevelName=                       '';
    $buildingName=                         '';
    
  }  
?>

<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>ΝΕΟΣ ΣΥΝΔΙΑΣΜΟΣ</title>
 <link rel="stylesheet" type="text/css" href="../styles.css"/>
</head>
<body>
 <div id="container">
  <h2 class="center"><?php echo $title; ?></h2>
  <br />
  <fieldset><legend>ΣΤΗ ΣΧΟΛΗ ΥΠΑΡΧΕΙ ΔΙΑΘΕΣΙΜΗ ΑΙΘΟΥΣΑ ΤΗΝ ΩΡΑ</legend>
  <form name="form1" action="inserthandler.php" method="post">



  <p>Διεύθηνση Σχολής: <select name="locationAddressID_byLocationAddresses">
          <?php load_options('locationaddresses', $locationAddressID_byLocationAddresses) ?>
        </select>
  </p>
  <p>Αίθουσα σε χώρο του ΤΕΙ: <select name="buildingFloorRoomID_byBuildingFloorRooms">
          <?php load_options('buildingfloorrooms', $buildingFloorRoomID_byBuildingFloorRooms) ?>
        </select>
  </p>
    <p>Διαθέσιμη μέρα-ώρα: <select name="timeSlotID_byTimeSlots">
          <?php load_options('timeslots', $timeSlotID_byTimeSlots) ?>
        </select>
  </p>
     
  <p><span><input type="reset"/></span><span><input type="submit"/></span></p>
  </form>  
  </fieldset>
  <p class="right"><a href="index.php" title="Επιστροφή χωρίς καμία λειτουργία φόρμας"><b>go.back</b></a></p>
 </div> 
</body>
</html>

