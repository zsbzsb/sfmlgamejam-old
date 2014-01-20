<?php
class Submission
{
	var $Name;
	var $DevOne;
	var $DevTwo;
	var $ScreenOne;
	var $ScreenTwo;
	var $ScreenThree;
	var $Windows32Link;
	var $Windows64Link;
	var $Linux32Link;
	var $Linux64Link;
	var $OSXLink;
	
	function Submission($name, $devOne, $devTwo, $screenOne, $screenTwo, $screenThree, $windows32Link, $windows64Link, $linux32Link, $linux64Link, $osxLink)
	{
		$this->Name = $name;
		$this->DevOne = $devOne;
		$this->DevTwo = $devTwo;
		$this->ScreenOne = $screenOne;
		$this->ScreenTwo = $screenTwo;
		$this->ScreenThree = $screenThree;
		$this->Windows32Link = $windows32Link;
		$this->Windows64Link = $windows64Link;
		$this->Linux32Link = $linux32Link;
		$this->Linux64Link = $linux64Link;
		$this->OSXLink = $osxLink;
	}

	public static function fromRow(array $row)
	{
		$instance = new Submission($row['Name'], $row['Dev1'], $row['Dev2'], $row['Screen1'], $row['Screen2'], $row['Screen3'], $row['Win32'], $row['Win64'], $row['Lin32'], $row['Lin64'], $row['OSX']);
		return $instance;
	}
	
	function submitToDataBase($con, $table)
	{
		if(!mysqli_query($con,"INSERT INTO ".$table."(Name, Dev1, Dev2, Screen1, Screen2, Screen3, Win32, Win64, Lin32, Lin64, OSX)
VALUES ('$this->Name', '$this->DevOne','$this->DevTwo', '$this->ScreenOne','$this->ScreenTwo', '$this->ScreenThree', '$this->Windows32Link', '$this->Windows64Link', '$this->Linux32Link', '$this->Linux64Link', '$this->OSXLink')"))
  	{
  		die('Error: ' . mysqli_error($con));
	}

	}
	
	function display()
	{
		echo '<div>';
		echo 'Name: '.$this->Name;
		echo '</div>';
	}
}


?>
