<center>
</br>
<?php
if(isset($_SESSION['lastSuggestion']))
{
echo "Your last suggestion was ".$_SESSION['lastSuggestion'].'.';
	echo '</br>';
	echo 'Feel free to make another one!';
}
else
{
	echo 'Themes for each game jam are chosen by the community.';
	echo '</br>';

	echo 'Please enter a suggestion:';
}
?>
</br>
</br>
<form action="themesubmit.php" method="post">
<input type="text" name="suggestion"><br>
<input type="submit" value="Send">
</form>

</center>