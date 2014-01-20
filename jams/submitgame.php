<?php
include 'submission.php';

$game = new Submission($_POST['Name'], $_POST['Dev1'], $_POST['Dev2'], $_POST['Screen1'], $_POST['Screen2'], $_POST['Screen3'], $_POST['Win32'], $_POST['Win64'], $_POST['Lin32'], $_POST['Lin64'], $_POST['OSX']);

// Create connection
$con=mysqli_connect("localhost","jebbs_jebbs","ilikepie","jebbs_jams");

$game->submitToDataBase($con, "jam1");

//$game->display();

header( 'Location: http://www.sfmlgamejam.com/jams/jam1submit.php' ) ;

?>