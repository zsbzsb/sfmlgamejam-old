<center>
SFML Game Jam 
<?php
if ($page == "index")
{
	echo '<a href="/submissions.php">Submissions</a> <a href="/themes.php">Themes</a> <a href="/rules.php">Info & Rules</a>';
}
if($page == "submissions")
{
	echo '<a href="/index.php">Home</a> <a href="/themes.php">Themes</a> <a href="/rules.php">Info & Rules</a>';
}
if ($page == "themes")
{
	echo '<a href="/index.php">Home</a> <a href="/submissions.php">Submissions</a> <a href="/rules.php">Info & Rules</a>';
}
if ($page == "rules")
{
	echo '<a href="/index.php">Home</a> <a href="/submissions.php">Submissions</a> <a href="/themes.php">Themes</a>';
}
?>
</br>
<center>
<script type="application/javascript">
var endTime = new Date(Date.UTC(2014,00,31,15));

document.write("<h2>The Jam starts " + endTime + "</h2>");


var myCountdown1 = new Countdown({
								 	
									month:endTime.getMonth() + 1, 
									day:endTime.getDate(),
                                                                        hour:endTime.getHours(),
									width:300, 
									height:60,  
									rangeHi:"day",
									style:"flip"	// <- no comma on last item!
									});




</script>
</br>
</center>