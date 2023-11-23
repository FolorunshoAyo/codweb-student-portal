<?php
    require(__DIR__.'/auth-library/resources.php');
    Auth::Route();
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
    <!-- Codeweb Form -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- Codeweb Preloader  -->
    <link rel="stylesheet" href="assets/css/student/preloader.css">
    <!-- Enroll stylesheet -->
    <link rel="stylesheet" href="assets/css/sign-up.css">
    <!-- Toast CSS (codeweb) -->
    <link rel="stylesheet" href="assets/css/custom-toast.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Sign Up - Codeweb Student</title>
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
            Have an account? <a href="./">Sign in</a>
        </header>
        <div class="registeration-wrapper">
            <div class="registeration-container">
                <h1 class="title">Sign Up</h1>

                <div class="registeration-form-container">
                    <form id="signup-form">
                        <div class="personal-info-container form-groupings">

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="fname" id="fname" class="form-input" placeholder=" "
                                        required>
                                    <label for="fname">First name</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="lname" id="lname" class="form-input" placeholder=" "
                                        required>
                                    <label for="lname">Last name</label>
                                </div>
                            </div>

                            <div class="form-group-container w-100">
                                <div class="form-group animate">
                                    <input type="text" name="uname" id="uname" class="form-input" placeholder=" "
                                        required>
                                    <label for="pwd">Username</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="number" name="pnum" id="pnum" class="form-input" placeholder=" "
                                        required>
                                    <label for="pnum">Phone Number</label>
                                </div>
                            </div>

                            <div class="form-group-container last">
                                <div class="form-group animate">
                                    <input type="email" name="email" id="email" class="form-input" placeholder=" "
                                        required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                        </div>

                            <div class="password-info-container form-groupings">
                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="password" name="pwd" id="pwd" class="form-input" placeholder=" "
                                            required>
                                        <label for="pwd">Password</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="password" name="cpwd" id="cpwd" class="form-input" placeholder=" "
                                            required>
                                        <label for="cpwd">Confirm password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="agreement-container">
                                <label for="agree"><input type="checkbox" id="agree_to_terms">I agree to all terms &
                                    conditions</label>
                            </div>

                            <div class="register-container">
                                <button type="submit" name="submit">Sign Up</button>
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
                <h1> Welcome to <br> Codeweb </h1>
                <p>Let's get you all set-up so you can verify <br> your personal account and begin setting <br> up your
                    profile</p>
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
    <!-- CUSTOM ALERT JS -->
    <script src="assets/js/custom-toast/custom-toast.js"></script>
    <!-- TOASTER PLUGIN -->
    <!-- <script src="auth-library/vendor/dist/sweetalert2.all.min.js"></script> -->
    <!-- JUST VALIDATE LIBRARY -->
    <script src="assets/js/just-validate/justvalidate.min.js"></script>
    <script>
        //FORM VALIDATION WITH VALIDATE.JS

        const validation = new JustValidate('#signup-form', {
            errorFieldCssClass: 'is-invalid',
        });

        validation
            .addField('#fname', [
                {
                    rule: 'required',
                    errorMessage: "Field is required"
                },
                {
                    rule: 'minLength',
                    value: 3,
                },
                {
                    rule: 'maxLength',
                    value: 30,
                },
            ])
            .addField('#lname', [
                {
                    rule: 'required',
                    errorMessage: "Field is required"
                },
                {
                    rule: 'minLength',
                    value: 3,
                },
                {
                    rule: 'maxLength',
                    value: 30,
                },
            ])
            .addField('#email', [
                {
                    rule: 'required',
                    errorMessage: 'Field is required',
                },
                {
                    rule: 'email',
                    errorMessage: 'Email is invalid!',
                },
            ])
            .addField('#uname', [
                {
                    rule: 'required',
                    errorMessage: 'Field is required',
                },
                {
                    rule: 'minLength',
                    value: 6,
                },
                {
                    rule: 'maxLength',
                    value: 30,
                },
            ])
            .addField('#pnum', [
                {
                    rule: 'required',
                    errorMessage: "Field is required"
                },
                {
                    rule: 'minLength',
                    value: 11,
                },
                {
                    rule: 'maxLength',
                    value: 11,
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
            .addField('#cpwd', [
                {
                    rule: 'minLength',
                    value: 6,
                },
                {
                    rule: 'required',
                    errorMessage: "Field is required"
                },
                {
                    validator: (value, fields) => {
                        if (fields['#pwd'] && fields['#pwd'].elem) {
                            const repeatPasswordValue = fields['#pwd'].elem.value;

                            return value === repeatPasswordValue;
                        }

                        return true;
                    },
                    errorMessage: 'Passwords should be the same',
                }
            ])
            .addField('#agree_to_terms', [
                {
                    rule: 'required',
                    errorMessage: 'Please agree to the terms'
                }
            ])
            .onSuccess(() => {
                const form = document.getElementById('signup-form');

                // GATHERING FORM DATA
                const formData = new FormData(form);
                formData.append("submit", true);

                //SENDING FORM DATA TO THE SERVER
                $.ajax({
                    type: "post",
                    url: 'controllers/sign-up-process.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    dataType: 'json',
                    beforeSend: function () {
                        $(".register-container button").html("Signing up...");
                        $(".register-container button").attr("disabled", true);
                    },
                    success: function (response) {
                        setTimeout(() => {
                            if (response.success === 1) {
                                ftoast("success", "You've successfully signed up").then((_) => {
                                    // REDIRECT USER TO THE SIGN IN PAGE
                                    window.location = "./";
                                });
                            } else {
                                $(".register-container button").attr("disabled", false);
                                $(".register-container button").html("Sign Up");

                                if (response.error_title === "fatal") {
                                    // REFRESH CURRENT PAGE
                                    location.reload();
                                } else {
                                    // ALERT USER
                                    ftoast("error", response.error_message);
                                }
                            }
                        }, 1500);
                    },
                    error: function () {
                        $(".register-container button").attr("disabled", false);
                        $(".register-container button").html("Sign Up");
                        setTimeout(() => {
                            ftoast("Unable to process request. Please check your internet connection and try again");
                        }, 1500);
                    },
                });
            });
    </script>
</body>

</html>