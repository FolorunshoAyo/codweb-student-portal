<?php
// require(__DIR__.'/auth-library/resources.php');
// Auth::Route("student/");
// $url = strval($url);
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
    <!-- Codeweb Fonts -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- Codeweb Forms -->
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- Enroll stylesheet -->
    <link rel="stylesheet" href="assets/css/sign-up.css">
    <!-- Toast CSS (codeweb) -->
    <link rel="stylesheet" href="assets/css/custom-toast.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Reset Password - Codeweb Student</title>
</head>

<!-- The auth class is for styling purposes only -->
<body class="auth">
    <section class="registeration-section">
        <!-- <header>
            Have an account? <a href="./sign-in">Sign in</a>
        </header> -->
        <div class="registeration-wrapper" style="height: 100vh;">
            <div class="registeration-container">
                <h1 class="title">Reset Password</h1>

                <div class="registeration-form-container">
                    <form id="resetpass-form">
                        <div>

                            <div class="password-form-group-container first">
                                <div class="password-form-group">
                                    <input
                                        type="password"
                                        name="pwd"
                                        id="pwd"
                                        class="password-form-input"
                                        placeholder=" "
                                        required
                                    />
                                    <label for="pwd">Password</label>
                                </div>
                                <div class="visibility-container">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>

                            <div class="password-form-group-container">
                                <div class="password-form-group">
                                    <input
                                        type="password"
                                        name="cpwd"
                                        id="cpwd"
                                        class="password-form-input"
                                        placeholder=" "
                                        required
                                    />
                                    <label for="cpwd">Confirm Password</label>
                                </div>
                                <div class="visibility-container">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>

                        <div class="register-container">
                            <button type="submit" name="submit">Reset</button>
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
                <h1>Redeem your account</h1>
                <p>Enter a new password. password must be at least 6 characters long.</p>
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

        const validation = new JustValidate('#resetpass-form', {
            errorFieldCssClass: 'is-invalid',
        });

        validation
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
                                    window.location = "sign-in";
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
                });
            });
    </script>
</body>

</html>