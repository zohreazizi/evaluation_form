<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require '../PHPMailer/src/Exception.php';
//require '../PHPMailer/src/PHPMailer.php';
//require '../PHPMailer/src/SMTP.php';

session_start();
if (isset($_POST['submit_button'])) {
    $conn = new mysqli('localhost', 'root', '', 'immigration_required_info');
    mysqli_set_charset($conn, "utf8");

    function insertEducation($degree, $customer_id, $major, $school, $graduated_at, mysqli $conn)
    {
            $education_data = "insert into 101_education(customer_id, position , major, insitute, duration, end_date, start_date, status, place, whois)
                                            values ('" . $customer_id . "', '" . $degree . "', '" . $major . "', '" . $school . "', '', '" . $graduated_at . "', CURRENT_DATE, 0, '', 0)";
        if (!$conn->query($education_data)) {
            echo $conn->error;
        }
    }
    function insertWorkExperience($job_position, $customer_id, $company, $job_start_date, $job_end_date, mysqli $conn)
    {
        for ($i = 0; $i < count($job_position); $i++) {
            $work_experience_data = "insert into 101_job(customer_id, typeOf, institue, start_date, end_date, status, whois, place)
                                                values ('" . $customer_id . "', '" . $job_position[$i] . "', '" . $company[$i] . "', '" . $job_start_date[$i] . "', '" . $job_end_date[$i] . "', 0, 0, '')";
            $conn->query($work_experience_data);
//        if (!$conn->query($work_experience_data)) {
//            print_r($conn->error_list);
//        }
        }
        return array($i, $work_experience_data);
    }
    function insertLanguageProficiency($listening, $reading, $writing, $speaking, $customer_id, $exam_date, $exam_title, $exam_type, mysqli $conn)
    {
        for ($i = 0; $i < count($exam_title); $i++) {
            $language_proficiency_data = "insert into IELTS(cid, issue_date, listening, reading, writing, speaking, title, type)
                                                    values ('" . $customer_id . "', '" . $exam_date[$i] . "', '" . $listening[$i] . "', '" . $reading[$i] . "', '" . $writing[$i] . "', '" . $speaking[$i] . "', '" . $exam_title[$i] . "', '" . $exam_type[$i] . "')";
            $conn->query($language_proficiency_data);
//        if (!$conn->query($language_proficiency_data)) {
//            print_r($conn->error_list);
//        }
        }
        return array($i, $language_proficiency_data);
    }
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $address = $_POST['country'] . ' | ' . $_POST['address'];
        $birthplace = $_POST['birthplace'];
        $marital_status = $_POST['marital_status'];
        $customer_data = "insert into customers(name, family_name, birthday, mobile, email, address,birthplace, marriage, type, code_posti, passport_issue, passport_expire, author, ext, cntst, password_status)
                                   values ('" . $name . "', '" . $lastname . "', '" . $birthday . "', '" . $phone_number . "', '" . $email . "', '" . $address . "', '" . $birthplace . "', '" . $marital_status . "', 1, '', CURRENT_DATE, CURRENT_DATE, '', 0, 0, 0)";
        if (!$conn->query($customer_data)) {
            echo $conn->error;
        }
        $sql = "SELECT id FROM customers WHERE email = '" . $email . "'";
        $applicant = $conn->query($sql)->fetch_assoc();
        if (!$conn->query($sql)) {
            echo $conn->error;
        }
        $customer_id = $applicant['id'];
        print_r($customer_id);
        $_SESSION["name"] = $_POST['name'];
        $_SESSION["email"] = $_POST['email'];
        $_SESSION["id"] = $applicant['id'];

//---------------------------------------------------------------education data-----------------------------------------
        $degree = $_POST['degree'];
        $major = $_POST['major'];
        $school = $_POST['school'];
        $graduated_at = $_POST['graduated_at'];
        insertEducation($degree, $customer_id, $major, $school, $graduated_at, $conn);
//---------------------------------------------------------------work experience data-----------------------------------

        $job_position = $_POST['job_position'];
        $company = $_POST['company'];
        $job_start_date = $_POST['job_start_date'];
        $job_end_date = $_POST['job_end_date'];
        list($i, $work_experience_data) = insertWorkExperience($job_position, $customer_id, $company, $job_start_date, $job_end_date, $conn);
//---------------------------------------------------------------language proficiency data------------------------------

        $exam_title = $_POST['exam_title'];
        $exam_type = $_POST['exam_type'];
        $exam_date = $_POST['exam_date'];
//        $score = $_POST['score'];
        $listening = $_POST['listening'];
        $reading = $_POST['reading'];
        $writing = $_POST['writing'];
        $speaking = $_POST['speaking'];
        list($i, $language_proficiency_data) = insertLanguageProficiency($listening, $reading, $writing, $speaking, $customer_id, $exam_date, $exam_title, $exam_type, $conn);

//---------------------------------------------------------------children data------------------------------------------
        $child_name = $_POST['child_name'];
        $child_birthday = $_POST['child_birthday'];
        for ($i = 0; $i < count($child_name); $i++) {
            $children_data = "insert into 101_closeFamily(customer_id, fullname, birthday, fullname_en, status)
values ('" . $customer_id . "', '" . $child_name[$i] . "', '" . $child_birthday[$i] . "', '', 0)";
            $conn->query($children_data);
//        if (!$conn->query($children_data)) {
//            print_r($conn->error_list);
//        }
        }
//---------------------------------------------------------------additional information---------------------------------
        $asset = $_POST['asset'];
        $fund = $_POST['fund'];
        $immediate_family = $_POST['immediate_family'];
        $immediate_family_address = $_POST['immediate_family_address'];
        $immigration_program = $_POST['immigration_program'];
        $attempt_date = $_POST['attempt_date'];
        $attempt_result = $_POST['attempt_result'];
        $found_us_via = $_POST['found_us_via'];
        if ($_POST['found_us_via'] === 'representative'){
            $found_us_via = $_POST['nameOfRepresentative'];
        }
        $documents_evaluated_by = $_POST['evaluated_by'];
        $documents_evaluated_at = $_POST['evaluated_at'];

        $additional_info = "insert into additional_info(cid, asset, fund, immediate_family, immediate_family_address,
immigration_program, attempt_date, attempt_result, found_us_via, documents_evaluated_by,
documents_evaluated_at)
values ('" . $customer_id . "', '" . $asset . "', '" . $fund . "', '" . $immediate_family . "', '"
            . $immediate_family_address . "', '" . $immigration_program . "', '" . $attempt_date . "', '" . $attempt_result .
            "', '" . $found_us_via . "', '" . $documents_evaluated_by . "', '" . $documents_evaluated_at . "')";
        if (!$conn->query($additional_info)) {
            echo $conn->error;
        }

//----------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------spouse information---------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
        $name = $_POST['spouse_name'];
        $lastname = $_POST['spouse_lastname'];
        $birthday = $_POST['spouse_birthday'];
        $address = $_POST['spouse_country'];
        $birthplace = $_POST['spouse_birthplace'];
        $customer_data = "insert into customers(name, family_name, birthday, address,birthplace, type, code_posti, passport_issue, passport_expire, author, ext, cntst, password_status, is_married_to)
values ('" . $name . "', '" . $lastname . "', '" . $birthday . "', '" . $address . "', '" .
            $birthplace . "', 1, '', CURRENT_DATE, CURRENT_DATE, '', 0, 0, 0, '" . $customer_id . "')";
        if ($conn->query($customer_data)) {
            // echo 'dependant added';
        } else {
            // echo $conn->error;
        }
        $sql = "SELECT id FROM customers WHERE name = '" . $name . "'";
        $dependant = $conn->query($sql)->fetch_assoc();
        if (!$conn->query($sql)) {
            echo $conn->error;
        }
        $dependant_id = $dependant['id'];
//---------------------------------------------------------------education data-----------------------------------------
        $degree = $_POST['spouse_degree'];
        $major = $_POST['spouse_major'];
        $school = $_POST['spouse_school'];
        $graduated_at = $_POST['spouse_graduated_at'];
        insertEducation($degree, $dependant_id, $major, $school, $graduated_at, $conn);

//---------------------------------------------------------------work experience data-----------------------------------

        $job_position = $_POST['spouse_job_position'];
        $company = $_POST['spouse_company'];
        $job_start_date = $_POST['spouse_job_start_date'];
        $job_end_date = $_POST['spouse_job_end_date'];
        list($i, $work_experience_data) = insertWorkExperience($job_position, $dependant_id, $company, $job_start_date, $job_end_date, $conn);
//---------------------------------------------------------------language proficiency data------------------------------

        $exam_title = $_POST['spouse_exam_title'];
        $exam_type = $_POST['spouse_exam_type'];
        $exam_date = $_POST['spouse_exam_date'];
//        $score = $_POST['spouse_score'];
        $listening = $_POST['spouse_listening'];
        $reading = $_POST['spouse_reading'];
        $writing = $_POST['spouse_writing'];
        $speaking = $_POST['spouse_speaking'];
        list($i, $language_proficiency_data) = insertLanguageProficiency($listening, $reading, $writing, $speaking, $customer_id, $exam_date, $exam_title, $exam_type, $conn);

//        list($i, $language_proficiency_data) = insertLanguageProficiency($score, $dependant_id, $exam_date, $exam_title, $exam_type, $conn);

//---------------------------------------------------------------additional information---------------------------------
        $asset = $_POST['spouse_asset'];
        $found_us_via = $_POST['s_found_us_via'];
        $documents_evaluated_by = $_POST['s_evaluated_by'];
        $documents_evaluated_at = $_POST['s_evaluated_at'];
        if ($_POST['s_found_us_via'] === 'representative'){
            $found_us_via = $_POST['s_nameOfRepresentative'];
        }
        $additional_info = "insert into additional_info(cid, asset, found_us_via, documents_evaluated_by, documents_evaluated_at)
values ('" . $dependant_id . "', '" . $asset . "','" . $found_us_via . "', '" .
            $documents_evaluated_by . "', '" . $documents_evaluated_at . "')";
        if ($conn->query($additional_info)) {
            echo $conn->error;
        }

//---------------------------------------------------------------note---------------------------------------------------

//        $note = $_POST['note'];
//        $add_note = "insert into note(customer_id, text, author)
//values ('" . $customer_id . "', '" . $note . "', 0 )";
//        if ($conn->query($add_note)) {
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
//            $mail->Body = '<p dir=rtl style="font-size: 18px;">' . $note . '</p>';
//            $mail->setLanguage('fa', 'PHPMailer/language/phpmailer.lang-fa.php');
//            $mail->send();
//
//            echo 'نوت ارسال شد';
//        } else {
//             echo $conn->error;
//        }
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
            <div class="col text-center"><h4>فرم اطلاعات مورد نیاز مهاجرت</h4></div>
        </div>
        <hr>

        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>اطلاعات هویتی</h6></div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input aria-label="Name" class="form-control" name="name" placeholder="نام"
                           type="text">
                    <label>نام</label>
                </div>
                <div class="col-xl-4 form-floating">
                    <input aria-label="Name" class="form-control" name="lastname" placeholder="نام خانوادگی"
                           type="text">
                    <label>نام خانوادگی</label>
                </div>
                <div class="col form-floating">
                    <input aria-label="Birthday" class="form-control" name="birthday"
                           placeholder="تاریخ تولد(مثلا 01-01-1400)"
                           type="text" data-jdp>
                    <label>تاریخ تولد </label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input aria-label="phone number" class="form-control" name="phone_number" placeholder="شماره تماس"
                           type="text">
                    <label>شماره تماس</label>
                </div>
                <div class="col form-floating">
                    <input aria-label="Email" class="form-control" name="email" placeholder="ایمیل" type="text">
                    <label>ایمیل</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="form-floating">
                    <textarea class="form-control" name="address" placeholder="آدرس" rows="3"></textarea>
                    <label>آدرس</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input class="form-control" name="country" placeholder="کشور محل سکونت" type="text">
                    <label>کشور محل سکونت</label>
                </div>
                <div class="col form-floating">
                    <input class="form-control" name="birthplace" placeholder="محل تولد" type="text">
                    <label>محل تولد</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col">
                    <select onchange="yesnoCheck(this);" class="form-select" aria-label="Default select example" name="found_us_via">
                        <option selected disabled>نحوه آشنایی با شرکت</option>
                        <option value="representative">معرف</option>
                        <option value="Instagram">اینستاگرام</option>
                        <option value="Telegram">تلگرام</option>
                        <option value="Website">وب سایت</option>
                    </select>
                    <div id="ifYes" style="display: none;" class="mt-2">
                        <input class="form-control" type="text" id="car" name="nameOfRepresentative" placeholder="نام معرف"/>
                    </div>
                </div>
            </div>
            <script>
                function yesnoCheck(that) {
                    if (that.value === "representative") {
                        document.getElementById("ifYes").style.display = "block";
                    } else {
                        document.getElementById("ifYes").style.display = "none";
                    }
                }
            </script>
            <div class="row mb-2 mt-4 d-flex">
                <div class="col">
                    <label style="margin-left: 30px">وضعیت تاهل</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="inlineRadio1" name="marital_status" type="radio"
                               value="1" onclick="function removeSpouse() {
            $('#spouse').hide();
            }
            removeSpouse()">
                        <label class="form-check-label" for="inlineRadio1">مجرد</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="inlineRadio2" name="marital_status" type="radio"
                               value="0" onclick="function showSpouse() {
            $('#spouse').show();
            }
            showSpouse()">
                        <label class="form-check-label" for="inlineRadio2">متاهل</label>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>اطلاعات آخرین مدرک تحصیلی</h6></div>
            </div>
            <div class="row mb-1" id="education_wrapper">
                <div class="col-xl-3 form-floating">
                    <input class="form-control" name="degree" placeholder="مقطع" type="text">
                    <label>مدرک تحصیلی</label>
                </div>
                <div class="col form-floating">
                    <input class="form-control" name="major" placeholder="رشته" type="text">
                    <label>رشته</label>
                </div>
                <div class="col form-floating">
                    <input class="form-control" name="school" placeholder="محل تحصیل" type="text">
                    <label>محل تحصیل</label>
                </div>
                <div class="col-xl-3 form-floating">
                    <input data-jdp class="form-control" name="graduated_at" placeholder="تاریخ فارغ التحصیلی"
                           type="text">
                    <label>تاریخ فارغ التحصیلی</label>
                </div>
            </div>
<!--            <div class="row mb-2" id="more-education_input" style="display: contents"></div>-->
<!--            <button class="btn btn-primary col-1 mb-3" onclick="function addEducation() {-->
<!--            $('#education_wrapper').clone().find('input').val('').end().appendTo('#more-education_input');-->
<!--            }-->
<!--            addEducation()" type="button">+-->
<!--            </button>-->

            <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده است؟ </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="0" onclick="function showEvaluated() {
            $('#evaluation_info').show();
            }
            showEvaluated()">
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="1" onclick="function hideEvaluated() {
            $('#evaluation_info').hide();
            }
            hideEvaluated()">
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>

                </div>
            </div>
            <div class="row mb-2" id="evaluation_info">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="evaluated_by">
                        <option selected disabled>نام سازمان</option>
                        <option value="Comparative Education Service – University of Toronto School of Continuing Studies">Comparative Education Service – University of Toronto School of Continuing Studies</option>
                        <option value="International Credential Assessment Service of Canada">International Credential Assessment Service of Canada</option>
                        <option value="World Education Services">World Education Services</option>
                        <option value="International Qualifications Assessment Service (IQAS)">International Qualifications Assessment Service (IQAS)</option>
                        <option value="International Credential Evaluation Service – British Columbia Institute of Technology">International Credential Evaluation Service – British Columbia Institute of Technology</option>
                    </select>
                </div>
                <div class="col">
                    <input data-jdp class="form-control" name="evaluated_at" placeholder="تاریخ" type="text">
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>اطلاعات شغلی</h6></div>
            </div>
            <div class="row mb-1" id="work_experience_input_wrapper">
                <div class="col-xl-3 form-floating">
                    <input class="form-control" name="job_position[]" placeholder="سمت شغلی" type="text">
                    <label>سمت شغلی</label>
                </div>
                <div class="col form-floating">
                    <input class="form-control" name="company[]" placeholder="نام شرکت" type="text">
                    <label>نام شرکت</label>
                </div>
                <div class="col form-floating">
                    <input data-jdp class="form-control" name="job_start_date[]" placeholder="تاریخ شروع" type="text">
                    <label>تاریخ شروع</label>
                </div>
                <div class="col-xl-3 form-floating">
                    <input data-jdp class="form-control" name="job_end_date[]" placeholder="تاریخ پایان" type="text">
                    <label>تاریخ پایان</label>
                </div>
            </div>
            <div class="row mb-2" id="more-work_experience-input" style="display: contents"></div>
            <button class="btn btn-primary col-1 mb-3" onclick="function addWorkExperience() {
            $('#work_experience_input_wrapper').clone().find('input').val('').end()
            .appendTo('#more-work_experience-input');
            }
            addWorkExperience()" type="button">+
            </button>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>سطح دانش زبان</h6></div>
            </div>
            <div class="row mb-1" id="exam_input_wrapper">
                <div class="row mb-2">
                    <div class="col-xl-3">
                        <select class="form-select" aria-label="Default select example" name="exam_title[]">
                            <option selected disabled>نام مدرک زبان</option>
                            <option value="IELTS">IELTS</option>
                            <option value="TEF(Canada)">TEF(Canada)</option>
                            <option value="CELPIP">CELPIP</option>
                            <option value="TOEFL">TOEFL</option>
                            <option value="Doulingo">Doulingo</option>
                            <option value="PTE">PTE</option>
                        </select>
                        <!--                    <input class="form-control" name="exam_title[]" placeholder="نام مدرک زبان" type="text">-->
                        <!--                    <label>نام مدرک زبان</label>-->
                    </div>
                    <div class="col">
                        <select class="form-select" aria-label="Default select example" name="exam_type[]">
                            <option selected disabled>نوع مدرک</option>
                            <option value="General">General</option>
                            <option value="Academic">Academic</option>
                        </select>
                        <!--                    <input class="form-control" name="exam_type[]" placeholder="نوع مدرک" type="text">-->
                        <!--                    <label>نوع مدرک</label>-->
                    </div>
                    <div class="col">
                        <input data-jdp class="form-control" name="exam_date[]" placeholder="تاریخ امتحان" type="text">
                    </div>
                    <!--                <div class="col-xl-3 form-floating">-->
                    <!--                    <input class="form-control" name="score[]" placeholder="نمره" type="text">-->
                    <!--                    <label>نمره</label>-->
                    <!--                </div>-->
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 form-floating">
                        <input class="form-control" name="listening[]" placeholder="Listening" type="text">
                        <label>Listening</label>
                    </div>
                    <div class="col-xl-3 form-floating">
                        <input class="form-control" name="reading[]" placeholder="Reading" type="text">
                        <label>Reading</label>
                    </div>
                    <div class="col-xl-3 form-floating">
                        <input class="form-control" name="writing[]" placeholder="Writing" type="text">
                        <label>Writing</label>
                    </div>
                    <div class="col-xl-3 form-floating">
                        <input class="form-control" name="speaking[]" placeholder="Speaking" type="text">
                        <label>Speaking</label>
                    </div>
                </div>
            </div>
            <div class="row mb-2" id="more-exam-input" style="display: contents"></div>
            <button class="btn btn-primary col-1 mb-3" onclick="function addExam() {
            $('#exam_input_wrapper').clone().find('input').val('').end().appendTo('#more-exam-input');
            }
            addExam()" type="button">+
            </button>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>میزان دارایی</h6></div>
            </div>
            <div class="row mb-2">
                <div class="col d-flex flex-column">
                    <label>لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را اعلام
                        کنید</label>
                    <input id="asset_range" step="10000" class="form-control-range mt-2" dir="ltr" name="asset"
                           type="range" min="50000" max="1000000">
                </div>
                <div id="show_asset" class="mt-3" style="font-weight: bold"></div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col text-right"><h6>اطلاعات تکمیل کننده</h6></div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا اقوام درجه یک در کانادا دارید؟</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="has_immediate_family" type="radio"
                               value="0" onclick="function showImmediateFamily() {
            $('#immediate_family').show();
            }
            showImmediateFamily()">
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="has_immediate_family" type="radio"
                               value="1" onclick="function hideImmediateFamily() {
            $('#immediate_family').hide();
            }
            hideImmediateFamily()">
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3" id="immediate_family">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="immediate_family">
                        <option selected disabled>نسبت شخص</option>
                        <option value="parents">parents</option>
                        <option value="siblings">siblings</option>
                        <option value="cousins">cousins</option>
                        <option value="aunts/uncles">aunts/uncles</option>
                    </select>
                    <!--                    <input class="form-control" name="immediate_family" placeholder="نسبت شخص" type="text">-->
                    <!--                    <label>نسبت شخص</label>-->
                </div>
                <!--                <div class="col form-floating">-->
                <!--                    <input class="form-control" name="immediate_family_address" placeholder="محل زندگی شخص" type="text">-->
                <!--                    <label>محل زندگی شخص</label>-->
                <!--                </div>-->
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="immediate_family_address">
                        <option selected disabled>محل زندگی شخص</option>
                        <option value="Ontario">Ontario</option>
                        <option value="British Columbia">British Columbia</option>
                        <option value="Alberta">Alberta</option>
                        <option value="Saskatchewan">Saskatchewan</option>
                        <option value="Quebec">Quebec</option>
                        <option value="Manitoba">Manitoba</option>
                        <option value="New Brunswick">New Brunswick</option>
                        <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                        <option value="Nova Scotia">Nova Scotia</option>
                        <option value="Nunavut">Nunavut</option>
                        <option value="Prince Edward Island">Prince Edward Island</option>
                        <option value="Yukon">Yukon</option>
                        <option value="Northwest Territories">Northwest Territories</option>
                    </select>
                </div>

                <div class="row mb-3 mt-4">
                    <div class="col">
                        <label style="margin-left: 30px">آیا تاکنون برای هر یک از برنامه های مهاجرتی دائم یا موقت کانادا
                            اقدام کرده اید؟</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="attempt" type="radio"
                                   value="0" onclick="function showImmigrationProgram() {
            $('#immigration_program').show();
            }
            showImmigrationProgram()">
                            <label class="form-check-label" for="inlineRadio1">بله</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="attempt" type="radio"
                                   value="1" onclick="function hideImmigrationProgram() {
            $('#immigration_program').hide();
            }
            hideImmigrationProgram()">
                            <label class="form-check-label" for="inlineRadio2">خیر</label>
                        </div>
                    </div>
                </div>
                <div id="immigration_program">
                    <div class="row mb-1">
                        <div class="col">
<!--                            <input class="form-control" name="immigration_program" placeholder="نام برنامه" type="text">-->
                            <select class="form-select" aria-label="Default select example" name="immigration_program">
                                <option selected disabled>نام برنامه</option>
                                <option value="Express Entry">اکسپرس انتری</option>
                                <option value="Provincial nominees">برنامه های استانی</option>
                                <option value="Start-up Visa">استارتاپ</option>
                                <option value="Entrepreneurship">کارآفرینی</option>
                                <option value="Self-employed">خوداشتغالی</option>
                                <option value="Study permit">تحصیلی</option>
                                <option value="Work permit">کاری</option>
                                <option value="Sponsorship">اسپانسرشیپ</option>
                                <option value="Refugees">پناهندگی</option>
                                <option value="Other">سایر</option>
                            </select>
                        </div>
                        <div class="col">
                            <input data-jdp class="form-control" name="attempt_date" placeholder="تاریخ اقدام "
                                   type="text">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="attempt_result" placeholder="نتیجه اقدام"
                                      rows="3"></textarea>
                            <label>نتیجه اقدام</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
<!--                        <input class="form-control" name="fund"-->
<!--                               placeholder="میزان سرمایه مورد نظرتان برای هزینه مهاجرت چقدر است؟" type="text">-->
                        <select class="form-select" aria-label="Default select example" name="fund">
                            <option selected disabled>میزان سرمایه مورد نظرتان برای هزینه مهاجرت چقدر است؟</option>
                            <option value="5000-10000">بین 5000 تا 10000 دلار</option>
                            <option value="10000-20000">بین 10000 تا 20000 دلار</option>
                            <option value="20000-40000">بین 20000 تا 40000 دلار</option>
                        </select>
                    </div>
                </div>
            </div>
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
            <div id="spouse">
                <div class="row justify-content-center mb-2">
                    <div class="col text-center"><h5>اطلاعات همسر</h5></div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="row justify-content-start mb-2">
                        <div class="col text-right"><h6>اطلاعات هویتی</h6></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col form-floating">
                            <input class="form-control" name="spouse_name" placeholder="نام" type="text">
                            <label>نام</label>
                        </div>
                        <div class=" col-xl-3 form-floating">
                            <input class="form-control" name="spouse_lastname" placeholder="نام خانوادگی" type="text">
                            <label>نام خانوادگی</label>
                        </div>
                        <div class="col form-floating">
                            <input data-jdp class="form-control" name="spouse_birthday" placeholder="تاریخ تولد"
                                   type="text">
                            <label>تاریخ تولد </label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col form-floating">
                            <input class="form-control" name="spouse_country" placeholder="کشور محل سکونت" type="text">
                            <label>کشور محل سکونت</label>
                        </div>
                        <div class="col form-floating">
                            <input class="form-control" name="spouse_birthplace" placeholder="محل تولد" type="text">
                            <label>محل تولد</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <select onchange="yesnoCheckSpouse(this);" class="form-select" aria-label="Default select example" name="s_found_us_via">
                                <option selected disabled>نحوه آشنایی با شرکت</option>
                                <option value="representative">معرف</option>
                                <option value="Instagram">اینستاگرام</option>
                                <option value="Telegram">تلگرام</option>
                                <option value="Website">وب سایت</option>
                            </select>
                            <div id="s_ifYes" style="display: none;" class="mt-2">
                                <input class="form-control" type="text" id="car" name="s_nameOfRepresentative" placeholder="نام معرف"/>
                            </div>
                        </div>
                    </div>
                    <script>
                        function yesnoCheckSpouse(that) {
                            if (that.value === "representative") {
                                document.getElementById("s_ifYes").style.display = "block";
                            } else {
                                document.getElementById("s_ifYes").style.display = "none";
                            }
                        }
                    </script>
<!--                        <div class="col form-floating">-->
<!--                            <input class="form-control" name="s_found_us_via" placeholder="نحوه آشنایی با شرکت"-->
<!--                                   type="text">-->
<!--                            <label>نحوه آشنایی با شرکت</label>-->
<!--                        </div>-->
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="row justify-content-start mb-2">
                        <div class="col text-right"><h6>آخرین مدرک تحصیلی</h6></div>
                    </div>
                    <div class="row mb-1" id="s_education_input_wrapper">
                        <div class=" col-xl-3 form-floating">
                            <input class="form-control" name="spouse_degree" placeholder="مدرک تحصیلی" type="text">
                            <label>مدرک تحصیلی</label>
                        </div>
                        <div class=" col-xl-3 form-floating">
                            <input class="form-control" name="spouse_major" placeholder="رشته" type="text">
                            <label>رشته</label>
                        </div>
                        <div class="col-xl-3 form-floating">
                            <input class="form-control" name="spouse_school" placeholder="محل تحصیل" type="text">
                            <label>محل تحصیل</label>
                        </div>
                        <div class="col-xl-3 form-floating">
                            <input data-jdp class="form-control" name="spouse_graduated_at"
                                   placeholder="تاریخ فارغ التحصیلی"
                                   type="text">
                            <label>تاریخ فارغ التحصیلی</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده
                            است؟ </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="is_evaluated" type="radio"
                                   value="0" onclick="function showEvaluated() {
            $('#s_evaluation_info').show();
            }
            showEvaluated()">
                            <label class="form-check-label" for="inlineRadio1">بله</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="is_evaluated" type="radio"
                                   value="1" onclick="function hideEvaluated() {
            $('#s_evaluation_info').hide();
            }
            hideEvaluated()">
                            <label class="form-check-label" for="inlineRadio2">خیر</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2" id="s_evaluation_info">
                    <div class="col">
                        <select class="form-select" aria-label="Default select example" name="s_evaluated_by">
                            <option selected disabled>نام سازمان</option>
                            <option value="Comparative Education Service – University of Toronto School of Continuing Studies">Comparative Education Service – University of Toronto School of Continuing Studies</option>
                            <option value="International Credential Assessment Service of Canada">International Credential Assessment Service of Canada</option>
                            <option value="World Education Services">World Education Services</option>
                            <option value="International Qualifications Assessment Service (IQAS)">International Qualifications Assessment Service (IQAS)</option>
                            <option value="International Credential Evaluation Service – British Columbia Institute of Technology">International Credential Evaluation Service – British Columbia Institute of Technology</option>
                        </select>
                    </div>
                    <div class="col">
                        <input data-jdp class="form-control" name="s_evaluated_at" placeholder="تاریخ" type="text">
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="row justify-content-start mb-2">
                        <div class="col text-right"><h6>اطلاعات شغلی</h6></div>
                    </div>
                    <div class="row mb-1" id="s_job_input_wrapper">
                        <div class="col-xl-3 form-floating">
                            <input class="form-control" name="spouse_job_position[]" placeholder="سمت شغلی" type="text">
                            <label>سمت شغلی</label>
                        </div>
                        <div class="col-xl-3 form-floating">
                            <input class="form-control" name="spouse_company[]" placeholder="نام شرکت" type="text">
                            <label>نام شرکت</label>
                        </div>
                        <div class="col-xl-3 form-floating">
                            <input data-jdp class="form-control" name="spouse_job_start_date[]" placeholder="تاریخ شروع"
                                   type="text">
                            <label>تاریخ شروع</label>
                        </div>
                        <div class="col-xl-3 form-floating">
                            <input data-jdp class="form-control" name="spouse_job_end_date[]" placeholder="تاریخ پایان"
                                   type="text">
                            <label>تاریخ پایان</label>
                        </div>
                    </div>
                    <div class="row mb-2" id="s_more-job-input" style="display: contents"></div>
                    <button class="btn btn-primary col-1 mb-3" onclick="function addAdditionalJob() {
            $('#s_job_input_wrapper').clone().find('input').val('').end().appendTo('#s_more-job-input');
            }
            addAdditionalJob()" type="button">+
                    </button>

                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="row justify-content-start mb-2">
                        <div class="col text-right"><h6>سطح دانش زبان</h6></div>
                    </div>
                    <div class="row mb-1" id="s_exam_input_wrapper">
                        <div class="row mb-2">
                            <div class="col-xl-3">
                                <select class="form-select" aria-label="Default select example" name="spouse_exam_title[]">
                                    <option selected>نام مدرک زبان</option>
                                    <option value="IELTS">IELTS</option>
                                    <option value="TEF(Canada)">TEF(Canada)</option>
                                    <option value="CELPIP">CELPIP</option>
                                    <option value="TOEFL">TOEFL</option>
                                    <option value="Doulingo">Doulingo</option>
                                    <option value="PTE">PTE</option>
                                </select>
                                <!--                    <input class="form-control" name="exam_title[]" placeholder="نام مدرک زبان" type="text">-->
                                <!--                    <label>نام مدرک زبان</label>-->
                            </div>
                            <div class="col">
                                <select class="form-select" aria-label="Default select example" name="spouse_exam_type[]">
                                    <option selected>نوع مدرک</option>
                                    <option value="General">General</option>
                                    <option value="Academic">Academic</option>
                                </select>
                                <!--                    <input class="form-control" name="exam_type[]" placeholder="نوع مدرک" type="text">-->
                                <!--                    <label>نوع مدرک</label>-->
                            </div>
                            <div class="col">
                                <input data-jdp class="form-control" name="spouse_exam_date[]" placeholder="تاریخ امتحان" type="text">
                            </div>
                            <!--                <div class="col-xl-3 form-floating">-->
                            <!--                    <input class="form-control" name="score[]" placeholder="نمره" type="text">-->
                            <!--                    <label>نمره</label>-->
                            <!--                </div>-->
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 form-floating">
                                <input class="form-control" name="spouse_listening[]" placeholder="Listening" type="text">
                                <label>Listening</label>
                            </div>
                            <div class="col-xl-3 form-floating">
                                <input class="form-control" name="spouse_reading[]" placeholder="Reading" type="text">
                                <label>Reading</label>
                            </div>
                            <div class="col-xl-3 form-floating">
                                <input class="form-control" name="spouse_writing[]" placeholder="Writing" type="text">
                                <label>Writing</label>
                            </div>
                            <div class="col-xl-3 form-floating">
                                <input class="form-control" name="spouse_speaking[]" placeholder="Speaking" type="text">
                                <label>Speaking</label>
                            </div>
                        </div>
                    <div class="row mb-2" id="s_more-exam-input" style="display: contents"></div>
                    <button class="btn btn-primary col-1 mb-3" onclick="function addAdditionalExam() {
            $('#s_exam_input_wrapper').clone().find('input').val('').end().appendTo('#s_more-exam-input');
            }
            addAdditionalExam()" type="button">+
                    </button>
                </div>
                <hr>
                <div class="row justify-content-start mb-2">
                    <div class="col text-right"><h6>میزان دارایی</h6></div>
                </div>
                <div class="row mb-3">
                    <div class="col d-flex flex-column">
                        <label>لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را
                            اعلام
                            کنید</label>
                        <input id="s_asset_range" step="10000" class="form-control-range mt-2" dir="ltr"
                               name="spouse_asset" type="range" min="50000" max="1000000">
                    </div>
                    <div id="s_show_asset" style="font-weight: bold" class="mt-3"></div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col text-center"><h5>مشخصات فرزندان</h5></div>
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="row mb-2 children-input-wrapper" id="children-input-wrapper">
                    <div class="col form-floating">
                        <input class="form-control" name="child_name[]" placeholder="نام فرزند" type="text">
                        <label>نام فرزند</label>
                    </div>
                    <div class="col form-floating">
                        <input data-jdp class="form-control" name="child_birthday[]" placeholder="تاریخ تولد"
                               type="text">
                        <label>تاریخ تولد </label>
                    </div>

                </div>
                <div class="row mb-2" id="more-children-input" style="display: contents"></div>
                <button class="btn btn-primary col-1 mb-3" onclick="function addChild() {
            $('#children-input-wrapper').clone().find('input').val('').end().appendTo('#more-children-input');
            }
            addChild()" type="button">+
                </button>
            </div>
<!---->
<!--            <div class="row mb-3 mt-6">-->
<!--                <div class="form-floating">-->
<!--                    <textarea class="form-control" name="note" placeholder="نوت مشاور" rows="3"></textarea>-->
<!--                    <label>نوت مشاور</label>-->
<!--                </div>-->
<!--            </div>-->
            <div class="row justify-content-center mb-5">
                <button class="col col-6 btn btn-primary" type="submit" name="submit_button">ثبت</button>
            </div>

    </form>
</div>
<script type="text/javascript" src="./dist/jalalidatepicker.min.js"></script>
<script>
    jalaliDatepicker.startWatch({
        separatorChars: {date: "-", between: " ", time: ":"},
        dayRendering: function (dayOptions, input) {
            return {
                isHollyDay: dayOptions.month === 1 && dayOptions.day <= 4,
                // isValid = false, امکان غیر فعال کردن روز
                // className = "nowruz" امکان افزودن کلاس برای درج استایل به روز
            }
        }
    })
</script>
<script>
    var asset = document.getElementById("asset_range");
    var assetValue = document.getElementById("show_asset");
    assetValue.innerHTML = asset.value + "  دلار کانادا";
    asset.oninput = function () {
        assetValue.innerHTML = this.value + "  دلار کانادا";
    }
    var spouseAsset = document.getElementById("s_asset_range");
    var spouseAssetValue = document.getElementById("s_show_asset");
    spouseAssetValue.innerHTML = spouseAsset.value + "  دلار کانادا";
    spouseAsset.oninput = function () {
        spouseAssetValue.innerHTML = this.value + "  دلار کانادا";
    }
</script>
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
