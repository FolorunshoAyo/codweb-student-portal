<?php
    require(__DIR__.'/auth-library/resources.php');
    Auth::Route();

    if(isset($_SESSION['reg_status'])){
        autoRedirect("index");
    }
    
    $url = strval($url);
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
    <!-- FONTS CSS -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- Codeweb Preloader  -->
    <link rel="stylesheet" href="assets/css/student/preloader.css">
    <!-- Toast CSS (codeweb) -->
    <link rel="stylesheet" href="assets/css/custom-toast.css">
    <!-- Codeweb Form -->
    <link rel="stylesheet" href="assets/css/sign-up.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Sign In - Codewb Student</title>
</head>

<!-- The auth class is for styling purposes only -->
<body class="auth">
    <div class="preloader-wrapper loaded">
        <div class="loader">
            C
        </div>
    </div>
    <section class="registeration-section">
        <header>
            Not a member yet? <a href="./sign-up">Create an account</a>
        </header>
        <div class="registeration-wrapper login">
            <div class="registeration-container">
                <h1 class="title">Sign in</h1>

                <div class="registeration-form-container">
                    <form  method="post" id="signin-form">

                        <div class="form-groupings">
                            <div class="form-group-container w-100">
                                <div class="form-group animate">
                                    <input type="text" name="username" id="username" class="form-input" placeholder=" "
                                        required>
                                    <label for="username">Username</label>
                                </div>
                            </div>

                            <div class="form-group-container w-100">
                                <div class="form-group animate">
                                    <input type="password" name="pwd" id="pwd" class="form-input" placeholder=" "
                                        required>
                                    <label for="pwd">Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="forgot-password-container">
                            <a href="#">Forgot password?</a>
                        </div>

                        <div class="register-container">
                            <button type="submit" name="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="hero-section-container">
        <div class="text-wrapper">
            <img src="assets/images/c-pole.png" />
            <div class="text-container">
                <h1> Welcome Back!! </h1>
                <p>Please put your login credentials to <br> start using the app</p>
            </div>
        </div>
    </section>
    <aside class="copy-sign">&copy; Codeweb 2023</aside>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- TOASTER PLUGIN -->
    <!-- <script src="auth-library/vendor/dist/sweetalert2.all.min.js"></script> -->
    <!-- CUSTOM TOAST -->
    <script src="assets/js/custom-toast/custom-toast.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="assets/js/just-validate/justvalidate.min.js"></script>
    <script>
        //FORM VALIDATION WITH VALIDATE.JS

        const validation = new JustValidate('#signin-form', {
            errorFieldCssClass: 'is-invalid',
        });

        validation
            .addField('#username', [
                {
                    rule: 'required',
                    errorMessage: 'Field is required',
                },
            ])
            .addField('#pwd', [
                {
                    rule: 'minLength',
                    value: 6,
                },
                {
                    rule: 'required',
                    errorMessage: "Please provide a password"
                }
            ])
            .onSuccess(() => {
                const form = document.getElementById('signin-form');

                // GATHERING FORM DATA
                const formData = new FormData(form);
                formData.append("submit", true);

                //SENDING FORM DATA TO THE SERVER
                $.ajax({
                    type: "post",
                    url: 'controllers/sign-in-process.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    dataType: 'json',
                    beforeSend: function () {
                        $(".register-container button").html("Signing in...");
                        $(".register-container button").attr("disabled", true);
                    },
                    success: function (response) {
                        setTimeout(() => {
                            if (response.success === 1) {
                                ftoast("success", "Login successful", 1000);
                                if(response.redirect === "make_payment"){
                                    window.location = "make-form-payment";
                                }else if(response.redirect === "application_form"){
                                    window.location = "application-form"
                                }else if(response.redirect === "select_course"){
                                    window.location = "select-course";
                                }else{
                                    window.location = "dashboard/"
                                }
                            } else {
                                if(response.error_title === "fatal"){
                                    $(".register-container button").attr("disabled", false);
                                    $(".register-container button").html("Sign In");
                                    // REFRESH CURRENT PAGE
                                    location.reload();
                                }else{
                                    if(response.redirect === "course-payment"){
                                        // ALERT USER
                                        ftoast("error", response.error_message, 4000).then(_ => {
                                            window.location="course-payment";
                                        });
                                    }

                                    // ALERT USER
                                    ftoast("error", response.error_message, 4000).then((_) => {
                                        $(".register-container button").attr("disabled", false);
                                        $(".register-container button").html("Sign In");
                                    });
                                }
                            }
                        }, 1500);
                    },
                    error: function () {
                        $(".register-container button").attr("disabled", false);
                        $(".register-container button").html("Sign In");
                        setTimeout(() => {
                            ftoast("Unable to process request. Please check your internet connection and try again");
                        }, 1500);
                    },
                });
            });
    </script>
</body>

</html>