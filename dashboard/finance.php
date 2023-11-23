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
    <!-- JQUERY DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- DROP DOWN MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/css/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/student-dash-menu.css" />
    <!-- ADMIN DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/student-dash/table.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/student-dash-mediaquery.css" />
    <title>Finance - Codeweb Student Dashboard</title>
</head>

<body>
    <div class="dash-wrapper">
        <?php
        include("includes/student-dash-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <h1 class="welcome-message">Finance
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
                    <div class="table-wrapper">
                        <h2 class="table-title" style="font-size: 2rem;">Finance History</h2>

                        <div class="table-container">
                            <table id="finance-table" class="main-table">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>
                                            Receipt
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_fetch_all_course_payments = $db->query("SELECT * FROM course_payments INNER JOIN courses ON course_payments.course_id = courses.course_id WHERE user_id = {$user_id} ORDER BY payment_id DESC");

                                    $count = 1;

                                    while ($course_payment_details = $sql_fetch_all_course_payments->fetch_assoc()) {

                                        if ($course_payment_details['duration_in_months'] === $course_payment_details['months_paid']) {
                                            $description = $course_payment_details['name'] . " Full Course payment ( " . $course_payment_details['duration_in_months'] . " Month(s) )";
                                        } else {
                                            $description = $course_payment_details['name'] . " Installmental Course payment ( " . $course_payment_details['months_paid'] . " of " . $course_payment_details['duration_in_months'] . " months )";
                                        }
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $count ?>
                                            </td>
                                            <td>
                                                <?= $description ?>
                                            </td>
                                            <td>
                                                ₦ <?= number_format($course_payment_details['amount_paid'],2) ?>
                                            </td>
                                            <td class="receipt-name">
                                                <i class="fa fa-file-pdf-o"></i> <?= $course_payment_details['receipt'] ?>
                                            </td>
                                            <td>
                                                <div class="dropdown" style="font-size: 10px;">
                                                    <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                        o<br>o<br>o
                                                    </button>
                                                    <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                        <a class="dropdown-menu__link" target="_blank" href="../receipts/<?= $course_payment_details['receipt'] ?>">View Receipt</a>
                                                        <a class="dropdown-menu__link" download href="../receipts/<?= $course_payment_details['receipt'] ?>">Download Receipt</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $count++;
                                    }
                                    ?>
                                    <?php
                                    $sql_fetch_course_payments = $db->query("SELECT * FROM application_form_payments WHERE user_id = {$user_id}");

                                    $application_form_payment_details = $sql_fetch_course_payments->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $count ?>
                                        </td>
                                        <td>
                                            Application Form Payment
                                        </td>
                                        <td>
                                            ₦ 2,000.00
                                        </td>
                                        <td class="receipt-name">
                                            <i class="fa fa-file-pdf-o"></i> <?= $application_form_payment_details['receipt'] ?>
                                        </td>
                                        <td>
                                            <div class="dropdown" style="font-size: 10px;">
                                                <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                    o<br>o<br>o
                                                </button>
                                                <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                    <a class="dropdown-menu__link" target="_blank" href="../receipts/<?= $_details['receipt'] ?>">View Receipt</a>
                                                    <a class="dropdown-menu__link" download href="../receipts/<?= $_details['receipt'] ?>">Download Receipt</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
    <!-- JQUERY DATATABLE SCRIPT -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../assets/js/dropdown/dropdown.min.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../assets/js/dash.js"></script>
    <script>
        $(function() {
            $("#finance-table").DataTable({
                "pageLength": 20
            });
        });
    </script>
</body>

</html>