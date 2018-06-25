<?php
include_once 'main.php';

if(!checkSession()) {
	header('Location: index.php');
}
else {
    if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
        header('Location: index.php');
    }

	if(isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $error_msg = '';

        if ($current_password == '') {
            $error_msg .= 'Current Password is required.<br />';
        }
        else if(!checkPassword($_SESSION['user_id'], $current_password)) {
        	$error_msg .= 'Current Password is incorrect.<br />';
        }

        if ($new_password == '') {
            $error_msg .= 'New Password is required.<br />';
        }
        else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!#\$]).{6,12}$/', $new_password)) {
            $error_msg .= 'New Password must be 6 - 12 characters in length containing at least 1 lowercase letter, 1 uppercase letter, 1 number and one of the following special characters ~ ! # $.<br />';
        }

        if ($confirm_new_password == '') {
            $error_msg .= 'New Password Confirmation is required.<br />';
        }

        if ($new_password && $confirm_new_password && $new_password != $confirm_new_password) {
            $error_msg .= 'New Passwords do not match.<br />';
        }
        
        if ($error_msg == '') {
            if(changePassword($_SESSION['user_id'], $new_password)) {
                $_SESSION['success_msg'] = 'Password changed successfully.';
                header('Location: change_password.php');
            }
            else {
                $error_msg = 'Failed to change password';
                include_once 'views/change_password_view.php';
            }
        }
        else {
            include_once 'views/change_password_view.php';
        }
    }
    else {
        include_once 'views/change_password_view.php';
    }
}