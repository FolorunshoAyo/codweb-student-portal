<?php
session_start();
require(dirname(__DIR__)."/call.php");

class Auth
{
    /**
     * Authentication for pages outside the user folder
     */
    static function Route()
    {
        if (isset($_SESSION['user_id'])) {      
            if($_SESSION['reg_status'] === "0"){
                header("Location: ".$_ENV['URL']. "make-form-payment"); 
            }elseif($_SESSION['reg_status'] === "1"){
                header("Location: ".$_ENV['URL']. "application-form"); 
            }elseif($_SESSION['reg_status'] === "2"){
                header("Location: ".$_ENV['URL']. "select-course");
            }elseif($_SESSION['reg_status'] === "3"){
                header("Location: " . $_ENV['URL'] . "course-payment");
            }else{
                header("Location: ".$_ENV['URL']. "dashboard/");
            }
        }else {
            //Don't Redirect
        }
    }

    /**
     * Authentication for pages inside the user folder
     * */
    static function  User()
    {
        if (isset($_SESSION['user_id'])) {
            // Don't redirect
        }else {
            header("Location: ".$_ENV['URL']);
        }
    }
}
?>