<?php session_start(); ?>

<?php require('errors.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  <!-- το περιεχόμενο στην ετικέτα title θα μπορούσε να παράγεται 
       δυναμικά ώστε κάθε σελίδα να έχει δικό της -->
  <title>HOME</title>
  <link rel="stylesheet" type="text/css" href="stylesPlus.css"/>
</head>
<body>

  <div id="container">


    <div id="header">
      <h1>εφαρμογή ανάθεσης διδακτικού έργου</h1>
    </div>

    <div id="leftsidebar">
      <ul class="menu">
        <li><a href="index.php" title="σελ.Αρχική της εφαρμογής"><b>home</b></a></li>
        <li><a href="pageOfRecruiter.php " title="...hallo Recruiter!">Σελίδα Στρατολογητή</a></li>
        <li><a href="pageOfDepositary.php" title="...hallo Depositary!">Σελίδα Θεματοφύλακα</a></li>
        <li><a href="pageOfResourcer.php" title="...hallo Resourcer!">Εκπαιδευτικών Πόρων σ.</a></li>
        <li><a href="pageOfCombiner.php" title="...hallo Combiner!">Συνδιαστή Πόρων σελ.</a></li>
        <li><a href="pageOfSecretary.php" title="...hallo Secretary!">Σελίδα Γραμματείας</a></li>
        <li><a href="pageOfAssignor.php" title="...hallo Assignor!">Σελίδα Εντολέα</a></li>
        <li><a href="pageOfInspector.php" title="...hallo Inspector!">Σελίδα Επιμελητή</a></li>

        <?php if ( isset($_SESSION['username']) ) { ?>

           <!-- η επιλογή logout δίνεται μόνο σε όσους έχουν κάνει login -->
           <!-- η ανάγκη για session_start() έχει καλυφθεί στα αρχεία-σελίδες -->
           <li><a href="con_logout.php">logout</a></li>
           
        <?php } ?>

      </ul>

    </div>
    <div id="main_notes"><br><br>
    Η εφαρμογή Ανάθεσης Διδακτικού Έργου είναι δομημένη με βάση<br>
    τον χρήστη που συνδέεται, για να κάνει συγκεκριμένες λειτουργίες.<br>
    Σύμφωνα με την ανάλυση-σχεδίαση που έγινε δημιουργήθηκαν οι ρόλοι των χρηστών.<br>
    Έτσι, ο Στρατολογητής έχει σκοπό την καταγραφή στοιχείων των καθηγητών<br>
    που εντάσονται για να εκτελέσουν εκπαιδευτικό έργο.<br>
    Ο Θεματοφύλακας έχει σκοπό να ενημερώσει τα θέματα-μαθήματα<br>
    που υπάρχουν στο Τ.Ε.Ι. διαθέσιμα προς διδασκαλία.<br>   
    O Διαχειριστής Εκπαιδευτικών Πόρων ενημερώνει την εφαρμογή<br>
    σε αντιστοιχία μέ πόρους του Τ.Ε.Ι. που σχετίζονται ...<br>
    Ο Συνδιαστής Εκπαιδευτικών Πόρων συνδιάζει τους πόρους του Τ.Ε.Ι.<br>
    για να προετοιμάσει τα μέρη της ανάθεσης εκπαιδευτικού έργου.<br>
    O Γραμματέας επιλέγει από το σύνολο των θεμάτων, τα μαθήματα<br>
    που είναι προγραμματισμένα να διδαχθούν στο εξάμηνο<br>
    στο κάθε τμήμα της σχολής αναθέτει διδασκαλία σε καθηγητές.<br>
    Ο Εντολέας συνδιάζει τα διάφορα μέρη της ανάθεσης εκπαιδευτικού έργου<br>
    με σκοπό την δημιουργία και προγραμματισμό αναθέσεων.<br>
    Ο Επιμελητής έχει σκοπό να επιθεωρίσει τις αναθέσεις που έχουν γίνει.<br>
    
        
    
    </div>  
    <div id="main">
       <h2>Home Page</h2>

       

       <!-- αν δεν έχει κάνει login δώσε τη φόρμα login -->
       <?php if ( !isset($_SESSION['username']) ) { ?>
       
         <p>Please login:</p>
         <form name="form1" method="post" action="con_login.php">
           <p>username: <input type="text" name="username"/> </p>
           <p>password: <input type="password" name="password"/> </p>
           <p><input name="submit" type="submit"></p>
         </form>
         
         <br><?php echo_msg(); ?>

       <?php } else echo '<p>Hello '.$_SESSION['username'].'!</p>'; ?>
       
    </div>


    <div id="footer">
      <div id="leftfooter">TEI of Thessaly</div>
      <div id="rightfooter">cs2393@teilar.gr</div>
    </div>


  </div>  <!-- div of container -->

</body>
</html>
