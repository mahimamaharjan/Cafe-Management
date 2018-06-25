<?php
include_once 'main.php';

if(!checkSession() || ($_SESSION['user_type'] != 'cafe_staff' && $_SESSION['user_type'] != 'cafe_manager')) {
	header('Location: index.php');
}
else {
	if(isset($_GET['action'])) {
		$action = $_GET['action'];
		if($action == 'details' && isset($_GET['id'])) {
			$id = $_GET['id'];
			if($order = getMyCafeOrder($_SESSION['user_cafe_id'], $id)) {
                $item_list = getMyCafeOrderItemList($_SESSION['user_cafe_id'], $id);
                include_once 'views/my_cafe_order_details_view.php';
            }
            else {
                header('Location: my_cafe_orders.php');
            }
		}
		else {
			header('Location: my_cafe_orders.php');
		}
	}
	else {
		$data_per_page = 10;
	    $total_records = getMyCafeOrderCount($_SESSION['user_cafe_id']);
	    $num_pages = ceil($total_records / $data_per_page);

	    if (isset($_GET['page'])) {
	        $current_page = $_GET['page'];

	        if ($current_page < 1 || $current_page > $num_pages) {
	            header('Location: my_cafe_orders.php');
	        }
	    }
	    else {
	        $current_page = 1;
	    }

	    $start_value = ($current_page - 1) * $data_per_page;

	    $order_list = getMyCafeOrderList($_SESSION['user_cafe_id'], $start_value, $data_per_page);
		include_once 'views/my_cafe_orders_view.php';
	}
}