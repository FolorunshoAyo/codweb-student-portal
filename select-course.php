<?php
require(__DIR__ . '/auth-library/resources.php');
Auth::User();
$url = strval($url);

autoRedirect("select-course");

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );

$user_id = $_SESSION['user_id'];

$sql_get_user_details = $db->query("SELECT * FROM users WHERE user_id={$user_id}");

if ($sql_get_user_details->num_rows) {
    $user_details = $sql_get_user_details->fetch_assoc();
} else {
    header("location: ./");
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
    <!-- CUSTOM TOAST CSS -->
    <link rel="stylesheet" href="assets/css/custom-toast.css">
    <!-- ENROLL STYLESHEET  -->
    <link rel="stylesheet" href="assets/css/form.css" type="text/css">
    <!-- STUDENT HEADER STYLESHEET -->
    <link rel="stylesheet" href="assets/css/student/sections/header.css" type="text/css">
    <!-- FOOTER STYLESHEET -->
    <link rel="stylesheet" href="assets/css/sections/footer.css" type="text/css">
    <!-- HOME STYLESHEET -->
    <link rel="stylesheet" href="assets/css/home.css" type="text/css">
    <!-- make payment css -->
    <link rel="stylesheet" href="assets/css/student/select-course.css" type="text/css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-mediaquery.css">
    <title>Select Course - Codeweb Student</title>
</head>

<body>
    <div class="preloader-wrapper">
        <div class="loader">
            C
        </div>
    </div>
    <header class="make-payment-header">
        <div class="person-container">
            <span class="first-name-initial"><?= substr($user_details['username'], 0, 1) ?></span>
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
                <div class="progress-thumb active"></div>
            </div>
            <div class="progress progress-2">
                <div class="progress-circle active">
                    2
                </div>
                <span class="progress-text">Fill application form</span>
            </div>
            <div class="progress-line progress-line-2">
                <div class="progress-thumb active"></div>
            </div>
            <div class="progress progress-2">
                <div class="progress-circle active">
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
        <section class="select-course-section">
            <div class="select-course-container">

                <h1 class="main-title">Select a course</h1>
                <p class="form-notice">Pick a course and set a payment plan</p>

                <form id="select-course-form">
                    <h2 class="form-title">Pick a course</h2>

                    <div class="form-groupings courses">
                        <?php
                        $sql_get_all_courses = $db->query("SELECT * FROM courses ORDER BY category DESC");

                        $web_count = $mobile_count = $network_count = 0;
                        while ($course_details = $sql_get_all_courses->fetch_assoc()) {
                        ?>
                            <?php
                            if ($course_details['category'] === "web") {
                                $web_count++;
                                $sql_check_number_of_web_courses = $db->query("SELECT * FROM courses WHERE category='web'");
                            ?>
                                <div class="form-group-container">
                                    <input type="radio" id="course-<?php echo $course_details['course_id'] ?>" name="selected-course" value="<?php echo $course_details['course_id'] ?>" class="radio-input">
                                    <label for="course-<?php echo $course_details['course_id'] ?>" class="course-label">
                                        <div class="card">
                                            <div class="title-container">
                                                <p>Web <?php echo $sql_check_number_of_web_courses->num_rows === 1 ? "" : "#$web_count" ?></p>
                                                <span class="course-price">₦ <?php echo number_format($course_details['course_price']) ?></span>
                                            </div>
                                            <div class="more-info-container">
                                                <h3 class="course-title"><?= $course_details['name'] ?></h3>
                                                <div class="course-description">
                                                    <?= $course_details['description'] ?>
                                                </div>

                                                <p class="course-duration">Duration: <?= $course_details['duration_in_months'] ?> months</p>
                                            </div>
                                            <div class="radio-btn-container">
                                                <div class="outer-circle course-select">
                                                    <div class="inner-circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php
                            } elseif ($course_details['category'] === "mobile") {
                                $mobile_count++;
                                $sql_check_number_of_mobile_courses = $db->query("SELECT * FROM courses WHERE category='mobile'");
                            ?>
                                <div class="form-group-container">
                                    <input type="radio" id="course-<?php echo $course_details['course_id'] ?>" name="selected-course" value="<?php echo $course_details['course_id'] ?>" class="radio-input">
                                    <label for="course-<?php echo $course_details['course_id'] ?>" class="course-label">
                                        <div class="card">
                                            <div class="title-container">
                                                <p>Mobile <?php echo $sql_check_number_of_mobile_courses->num_rows === 1 ? "" : "#$mobile_count" ?></p>
                                                <span class="course-price">₦ <?php echo number_format($course_details['course_price']) ?></span>
                                            </div>
                                            <div class="more-info-container">
                                                <h3 class="course-title"><?= $course_details['name'] ?></h3>
                                                <div class="course-description">
                                                    <?= $course_details['description'] ?>
                                                </div>

                                                <p class="course-duration">Duration: <?= $course_details['duration_in_months'] ?> months</p>
                                            </div>
                                            <div class="radio-btn-container">
                                                <div class="outer-circle course-select">
                                                    <div class="inner-circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php
                            } elseif ($course_details['category'] === "networking") {
                                $network_count++;
                                $sql_check_number_of_networking_courses = $db->query("SELECT * FROM courses WHERE category='networking'");
                            ?>
                                <div class="form-group-container">
                                    <input type="radio" id="course-<?php echo $course_details['course_id'] ?>" name="selected-course" value="<?php echo $course_details['course_id'] ?>" class="radio-input">
                                    <label for="course-<?php echo $course_details['course_id'] ?>" class="course-label">
                                        <div class="card">
                                            <div class="title-container">
                                                <p>Networking <?php echo $sql_check_number_of_networking_courses->num_rows === 1 ? "" : "#$network_count" ?></p>
                                                <span class="course-price">₦ <?php echo number_format($course_details['course_price']) ?></span>
                                            </div>
                                            <div class="more-info-container">
                                                <h3 class="course-title"><?= $course_details['name'] ?></h3>
                                                <div class="course-description">
                                                    <?= $course_details['description'] ?>
                                                </div>

                                                <p class="course-duration">Duration: <?= $course_details['duration_in_months'] ?> months</p>
                                            </div>
                                            <div class="radio-btn-container">
                                                <div class="outer-circle course-select">
                                                    <div class="inner-circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <div class="form-group-container">
                            <input type="radio" id="course-6" name="selected-course" value="6" class="radio-input">
                            <label for="course-6" class="course-label">
                                <div class="card">
                                    <div class="title-container">
                                        <p>Special #1</p>
                                        <span class="course-price">₦ 20,000</span>
                                    </div>
                                    <div class="more-info-container">
                                        <h3 class="course-title">Holiday coding camp </h3>
                                        <div class="course-description">
                                            <p>Prepare your children for a brighter future with the following ICT trainings</p>
                                            <ul>
                                                <li>Learning to code</li>
                                                <li>Graphics Design</li>
                                                <li>Robotics</li>
                                            </ul>
                                        </div>

                                        <p class="course-duration">Duration: 1 months</p>
                                    </div>
                                    <div class="radio-btn-container">
                                        <div class="outer-circle course-select">
                                            <div class="inner-circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <h2 class="form-title">Set a payment plan</h2>

                    <div class="form-groupings payment-plans">

                        <div class="form-group-container">
                            <input type="radio" name="payment-plan" id="payment-plan-1" value="1">
                            <label for="payment-plan-1" class="payment-label">
                                <div class="payment-card">
                                    <div class="image-container">
                                        <img src="assets/images/one-time-purchase-icon.png" alt="Icon">
                                    </div>
                                    <div class="payment-text-container">
                                        <h3>Full payment</h3>
                                        <p>Make a full, one time payment.
                                        <p>
                                    </div>
                                    <div class="radio-container">
                                        <div class="outer-circle">
                                            <div class="inner-circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="form-group-container">
                            <input type="radio" name="payment-plan" id="payment-plan-2" value="2">
                            <label for="payment-plan-2" class="payment-label">
                                <div class="payment-card">
                                    <div class="image-container">
                                        <img src="assets/images/payment-plan-icon.png" alt="Icon">
                                    </div>
                                    <div class="payment-text-container">
                                        <h3>Monthly Payment</h3>
                                        <p>Pay fees monthly.
                                        <p>
                                    </div>
                                    <div class="radio-container">
                                        <div class="outer-circle">
                                            <div class="inner-circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </div>

                    <div class="enroll-form-container">
                        <button role="button" type="button">Save and continue</button>
                    </div>
                </form>
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
            &copy; Copyright Codeweb <?php echo (date("Y")) ?>.
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
    <!-- CUSTOM TOAST -->
    <script src="assets/js/custom-toast/custom-toast.js"></script>
    <script>

        $(document).on("click", ".course-label", function(){
            const selectedLabel = $(this);
            const monthlyPaymentLabel = $("label[for='payment-plan-2']");

            const selectedCourse = selectedLabel.attr("for");

            // REMOVE monthly payment for special course 6
            if(selectedCourse === "course-6"){
                monthlyPaymentLabel.css("display", "none");
            }else{
                monthlyPaymentLabel.css("display", "block");
            }
        });

        $(".enroll-form-container button").on("click", function() {
            const form = document.getElementById("select-course-form");

            const formData = new FormData(form);


            if (formData.get("selected-course") === null && formData.get("payment-plan") === null) {
                ftoast("error", "Please select a course and a payment option", 4000);
            } else if (formData.get("selected-course") === null) {
                ftoast("error", "Please select a course", 4000);
            } else if (formData.get("payment-plan") === null) {
                ftoast("error", "Please choose a payment plan");
            } else {
                sendData({
                    paymentPlan: formData.get("payment-plan"),
                    selectedCourse: formData.get("selected-course"),
                    submit: true
                })
            }
        });

        function sendData(data) {
            const formData = new FormData();

            formData.append("submit", true);
            formData.append("payment-plan", data.paymentPlan);
            formData.append("selected-course", data.selectedCourse);

            //SENDING FORM DATA TO THE SERVER
            $.ajax({
                type: "post",
                url: 'controllers/select-course-process.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $(".enroll-form-container button").html("Processing...");
                    $(".enroll-form-container button").attr("disabled", true);
                },
                success: function(response) {
                    setTimeout(() => {
                        if (response.success === 1) {
                            ftoast("success", response.message, 4000).then(_ => {
                                window.location = "course-payment";
                            });
                        } else {
                            $(".enroll-form-container button").attr("disabled", false);
                            $(".enroll-form-container button").html("Save and continue");

                            if (response.error_title === "fatal") {
                                // REFRESH CURRENT PAGE
                                location.reload();
                            } else {
                                // ALERT USER
                                ftoast("error", response.error_message, 4000);
                            }
                        }
                    }, 1500);
                },
            });
        };

        // REMOVE PRELOADER
        setTimeout(() => {
            $(".preloader-wrapper").addClass("loaded");
            <?php
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "https://localhost/codeweb/student/") {
                echo 'ftoast("success", "Welcome back ' . $user_details['username'] . '", 4000);';
            }
            ?>
        }, 3000);
    </script>
</body>

</html>