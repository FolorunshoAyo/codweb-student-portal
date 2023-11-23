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
		$sql_update_form_payment = $db->query("UPDATE users SET reg_status = '1' WHERE user_id ={$user_id}");

		$receipt_props = array();

		$sql_get_student_details = $db->query("SELECT * FROM users WHERE user_id = {$user_id}");

		$student_details = $sql_get_student_details->fetch_assoc();

		$receipt_props['name'] = $student_details['last_name'] . " " . $student_details['first_name'];
		$receipt_props['email'] = $student_details['email'];
		$receipt_props['phone'] = $student_details['phone_no'];

		$receipt_props['amount_paid'] = $api_amount;
		$receipt_props['transaction_date'] = date("Y-m-d h:i:s");
		$receipt_props['receipt_code'] = substr($student_details['last_name'],0,1) . substr($student_details['first_name'],0,1) . "_" . time();

		$receipt_props['application_form'] = "";
		
		$receipt = generateReceipt($receipt_props);

		// INSERT INTO APPLICATION FORM PAYMENTS
		$sql_insert_application_form_payments = $db->query("INSERT INTO application_form_payments (user_id,receipt) VALUES ({$user_id},'$receipt')");

		if ($sql_update_form_payment) {
			$_SESSION['reg_status'] = "1";	
			$_SESSION['receipt'] = $receipt;
				
			header("location: ../payment-success");
		}
		else {
			header("location: ../error");
		}
	}else {
		header("location: ../error");
	}

	curl_close($curl);
}
else {
	header("location: ../");
}
?>