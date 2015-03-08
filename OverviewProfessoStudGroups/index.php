<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ΚΑΘΗΓΗΤΩΝ-ΦΟΙΤΗΤΩΝ ΕΠΙΣΚΟΠΗΣΗ</title>

  <style type="text/css">
    body {font-family:Helvetica,Arial,sans-serif; font-size:10.3pt;}
    #header {
      
      width:640;
      padding:6px;
      margin:4px;
      height:55px;
      font-size:14pt;
      text-align: center;
      border:solid thin gray;
      border-radius:5px;
    }
    #professors, #schoolstudentgroup_professor_links, #eventplannedcourse_scarceresource_participantgroup_combis { 
      float:left;   
      width:140px;        
      padding:10px; 
      margin:5px;   
      min-height:80px;    
      border:solid thin gray;
      border-radius:5px;  /* στρογγυλεμένες γωνίες - CSS3 */
    }
    #professors, #header {background-color:rgb(200,200,200);}
    #schoolstudentgroup_professor_links {width: 480px;} 
    #eventplannedcourse_scarceresource_participantgroup_combis {width: 320px; text-align: center;} 
       
    .center {text-align:center;}       

    .spinner {
      display: block;   /* εξ ορισμού είναι inline - για να δουλέψει το επόμενο */
      margin:30px auto; /* οριζόντιο κεντράρισμα εντός του πατρικού div */
    }
    
  </style>

  
<script type="text/javascript">

function myAJAXCall(professorID) {
  //-----AJAX init.-----
	var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
	//-----Avoid of page caching-----  
  var d= new Date();    
	var url= "getdata.php?foo="+d;
	
  //------- initial. of bussy indicator -----------
  document.getElementById('schoolstudentgroup_professor_links').innerHTML= "<img src= '../spinner.gif' class= 'spinner' />";
 
  //-----query to the server-----
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("professorID="+professorID);   
  
  //----- callback funct. declaration -----
  //auto calling on readyState change
  xmlhttp.onreadystatechange=function() {
    //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
    //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
		if(xmlhttp.readyState==4 && xmlhttp.status==200) {
      //η απάντηση του server βρίσκεται στο xmlhttp.responseText
      //την τοποθετούμε μέσα στο δεξιό div
			document.getElementById("schoolstudentgroup_professor_links").innerHTML= xmlhttp.responseText;
		} else 
        document.getElementById("schoolstudentgroup_professor_links").innerHTML= "Μη αποδεκτή απάντηση<br/>στην AJAX κλίση!";
	}

}
</script>

</script>

<script type="text/javascript">
function myAJAXCallPlus(schoolStudentGroupProfessorID) {              
  
	var xmlhttp2;
	if (window.XMLHttpRequest) {
	
		xmlhttp2=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
	
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
  }
  
  var d= new Date();   
	var url= "getdataPlus.php?foo="+d;
	
  document.getElementById('eventplannedcourse_scarceresource_participantgroup_combis').innerHTML= "<img src= '../spinner.gif' class= 'spinner' />";
 
  xmlhttp2.open("POST",url,true);
  xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp2.send("schoolStudentGroupProfessorID="+schoolStudentGroupProfessorID);   
  
  xmlhttp2.onreadystatechange=function() {
  
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200) {
  
			document.getElementById("eventplannedcourse_scarceresource_participantgroup_combis").innerHTML= xmlhttp2.responseText;
		} else 
        document.getElementById("eventplannedcourse_scarceresource_participantgroup_combis").innerHTML= "Μη αποδεκτή απάντηση<br/>στην AJAX κλίση!";
	}

}
</script>
  
</head>
  
</head>

<body>
<div>
<p><h3>&nbsp&nbsp&nbspΕπιθεώρηση Αναθέσεων μέσω των  ΚΑΘΗΓΗΤΗΣ+=> ΟΜΑΔΑ ΦΟΙΤΗΤΩΝ+=> ΑΝΑΘΕΣΗ  εκπαιδευτικού έργου TEI</h3></p>
</div>
<div id="professors">
  <p><a href="../index.php" title="Επιστροφή στην Αρχική της εφαρμογής"><b>home</b></a></p>
  <p><strong>Καθηγητές</strong></p>
  <?php
    require('../parameteDB.php');
    try { 
      $pdoObject= new PDO( "mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass );
      $pdoObject->exec( 'set names utf8' );
      $sql= "SELECT * FROM professors ORDER BY professorFullName ASC";
      $statement= $pdoObject->query($sql);
      while ( $record = $statement -> fetch( ) ) {
       
        echo '<p><a href="#" onclick="myAJAXCall('.$record['professorID'].');">' .$record['professorFullName']."</a></p>";
      }
      $statement -> closeCursor( );
      $pdoObject = null;
    } catch ( PDOException $e ) {
        
        die( "Database Error: " . $e -> getMessage( ) );
      }
?>
<p><a href="." title="Ανανέωση της σελίδας"><b>renew</b></a></p>
</div>

<!-- div with JavaScript results in it, by AJAX call -->
<div id="schoolstudentgroup_professor_links">
  <p class="center">εδώ θα εμφανιστούν<br/>ομάδες φοιτητών με καθηγητή</p>
</div>

<div id="eventplannedcourse_scarceresource_participantgroup_combis">
  <p class="center">εδώ θα εμφανιστούν<br/>τα ανατεθημένα μαθήματα</p>
</div> 

</body>
</html>
