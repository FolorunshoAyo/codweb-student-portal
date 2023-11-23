<?php 
    require(__DIR__.'/auth-library/resources.php');
    Auth::User();
    $url = strval($url);

    autoRedirect("course-payment");

    $user_id = $_SESSION['user_id'];

    $sql_get_user_details = $db->query("SELECT * FROM users WHERE user_id={$user_id}");

    if($sql_get_user_details->num_rows){
        $user_details = $sql_get_user_details->fetch_assoc();
    }else{
        header("location: ./");
    }

    if(isset($_SESSION['months_paid']) && isset($_SESSION['is_installment']) && isset($_SESSION['course_duration']) && isset($_SESSION['course_id'])){
        unset( $_SESSION['months_paid'],  $_SESSION['is_installment'], $_SESSION['course_duration'], $_SESSION['course_id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="icon" href="assets/images/logo.jpg">
    <!-- Bootstrap 5 stylesheet-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> -->
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- initial config css file -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Codeweb Form -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- Codeweb Preloader  -->
    <link rel="stylesheet" href="assets/css/student/preloader.css">
    <!-- ENROLL STYLESHEET  -->
    <link rel="stylesheet" href="assets/css/form.css" type="text/css">
    <!-- STUDENT HEADER STYLESHEET -->
    <link rel="stylesheet" href="assets/css/student/sections/header.css" type="text/css">
    <!-- FOOTER STYLESHEET -->
    <link rel="stylesheet" href="assets/css/sections/footer.css" type="text/css">
    <!-- HOME STYLESHEET -->
    <link rel="stylesheet" href="assets/css/home.css" type="text/css">
    <!-- make payment css -->
    <link rel="stylesheet" href="assets/css/student/make-payment.css" type="text/css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Course Payment - Codeweb Student</title>
</head>

<body>
    <div class="preloader-wrapper loaded">
        <div class="loader">
            C
        </div>
    </div>
    <header class="make-payment-header">
        <div class="person-container">
        <span class="first-name-initial"><?= substr($user_details['username'],0,1)?></span>
            <?php echo ucfirst($user_details['username']) ?>
        </div>
        
        <div class="progress-container hide" style="display: none;">
            <div class="progress progress-1">
                <div class="progress-circle active">
                    1
                </div>
                <span class="progress-text">Buy Application Form</span>
            </div>
            <div class="progress-line progress-line-1 active">
                <div class="progress-thumb"></div>
            </div>
            <div class="progress progress-2">
                <div class="progress-circle">
                    2
                </div>
                <span class="progress-text">Fill application form</span>
            </div>
            <div class="progress-line progress-line-2">
                <div class="progress-thumb"></div>
            </div>
            <div class="progress progress-2">
                <div class="progress-circle">
                    3
                </div>
                <span class="progress-text">Select a course</span>
            </div>
        </div>

        <div class="status-container">
            Status: Applicant
        </div>
    </header>
    <main>
        <section class="make-payment-section">
            <div class="make-payment-container">
                <h1 class="main-title">Course Payment</h1>

                <p class="make-payment-notice">Pay course fee to become a student</p>

                <div class="details">
                    <h2><b>Applicant Details</b></h2>

                    <p>
                        <?php echo $user_details['first_name'] . " " . $user_details['last_name'] ?><br><br>
                        <?php echo $user_details['phone_no'] ?> <br><br>
                        <?php echo $user_details['email'] ?>
                    </p>
                </div>

                <div class="details">
                    <h2><b>Course Information</b></h2>
                    <?php 
                        $sql_get_course_details = $db->query("SELECT * FROM course_lookup INNER JOIN courses ON course_lookup.course_id=courses.course_id WHERE user_id = {$user_id} AND completed=0");
                        $sql_get_last_payment_info = $db->query("SELECT * FROM course_payments WHERE user_id={$user_id} ORDER BY payment_id DESC LIMIT 1");

                        $course_details = $sql_get_course_details->fetch_assoc();
                        $isInstallment = $course_details['installment'];
                        
                    ?>
                    <p>
                        Course-title: <?php echo $course_details['name'] ?> <br><br>
                        Course fee: NGN <?php echo number_format($course_details['course_price'], 2) ?><br><br>
                        Type of payment: <?php echo $isInstallment === "1"? "Monthly Payment" : "One time payment" ?><br><br>
                        <?php
                            $months_paid = "0";
                            if($sql_get_last_payment_info->num_rows === 1){
                                $last_payment_details = $sql_get_last_payment_info->fetch_assoc();
                                $months_paid = $last_payment_details['months_paid'];
                        ?>
                        Month(s) paid: <?php echo $months_paid ?> of <?= $course_details['duration_in_months'] ?> months<br><br>
                        <?php
                            $course_id = $course_details['course_id'];
                            $sql_sum_of_payments = $db->query("SELECT SUM(amount_paid) as total_payments FROM course_payments WHERE user_id={$user_id} AND course_id={$course_id}");
                            $total_payments_for_course = $sql_sum_of_payments->fetch_assoc()['total_payments'];
                        ?>
                        Course fee paid: <?php echo "NGN " . number_format($total_payments_for_course, 2) ?><br><br>
                        Remaining balance: <?php echo "NGN " . number_format((intval($course_details['course_price']) - intval($total_payments_for_course)), 2); ?>
                        <?php
                            }
                        ?>
                    </p>
                </div>

                <div class="order-details course">
                    <div class="order-info">
                        <div class="label">
                            <i class="fa fa-plus"></i>
                            <span>Fee to pay:</span>
                        </div>
                        <?php
                            $fee_to_pay = $isInstallment === "1"? number_format($course_details['course_price'] / $course_details['duration_in_months'], 2) : number_format($course_details['course_price'], 2);
                        ?>
                        <div class="value">
                            <span>NGN <?= $fee_to_pay ?></span>
                        </div>
                    </div>
                    <!-- <div class="handling-info">
                        <div class="label">
                            <i class="fa fa-hand"></i>
                            <span>Handling Fee:</span>
                        </div>
                        <div class="value">
                            <span>NGN 500</span>
                        </div>
                    </div> -->
                    <div class="total">
                        <span><b>Total:</b></span>
                        <span>NGN <?= $fee_to_pay ?></span>
                    </div>
                </div>

                <div class="pay-btn-container">
                    <button>Pay Securely <i class="fa fa-lock"></i></button>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="footer-col3 col-sm-12">
                    <div class="footer-logo-container">
                        <img src="assets/images/logo.jpg" alt="Footer Logo" class="footer-logo">
                    </div>
                </div>
                <div class="footer-col3 col-sm-12">
                    <div class="footer-text">
                        Codeweb Coding Academy is an institution that gives 100% practical classes to students who pursue a
                        Career in any of our available courses. Be job ready with our certified ICT Training.
                        For more enquiries: info@codeweb.org.ng
                    </div>
                </div>
                <div class="footer-col3 col-sm-12">
                    <ul class="social-media-links">
                        <li>
                            <a href="#">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; Copyright Codeweb <?php echo(date("Y"))?>.
        </div>
    </footer>
      <!-- FONT AWESOME JIT SCRIPT-->
      <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- TOASTER PLUGIN -->
    <!-- <script src="auth-library/vendor/dist/sweetalert2.all.min.js"></script> -->
    <!-- JUST VALIDATE LIBRARY -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <!-- Flutterwave script -->
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        function makePayment(x, final_amt) {
            FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-9907ef66591a80edfb5c7ea51208031d-X",
                tx_ref: x,
                amount: Number(final_amt),
                currency: "NGN",
                payment_options: "card, banktransfer, ussd",
                redirect_url: `https://localhost/codeweb-student/controllers/auth-course-payment`,

                customer: {
                    email: "info@codeweb.ng",
                    phone_number: "123456789",
                    name: "CODEWEB",
                },
                customizations: {
                    title: "Form Payment",
                    description: '',
                    logo: "https://codeweb.ng/assets/images/logo.jpg",
                },
            });
        }

        function generateTransaction_ref() {
            var randm = Math.floor((Math.random() * 100000000) + 1);
            var tran = "TRX-";
            return tran + randm;
        }

        $(".pay-btn-container button").on("click", function () {
            // GENERATING TRANSACTION REF:
            const tranx_ref = generateTransaction_ref();
            const btnEl = $(this);
            const formData = new FormData();

            formData.append("submit", true);
            formData.append("tx_ref", tranx_ref);
            formData.append("amount", "<?= $fee_to_pay ?>");
            // formData.append("amount", "2000");
            formData.append("months_paid", "<?=  $months_paid ?>");
            formData.append("is_installment", "<?= $isInstallment ?>");
            formData.append("course_duration", "<?= $course_details['duration_in_months'] ?>");
            formData.append("course_id", "<?= $course_details['course_id'] ?>");

            $.ajax({
                url: 'controllers/initiate-payment.php',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    btnEl.html("loading...");
                    $(".preloader-wrapper").removeClass("loaded");
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.success === 1) {

                        makePayment(tranx_ref, response.amount_charged);

                    } else {
                        // ALERT THE USER UPON FAILED REQUEST/RESPONSE
                        console.error(response.error_message);
                    }
                }
            });
        });

        function sendData(){
            const form = document.getElementById('registeration-form');

            // GATHERING FORM DATA
            const formData = new FormData(form);
            formData.append("submit", true);
            
            //SENDING FORM DATA TO THE SERVER
            $.ajax({
                type: "post",
                url: 'authentication/register.php',
                data: formData,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $(".register-container button").html("Registering...");
                    $(".register-container button").attr("disabled", true);
                },
                success: function (response) {
                setTimeout(() => {
                        if (response.success === 1) {
                            // REDIRECT USER TO THE VERIFICATION PAGE
                            window.location = "authentication/send-code?a=send";

                        } else {
                            $(".register-container button").setAttr("disabled", false);
                            $(".register-container button").html("Register");

                            if(response.error_title === "fatal"){
                                // REFRESH CURRENT PAGE
                                location.reload();
                            }else{
                                // ALERT USER
                                Swal.fire({
                                    title: response.error_title,
                                    icon: "error",
                                    text: response.error_message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });
                            }
                        }
                    }, 1500);
                },
            });
        };

        // function showProgress(noOfPages){
        //     if(noOfPages === 1){
                
        //     }
        // }

        // showProgress(1);
    </script>
</body>

</html>
