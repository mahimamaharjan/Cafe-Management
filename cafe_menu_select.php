<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
	if(isset($_POST['cafe']) && isset($_POST['date'])) {
		$cafe_id = trim($_POST['cafe']);
    	$date = trim($_POST['date']);

    	$error_msg = '';

    	if ($cafe_id == '') {
	        $error_msg .= 'Cafe is required.<br />';
	    }

	    if ($date == '') {
            $error_msg .= 'Date is required.<br />';
        }
        else if(!checkDateFormat($date)) {
            $error_msg .= 'Date is invalid.<br />';   
        }

        if ($error_msg == '') {
        	header('Location: cafe_menu.php?cafe=' . $cafe_id . '&date=' . $date);
        }
        else {
        	$cafe_list = getAllCafeList();
			include_once 'views/cafe_menu_select_view.php';
        }
	}
	else {
		$cafe_list = getAllCafeList();
		include_once 'views/cafe_menu_select_view.php';
	}
}