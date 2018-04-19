<?php

class User {
	public $firstName = '';
	public $lastName = '';
	public $loginID = '';
	public $userID = 0;
	public $hashedPassword = '';
	public $PermissionID ='';
	
	public function load($loginID, $mysqli) {
		$this->clear();
	
		if (! $mysqli) {
			return false;
		}
		
		$loginIDEscaped = $mysqli->real_escape_string($loginID);
	
		$sql = "SELECT * FROM users WHERE loginID = '$loginIDEscaped'";
		
		if ($result = $mysqli->query($sql)) {
			if ($result->num_rows > 0) {
				$user = $result->fetch_assoc();
				$this->firstName = $user['First_Name'];
				$this->studentid = $user['studentId'];
				$this->lastName = $user['Last_Name'];
				$this->loginID = $user['loginID'];
				$this->userID = $user['id'];
				$this->hashedPassword = $user['Password'];
				$this->Email = $user['Email'];
				$this->Street_Address= $user['Street_Address'];
				$this->City = $user['City'];
				$this->State = $user['State'];
				$this->Zipcode = $user['Zipcode'];
				$this->county = $user['county'];
				$this->PermissionID = $user['PermissionID'];
							
			}
			$result->close();
			return true;
		} else {
			return false;
		}
	}
	
	private function clear() {
		$firstName = '';
		$lastName = '';
		$loginID = '';
		$userID = 0;
		$hashedPassword = '';
	}
}

?>