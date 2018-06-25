<?php
include_once 'main.php';

if (checkSession()) {
    header('Location: index.php');
}
else {
    if (isset($_POST['email_address']) && isset($_POST['password'])) {
        $email_address = trim($_POST['email_address']);
        $password = $_POST['password'];

        if ($email_address == '' || $password == '') {
            $error_msg = 'Please enter email address/user id and password.';
            include_once 'views/login_view.php';
        }
        else if ($array = login($email_address, $password)) {
            $_SESSION['user_id'] = $array['id'];
			$_SESSION['user_first_name'] = $array['first_name'];
            $_SESSION['user_last_name'] = $array['last_name'];
            $_SESSION['user_type'] = $array['type'];
            $_SESSION['user_cafe_id'] = $array['cafe_id'];
            $_SESSION['user_is_confirmed'] = $array['is_confirmed'];
            
            header('Location: index.php');
        }
        else {
            $error_msg = 'Invalid email address, user id or password.';
            include_once 'views/login_view.php';
        }
    }
    else {
        include_once 'views/login_view.php';
    }
}