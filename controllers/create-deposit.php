<?php
    require(dirname(__DIR__) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $user_id = $_SESSION['user_id'];
        $transaction_ref = $_POST['tx_ref'];
        $amount = $_POST['amount'];

        $deposit_for = "1";

        $sql_deposit = $db->prepare("INSERT INTO deposits(transaction_ref, user_id, deposit_amount, deposit_for) VALUES(?,?,?,?)");
        $sql_deposit->bind_param("siis", $transaction_ref, $user_id, $amount, $deposit_for);

        if($sql_deposit->execute()){
            echo json_encode(array("success" => 1, "amount_charged" => $amount, "tx_ref" => $transaction_ref));
        }else{
            //CONSOLE LOG A RESPONSE
            echo json_encode(array("success" => 0, "error_message" => "Unable to insert deposits values to database"));
        }
    }
?>