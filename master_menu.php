<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
    if(isset($_POST['name']) && isset($_POST['type']) && isset($_POST['price']) && isset($_POST['date'])) {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $name = trim($_POST['name']);
        $type = trim($_POST['type']);
        $price = trim($_POST['price']);
        $date = trim($_POST['date']);


        $error_msg = '';

        if ($name == '') {
            $error_msg .= 'Name is required.<br />';
        }

        if ($type == '') {
            $error_msg .= 'Type is required.<br />';
        }

        if ($price == '') {
            $error_msg .= 'Price is required.<br />';
        }
        else if (!is_numeric($price) || $price <= 0) {
            $error_msg .= 'Price is invalid.<br />';
        }

        if ($date == '') {
            $error_msg .= 'Date is required.<br />';
        }
        else if(!checkDateFormat($date)) {
            $error_msg .= 'Date is invalid.<br />';
        }

        if ($error_msg == '') {
            if(isset($id)) {
                if(updateMasterItem($name, $type, $price, $date, $id)) {
                    $_SESSION['success_msg'] = 'Master menu item updated successfully.';
                    header('Location: master_menu.php');
                }
                else {
                    $error_msg = 'Failed to update master menu item.';
                    include_once 'views/add_master_menu_view.php';
                }
            }
            else {
                if(addMasterItem($name, $type, $price, $date)) {
                    $_SESSION['success_msg'] = 'Master menu item added successfully.';
                    header('Location: master_menu.php');
                }
                else {
                    $error_msg = 'Failed to add master menu item.';
                    include_once 'views/add_master_menu_view.php';
                }
            }
        }
        else {
            include_once 'views/add_master_menu_view.php';
        }
    }
    else {
        if(isset($_GET['action'])) {

            $action = $_GET['action'];
            if($action == 'add') {

                include_once 'views/add_master_menu_view.php';
            }
            else if($action == 'edit' && isset($_GET['id'])) {
                $id = $_GET['id'];
                if($item = getMasterItem($id)) {
                    $name = $item['name'];
                    $type = $item['type'];
                    $price = $item['price'];
                    $date = $item['date'];

                    include_once 'views/add_master_menu_view.php';
                }
                else {
                    header('Location: master_menu.php');
                }
            }
            else if($action == 'delete' && isset($_GET['id'])) {
                if(deleteMasterItem($_GET['id'])) {
                    $_SESSION['success_msg'] = 'Master menu item deleted successfully.';
                }
                else {
                    $_SESSION['error_msg'] = 'Failed to delete master menu item.';
                }
                header('Location: master_menu.php');
            }
            else {
                header('Location: master_menu.php');
            }
        }
        else {
        	$data_per_page = 10;
            $total_records = getMasterItemCount();
            $num_pages = ceil($total_records / $data_per_page);

            if (isset($_GET['page'])) {
                $current_page = $_GET['page'];

                if ($current_page < 1 || $current_page > $num_pages) {
                    header('Location: master_menu.php');
                }
            }
            else {
                $current_page = 1;
            }

            $start_value = ($current_page - 1) * $data_per_page;

            $item_list = getMasterItemList($start_value, $data_per_page);
        	include_once 'views/master_menu_view.php';
        }
    }
}
