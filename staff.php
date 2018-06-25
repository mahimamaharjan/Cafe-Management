<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['user_id']) && isset($_POST['type']) && isset($_POST['cafe']) && isset($_POST['phone']) && isset($_POST['email_address']) && isset($_POST['creditcard_number']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $user_id = trim($_POST['user_id']);
        $type = trim($_POST['type']);
        $cafe_id = trim($_POST['cafe']);
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

        if ($user_id == '') {
            $error_msg .= 'User ID is required.<br />';
        }
        else if(!preg_match('/^CS\d{4}$/i', $user_id)) {
            $error_msg .= 'User ID is invalid.<br />';
        }
        else if (!isset($id) && userIdExists($user_id)) {
            $error_msg .= 'User ID is already registered.<br />';
        }
        else if (isset($id) && userIdExists($user_id, $id)) {
            $error_msg .= 'User ID is already registered.<br />';
        }

        if ($type == '') {
            $error_msg .= 'Type is required.<br />';
        }

        if ($cafe_id == '') {
            $error_msg .= 'Cafe is required.<br />';
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
        else if (!isset($id) && emailExists($email_address)) {
            $error_msg .= 'Email Address is already registered.<br />';
        }
        else if (isset($id) && emailExists($email_address, $id)) {
            $error_msg .= 'Email Address is already registered.<br />';
        }

        if ($creditcard_number == '') {
            $error_msg .= 'Credit Card Number is required.<br />';
        }

        if(!isset($id)) {
            if ($password == '') {
                $error_msg .= 'Password is required.<br />';
            }
            else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!#\$]).{6,12}$/', $password)) {
                $error_msg .= 'Password must be 6 - 12 characters in length containing at least 1 lowercase letter, 1 uppercase letter, 1 number and one of the following special characters ~ ! # $.<br />';
            }

            if ($confirm_password == '') {
                $error_msg .= 'Confirm Password is required.<br />';
            }

            if ($password && $confirm_password && $password != $confirm_password) {
                $error_msg .= 'Passwords do not match.<br />';
            }
        }
        else {
            if($password && $confirm_password) {
                if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!#\$]).{6,12}$/', $password)) {
                    $error_msg .= 'Password must be 6 - 12 characters in length containing at least 1 lowercase letter, 1 uppercase letter, 1 number and one of the following special characters ~ ! # $.<br />';
                }

                if ($password != $confirm_password) {
                    $error_msg .= 'Passwords do not match.<br />';
                }
            }
            else {
                $password = '';
            }
        }
        
        if ($error_msg == '') {            
            if(isset($id)) {            
                if(updateStaff($first_name, $last_name, $user_id, $type, $cafe_id, $phone, $email_address, $creditcard_number, $password, $id)) {
                    if($type == 'cafe_manager') {
                        removeCafeManagers($cafe_id, $id);
                    }
                    $_SESSION['success_msg'] = 'Staff updated successfully.';
                    header('Location: staff.php');
                }
                else {
                    $error_msg = 'Failed to update staff.';
                    $cafe_list = getAllCafeList();
                    include_once 'views/add_staff_view.php';
                }
            }
            else {
                if($id = addStaff($first_name, $last_name, $user_id, $type, $cafe_id, $phone, $email_address, $creditcard_number, $password)) {
                    if($type == 'cafe_manager') {
                        removeCafeManagers($cafe_id, $id);
                    }
                    $_SESSION['success_msg'] = 'Staff added successfully.';
                    header('Location: staff.php');
                }
                else {
                    $error_msg = 'Failed to add staff.';
                    $cafe_list = getAllCafeList();
                    include_once 'views/add_staff_view.php';
                }
            }
        }
        else {
            $cafe_list = getAllCafeList();
            include_once 'views/add_staff_view.php';
        }
    }
    else {
        if(isset($_GET['action'])) {
            $action = $_GET['action'];
            if($action == 'add') {
                $cafe_list = getAllCafeList();
                include_once 'views/add_staff_view.php';
            }
            else if($action == 'edit' && isset($_GET['id'])) {
                $id = $_GET['id'];
                if($staff = getStaff($id)) {
                    $first_name = $staff['first_name'];
                    $last_name = $staff['last_name'];
                    $user_id = $staff['user_id'];
                    $type = $staff['type'];
                    $cafe_id = $staff['cafe_id'];
                    $phone = $staff['phone'];
                    $email_address = $staff['email_address'];
                    $creditcard_number = $staff['creditcard_number'];
                    
                    $cafe_list = getAllCafeList();
                    include_once 'views/add_staff_view.php';
                }
                else {
                    header('Location: staff.php');
                }
            }
            else if($action == 'delete' && isset($_GET['id'])) {
                if(deleteStaff($_GET['id'])) {
                    $_SESSION['success_msg'] = 'Staff deleted successfully.';
                }
                else {
                    $_SESSION['error_msg'] = 'Staff could not be deleted due to an error.';
                }
                header('Location: staff.php');
            }
            else {
                header('Location: staff.php');
            }
        }
        else {
        	$data_per_page = 10;
            $total_records = getStaffCount();
            $num_pages = ceil($total_records / $data_per_page);

            if (isset($_GET['page'])) {
                $current_page = $_GET['page'];

                if ($current_page < 1 || $current_page > $num_pages) {
                    header('Location: staff.php');
                }
            }
            else {
                $current_page = 1;
            }

            $start_value = ($current_page - 1) * $data_per_page;

            $staff_list = getStaffList($start_value, $data_per_page);
        	include_once 'views/staff_view.php';
        }
    }
}