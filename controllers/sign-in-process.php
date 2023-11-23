<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::Route("student/");

if (isset($_POST['submit'])) { 
	$username = filter_var($db->real_escape_string($_POST['username']), FILTER_SANITIZE_STRING);
	$password = filter_var($db->real_escape_string($_POST['pwd']), FILTER_SANITIZE_STRING);

	if (empty($username) || empty($password)) {
		echo json_encode(array('success' => 0, 'error_title' => "Both fields are required"));
	}else {
		$sql = $db->query("SELECT * FROM users WHERE username='{$username}'");
		if ($sql->num_rows == 1) {
			$row = $sql->fetch_assoc();
			$passcode = $row['passkey'];
			if (password_verify($password, $passcode)) {
			// if ($password === $passcode) {
				if($row['reg_status'] == '0') {
					//this user had not paid for the application form
					//sent to payment gateway to pay for application form
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['reg_status'] = "0";
					echo json_encode(array('success' => 1, 'redirect' => 'make_payment'));
				}elseif ($row['reg_status'] == '1') {
					//this user has made payment for the application form but has not filled the form.
					//redirect user to the application form
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['reg_status'] = "1";
					echo json_encode(array('success' => 1, 'redirect' => 'application_form'));			
				}elseif ($row['reg_status'] == '2') {
					//this person has filled  the application form but has not selected any course of study
					//redirect to select course page
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['reg_status'] = "2";
					echo json_encode(array('success' => 1, "redirect" => "select_course"));
				}else{
					//this user has selected a course of study and has made payments.
					$user_id = $row['user_id'];
					$_SESSION['user_id'] = $user_id;

					// CHECKING FOR OUTSTANDING FEES
					$sql_get_student_details = $db->query("SELECT * FROM students WHERE user_id={$user_id}");
					$sql_check_unpaid_course = $db->query("SELECT * FROM course_lookup INNER JOIN courses ON course_lookup.course_id=courses.course_id WHERE course_lookup.user_id ={$user_id} AND course_lookup.fully_paid=0 ORDER BY id DESC LIMIT 1");
					$outstanding_course_details = $sql_check_unpaid_course->fetch_assoc();

					if($sql_check_unpaid_course->num_rows === 1){
						if($outstanding_course_details['installment'] === "1"){
							$sql_get_last_recorded_payment = $db->query("SELECT * FROM course_payments WHERE user_id={$user_id} ORDER BY payment_id DESC LIMIT 1");

							if($sql_get_last_recorded_payment->num_rows === 1){
								$last_payment_details = $sql_get_last_recorded_payment->fetch_assoc();
								if($last_payment_details['months_paid'] === $outstanding_course_details['duration_in_months']){
									$_SESSION['user_id'] = $user_id;
									echo json_encode(array('success' => 1, "redirect" => "student_dashboard"));
								}else{
									$due_time = strtotime($last_payment_details['paid_at'] . "+ 1 month");
									$today = strtotime("now");

									// CHECKING IF USER PAYMENT IS PAST DUE
									if($today >= $due_time){
										$_SESSION['reg_status'] = "3";
										echo json_encode(array("success" => 0, "error_title" => "Due Payment", "error_message" => "Your payment is due for the month. Pay now to access dashboard", "redirect" => "course-payment"));
									}else{
										echo json_encode(array('success' => 1, "redirect" => "student_dashboard"));
									}
								}
							}else{
								$_SESSION['reg_status'] = "3";
								echo json_encode(array("success" => 0, "error_title" => "Make course payment", "error_message" => "You need to make payment before you can access dashboard", "redirect" => "course-payment"));
							}
						}else{
							$_SESSION['reg_status'] = "3";
							echo json_encode(array("success" => 0, "error_title" => "Make course payment", "error_message" => "You need to make payment before you can access dashboard", "redirect" => "course-payment"));	
						}
					}else{
						echo json_encode(array('success' => 1, "redirect" => "student_dashboard"));
					}
				}
                
			}else {
				//Error incorrect password
				echo json_encode(array('success' => 0, "error_title" => "Sign in Error", "error_message" => "Incorrect password, please try again."));
			}
		}else {
			//Error incorrect credentials
			echo json_encode(array('success' => 0, "error_title" => "Sign in Error", "error_message" => "Incorrect details, please try again."));
		}
	}
// }
}else {
	//Error if not isset
	echo json_encode(array('success' => 0, "error_title" => "Fatal", "error_message" => "Unable to process form inputs"));
}
?>