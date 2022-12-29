<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require '../PHPMailer/src/Exception.php';
//require '../PHPMailer/src/PHPMailer.php';
//require '../PHPMailer/src/SMTP.php';

if (isset($_POST['submit_button'])) {
    $conn = new mysqli('localhost', 'root', '', 'immigration_required_info');
    mysqli_set_charset($conn, "utf8");


    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {

//---------------------------------------------------------------note---------------------------------------------------
        $customer_id = $_SESSION['id'];
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];

        $express_entry = $_POST['express-entry'];
        $provincial_nominees = $_POST['provincial-nominees'];
        $educational = $_POST['educational'];
        $work = $_POST['work'];
        $start_up = $_POST['start-up'];
        $sponsorship = $_POST['sponsorship'];
        $entrepreneurship = $_POST['entrepreneurship'];
        $self_employed = $_POST['self-employed'];
        $refugee = $_POST['refugee'];

        $note = 'Express Entry: '.$express_entry.' | '.'Provincial-nominees: '.$provincial_nominees. ' | '.'Educational: '.$educational.' | '.'Work: '.$work.' | '.'Start-up: '.$start_up.' | '.'Sponsorship: '.$sponsorship.' | '.'Entrepreneurship: '.$entrepreneurship.' | '.'Self-employed: '.$self_employed.' | '.'Refugee: '.$refugee;
        $add_note = "insert into note(customer_id, text, author)
values ('" . $customer_id . "', '" . $note . "', 0 )";
        if ($conn->query($add_note)) {
//            $mail = new PHPMailer();
//            $mail->isSMTP();
//            $mail->Host = 'toos.dnswebhost.com';
//            $mail->SMTPAuth = true;
//            $mail->Username = 'crm@iciservicesco.com';
//            $mail->Password = 'iciservices@3636807';
//            $mail->SMTPSecure = 'tls';
//            $mail->Port = 26;
//            $mail->setFrom('crm@iciservicesco.com', 'IRAN & CANADA IMMIGRATION');
//            $mail->addAddress($email, $name);
//            $mail->CharSet = 'UTF-8';
//            $mail->isHTML(true);
//            $mail->Subject = 'سازمان مهاجرتی آی سی آی | نوت مشاور';
//            $mail->Body = $note;
//            $mail->setLanguage('fa', 'PHPMailer/language/phpmailer.lang-fa.php');
//            $mail->send();

            echo 'نوت ارسال شد';
        } else {
            echo $conn->error;
        }
    }
    $conn->close();
}
?>

<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>immigration required info form</title>
    <link type="text/css" rel="stylesheet" href="./dist/jalalidatepicker.min.css"/>
    <link crossorigin="anonymous"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-dc2NSrAXbAkjrdm9IYrX10fQq9SDG6Vjz7nQVKdKcJl3pC+k37e7qJR5MVSCS+wR" rel="stylesheet">

    <style>
        @import url(./css/fontiran.css);

        body {
            font-family: IRANSans;
            font-weight: 300;
        }

        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        ::-webkit-input-placeholder {
            text-align: right;
        }

        label {
            margin-right: 20px;
        }

        input {
            padding-right: 25px !important;
        }

        .form-check-input {
            padding-right: unset !important;
        }

    </style>
</head>
<body>
<div class="container mt-4">
    <form action="#" method="post">
        <div class="row justify-content-center mb-2">
            <div class="col text-center"><h4>نوت مشاور</h4></div>
        </div>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="express-entry" placeholder="اکسپرس انتری" rows="3"></textarea>
                <label>اکسپرس انتری</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="provincial-nominees" placeholder="برنامه های استانی" rows="3"></textarea>
                <label>برنامه های استانی</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="educational" placeholder="تحصیلی" rows="3"></textarea>
                <label>تحصیلی</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="work" placeholder="کاری" rows="3"></textarea>
                <label>کاری</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="start-up" placeholder="استارتاپ" rows="3"></textarea>
                <label>استارتاپ</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="sponsorship" placeholder="اسپانسرشیپ" rows="3"></textarea>
                <label>اسپانسرشیپ</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="entrepreneurship" placeholder="کارآفرینی" rows="3"></textarea>
                <label>کارآفرینی</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="self-employed" placeholder="خوداشتغالی" rows="3"></textarea>
                <label>خوداشتغالی</label>
            </div>
        </div>
        <hr>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="refugee" placeholder="پناهندگی" rows="3"></textarea>
                <label>پناهندگی</label>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center mb-5">
            <button class="col col-6 btn btn-primary" type="submit" name="submit_button">ثبت</button>
        </div>

    </form>
</div>
<script type="text/javascript" src="./dist/jalalidatepicker.min.js"></script>
<script crossorigin="anonymous"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script crossorigin="anonymous"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script crossorigin="anonymous"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
<script crossorigin="anonymous"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"></script>
</body>
</html>
