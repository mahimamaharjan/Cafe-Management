<?php
include_once 'main.php';

if(!checkSession()) {
	header('Location: index.php');
}
else if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
    header('Location: index.php');
}
else {
    if(isset($_POST['amount']) && isset($_POST['password'])) {
        $amount = trim($_POST['amount']);
        $password = $_POST['password'];

        $error_msg = '';

        if ($amount == '') {
            $error_msg .= 'Amount is required.<br />';
        }
        else if(!is_numeric($amount) || +$amount <= 0) {
            $error_msg .= 'Amount is invalid.<br />';   
        }

        if ($password == '') {
            $error_msg .= 'Password is required.<br />';
        }
        else if(!checkPassword($_SESSION['user_id'], $password)) {
        	$error_msg .= 'Password is incorrect.<br />';
        }
        
        if ($error_msg == '') {
            if(depositFund($_SESSION['user_id'], $amount)) {
                $_SESSION['success_msg'] = 'Fund deposited successfully.';
                header('Location: deposit_fund.php');
            }
            else {
                $error_msg = 'Failed to deposit fund.';
                $balance = getUserBalance($_SESSION['user_id']);
                include_once 'views/deposit_fund_view.php';
            }
        }
        else {
            $balance = getUserBalance($_SESSION['user_id']);
            include_once 'views/deposit_fund_view.php';
        }
    }
    else {
        $balance = getUserBalance($_SESSION['user_id']);

        include_once 'views/deposit_fund_view.php';
    }
}