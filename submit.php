<!DOCTYPE html>
<html>
<head profile="http://www.w3.org/2005/10/profile">
<title>SFML Game Jam</title>

<link rel="icon" 
      type="image/png" 
      href="http://sfmlgamejam.com/favicon.ico">

<script type="text/javascript" src="countdown.js"></script>
</style>
</head>
<body>
<div>
<?php 
$page = "submissions";
include 'header.php';
?>
</div>

<center>
<form action="welcome.php" method="post">
Game Title: <input type="text" name="name"><br>
First Dev Name: <input type="text" name="DevOne"><br>
Second Dev Name: <input type="text" name="DevTwo"><br>
Windows Link: <input type="text" name="Windows"><br>
Linux Link: <input type="text" name="Linux"><br>
OS X Link: <input type="text" name="OSX"><br>
<input type="submit">
</form>
</center>


</body>
</html> 
