<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
	if(isset($_GET['action'])) {
		$action = $_GET['action'];
		if($action == 'details' && isset($_GET['id'])) {
			$id = $_GET['id'];
			if($order = getOrder($id)) {
                $item_list = getOrderItemList($id);
                include_once 'views/order_details_view.php';
            }
            else {
                header('Location: orders.php');
            }
		}
		else {
			header('Location: orders.php');
		}
	}
	else {
		$data_per_page = 10;
	    $total_records = getOrderCount();
	    $num_pages = ceil($total_records / $data_per_page);

	    if (isset($_GET['page'])) {
	        $current_page = $_GET['page'];

	        if ($current_page < 1 || $current_page > $num_pages) {
	            header('Location: orders.php');
	        }
	    }
	    else {
	        $current_page = 1;
	    }

	    $start_value = ($current_page - 1) * $data_per_page;

	    $order_list = getOrderList($start_value, $data_per_page);
		include_once 'views/orders_view.php';
	}
}