<?php
include_once 'main.php';

if(!checkSession()) {
	header('Location: index.php');
}
else if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
    header('Location: index.php');
}
else {
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone']) && isset($_POST['email_address']) && isset($_POST['creditcard_number'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $phone = trim($_POST['phone']);
        $email_address = trim($_POST['email_address']);
        $creditcard_number = trim($_POST['creditcard_number']);

        $error_msg = '';

        if ($first_name == '') {
            $error_msg .= 'First name is required.<br />';
        }

        if ($last_name == '') {
            $error_msg .= 'Last name is required.<br />';
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
        else if (emailExists($email_address, $_SESSION['user_id'])) {
            $error_msg .= 'Email Address is already registered.<br />';
        }

        if ($creditcard_number == '') {
            $error_msg .= 'Credit Card Number is required.<br />';
        }
        
        if ($error_msg == '') {
            if(updateUser($first_name, $last_name, $phone, $email_address, $creditcard_number, $_SESSION['user_id'])) {
                $_SESSION['user_first_name'] = $first_name;
                $_SESSION['user_last_name'] = $last_name;
                $_SESSION['success_msg'] = 'Profile updated successfully.';
                header('Location: profile.php');
            }
            else {
                $error_msg = 'Failed to update profile.';
                $user = getUser($_SESSION['user_id']);
                $user_id = $user['user_id'];
                include_once 'views/profile_view.php';
            }
        }
        else {
            $user = getUser($_SESSION['user_id']);
            $user_id = $user['user_id'];
            include_once 'views/profile_view.php';
        }
    }
    else {
        $user = getUser($_SESSION['user_id']);
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $user_id = $user['user_id'];
        $phone = $user['phone'];
        $email_address = $user['email_address'];
        $creditcard_number = $user['creditcard_number'];

        include_once 'views/profile_view.php';
    }
}