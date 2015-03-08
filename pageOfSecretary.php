<?php 

     // if user haven't login, redirect him with messg 
  require('con_is_logged_in.php');

?>


<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>ΓΡΑΜΜΑΤΕΙΑ</title>
  <link rel="stylesheet" type="text/css" href="stylesPlus.css"/>
  
</head>
<body>

  <div id="container">


    <div id="header">
      <h1>συνδιασμός εκπαιδευτικών πόρων<br>
      και αναθέσεις</h1>
    </div>
    
    <div id="leftsidebar">
      <ul class="menu">
        <li><a href="#">home</a></li>
        <li><a href="#">grant option</a></li>
        <li><a href="#">Σελίδα Χρήστη</a></li>
        
        <p><strong>Τμήματα Σχολών*</strong></p>
        
<?php //notWorking function sessionPlus($schoolID) { $_SESSION['schoolID']= $schoolID; print_r($_SESSION); } ?>   
<?php if( isset($_GET['id1'], $_GET['id2']) ) { $_SESSION['schoolID']= $_GET['id1']; $_SESSION['schoolSectionName']= $_GET['id2']; } ?>
                
<?php
    require('parameteDB.php');
    try { 
      $pdoObject= new PDO( "mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass );
      $pdoObject->exec( 'set names utf8' );
      $sql= "SELECT * FROM schools ORDER BY schoolSectionAbbrev ASC";
      $statement= $pdoObject->query($sql);
      while ( $record = $statement -> fetch( ) ) {
        echo '<li><a href="pageOfSecretary.php?id1='.$record['schoolID'].'&id2='.$record['schoolSectionName'].'">' .$record['schoolSectionAbbrev'] .'</a></li>';
  
      }                                         
      $statement -> closeCursor( );
      $pdoObject = null;
    } catch ( PDOException $e ) {
         
        die( "Database Error: " . $e -> getMessage( ) );
      }
?>

        <?php if ( isset($_SESSION['username']) ) { ?>

           <!-- η επιλογή logout δίνεται μόνο σε όσους έχουν κάνει login -->
           <!-- η ανάγκη για session_start() έχει καλυφθεί στα αρχεία-σελίδες -->
           <li><a href="con_logout.php">logout</a></li>
           
        <?php } ?>

      </ul>

    </div>
    

    <?php require('errors.php'); ?>
    <div id="main">
<?php  
  echo'<h2>Σελίδα Γραμματείας '.$_SESSION['schoolSectionName'].' </h2>'; ?>
       <?php echo_msg(); ?>
       
<?php if(isset($_SESSION['schoolID'] ) )  {
  echo'<br><ul class="main">';
  echo'<br><li><a href="\EduSchedule\secretaryOperations\" title="ανοίγει ευρύ παράθυρο για οθόνη ανάλογου μεγέθους!">ΑΝΑΘΕΣΕΙΣ ΕΚΠΑΙΔΕΥΤΙΚΟΥ ΕΡΓΟΥ</a></li>';
                                                                       }    ?>
    </div>

    <div id="footer">
      <div id="leftfooter">Τεχνολογικό Εκπαιδευτικό Ι. Θεσσαλίας</div>
      <?php //checkSession print_r($_SESSION); ?>
      <div id="rightfooter">Γραμματειακές Υπηρεσίες</div>
    </div>


  </div>  <!-- div of container -->

</body>
</html>
