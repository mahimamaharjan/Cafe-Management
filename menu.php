<?php
include_once 'main.php';

if(!isset($_GET['cafe']) || !($cafe = getCafe($_GET['cafe']))) {
	header('Location: index.php');
}
else {
	if(isset($_POST['item']) && isset($_POST['quantity']) && isset($_POST['comment']) && isset($_POST['collection_time'])) {
		if(!checkSession()) {
			header('Location: menu.php?cafe=' . $cafe['id']);
		}
		else if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
			header('Location: menu.php?cafe=' . $cafe['id']);	
		}
		else {
			$can_place_order = true;
			
			$items = $_POST['item'];
			$quantities = $_POST['quantity'];
			$comments = $_POST['comment'];
			$collection_time = trim($_POST['collection_time']);
			$prices = array();

			$error_msg = '';

			$is_item_invalid = false;
			for($i = 0; $i < count($items); $i++) {
				$cafe_item = getTodayCafeItem($cafe['id'], $items[$i]);
				if(!$cafe_item) {
					$is_item_invalid = true;
					break;
				}
				else {
					$prices[] = $cafe_item['price'];
				}
			}

			if($is_item_invalid) {
				$error_msg .= 'One or more items are invalid.<br />';
			}

			$is_quantity_empty = false;
			$is_quantity_invalid = false;
			for($i = 0; $i < count($quantities); $i++) {
				$quantities[$i] = trim($quantities[$i]);
				if(!$quantities[$i]) {
					$is_quantity_empty = true;
					break;
				}
				else if(!is_integer(+$quantities[$i]) || +$quantities[$i] <= 0) {
					$is_quantity_invalid = true;
				}
			}

			if($is_quantity_empty) {
				$error_msg .= 'Quantity is required for all items.<br />';
			}
			else if($is_quantity_invalid) {
				$error_msg .= 'Quantity is invalid for one or more items.<br />';
			}

			if(!$is_item_invalid && !$is_quantity_empty && !$is_quantity_invalid) {
				$discount_rate = $_SESSION['user_type'] == 'student' ? 10 : 0;
				$sub_total = 0;
				for($i = 0; $i < count($prices); $i++) {
					$sub_total += $prices[$i] * +$quantities[$i];
				}

				$discount = $sub_total * $discount_rate / 100;
				$total = $sub_total - $discount;

				if($total > getUserBalance($_SESSION['user_id'])) {
					$error_msg .= 'Your order total is more than your balance.<br />';
				}
			}

			if($collection_time == '') {
	            $error_msg .= 'Collection Time is required.<br />';
	        }

	        if ($error_msg == '') {
	        	$c_time = date('H:i:s', strtotime($collection_time));
	        	if(placeOrder($items, $quantities, $comments, $c_time, $discount_rate, $total, $cafe['id'], $_SESSION['user_id'])) {
	                $_SESSION['success_msg'] = 'Your order has been placed successfully.';
	        		header('Location: menu.php?cafe=' . $cafe['id']);
	            }
	            else {
	                $error_msg = 'Failed to place order.';
	                $cafe_item_list = getTodayCafeItemList($cafe['id']);
					$user_balance = getUserBalance($_SESSION['user_id']);
					$time_list = getCollectionTimeList($cafe['opening_time'], $cafe['closing_time']);

	                include_once 'views/menu_view.php';
	            }
	        }
	        else {
	        	$cafe_item_list = getTodayCafeItemList($cafe['id']);
				$user_balance = getUserBalance($_SESSION['user_id']);
				$time_list = getCollectionTimeList($cafe['opening_time'], $cafe['closing_time']);

				include_once 'views/menu_view.php';
	        }
		}
	}
	else {
		if(checkSession()) {
			if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
				$can_place_order = false;
			}
			else {
				$can_place_order = true;
				$user_balance = getUserBalance($_SESSION['user_id']);
			}
		}
		else {
			$can_place_order = false;
		}
		$cafe_item_list = getTodayCafeItemList($cafe['id']);
		$time_list = getCollectionTimeList($cafe['opening_time'], $cafe['closing_time']);

		include_once 'views/menu_view.php';
	}
}