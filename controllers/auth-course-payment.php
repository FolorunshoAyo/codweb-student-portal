<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("");

$user_id = $_SESSION['user_id'];

if (isset($_GET["transaction_id"]) && isset($_GET["status"]) && isset($_GET["tx_ref"])) {
	$trans_id = $_GET['transaction_id'];
	$trans_status = $_GET['status'];
	$trans_ref = $_GET['tx_ref'];

	$url = "https://api.flutterwave.com/v3/transactions/" . $trans_id . "/verify";
	//Create cURL session
	$curl = curl_init($url);
	//Turn off SSL checker
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	//Decide the request that you want
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	//Set the API headers
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		// "Authorization: Bearer FLWSECK-39743e6c4b313849e1a091fb9e47b322-X",
		"Authorization: Bearer FLWSECK_TEST-a2811a821fc0113cb78c03ca07632980-X",
		"Content-Type: Application/json"
	]);
	//Run cURL
	$run = curl_exec($curl);
	//Check for erros
	$error = curl_error($curl);
	if ($error) {
		die("Curl returned some errors: " . $error);
	}
	//echo"<pre>" . $run ."</pre>";
	//Convert to json obj
	$result = json_decode($run);	// 		print_r($result);

	if ($result->data->status == "successful") {
		$status = $result->data->status;
		$api_tranx_ref = $result->data->tx_ref;
		$api_amount = $result->data->amount;
		$api_charged_amount = $result->data->charged_amount;
		
		$sql_update_deposits = $db->query("UPDATE deposits SET deposit_status=1, deposit_amount={$api_amount} WHERE transaction_ref='{$api_tranx_ref}' AND user_id={$user_id}");
		$sql_update_form_payment = $db->query("UPDATE users SET reg_status = '3' WHERE user_id ={$user_id}");
		$_SESSION['reg_status'] = "3";

        $course_id = $_SESSION['course_id'];
        $months_paid = $_SESSION['months_paid'];
        $course_duration = $_SESSION['course_duration'];
        $isInstallment = $_SESSION['is_installment'];
        
        $months_paid = $isInstallment !== "1"? $course_duration : $months_paid + 1;

		$receipt_props = array();

		$sql_get_student_details = $db->query("SELECT * FROM users WHERE user_id = {$user_id}");
		$sql_get_course_details = $db->query("SELECT * FROM courses WHERE course_id = {$course_id}");

		$student_details = $sql_get_student_details->fetch_assoc();
		$course_details = $sql_get_course_details->fetch_assoc();

		$receipt_props['name'] = $student_details['last_name'] . " " . $student_details['first_name'];
		$receipt_props['email'] = $student_details['email'];
		$receipt_props['phone'] = $student_details['phone_no'];
		
		$receipt_props['installment'] = $isInstallment;
		$receipt_props['course_title'] = $course_details['name'];
		$receipt_props['course_fee'] = $course_details['course_price'];

		$receipt_props['amount_paid'] = $api_amount;
		$receipt_props['transaction_date'] = date("Y-m-d h:i:s");
		$receipt_props['receipt_code'] = substr($student_details['last_name'],0,1) . substr($student_details['first_name'],0,1) . "_" . time();

		if($isInstallment === "1"){
			$receipt_props['months_paid'] = $months_paid;
			$receipt_props['remaining_balance'] = $course_details['course_price'] - ($months_paid * ($course_details['course_price'] / $course_details['duration_in_months'])); 
		}

		$receipt = generateReceipt($receipt_props);

        $sql_insert_course_payment = $db->query("INSERT INTO course_payments (user_id, course_id, amount_paid, months_paid, receipt) VALUES ({$user_id},{$course_id},{$api_amount},{$months_paid},'$receipt')");

		// CHECK SUM OF COURSE PAYMENTS
		$sql_checksum_course_payments = $db->query("SELECT SUM(amount_paid) as total_course_payment FROM course_payments WHERE user_id = {$user_id} AND course_id = {$course_id}");

		$sum_of_course_payments = $sql_checksum_course_payments->fetch_assoc();

		// UPDATE DB IF COURSE PAYMENT COMPLETE
		if($sum_of_course_payments['total_course_payment'] === $course_details['course_price']){
			$sql_update_course_payment = $db->query("UPDATE course_lookup SET fully_paid = 1 WHERE user_id = {$user_id} AND course_id = {$course_id}");
		}

		if ($sql_update_form_payment && $sql_insert_course_payment) {
            $_SESSION['months_paid'] = $months_paid;
			$_SESSION['receipt'] = $receipt;

			header("location: ../payment-success");
		} else {
			header("location: ../payment-error");
		}
	}else {
		header("location: ../payment-error");
	}

	curl_close($curl);
}
else {
	header("location: ../");
}
?>