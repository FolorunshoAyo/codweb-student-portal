<?php
    require(__DIR__.'/auth-library/resources.php');
    Auth::Route("");
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
    <!-- Codeweb Fonts -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <!-- Codeweb Forms -->
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- Enroll stylesheet -->
    <link rel="stylesheet" href="assets/css/sign-up.css">
    <!-- Toast CSS (codeweb) -->
    <link rel="stylesheet" href="assets/css/custom-toast.css">
    <!-- SUCCESS CSS -->
    <link rel="stylesheet" href="assets/css/success.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Success - Codeweb Student</title>
</head>

<body>
    <section class="registeration-section" style="flex: 0 0 100%;">
        <div class="registeration-wrapper" style="height: 100vh;">
            <div class="info-container">
                <div class="icon-container">
                    <img src="assets/images/check-icon.png" alt="check-icon">
                </div>

                <h1 class="title title--info">Sucess</h1>

                <p class="text">Password reset was successfull</p>

                <div class="success-container">
                    <button>Back to login</buttton>
                </div>
            </div>
        </div>
    </section>
    <aside class="copy-sign">&copy; Codeweb 2023</aside>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
</body>

</html>