<?php
$conn = new mysqli('localhost', 'root', '', 'immigration_required_info');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customers WHERE id = '" . $id . "'";
    $result = $conn->query($sql);
    $customer_data = $result->fetch_assoc();
    $address = explode("|", $customer_data['address']);
    
    $sql = "SELECT * FROM 101_education WHERE customer_id = '" . $id . "'";
    $result = $conn->query($sql);
    $education_data = $result->fetch_all(MYSQLI_ASSOC);
    
    $sql = "SELECT * FROM 101_job WHERE customer_id = '" . $id . "'";
    $result = $conn->query($sql);
    $work_experience_data = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM IELTS WHERE cid = '" . $id . "'";
    $result = $conn->query($sql);
    $language_proficiency_data = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM additional_info WHERE cid = '" . $id . "'";
    $result = $conn->query($sql);
    $additional_info = $result->fetch_assoc();

    $sql = "SELECT * FROM 101_closeFamily WHERE customer_id = '" . $id . "'";
    $result = $conn->query($sql);
    $children_data = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM note WHERE customer_id = '" . $id . "'";
    $result = $conn->query($sql);
    $note = $result->fetch_assoc();

    $sql = "SELECT * FROM customers WHERE is_married_to = '" . $id . "'";
    $result = $conn->query($sql);
    $spouse_data = $result->fetch_assoc();
    $spouse_id = $spouse_data['id'];

    $sql = "SELECT * FROM additional_info WHERE cid = '" . $spouse_id . "'";
    $result = $conn->query($sql);
    $s_additional_info = $result->fetch_assoc();

    $sql = "SELECT * FROM 101_education WHERE customer_id = '" . $spouse_id . "'";
    $result = $conn->query($sql);
    $s_education_data = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM 101_job WHERE customer_id = '" . $spouse_id . "'";
    $result = $conn->query($sql);
    $s_work_experience_data = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT * FROM IELTS WHERE cid = '" . $spouse_id . "'";
    $result = $conn->query($sql);
    $s_language_proficiency_data = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>immigration required info form</title>
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
            <div class="col col-4 text-center"><h4>فرم اطلاعات مورد نیاز مهاجرت</h4></div>
        </div>
        <hr>

        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات هویتی</h6></div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled aria-label="Name" class="form-control" name="name" placeholder="نام"
                           type="text" value="<?= $customer_data['name'] ?>">
                    <label>نام</label>
                </div>
                <div class="col form-floating">
                    <input disabled aria-label="Name" class="form-control" name="lastname" placeholder="نام خانوادگی"
                           type="text" value="<?= $customer_data['family_name'] ?>">
                    <label>نام خانوادگی</label>
                </div>
                <div class="col form-floating">
                    <input disabled aria-label="Birthday" class="form-control" name="birthday"
                           placeholder="تاریخ تولد(مثلا 01-01-1400)"
                           type="text" value="<?= $customer_data['birthday'] ?>">
                    <label>تاریخ تولد (به این شکل 01-01-1360)</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled aria-label="phone number" class="form-control" name="phone_number"
                           placeholder="شماره تماس"
                           type="text" value="<?= $customer_data['mobile'] ?>">
                    <label>شماره تماس</label>
                </div>
                <div class="col form-floating">
                    <input disabled aria-label="Email" class="form-control" name="email" placeholder="ایمیل" type="text"
                           value="<?= $customer_data['email'] ?>">
                    <label>ایمیل</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="form-floating">
                    <textarea class="form-control" name="address" placeholder="آدرس" rows="3"
                              disabled><?= $address[1] ?></textarea>
                    <label>آدرس</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="country" placeholder="کشور محل سکونت" type="text"
                           value="<?= $address[0] ?>">
                    <label>کشور محل سکونت</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="birthplace" placeholder="محل تولد" type="text"
                           value="<?= $customer_data['birthplace'] ?>">
                    <label>محل تولد</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="found_us_via" placeholder="نحوه آشنایی با شرکت"
                           type="text" value="<?= $additional_info['found_us_via'] ?>">
                    <label>نحوه آشنایی با شرکت</label>
                </div>
            </div>
            <div class="row mb-2 mt-4 d-flex">
                <div class="col">
                    <label style="margin-left: 30px">وضعیت تاهل</label>
                    <?php if ($customer_data['marriage'] == 1) { ?>
                        <div class="form-check form-check-inline">
                            <input disabled class="form-check-input" id="inlineRadio1" name="marital_status"
                                   type="radio"
                                   value="0" checked>
                            <label class="form-check-label" for="inlineRadio1">مجرد</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled class="form-check-input" id="inlineRadio2" name="marital_status"
                                   type="radio"
                                   value="1">
                            <label class="form-check-label" for="inlineRadio2">متاهل</label>
                        </div>
                    <?php } elseif ($customer_data['marriage'] == 0) { ?>
                        <div class="form-check form-check-inline">
                            <input disabled class="form-check-input" id="inlineRadio1" name="marital_status"
                                   type="radio"
                                   value="0">
                            <label class="form-check-label" for="inlineRadio1">مجرد</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled class="form-check-input" id="inlineRadio2" name="marital_status"
                                   type="radio"
                                   value="1" checked>
                            <label class="form-check-label" for="inlineRadio2">متاهل</label>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات تحصیلی</h6></div>
            </div>
            <?php
            foreach ($education_data as $item) {
                echo '<div class="row mb-3" id="education_wrapper">
                <div class="col form-floating">
                    <input disabled class="form-control" name="degree[]" placeholder="مدرک تحصیلی" type="text" value="' . $item['position'] . '">
                    <label>مدرک تحصیلی</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="major[]" placeholder="رشته" type="text" value="' . $item['major'] . '">
                    <label>رشته</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="school[]" placeholder="محل تحصیل" type="text" value="' . $item['insitute'] . '">
                    <label>محل تحصیل</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="graduated_at[]" placeholder="تاریخ فارغ التحصیلی" type="text" value="' . $item['end_date'] . '">
                    <label>تاریخ فارغ التحصیلی</label>
                </div>
            </div>';
            }
            ?>
            <?php
            if ($additional_info['documents_evaluated_by']) {
                echo
                    '<div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده است؟ </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="0" checked disabled>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="1" disabled>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>

                </div>
            </div>
            <div class="row mb-2">
                <div class="col form-floating">
                    <input disabled class="form-control" name="evaluated_by" placeholder="نام سازمان" type="text" value="' . $additional_info['documents_evaluated_by'] . '">
                    <label>نام سازمان</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="evaluated_at" placeholder="تاریخ" type="text" value="' . $additional_info['documents_evaluated_at'] . '">
                    <label>تاریخ (به این شکل 01-01-1360)</label>
                </div>
            </div>';
            } else {
                echo
                '<div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده است؟ </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="0" checked disabled>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="1" checked disabled>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>

                </div>
            </div>
            ';
            }
            ?>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات شغلی</h6></div>
            </div>
            <?php
            foreach ($work_experience_data as $item) {
                echo '<div class="row mb-1" id="work_experience_input_wrapper">
                <div class="col form-floating">
                    <input disabled class="form-control" name="job_position[]" placeholder="سمت شغلی" type="text" value="' . $item['typeOf'] . '">
                    <label>سمت شغلی</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="company[]" placeholder="نام شرکت" type="text" value="' . $item['institue'] . '">
                    <label>نام شرکت</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="job_start_date[]" placeholder="تاریخ شروع" type="text" value="' . $item['start_date'] . '">
                    <label>تاریخ شروع</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="job_end_date[]" placeholder="تاریخ پایان" type="text" value="' . $item['end_date'] . '">
                    <label>تاریخ پایان</label>
                </div>
            </div>';
            }
            ?>

        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>سطح دانش زبان</h6></div>
            </div>
            <?php
            foreach ($language_proficiency_data as $item) {
                echo
                    '<div class="row mb-1" id = "exam_input_wrapper" >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "exam_title[]" placeholder = "نام مدرک زبان" type = "text" value="' . $item['title'] . '">
                    <label > نام مدرک زبان </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "exam_type[]" placeholder = "نوع مدرک" type = "text" value="' . $item['type'] . '">
                    <label > نوع مدرک </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "exam_date[]" placeholder = "تاریخ امتحان" type = "text" value="' . $item['issue_date'] . '">
                    <label > تاریخ امتحان </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "score[]" placeholder = "نمره" type = "number" value="' . $item['overall'] . '">
                    <label > نمره</label >
                </div >
            </div >';
            } ?>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>میزان دارایی</h6></div>
            </div>
            <div class="row mb-2">
                <div class="col form-floating">
                    <input disabled class="form-control" name="asset"
                           placeholder="لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را اعلام کنید"
                           type="number" value="<?= $additional_info['asset'] ?>">
                    <label>لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را اعلام
                        کنید</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات تکمیل کننده</h6></div>
            </div>
            <?php
            if ($additional_info['immediate_family']) {
                echo '
            <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا اقوام درجه یک در کانادا دارید؟</label>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="has_immediate_family" type="radio"
                               value="0" checked>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="has_immediate_family" type="radio"
                               value="1">
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col form-floating">
                    <input disabled class="form-control" name="immediate_family" placeholder="نسبت شخص" type="text" value="' . $additional_info['immediate_family'] . '">
                    <label>نسبت شخص</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="immediate_family_address" placeholder="محل زندگی شخص"
                           type="text" value="' . $additional_info['immediate_family_address'] . '">
                    <label>محل زندگی شخص</label>
                </div>
            </div>
                    ';
            } else {
                echo '
                <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا اقوام درجه یک در کانادا دارید؟</label>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="has_immediate_family" type="radio"
                               value="0">
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="has_immediate_family" type="radio"
                               value="1" checked>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>
                </div>
            </div>
                ';
            }
            ?>
            <?php
            if ($additional_info['immigration_program']){
                echo '
            <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا تاکنون برای هر یک از برنامه های مهاجرتی دائم یا موقت کانادا
                        اقدام کرده اید؟</label>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="attempt" type="radio"
                               value="0" checked>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="attempt" type="radio"
                               value="1">
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="immigration_program" placeholder="نام برنامه"
                           type="text" value="' . $additional_info['immigration_program'] . '">
                    <label>نام برنامه</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="attempt_date"
                           placeholder="تاریخ اقدام (به این شکل 01-01-1360)"
                           type="text" value="' . $additional_info['attempt_date'] . '">
                    <label>تاریخ اقدام (به این شکل 01-01-1360)</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-floating">
                    <textarea class="form-control" name="attempt_result" placeholder="نتیجه اقدام" rows="3"
                              disabled>'.$additional_info['attempt_result'].'</textarea>
                    <label>نتیجه اقدام</label>
                </div>
            </div>
                ';
            }else{
                echo '
                <div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا تاکنون برای هر یک از برنامه های مهاجرتی دائم یا موقت کانادا
                        اقدام کرده اید؟</label>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="attempt" type="radio"
                               value="0">
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" name="attempt" type="radio"
                               value="1" checked>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>
                </div>
            </div>
                ';
            }
            ?>
            <div class="row mb-5">
                <div class="col form-floating">
                    <input disabled class="form-control" name="fund"
                           placeholder="میزان سرمایه مورد نظرتان برای هزینه مهاجرت چقدر است؟" type="number"
                           value="<?= $additional_info['fund'] ?>">
                    <label>میزان سرمایه مورد نظرتان برای هزینه مهاجرت چقدر است؟</label>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-2">
            <div class="col col-3 text-center"><h5>اطلاعات همسر</h5></div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات هویتی</h6></div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_name" placeholder="نام" type="text" value="<?= $spouse_data['name'] ?>">
                    <label>نام</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_lastname" placeholder="نام خانوادگی" type="text" value="<?= $spouse_data['family_name'] ?>">
                    <label>نام خانوادگی</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_birthday"
                           placeholder="تاریخ تولد (به این شکل 01-01-1360)"
                           type="text" value="<?= $spouse_data['birthday'] ?>">
                    <label>تاریخ تولد (به این شکل 01-01-1360)</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_country" placeholder="کشور محل سکونت" type="text" value="<?= $spouse_data['address'] ?>">
                    <label>کشور محل سکونت</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_birthplace" placeholder="محل تولد" type="text" value="<?= $spouse_data['birthplace'] ?>">
                    <label>محل تولد</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col form-floating">
                    <input disabled class="form-control" name="s_found_us_via" placeholder="نحوه آشنایی با شرکت"
                           type="text" value="<?= $s_additional_info['found_us_via'] ?>">
                    <label>نحوه آشنایی با شرکت</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات تحصیلی</h6></div>
            </div>
            <?php
            foreach ($s_education_data as $item) {
                echo '<div class="row mb-3" id="s_education_input_wrapper">
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_degree[]" placeholder="مدرک تحصیلی" type="text" value="' . $item['position'] . '">
                    <label>مدرک تحصیلی</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_major[]" placeholder="رشته" type="text" value="' . $item['major'] . '">
                    <label>رشته</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_school[]" placeholder="محل تحصیل" type="text" value="' . $item['insitute'] . '">
                    <label>محل تحصیل</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_graduated_at[]" placeholder="تاریخ فارغ التحصیلی" type="text" value="' . $item['end_date'] . '">
                    <label>تاریخ فارغ التحصیلی</label>
                </div>
            </div>';
            }
            ?>
            <?php
            if ($s_additional_info['documents_evaluated_by']) {
                echo
                    '<div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده است؟ </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="0" checked disabled>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="1" disabled>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>

                </div>
            </div>
            <div class="row mb-2">
                <div class="col form-floating">
                    <input disabled class="form-control" name="s_evaluated_by" placeholder="نام سازمان" type="text" value="' . $s_additional_info['documents_evaluated_by'] . '">
                    <label>نام سازمان</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="s_evaluated_at" placeholder="تاریخ" type="text" value="' . $s_additional_info['documents_evaluated_at'] . '">
                    <label>تاریخ (به این شکل 01-01-1360)</label>
                </div>
            </div>';
            } else {
                echo
                '<div class="row mb-3">
                <div class="col">
                    <label style="margin-left: 30px">آیا مدرک شما در کانادا در پنج سال اخیر ارزیابی شده است؟ </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="0" checked disabled>
                        <label class="form-check-label" for="inlineRadio1">بله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="is_evaluated" type="radio"
                               value="1" checked disabled>
                        <label class="form-check-label" for="inlineRadio2">خیر</label>
                    </div>

                </div>
            </div>
            ';
            }
            ?>

        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>اطلاعات شغلی</h6></div>
            </div>
            <?php
            foreach ($s_work_experience_data as $item) {
                echo '<div class="row mb-1" id="s_work_experience_input_wrapper">
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_job_position[]" placeholder="سمت شغلی" type="text" value="' . $item['typeOf'] . '">
                    <label>سمت شغلی</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_company[]" placeholder="نام شرکت" type="text" value="' . $item['institue'] . '">
                    <label>نام شرکت</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_job_start_date[]" placeholder="تاریخ شروع" type="text" value="' . $item['start_date'] . '">
                    <label>تاریخ شروع</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="spouse_job_end_date[]" placeholder="تاریخ پایان" type="text" value="' . $item['end_date'] . '">
                    <label>تاریخ پایان</label>
                </div>
            </div>';
            }
            ?>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row justify-content-start mb-2">
                <div class="col col-2 text-right"><h6>سطح دانش زبان</h6></div>
            </div>
            <?php
            foreach ($s_language_proficiency_data as $item) {
                echo
                    '<div class="row mb-1" id = "s_exam_input_wrapper" >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "spouse_exam_title[]" placeholder = "نام مدرک زبان" type = "text" value="' . $item['title'] . '">
                    <label > نام مدرک زبان </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "spouse_exam_type[]" placeholder = "نوع مدرک" type = "text" value="' . $item['type'] . '">
                    <label > نوع مدرک </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "spouse_exam_date[]" placeholder = "تاریخ امتحان" type = "text" value="' . $item['issue_date'] . '">
                    <label > تاریخ امتحان </label >
                </div >
                <div class="col form-floating" >
                    <input disabled class="form-control" name = "spouse_score[]" placeholder = "نمره" type = "number" value="' . $item['overall'] . '">
                    <label > نمره</label >
                </div >
            </div >';
            } ?>
        </div>
        <hr>
        <div class="row justify-content-start mb-2">
            <div class="col col-2 text-right"><h6>میزان دارایی</h6></div>
        </div>
        <div class="row mb-3">
            <div class="col form-floating">
                <input disabled class="form-control" name="spouse_asset"
                       placeholder="لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را اعلام کنید"
                       type="number" value="<?= $s_additional_info['asset'] ?>">
                <label>لطفا میزان دارایی خود را از عددی بین 50 هزار دلار کانادا تا یک میلیون دلار کانادا را اعلام
                    کنید</label>
            </div>
        </div>
        <div class="row justify-content-center mb-2">
            <div class="col col-3 text-center"><h5>مشخصات فرزندان</h5></div>
        </div>
        <hr>
            <?php
            foreach ($children_data as $item) {
            echo'
            <div class="row justify-content-center">
            <div class="row mb-2 children-input-wrapper" id="children-input-wrapper">
                <div class="col form-floating">
                    <input disabled class="form-control" name="child_name[]" placeholder="نام فرزند" type="text" value="' . $item['fullname'] . '">
                    <label>نام فرزند</label>
                </div>
                <div class="col form-floating">
                    <input disabled class="form-control" name="child_birthday[]" placeholder="تاریخ تولد" type="text" value="' . $item['birthday'] . '">
                    <label>تاریخ تولد (به این شکل 01-01-1360)</label>
                </div>

            </div>
            <div class="row mb-2" id="more-children-input" style="display: contents"></div>
        </div>';
            }
            ?>
        <div class="row mb-3 mt-6">
            <div class="form-floating">
                <textarea class="form-control" name="note" placeholder="نوت مشاور" disabled rows="3"><?= $note['text'] ?></textarea>
                <label>نوت مشاور</label>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <button class="col col-6 btn btn-primary" type="submit" name="submit_button">ثبت و ارسال نوت</button>
        </div>

    </form>
</div>
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
