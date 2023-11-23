<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::User("");

if (isset($_POST['submit'])) {
	// CLEAN AND GATHER PERSONAL INFORMATION
	$user_id = $_SESSION['user_id'];
	$sex = filter_var($db->real_escape_string($_POST['sex']), 513);
	$dob = filter_var($db->real_escape_string($_POST['dob']), 513);
	$address = filter_var($db->real_escape_string($_POST['address']), 513);
	$city = filter_var($db->real_escape_string($_POST['city']), 513);
	$state = filter_var($db->real_escape_string($_POST['state']), 513);
	$country = filter_var($db->real_escape_string($_POST['country']), 513);
	$applicant_leads = $_POST['leads'];

	// CLEAN AND GATHER GUARDIAN INFORMATION
	$gfname = filter_var($db->real_escape_string($_POST['gfname']), 513);
	$glname = filter_var($db->real_escape_string($_POST['glname']), 513);
	$gpnum = filter_var($db->real_escape_string($_POST['gpnum']), 513);
	$goccupation = filter_var($db->real_escape_string($_POST['goccupation']), 513);
	$grelationship = filter_var($db->real_escape_string($_POST['grelationship']), 513);
	$gemail = filter_var($db->real_escape_string($_POST['gemail']), 513);
	$gaddress = filter_var($db->real_escape_string($_POST['gaddress']), 513);
	$gcity = filter_var($db->real_escape_string($_POST['gcity']), 513);
	$gstate = filter_var($db->real_escape_string($_POST['gstate']), 513);
	$gcountry = filter_var($db->real_escape_string($_POST['gcountry']), 513);
	
	$leads = "";

	// CHECK FOR RETRIEVED LEADS
	if(!empty($applicant_leads)){
		$count = 1;
		// Loop to store and display values of individual checked checkbox.
		foreach($applicant_leads as $selected){
			if(count($applicant_leads) === $count){
				$leads .= $selected;
			}else{
				$leads .= $selected . ", ";
			}

			$count++;
		}
	}

	//Check if all fields are empty
	if (empty($sex) || empty($dob) || empty($address) || empty($city) || empty($state) || empty($country) || empty($gfname) || empty($glname) || empty($gpnum) || empty($goccupation) || empty($grelationship) || empty($gemail) || empty($gaddress) || empty($gcity) || empty($gstate) || empty($gcountry)) {
		echo json_encode(array('success' => 0, 'error_title' => "Form error", 'error_message' => "All fields are required"));
		exit();
	} else {
		$sql_insert_student = $db->prepare("INSERT INTO students(user_id, sex, date_of_birth, address, city, state, country, leads) VALUES(?,?,?,?,?,?,?,?)");
		$sql_insert_student->bind_param("isssssss", $user_id, $sex, $dob, $address, $city, $state, $country, $leads);

		if ($sql_insert_student->execute()) {
			$student_id = $db->insert_id;
			$sql_insert_guardian = $db->prepare("INSERT INTO guardians(student_id, first_name, last_name, phone_no, email, occupation, relationship, address, city, state, country) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
			$sql_insert_guardian->bind_param("issssssssss", $student_id, $gfname, $glname, $gpnum, $gemail, $goccupation, $grelationship, $gaddress, $gcity, $gstate, $gcountry);

			if($sql_insert_guardian->execute()){
				// UPDATE USER STATUS
				$db->query("UPDATE users SET reg_status = '2' WHERE user_id = {$user_id}");
				$_SESSION['reg_status'] = "2";
				echo json_encode(array('success' => 1));
			}
		}
	}
} else {
	echo json_encode(array('success' => 0, 'error_title' => "Fatal", 'error_message' => "Unable to register user"));
}
?>