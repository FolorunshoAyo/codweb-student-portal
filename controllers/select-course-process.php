<?php
    require(dirname(__DIR__) . '/auth-library/resources.php');

    if (isset($_POST['submit'])) {
        $user_id = $_SESSION['user_id'];
        $selected_course_id = filter_var($db->real_escape_string($_POST['selected-course']), 513);
        $payment_plan = filter_var($db->real_escape_string($_POST['payment-plan']), 513);

        if($payment_plan === "1"){
            // ONE TIME PAYMENT PROCCESS
            $sql_add_course = $db->query("INSERT INTO course_lookup(user_id, course_id, fully_paid, installment) VALUES({$user_id}, {$selected_course_id}, '0', '0')");
            $db->query("UPDATE users SET reg_status = '3' WHERE user_id = {$user_id}");

            $_SESSION['reg_status'] = "3";
            echo json_encode(array("success" => 1, "message"=>"Course saved successfully. Proceeding to payment"));
        }else{
            // INSTALLMENTAL PAYMENT PROCESS
            $_SESSION['reg_status'] = "3";
            $sql_add_course = $db->query("INSERT INTO course_lookup(user_id, course_id, fully_paid, installment) VALUES({$user_id}, {$selected_course_id}, '0', '1')");

            echo json_encode(array("success" => 1, "message"=>"Course saved successfully. Proceeding to payment"));
        }
    }else{
        echo json_encode(array("success" => 0, "error_title" => "fatal", "error_message" => "Unable to process selections"));
    }
?>