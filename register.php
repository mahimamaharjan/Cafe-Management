<?php
include_once 'main.php';

if (checkSession()) {
    header('Location: index.php');
}
else {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['student_staff_id']) && isset($_POST['phone']) && isset($_POST['email_address']) && isset($_POST['creditcard_number']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $student_staff_id = trim($_POST['student_staff_id']);
        $phone = trim($_POST['phone']);
        $email_address = trim($_POST['email_address']);
        $creditcard_number = trim($_POST['creditcard_number']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $error_msg = '';

        if ($first_name == '') {
            $error_msg .= 'First name is required.<br />';
        }

        if ($last_name == '') {
            $error_msg .= 'Last name is required.<br />';
        }

        if ($student_staff_id == '') {
            $error_msg .= 'Student/Staff Id is required.<br />';
        }
        else if(!preg_match('/^U[SE]\d{4}$/i', $student_staff_id)) {
            $error_msg .= 'Student/Staff Id is invalid.<br />';
        }
        else if (userIdExists($student_staff_id)) {
            $error_msg .= 'Student/Staff Id is already registered.<br />';
        }

        if ($phone == '') {
            $error_msg .= 'Phone is required.<br />';
        }

        if ($email_address == '') {
            $error_msg .= 'Email Address is required.<br />';
        }
        else if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $error_msg .= 'Email Address is invalid.<br />';
        }
        else if (emailExists($email_address)) {
            $error_msg .= 'Email Address is already registered.<br />';
        }

        if ($creditcard_number == '') {
            $error_msg .= 'Credit Card Number is required.<br />';
        }

        if ($password == '') {
            $error_msg .= 'Password is required.<br />';
        }
        else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!#\$]).{6,12}$/', $password)) {
            $error_msg .= 'Password must be 6 - 12 characters in length containing at least 1 lowercase letter, 1 uppercase letter, 1 number and one of the following special characters ~ ! # $.<br />';
        }

        if ($confirm_password == '') {
            $error_msg .= 'Password Confirmation is required.<br />';
        }

        if ($password && $confirm_password && $password != $confirm_password) {
            $error_msg .= 'Passwords do not match.<br />';
        }

        if ($error_msg == '') {
            $type = preg_match('/^US/i', $student_staff_id) ? 'student' : 'employee';
            $confirmation_code = md5(date('Y-m-d H:i:s') . rand('111111', '999999'));
            if ($id = register($first_name, $last_name, $student_staff_id, $phone, $email_address, $creditcard_number, $password, $type, $confirmation_code)) {
                $link = 'http://localhost/yeom/confirm.php?id=' . $id . '&code=' . $confirmation_code;
                // sendConfirmationEmail($first_name, $last_name, $email_address, $link);
                
                $_SESSION['user_id'] = $id;
                $_SESSION['user_first_name'] = $first_name;
                $_SESSION['user_last_name'] = $last_name;
                $_SESSION['user_type'] = $type;
                $_SESSION['user_cafe_id'] = null;
                $_SESSION['user_is_confirmed'] = true;

                header('Location: index.php');
            }
            else {
                $error_msg = 'Registration failed. An error occurred.';
            }
        }
        else {
            include_once 'views/register_view.php';
        }
    }
    else {
        include_once 'views/register_view.php';
    }
}