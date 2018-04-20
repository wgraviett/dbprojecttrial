<?php
	require ('db_credentials.php');
	require ('web_utils.php');
	
	$stylesheet = 'taskmanager.css';
	
			$FirstName = $_POST['FirstName'];
			$LastName = $_POST['LastName'];
			$loginid = $_POST['loginid'];
			$Password = $_POST['Password'];
			$Email = $_POST['Email'];
			$StudentID = $_POST['studentid'];
			$Address = $_POST['Address'];
			$City = $_POST['City'];
			$State = $_POST['State'];
			$Zipcode = $_POST['Zipcode'];
			$County = $_POST['county'];
	
	
	// Create connection
	$mysqli = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($mysqli->connect_error) {
		print generatePageHTML("Tasks (Error)", generateErrorPageHTML($mysqli->connect_error), $stylesheet);
		exit;
	}
			
			$FirstNameEscaped = $mysqli->real_escape_string($FirstName);
			$LastNameEscaped = $mysqli->real_escape_string($LastName);
			$loginidEscaped = $mysqli->real_escape_string($loginid);
		$PasswordEscaped = $mysqli->real_escape_string($Password);			
		$EmailEscaped = $mysqli->real_escape_string($Email);		
		$StudentIDEscaped = $mysqli->real_escape_string($StudentID);
		$AddressEscaped = $mysqli->real_escape_string($Address);
		$CityEscaped = $mysqli->real_escape_string($City);
		$StateEscaped = $mysqli->real_escape_string($State);
		$ZipcodeEscaped = $mysqli->real_escape_string($Zipcode);		
		$CountyEscaped = $mysqli->real_escape_string($County);
	
	$PasswordEscaped=password_hash($PasswordEscaped, PASSWORD_DEFAULT); // This is not protecting against SQL injection 
			$sql = "INSERT INTO users (First_Name, Last_Name, Email, studentId, Password, Street_Address, City, State, Zipcode, county, loginID)
			VALUES ('$FirstNameEscaped', '$LastNameEscaped', '$EmailEscaped', '$StudentIDEscaped','$PasswordEscaped','$AddressEscaped','$CityEscaped','$StateEscaped','$ZipcodeEscaped','$CountyEscaped', '$loginidEscaped')";
	
	$result = $mysqli->query($sql);
	if ($result) {
		// insert successfull, redirect browser to index.php to see list of tasks
		redirect("index.php");
	} else {
		print generatePageHTML("Tasks (Error)", generateErrorPageHTML($mysqli->error . " using SQL: $sql"), $stylesheet);
		exit;
	}
	
	
	function generateErrorPageHTML($error) {
	$html = <<<EOT
<h1>Applications</h1>
<p>An error occurred: $error</p>
<p><a class='taskButton' href='index.php'>Login</a></p>
EOT;

	return $html;
	}
?>