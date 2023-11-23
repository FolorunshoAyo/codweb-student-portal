<?php
include(__DIR__ . "/vendor/autoload.php");

use Dompdf\Dompdf;
use Dompdf\Options;

function greeting()
{
    $theDate = date("H");
    if ($theDate < 12) {
        return "Good morning to you";
    } else if ($theDate < 18) {
        return "Good afternoon to you";
    } else {
        return "Good evening to you";
    }
}


function make_avatar($character)
{
    $path = "C:/xampp/htdocs/codeweb/student/" . "images/" . time() . ".png";
    $file_name = time() . ".png";
    $image = imagecreate(200, 200);
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);
    $textcolor = imagecolorallocate($image, 255, 255, 255);

    $font = 'C:/xampp/htdocs/codeweb/assets/fonts/Montserrat-Bold.ttf';

    imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
    imagepng($image, $path);
    imagedestroy($image);

    return $file_name;
}

// Redirects user depending on registeration status
function autoRedirect($currPage)
{
    if ($_SESSION['reg_status'] === "0" && $currPage !== "make-form-payment") {
        header("Location: ../student/make-form-payment");
    }
    if ($_SESSION['reg_status'] === "1" && $currPage !== "application-form") {
        header("Location: ../student/application-form");
    }
    if ($_SESSION['reg_status'] === "2" && $currPage !== "select-course") {
        header("Location: ../student/select-course");
    }
    if ($_SESSION['reg_status'] === "3" && $currPage !== "course-payment") {
        header("Location: ../student/course-payment");
    }

    if (!isset($_SESSION['reg_status'])) {
        header("Location: ../student/dashboard/");
    }
}

// GENERATING PDF
function generateReceipt($receiptProps)
{
    $options = new Options;
    $options->setChroot(__DIR__);
    $options->setIsRemoteEnabled(true);

    $dompdf = new Dompdf($options);

    $student_name = $receiptProps['name'];
    $student_phoneno = $receiptProps['phone'];
    $student_email = $receiptProps['email'];
    $transaction_date = $receiptProps['transaction_date'];
    $receipt_code = $receiptProps['receipt_code'];
    $amount_paid = number_format($receiptProps['amount_paid'], 2);
    $curr_year = date("Y");

    /**
     * Set the paper size and orientation
     */
    $dompdf->setPaper("A4", "potrait");

    if (isset($receiptProps['application_form'])) {
        /**
         * Load the HTML and replace placeholders with values from the form
         */
        $html = file_get_contents("../application-form-receipt-template.html");

        $html = str_replace(
            [
                "{{ date }}",
                "{{ code }}",
                "{{ name }}",
                "{{ phoneNo }}",
                "{{ email }}",
                "{{ paidFee }}",
                "{{ year }}"
            ],
            [
                $transaction_date,
                $receipt_code,
                $student_name,
                $student_phoneno,
                $student_email,
                $amount_paid,
                $curr_year
            ],
            $html
        );

        $dompdf->loadHtml($html);
        //$dompdf->loadHtmlFile("template.html");
    } else {
        $course_title = $receiptProps['course_title'];
        $type_of_payment = $receiptProps['installment'] === "1" ? "Monthly Payment" : "One time payment";
        $course_fee = number_format($receiptProps['course_fee'], 2);


        if ($receiptProps['installment'] === "1") {
            $months_paid = $receiptProps['months_paid'];
            $remaining_balance = number_format($receiptProps['remaining_balance'], 2);

            /**
             * Load the HTML and replace placeholders with values from the form
             */
            $html = file_get_contents("../installmental-receipt-template.html");

            $html = str_replace(
                [
                    "{{ date }}",
                    "{{ code }}",
                    "{{ name }}",
                    "{{ phoneNo }}",
                    "{{ email }}",
                    "{{ ctitle }}",
                    "{{ cfee }}",
                    "{{ paymentType }}",
                    "{{ monthsPaid }}",
                    "{{ remainingBalance }}",
                    "{{ paidFee }}",
                    "{{ year }}"
                ],
                [
                    $transaction_date,
                    $receipt_code,
                    $student_name,
                    $student_phoneno,
                    $student_email,
                    $course_title,
                    $course_fee,
                    $type_of_payment,
                    $months_paid,
                    $remaining_balance,
                    $amount_paid,
                    $curr_year
                ],
                $html
            );

            $dompdf->loadHtml($html);
            //$dompdf->loadHtmlFile("template.html");
        } else {
            /**
             * Load the HTML and replace placeholders with values from the form
             */
            $html = file_get_contents("../full-payment-receipt-template.html");

            $html = str_replace(
                [
                    "{{ date }}",
                    "{{ code }}",
                    "{{ name }}",
                    "{{ phoneNo }}",
                    "{{ email }}",
                    "{{ ctitle }}",
                    "{{ cfee }}",
                    "{{ paymentType }}",
                    "{{ paidFee }}",
                    "{{ year }}"
                ],
                [
                    $transaction_date,
                    $receipt_code,
                    $student_name,
                    $student_phoneno,
                    $student_email,
                    $course_title,
                    $course_fee,
                    $type_of_payment,
                    $amount_paid,
                    $curr_year
                ],
                $html
            );

            $dompdf->loadHtml($html);
            //$dompdf->loadHtmlFile("template.html");
        }
    }

    /**
     * Create the PDF and set attributes
     */
    $dompdf->render();

    $dompdf->addInfo("Title", "Student Receipt"); // "add_info" in earlier versions of Dompdf

    /**
     * Send the PDF to the browser
     */
    // $dompdf->stream("invoice.pdf", ["Attachment" => 0]);

    /**
     * Save the PDF file locally
     */
    $file_name = $receipt_code . ".pdf";

    $output = $dompdf->output();
    file_put_contents("../receipts/" . $file_name, $output);

    return $file_name;
}
