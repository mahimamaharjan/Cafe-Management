<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'cafe_manager') {
	header('Location: index.php');
}
else {
	if(isset($_POST['date'])) {
    	$date = trim($_POST['date']);

    	$error_msg = '';

	    if ($date == '') {
            $error_msg .= 'Date is required.<br />';
        }
        else if(!checkDateFormat($date)) {
            $error_msg .= 'Date is invalid.<br />';   
        }

        if ($error_msg == '') {
        	header('Location: my_cafe_menu.php?date=' . $date);
        }
        else {
			include_once 'views/my_cafe_menu_select_view.php';
        }
	}
	else {
		include_once 'views/my_cafe_menu_select_view.php';
	}
}