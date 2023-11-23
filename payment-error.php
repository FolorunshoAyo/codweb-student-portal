<?php
    require(__DIR__ . '/auth-library/resources.php');
    // Auth::Route();
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
    <title>Payment Error - Codeweb Student</title>
</head>

<body>
    <section class="registeration-section" style="flex: 0 0 100%;">
        <div class="registeration-wrapper" style="height: 100vh;">
            <div class="info-container">
                <div class="icon-container">
                    <i class="fa fa-ban"></i>
                </div>

                <h1 class="title title--info">Payment Error</h1>

                <p class="text">Your payment was unsuccessful</p>
                <p class="text">Please hold on, you would be redirected in a few seconds.</p>
                <!-- <div class="success-container">
                    <button>Download reciept</button>
                    <button>Go to Dashboard</button>
                </div> -->
            </div>
        </div>
    </section>
    <aside class="copy-sign">&copy; Codeweb 2023</aside>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <script>
        setTimeout(() => {
            <?php
            if ($_SESSION['reg_status'] === "1") {
            ?>
                window.location = "application-form";
            <?php
            } elseif($_SESSION['reg_status'] === "3") {
            ?>
                window.location = "course-payment";
            <?php
            }else{
            ?>
            window.location = "dashboard/"
            <?php }?>
        }, 5000);
    </script>
</body>

</html>