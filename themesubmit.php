<?php
session_start();

$theme=$_POST["suggesstion"];
if($theme != "")
{
$_SESSION['lastSuggestion'] = $theme;

//put all that shit into a database
$notice = "Thank you for submitting " . $_POST["suggestion"];

// Create connection
$con=mysqli_connect("localhost","jebbs_jebbs","ilikepie","jebbs_themesuggestions");

 
 
  	//table name = suggestions
  	$sql = "INSERT INTO suggestions(theme)
	VALUES ('$_POST[suggestion]')";

	if (!mysqli_query($con,$sql))
  	{
  		die('Error: ' . mysqli_error($con));
	}

 	 /* This part gets all of the data stored in the data base
  	$result = mysqli_query($con,"SELECT * FROM suggestions");
  	
	while($row = mysqli_fetch_array($result))
 	 {
 	 echo $row['theme'];
  	echo "<br>";
  	}
  	*/
  }
  header( 'Location: http://www.sfmlgamejam.com/themes.php' ) ;
	die('Don\'t ignore my php headers, yo!');

?>