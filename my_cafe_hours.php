<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'cafe_manager') {
	header('Location: index.php');
}
else {
	if(isset($_POST['opening_hh']) && isset($_POST['opening_mm']) && isset($_POST['opening_tt']) && isset($_POST['closing_hh']) && isset($_POST['closing_mm']) && isset($_POST['closing_tt'])) {
        $opening_hh = trim($_POST['opening_hh']);
        $opening_mm = trim($_POST['opening_mm']);
        $opening_tt = trim($_POST['opening_tt']);
        $closing_hh = trim($_POST['closing_hh']);
        $closing_mm = trim($_POST['closing_mm']);
        $closing_tt = trim($_POST['closing_tt']);
        $opening_time = '';
        $closing_time = '';

        $error_msg = '';

        if(!$opening_hh || !$opening_mm || !$opening_tt) {
            $error_msg .= 'Opening Time is required.<br/>';
        }
        else {
            $opening_time = get24HourFormat($opening_hh, $opening_mm, $opening_tt);
        }

        if(!$closing_hh || !$closing_mm || !$closing_tt) {
            $error_msg .= 'Closing Time is required.<br/>';
        }
        else {
            $closing_time = get24HourFormat($closing_hh, $closing_mm, $closing_tt);
        }
        
        if ($error_msg == '') {
            if(updateCafeHours($opening_time, $closing_time, $_SESSION['user_cafe_id'])) {
                $_SESSION['success_msg'] = 'My cafe hours updated successfully.';
                header('Location: my_cafe_hours.php');
            }
            else {
                $error_msg = 'Failed to update my cafe hours.';
                $hh_list = getHHList();
                $mm_list = getMMList();
                $tt_list = getTTList();
                include_once 'views/my_cafe_hours_view.php';
            }
        }
        else {
            $hh_list = getHHList();
            $mm_list = getMMList();
            $tt_list = getTTList();
            include_once 'views/my_cafe_hours_view.php';
        }
    }
    else {
    	$cafe = getCafe($_SESSION['user_cafe_id']);
        $opening_time = $cafe['opening_time'];
        $closing_time = $cafe['closing_time'];

        if($opening_time) {
            $t = getHHMMTT($opening_time);
            $opening_hh = $t[0];
            $opening_mm = $t[1];
            $opening_tt = $t[2];
        }

        if($closing_time) {
            $t = getHHMMTT($closing_time);
            $closing_hh = $t[0];
            $closing_mm = $t[1];
            $closing_tt = $t[2];
        }
        
        $hh_list = getHHList();
        $mm_list = getMMList();
        $tt_list = getTTList();
        include_once 'views/my_cafe_hours_view.php';
    }
}