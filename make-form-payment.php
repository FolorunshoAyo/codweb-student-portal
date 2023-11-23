<?php 
    require(__DIR__.'/auth-library/resources.php');
    Auth::User();
    $url = strval($url);

    $user_id = $_SESSION['user_id'];

    $sql_get_user_details = $db->query("SELECT * FROM users WHERE user_id={$user_id}");

    if($sql_get_user_details->num_rows){
        $user_details = $sql_get_user_details->fetch_assoc();
    }else{
        header("location: sign-in");
    }

    autoRedirect("make-form-payment");
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
    <title>Make Form Payment - Codeweb Student</title>
</head>

<body>
    <div class="preloader-wrapper">
        <div class="loader">
            C
        </div>
    </div>
    <header class="make-payment-header">
        <div class="person-container">
            <span class="first-name-initial"><?= substr($user_details['username'],0,1)?></span>
            <?php echo ucfirst($user_details['username']) ?>
        </div>
        
        <div class="progress-container">
            <div class="progress progress-1">
                <div class="progress-circle active">
                    1
                </div>
                <span class="progress-text">Buy Application Form</span>
            </div>
            <div class="progress-line progress-line-1">
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
            Status: Guest
        </div>
    </header>
    <main>
        <section class="make-payment-section">
            <div class="make-payment-container">
                <h1 class="main-title">Make payment</h1>

                <p class="make-payment-notice">Pay form fee to enroll</p>

                <div class="details">
                    <h2><b>User Details</b></h2>

                    <p>
                        Name: <?php echo $user_details['first_name'] . " " . $user_details['last_name'] ?><br><br>
                        Phone No: <?php echo $user_details['phone_no'] ?> <br><br>
                        Email: <?php echo $user_details['email'] ?>
                    </p>
                </div>

                <div class="order-details">
                    <div class="order-info">
                        <div class="label">
                            <i class="fa fa-plus"></i>
                            <span>Form Fee:</span>
                        </div>
                        <div class="value">
                            <span>NGN 1,500</span>
                        </div>
                    </div>
                    <div class="handling-info">
                        <div class="label">
                            <i class="fa fa-hand"></i>
                            <span>Handling Fee:</span>
                        </div>
                        <div class="value">
                            <span>NGN 500</span>
                        </div>
                    </div>
                    <div class="total">
                        <span><b>Total:</b></span>
                        <span>NGN 2,000</span>
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
        function makePayment(transaction_ref, final_amt) {
            const formData = new FormData();

            formData.append("submit", true);
            formData.append("tx_ref", transaction_ref);
            formData.append("amount", final_amt);

            //SENDING FORM DATA TO THE SERVER
            $.ajax({
                type: "post",
                url: 'controllers/create-deposit.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success === 1) {

                        FlutterwaveCheckout({
                            // public_key: "FLWPUBK-8a73c7e27bc482383e107f69056d6c48-X",
                            public_key: "FLWPUBK_TEST-9907ef66591a80edfb5c7ea51208031d-X",
                            tx_ref: response.tx_ref,
                            amount: response.amount_charged,
                            currency: "NGN",
                            payment_options: "card, banktransfer, ussd",
                            redirect_url: `https://localhost/codeweb-student/controllers/auth-form-payment`,

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
                        // ENABLE BUTTON TO TRY REPAYMENT
                        $(".pay-btn-container button").attr("disabled", false);
                    } else {
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
            });
        }

        function generateTransaction_ref() {
            var randm = Math.floor((Math.random() * 100000000) + 1);
            var tran = "TRX-";
            return tran + randm;
        }

        $(".pay-btn-container button").on("click", function () {
            // DISABLE BUTTON TO AVOID MULTIPLE CLICKS.
            $(this).attr("disabled", true);
            $(this).html("loading...");

            $(".preloader-wrapper").removeClass("loaded");
            
            // GENERATING TRANSACTION REF:
            const tranx_ref = generateTransaction_ref();

            // const formData = new FormData();

            // formData.append("submit", true);
            // formData.append("tx_ref", tranx_ref);


            makePayment(tranx_ref, "2000");
        });

         // REMOVE PRELOADER
         setTimeout(() => $(".preloader-wrapper").addClass("loaded"), 3000);
    </script>
</body>

</html>
