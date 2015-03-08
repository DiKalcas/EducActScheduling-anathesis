<?php
      //in order to login need to check if already logedin 
     //      and if credentials have already sent
if ( !isset($_SESSION['username']) && isset($_POST['username'], $_POST['password']) ) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  // initialy the user is not authorised
  $authorised=false;

  if ( $username=='Secretary' && $password=='secretary' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;
      $_SESSION['schoolSectionName']= '*τμήμα σχολής;';       
      header('Location: pageOfSecretary.php');
      exit();
  }

  if ( $username=='Inspector' && $password=='inspector' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;  
      header('Location: pageOfInspector.php');
      exit();
  }
       
  if ( $username=='Assignor' && $password=='assignor' ) { //assume checked with DB query
      $authorised= true;                                 //  so that authorized user 
	    session_start();                   //start a new session for the user
	    $_SESSION['username']= $username; //  and put him in the session
      header('Location: pageOfAssignor.php');
      exit();
  }
  
  if ( $username=='Combiner' && $password=='combiner' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;  
      header('Location: pageOfCombiner.php');
      exit();
  }
  if ( $username=='Resourcer' && $password=='resourcer' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;  
      header('Location: pageOfResourcer.php');
      exit();
  }  
  if ( $username=='Depositary' && $password=='depositary' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;  
      header('Location: pageOfDepositary.php');
      exit();
  }
  if ( $username=='Recruiter' && $password=='recruiter' ) { //assume checked with DB query
      $authorised= true;                                   // so that authorized user
	    session_start();                      
	    $_SESSION['username']= $username;  
      header('Location: pageOfRecruiter.php');
      exit();
  }


      //redirect accondingly
  if ($authorised==false)  { 
      header("Location: index.php?msg=Αποτυχημένη διαπίστευση χρήστη!");
      exit();
  }


} else { 

  session_start();     //reconection with the current session
  session_destroy();  //  so that to destroy it
  header("Location: index.php?msg=Πρόβλημα - Δοκίμασε ξανά!");
  exit();  //πάντα exit μετά το header (προληπτικά)

}

?>