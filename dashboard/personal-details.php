<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User();
$url = strval($url);


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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/css/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- FORM CSS -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/student-dash-menu.css" />
    <!-- ADMIN DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/student-dash/personal-details.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/student-dash-mediaquery.css" />
    <title>Personal Details - Codeweb Student Dashboard</title>
</head>

<body>
    <div class="dash-wrapper">
        <?php
        include("includes/student-dash-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <h1 class="welcome-message">Personal Details
                </h1>
                <div class="profile-container">
                    <div class="first-name-initial">
                        <?= substr($user_details['username'], 0, 1) ?>
                    </div>
                    <div class="profile-details">
                        <h2><?= $user_details['last_name'] . " " . $user_details['first_name'] ?></h2>
                        <p>Student</p>
                    </div>
                    <div class="logout-container">
                        <a href="../logout">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </div>
                </div>
            </header>
            <main>
                <div class="main-wrapper">

                    <section class="personal-details-section">
                        <div class="profile-first-name-initial">
                            <?= substr($user_details['first_name'], 0, 1) ?>
                        </div>
                        <h2 class="form-title">Primary Information</h2>

                        <div class="personal-info-container form-groupings">

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="fname" id="fname" class="form-input" value="<?php echo $user_details['first_name'] ?>" placeholder=" " disabled>
                                    <label for="fname">First name</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="lname" id="lname" class="form-input" value="<?php echo $user_details['last_name'] ?>" placeholder=" " disabled>
                                    <label for="lname">Last name</label>
                                </div>
                            </div>

                            <?php
                            $sql_get_student_details = $db->query("SELECT * FROM students WHERE user_id = {$user_id}");

                            $student_primary_details = $sql_get_student_details->fetch_assoc();

                            $student_id = $student_primary_details['student_id'];
                            ?>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="date" name="dob" id="dob" value="<?= $student_primary_details['date_of_birth'] ?>" class="form-input" placeholder=" " disabled>
                                    <label for="dob">Date of Birth</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <select name="sex" id="sex" class="form-input" required disabled>
                                        <option value="">Choose sex</option>
                                        <option value="M" <?= $student_primary_details['sex'] === "M" ? "selected" : "" ?>>Male</option>
                                        <option value="F" <?= $student_primary_details['sex'] === "F" ? "selected" : "" ?>>Female</option>
                                    </select>
                                    <label for="sex">Sex</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="email" name="email" id="email" class="form-input" value="<?php echo $user_details['email'] ?>" placeholder=" " required disabled>
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="number" name="phoneno" id="phoneno" class="form-input" value="<?php echo $user_details['phone_no'] ?>" placeholder=" " required disabled>
                                    <label for="phoneno">Phone number</label>
                                </div>
                            </div>

                        </div>

                        <h2 class="form-title">Residential Information</h2>

                        <div class="address-info-container form-groupings">
                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="address" id="address" class="form-input" value="<?= $student_primary_details['address'] ?>" placeholder=" " required disabled>
                                    <label for="address">Address line (home)</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="city" id="city" class="form-input" value="<?= $student_primary_details['city'] ?>" placeholder=" " required disabled>
                                    <label for="city">City</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="state" id="state" class="form-input" value="<?= $student_primary_details['state'] ?>" placeholder=" " required disabled>
                                    <label for="state">State</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="country" id="country" class="form-input" value="<?= $student_primary_details['country'] ?>" placeholder=" " required disabled>
                                    <label for="country">Country</label>
                                </div>
                            </div>
                        </div>

                        <?php
                        $sql_get_guardian_details = $db->query("SELECT * FROM guardians WHERE student_id = {$student_id}");

                        $student_guardian_details = $sql_get_guardian_details->fetch_assoc();
                        ?>

                        <h2 class="form-title">Guardian Information</h2>

                        <div class="address-info-container form-groupings">
                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gfname" id="gfname" class="form-input" value="<?= $student_guardian_details['first_name'] ?>" placeholder=" " required disabled>
                                    <label for="gfname">First name</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="glname" id="glname" class="form-input" value="<?= $student_guardian_details['last_name'] ?>" placeholder=" " required disabled>
                                    <label for="glname">Last name</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gpnum" id="gpnum" class="form-input" value="<?= $student_guardian_details['phone_no'] ?>" placeholder=" " required disabled>
                                    <label for="gpnum">Phone number</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gemail" id="gemail" class="form-input" value="<?= $student_guardian_details['email'] ?>" placeholder=" " required disabled>
                                    <label for="gemail">Email</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="goccupation" id="goccupation" class="form-input" value="<?= $student_guardian_details['occupation'] ?>" placeholder=" " required disabled>
                                    <label for="goccupation">Occupation</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="grelationship" id="grelationship" class="form-input" value="<?= $student_guardian_details['relationship'] ?>" placeholder=" " required disabled>
                                    <label for="grelationship">Relationship</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gaddress" id="gaddress" class="form-input" value="<?= $student_guardian_details['address'] ?>" placeholder=" " required disabled>
                                    <label for="gaddress">Address line (home)</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gcity" id="gcity" class="form-input" value="<?= $student_guardian_details['city'] ?>" placeholder=" " required disabled>
                                    <label for="gcity">City</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input name="gstate" id="gstate" class="form-input" value="<?= $student_guardian_details['state'] ?>" placeholder=" " required disabled>
                                    <label for="gstate">State</label>
                                </div>
                            </div>

                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <input type="text" name="gcountry" id="gcountry" value="<?= $student_guardian_details['country'] ?>" class="form-input" placeholder=" " required disabled>
                                    <label for="gcountry">Country</label>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- METIS MENU JS -->
    <script src="../assets/js/metismenujs/metismenujs.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../assets/js/dash.js"></script>
    <script>
        //PROGRESS LOADERS FOR TOP SELLING CATEGORIES
        // const progressThumbs = $(".progress-thumb");

        // progressThumbs.each(function () {
        //   const dataPercent = $(this).attr("data-percent");

        //   $(this).css("width", dataPercent);
        // });

        // TAB FUNCTIONALITY
        // $(".tab").each(function(){
        //   $(this).on("click", function(){
        //     const selectedTabNo = $(this).attr("data-tab");

        //     $(".tab").each(function(){
        //       $(this).removeClass("active");
        //     })

        //     $(this).addClass("active");

        //     $(".tab-content").each(function(){
        //       $(this).removeClass("active");
        //     });

        //     $(`.tab-${selectedTabNo}`).addClass("active")
        //   });
        // });
    </script>
</body>

</html>