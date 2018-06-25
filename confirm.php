<?php
include_once 'main.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$code = isset($_GET['code']) ? $_GET['code'] : '';

if($id && $code && ($user = getUser($id)) && !$user['is_confirmed']) {
	if($user['confirmation_code'] == $code && confirmUser($id)) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['user_first_name'] = $user['first_name'];
        $_SESSION['user_last_name'] = $user['last_name'];
        $_SESSION['user_type'] = $user['type'];
        $_SESSION['user_cafe_id'] = $user['cafe_id'];
		$_SESSION['user_is_confirmed'] = true;

		$success_msg = 'Your email address has been confirmed successfully.';
	}
	else {
		$error_msg = 'Failed to confirm email address.';	
	}
}
else {
	$error_msg = 'Invalid Verification Link';
}

include_once 'views/confirm_view.php';