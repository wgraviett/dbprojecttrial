<?php
	class TasksViews {
		private $stylesheet = 'taskmanager.css';
		private $pageTitle = 'Tasks';
		
		public function __construct() {
		}
		
		public function __destruct() {
		}
		
		public function taskListView($user, $tasks, /*$orderBy = 'title', $orderDirection = 'asc',*/ $message = '') {
			//$body = "<h1>Applications for {$user->firstName} {$user->lastName}</h1>\n";
			
			if (strcmp($user ->PermissionID, 'student') == 0){ //student
				$body = "<h1>Applications for {$user->firstName} {$user->lastName} </h1>\n";
				$body .= "<p><a class='taskButton' href='index.php?view=taskform'>+ Add Application</a> <a class='taskButton' href='index.php?logout=1'>Logout</a></p>\n";
				if ($message) {
					$body .= "<p class='message'>$message</p>\n";
				}
			//TEST
				//$body .= "<p><a class='taskButton' href='index.php?view=taskform'>+ Add Application</a> <a class='taskButton' href='index.php?logout=1'>Logout</a></p>\n";
		
				if (count($tasks) < 1) {
					$body .= "<p>No Applications to display!</p>\n";
					return $this->page($body);
				}
		
			if ($message) {
				$body .= "<p class='message'>$message</p>\n";
			}
		
			
	
			if (count($tasks) < 1) {
				$body .= "<p>No Applications to display!</p>\n";
				return $this->page($body);
			}
	
			$body .= "<table>\n";
			$body .= "<tr><th>Delete</th><th>Edit</th><th>View</th>";
		
			$columns = array(array('name' => 'id', 'label' => 'Application ID'),
			array('name' => 'First_Name', 'label' => 'First Name'),
							array('name' => 'Last_Name', 'label' => 'Last Name'),
							array('name' => 'StudentID', 'label' => 'StudentID'), 
							 array('name' => 'application_status', 'label' => 'Application Status'), 
							 array('name' => 'ProgramID', 'label' => 'ProgramID'));
		
			// geometric shapes in unicode
			// http://jrgraphix.net/r/Unicode/25A0-25FF
			foreach ($columns as $column) {
				$name = $column['name'];
				$label = $column['label'];
				if ($name == $orderBy) {
					if ($orderDirection == 'asc') {
						$label .= " &#x25BC;";  // ▼
					} else {
						$label .= " &#x25B2;";  // ▲
					}
				}
				$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
			}
	
			foreach ($tasks as $task) {
				$id = $task['id'];
				$application_status = $task['application_status'];
				$ProgramID = $task['ProgramID'];
				$First_Name= $task['First_Name'];
				$Last_Name = $task['Last_Name'];
				$StudentID = $task['StudentID'];
			
				$body .= "<tr>";
				$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
				$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='edit' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
				$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='view' /><input type='hidden' name='id' value='$id' /><input type='submit' value='View'></form></td>";
				//$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='approve' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Approve'></form></td>";
			//	$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='deny' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Deny'></form></td>";			
				$body .= "<td>$id</td><td>$First_Name</td><td>$Last_Name</td><td>$StudentID</td><td>$application_status</td><td>$ProgramID</td>";
				$body .= "</tr>\n";
			}
			$body .= "</table>\n";
			}
			else {//admin or advisor
				$body = "<h1>All Applications </h1>\n";
				if ($message) {
					$body .= "<p class='message'>$message</p>\n";
				}
			
				$body .= "<p><a class='taskButton' href='index.php?view=taskform'>+ Add Application</a> <a class='taskButton' href='index.php?logout=1'>Logout</a></p>\n";
		
				if (count($tasks) < 1) {
					$body .= "<p>No Applications to display!</p>\n";
					return $this->page($body);
				}
		
				$body .= "<table>\n";
				$body .= "<tr><th>delete</th><th>View</th><th>Approve</th><th>Deny</th>";
			
				$columns = array(array('name' => 'id', 'label' => 'Application ID'),
				array('name' => 'First_Name', 'label' => 'First Name'),
								array('name' => 'Last_Name', 'label' => 'Last Name'),
								array('name' => 'StudentID', 'label' => 'StudentID'), 
								 array('name' => 'application_status', 'label' => 'Application Status'), 
								 array('name' => 'ProgramID', 'label' => 'ProgramID'));
			
				// geometric shapes in unicode
				// http://jrgraphix.net/r/Unicode/25A0-25FF
				foreach ($columns as $column) {
					$name = $column['name'];
					$label = $column['label'];
					if ($name == $orderBy) {
						if ($orderDirection == 'asc') {
							$label .= " &#x25BC;";  // ▼
						} else {
							$label .= " &#x25B2;";  // ▲
						}
					}
					$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
				}
		
				foreach ($tasks as $task) {
					$id = $task['id'];
					$application_status = $task['application_status'];
					$ProgramID = $task['ProgramID'];
					$First_Name= $task['First_Name'];
					$Last_Name = $task['Last_Name'];
					$StudentID = $task['StudentID'];
				
					$body .= "<tr>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
					
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='view' /><input type='hidden' name='id' value='$id' /><input type='submit' value='View'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='approve' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Approve'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='deny' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Deny'></form></td>";			
					$body .= "<td>$id</td><td>$First_Name</td><td>$Last_Name</td><td>$StudentID</td><td>$application_status</td><td>$ProgramID</td>";
					$body .= "</tr>\n";
				}
				$body .= "</table>\n";
			}
			return $this->page($body);
		}
		
		public function taskFormView($user, $data = null, $message = '') {//EDIT
			$FirstName = '';
			$LastName ='';
			$StudentID='';
			$Program='';
			$Answer_1='';
		$Program_Selected = array('0' => '','1' => '', '2' => '', '3' => '', '4' => '');
			
			if ($user){
				$FirstName = $user->firstName;
				$LastName = $user->lastName;
				$StudentID = ($user->studentid);
				//add more fields here to autofill more in the application.
			} 
			
			
			
					if ($data){
						//echo "in if";
				$Program=$data['ProgramID'] ? $data['ProgramID'] : 'Uncategorized';
				$FirstName = $data['First_Name'];
				$LastName = $data['Last_Name'];
				$StudentID= $data['studentID'];
				$Address = $data['Street_Address'];
				$City = $data['City'];
				$State = $data ['State'];
				$Zip = $data ['Zipcode'];
				$county = $data ['county'];
		
				$Program_Selected[$Program] = 'selected'; //check this 
				$Answer_1 = $data['application_question_1'];
			} else {
				$Program_Selected['uncategorized'] = 'selected';
			}
	
			$body = "<h1>Applications for  {$user->firstName} {$user->lastName}</h1>\n";
			if ($message) {
				$body .= "<p class='message'>$message</p>\n";
			}
		
			$body .= "<form action='index.php' method='post'>";
		
			if ($data['id']) {
				$body .= "<input type='hidden' name='action' value='update' />";
				$body .= "<input type='hidden' name='id' value='{$data['id']}' />";
			} else {
				$body .= "<input type='hidden' name='action' value='add' />";
			}
		
		$PermissionID = $user ->PermissionID;
			
		$body .= <<<EOT2
 <p>Please fill out the form below<br />
<p>Student ID</>
<input type = "number" name="StudentID" value="$StudentID" placeholder ="########" maxlength ="8" size="80"></p> 
 <p> Full Legal Name<br />
<label for=LastName>Last Name</label>
  <input type="text" name="LastName" value="$LastName" placeholder="Last Name" maxlength="255" size="20"></p>
<label for=FirstName>First Name</label>
  <input type="text" name="FirstName" value="$FirstName" placeholder="First Name" maxlength="255" size="20"></p>
  <label for=address>Street Address</label>
  <input type="text" name="address" value="$Address" placeholder="Street Address" maxlength="255" size="20"></p>
  <label for=city>City</label>
  <input type="text" name="city" value="$City" placeholder="City" maxlength="255" size="20"></p>
  <label for=state>State</label>
  <input type="text" name="state" value="$State" placeholder="State" maxlength="255" size="20"></p>
  <label for=zip>Zipcode</label>
  <input type="text" name="zip" value="$Zip" placeholder="Zipcode" maxlength="255" size="20"></p>
  <label for=county>County</label>
  <input type="text" name="county" value="$county" placeholder="County" maxlength="255" size="20"></p>
  
<label for=program>Select Program</label>
  <select name="Program">
  	  <option value="0" $Program_Selected[0]>Uncategorized</option>
	  <option value="1" $Program_Selected[1]>MSN - Adult Gerontology NP</option>
	  <option value="2" $Program_Selected[2]>MSN - Family Nurse Practitioner</option>
	  <option value="3" $Program_Selected[3]>MSN - Pediatric Nurse Practitioner</option>
	  <option value="4" $Program_Selected[4]>MSN - Psychiatric Mental Health Nurse Practitioner</option>
  </select>
</p>
  <label for=Answer_1>What was your favorite undergraduate nursing course?  </label>
  </br>
  <textarea name="Answer_1" rows="6" cols="80" placeholder="">$Answer_1</textarea></p>
  <input type="submit" value="Submit"><input type="submit" name='cancel' value="Cancel">
</form>
EOT2;
	
			
			return $this->page($body);
		}
		public function taskView($user, $data = null, $message = '') {
			$FirstName = '';
			$LastName ='';
			$StudentID='';
			$Program='';
			$Answer_1='';
			$Address = '';
			//echo $Address;
			$City = '';
			$State = '';
			$Zip = '';
			$County = '';
			
		$Program_Selected = array('0' => '','1' => '', '2' => '', '3' => '', '4' => '');
			
			
			
					if ($data){
				$Program=$data['ProgramID'] ? $data['ProgramID'] : 'Uncategorized';
				$FirstName = $data['First_Name'];
				$LastName = $data['Last_Name'];
				
				$Address = $data['Street_Address'];
				//echo $Address;
				//echo FirstName;
				//$Address = "5065 Kennelwood Dr.";
				$City = $data['City'];
				$State = $data['State'];
				$Zip = $data['Zipcode'];
				$County = $data['county'];
				
				$StudentID= $data['studentID'];
				$Program_Selected[$Program] = 'selected'; //check this 
				$Answer_1 = $data['application_question_1'];
			} else {
				$Program_Selected['uncategorized'] = 'selected';
			}
	
			$body = "<h1>Applications for {$FirstName} {$LastName}</h1>\n";
			if ($message) {
				$body .= "<p class='message'>$message</p>\n";
			}
		
			$body .= "<form action='index.php' method='post'>";
		
			if ($data['id']) {
				//$body .= "<input type='hidden' name='action' value='update' />";
				$body .= "<input type='hidden' name='id' value='{$data['id']}' />";
			} else {
				$body .= "<input type='hidden' name='action' value='add' readonly = 'readonly' />";
			}
		
			$body .= <<<EOT2
 <p>Please fill out the form below<br />
<p>Student ID</>
<input type = "number" name="StudentID" value="$StudentID" placeholder ="########" maxlength ="8" size="80" readonly = "readonly"></p>
 <p> Full Legal Name<br />
<label for=LastName>Last Name</label>
  <input type="text" name="LastName" value="$LastName" placeholder="Last Name" maxlength="255" size="20" readonly = "readonly"></p>
<label for=FirstName>First Name</label>
  <input type="text" name="FirstName" value="$FirstName" placeholder="First Name" maxlength="255" size="20" readonly = "readonly"></p>
<label for=Address>Street Address</label>
  <input type="text" name="Address" value="$Address" placeholder="Street Address" maxlength="255" size="20" readonly = "readonly"></p>
<label for=City>City</label>
  <input type="text" name="city" value="$City" placeholder="City" maxlength="255" size="20" readonly = "readonly"></p>
<label for=State>State</label>
  <input type="text" name="State" value="$State" placeholder="State" maxlength="255" size="20" readonly = "readonly"></p>
<label for=Zip>Zipcode</label>
  <input type="text" name="Zip" value="$Zip" placeholder="Zipcode" maxlength="255" size="20" readonly = "readonly"></p>
<label for=county>County</label>
  <input type="text" name="county" value="$county" placeholder="County" maxlength="255" size="20" readonly = "readonly"></p>
  <select name="Program" disabled = "true">
  	  <option value="0">Uncategorized</option>
	  <option value="1">MSN - Adult Gerontology NP</option>
	  <option value="2">MSN - Family Nurse Practitioner</option>
	  <option value="3">MSN - Pediatric Nurse Practitioner</option>
	  <option value="4" selected>MSN - Psychiatric Mental Health Nurse Practitioner</option>
  </select>
</p>
  <label for=Answer_1>What was your favorite undergraduate nursing course?  </label>
  </br>
  <textarea name="Answer_1" rows="6" cols="80" placeholder="" readonly = "readonly">$Answer_1</textarea></p>
  <input type = "submit" name = 'Cancel' value = "Return">
</form>
EOT2;
			return $this->page($body);
		}
		
		public function userformView ($data = null, $message = '') {
			$body = "<h1>Create User </h1>\n";
			if ($message) {
				$body .= "<p class='message'>$message</p>\n";
			}
			$body .= <<<EOT4
		<form action="index.php" method="post">
				<input type='hidden' name='action' value='createuser' />
				
				<label for=FirstName>First Name</label>
				  <input type="text" name="FirstName" value="" placeholder="First Name" maxlength="255" size="20"></p>
				 
				 <label for=LastName>Last Name</label>
				  <input type="text" name="LastName" value="" placeholder="Last Name" maxlength="255" size="20"></p>
				 
				  <label for=logind>Username</label>
				  <input type="text" name="loginid" value="" placeholder="" maxlength="255" size="20"></p>
				 
				  <label for=Password>Password</label>
				  <input type="password" name="Password" value="" placeholder="" maxlength="255" size="20"></p>
				 
				  <label for=Email>Email</label>
				  <input type="text" name="Email" value="" placeholder="" maxlength="255" size="20"></p>
				   
				  <label for=studentid>StudentID</label>
				  <input type="number" name="studentid" value="" placeholder="" maxlength="255" size="20"></p>
				 
				 
				 <label for=Address>Address</label>
				  <input type="text" name="Address" value="" placeholder="Address" maxlength="255" size="20"></p>
				 
				 <label for=city>City</label>
				  <input type="text" name="City" value="" placeholder="" maxlength="255" size="20"></p>
				  <label for=State>State</label>
				  <input type="text" name="State" value="" placeholder="" maxlength="255" size="20"></p>
				<label for=Zipcode>Zipcode</label>
				  <input type="number" name="Zipcode" value="" placeholder="Zipcode" maxlength="255" size="20"></p>
					
				<label for=county>County</label>
				  <input type="text" name="county" value="" placeholder="" maxlength="255" size="20"></p>
				   
				  <input type="submit" name ='submit' value="Create user">
			</form>	
EOT4;
			
			return $this->page($body);
			
		}
	
		public function loginFormView($data = null, $message = '') {
			$loginID = '';
			if ($data) {
				$loginID = $data['loginid'];
			}
		
			$body = "<h1>Tasks</h1>\n";
			
			if ($message) {
				$body .= "<p class='message'>$message</p>\n";
			}
			
			$body .= <<<EOT
	<!--	<p><a class='taskButton' href='index.php?view=userform'>+ Create User</a> </p>\n -->
			<p><a class='taskButton' href='userform.html'>+ Create User</a> </p>\n
		<form action='index.php' method='post'>
<input type='hidden' name='action' value='login' />
<p>User ID<br />
  <input type="text" name="loginid" value="$loginID" placeholder="login id" maxlength="255" size="80"></p>
<p>Password<br />
  <input type="password" name="password" value="" placeholder="password" maxlength="255" size="80"></p>
  <input type="submit" name='submit' value="Login">
 	
</form>	
EOT;
			
			return $this->page($body);
		}
		
		public function errorView($message) {	
			$body = "<h1>Tasks</h1>\n";
			$body .= "<p>$message</p>\n";
			
			return $this->page($body);
		}
		
		private function page($body) {
			$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>{$this->pageTitle}</title>
<link rel="stylesheet" type="text/css" href="{$this->stylesheet}">
</head>
<body>
$body
<p></p>
</body>
</html>
EOT;
			return $html;
		}
}