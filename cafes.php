<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
    if(isset($_POST['name']) && isset($_POST['opening_hh']) && isset($_POST['opening_mm']) && isset($_POST['opening_tt']) && isset($_POST['closing_hh']) && isset($_POST['closing_mm']) && isset($_POST['closing_tt'])) {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        
        $name = trim($_POST['name']);
        $opening_hh = trim($_POST['opening_hh']);
        $opening_mm = trim($_POST['opening_mm']);
        $opening_tt = trim($_POST['opening_tt']);
        $closing_hh = trim($_POST['closing_hh']);
        $closing_mm = trim($_POST['closing_mm']);
        $closing_tt = trim($_POST['closing_tt']);
        $opening_time = '';
        $closing_time = '';

        $error_msg = '';

        if ($name == '') {
            $error_msg .= 'Name is required.<br />';
        }

        if($opening_hh && $opening_mm && $opening_tt) {
            $opening_time = get24HourFormat($opening_hh, $opening_mm, $opening_tt);
        }

        if($closing_hh && $closing_mm && $closing_tt) {
            $closing_time = get24HourFormat($closing_hh, $closing_mm, $closing_tt);
        }
        
        if ($error_msg == '') {            
            if(isset($id)) {            
                if(updateCafe($name, $opening_time, $closing_time, $id)) {
                    $_SESSION['success_msg'] = 'Cafe updated successfully.';
                    header('Location: cafes.php');
                }
                else {
                    $error_msg = 'Failed to update cafe.';
                    $hh_list = getHHList();
                    $mm_list = getMMList();
                    $tt_list = getTTList();
                    include_once 'views/add_cafe_view.php';
                }
            }
            else {
                if(addCafe($name, $opening_time, $closing_time)) {
                    $_SESSION['success_msg'] = 'Cafe added successfully.';
                    header('Location: cafes.php');
                }
                else {
                    $error_msg = 'Failed to add cafe.';
                    $hh_list = getHHList();
                    $mm_list = getMMList();
                    $tt_list = getTTList();
                    include_once 'views/add_cafe_view.php';
                }
            }
        }
        else {
            $hh_list = getHHList();
            $mm_list = getMMList();
            $tt_list = getTTList();
            include_once 'views/add_cafe_view.php';
        }
    }
    else {
        if(isset($_GET['action'])) {
            $action = $_GET['action'];
            if($action == 'add') {
                $hh_list = getHHList();
                $mm_list = getMMList();
                $tt_list = getTTList();
                include_once 'views/add_cafe_view.php';
            }
            else if($action == 'edit' && isset($_GET['id'])) {
                $id = $_GET['id'];
                if($cafe = getCafe($id)) {
                    $name = $cafe['name'];
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
                    include_once 'views/add_cafe_view.php';
                }
                else {
                    header('Location: cafes.php');
                }
            }
            else if($action == 'delete' && isset($_GET['id'])) {
                if(deleteCafe($_GET['id'])) {
                    $_SESSION['success_msg'] = 'Cafe deleted successfully.';
                }
                else {
                    $_SESSION['error_msg'] = 'Cafe could not be deleted due to an error.';
                }
                header('Location: cafes.php');
            }
            else {
                header('Location: cafes.php');
            }
        }
        else {
        	$data_per_page = 10;
            $total_records = getCafeCount();
            $num_pages = ceil($total_records / $data_per_page);

            if (isset($_GET['page'])) {
                $current_page = $_GET['page'];

                if ($current_page < 1 || $current_page > $num_pages) {
                    header('Location: cafes.php');
                }
            }
            else {
                $current_page = 1;
            }

            $start_value = ($current_page - 1) * $data_per_page;

            $cafe_list = getCafeList($start_value, $data_per_page);
        	include_once 'views/cafes_view.php';
        }
    }
}