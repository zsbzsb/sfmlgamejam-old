<?php include 'admin/settings.php' ?>
<!DOCTYPE html>
<html>
<head profile="http://www.w3.org/2005/10/profile">
<title>SFML Game Jam</title>

<link rel="icon" 
      type="image/png" 
      href="http://sfmlgamejam.com/favicon.ico">

<script type="text/javascript" src="countdown.js"></script>
</head>
<body>
<div id = "header">
<?php 
$page = "themes";
include 'header.php';
 ?>
</div>

<div id = "page">
<?php 



if($GLOBALS['themesubmit'] == true)
{
	include 'themesubmissions.php';
}
else
{
	
}
	


 ?>
</div>

</body>
</html> 
