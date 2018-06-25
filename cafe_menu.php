<?php
include_once 'main.php';

if(!checkSession() || $_SESSION['user_type'] != 'board_director') {
	header('Location: index.php');
}
else {
	if(isset($_GET['cafe']) && isset($_GET['date']) && ($cafe = getCafe($_GET['cafe'])) && checkDateFormat($_GET['date'])) {
		$cafe_id = $_GET['cafe'];
		$date = $_GET['date'];

		if(isset($_POST['item'])) {
			$item_id = trim($_POST['item']);

	        $error_msg = '';

	        if ($item_id == '') {
	            $error_msg .= 'Item is required.<br />';
	        }
	        else if(cafeItemExists($cafe_id, $item_id)) {
	        	$error_msg .= 'Item already exists in menu.<br />';	
	        }

	        if ($error_msg == '') {
                if(addCafeItem($cafe_id, $item_id)) {
                    $_SESSION['success_msg'] = 'Item added to menu successfully.';
                    header('Location: cafe_menu.php?cafe=' . $cafe_id . '&date=' . $date);
                }
                else {
                    $error_msg = 'Failed to add item to menu.';
                    $master_item_list = getAllMasterItemList($date);
                    include_once 'views/add_cafe_menu_view.php';
                }
	        }
	        else {
	        	$master_item_list = getAllMasterItemList($date);
	            include_once 'views/add_cafe_menu_view.php';
	        }
		}
		else {
			if(isset($_GET['action'])) {
            	$action = $_GET['action'];
				if($action == 'add') {
	                $master_item_list = getAllMasterItemList($date);
	            	include_once 'views/add_cafe_menu_view.php';
	            }
	            else if($action == 'delete' && isset($_GET['item_id'])) {
		            if(deleteCafeItem($cafe_id, $_GET['item_id'])) {
	                    $_SESSION['success_msg'] = 'Item deleted from menu successfully.';
	                }
	                else {
	                    $_SESSION['error_msg'] = 'Failed to delete item from menu.';
	                }
	                header('Location: cafe_menu.php?cafe=' . $cafe_id . '&date=' . $date);
	            }
	            else {
	            	header('Location: cafe_menu.php?cafe=' . $cafe_id . '&date=' . $date);
	            }
	        }
	        else {
				$data_per_page = 10;
	            $total_records = getCafeItemCount($cafe_id, $date);
	            $num_pages = ceil($total_records / $data_per_page);

	            if (isset($_GET['page'])) {
	                $current_page = $_GET['page'];

	                if ($current_page < 1 || $current_page > $num_pages) {
	                    header('Location: cafe_menu.php?cafe=' . $cafe_id . '&date=' . $date);
	                }
	            }
	            else {
	                $current_page = 1;
	            }

	            $start_value = ($current_page - 1) * $data_per_page;

                $cafe_item_list = getCafeItemList($cafe_id, $date, $start_value, $data_per_page);
                include_once 'views/cafe_menu_view.php';
	        }
		}
	}
	else {
		header('Location: cafe_menu_select.php');
	}
}
