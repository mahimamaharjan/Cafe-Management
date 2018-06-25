<?php
function placeOrder($items, $quantities, $comments, $collection_time, $discount_rate, $total, $cafe_id, $user_id) {
    global $db;
    $collection_time = $db->real_escape_string($collection_time);
    $discount_rate = $db->real_escape_string($discount_rate);
    $total = $db->real_escape_string($total);
    $cafe_id = $db->real_escape_string($cafe_id);
    $user_id = $db->real_escape_string($user_id);
    $date = date('Y-m-d');
    
    $sql = "INSERT INTO orders(date, cafe_id, user_id, collection_time, discount_rate) VALUES('$date', '$cafe_id', '$user_id', '$collection_time', '$discount_rate')";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $order_id = $db->insert_id;
        for($i = 0; $i < count($items); $i++) {
        	$item_id = $db->real_escape_string($items[$i]);
        	$quantity = $db->real_escape_string($quantities[$i]);
        	$comment = $db->real_escape_string($comments[$i]);

        	$sql = "INSERT INTO order_item(item_id, quantity, comment, order_id) VALUES('$item_id', '$quantity', '$comment', '$order_id')";
        	$db->query($sql);
        }
        $sql = "UPDATE users SET balance = balance - $total WHERE id = $user_id";
        $db->query($sql);

        return $order_id;
    } else {
        return false;
    }
}

function getOrder($id) {
    global $db;
    $sql = "SELECT o.id, o.date, c.name AS cafe, CONCAT_WS(' ', u.first_name, u.last_name) AS user, o.collection_time, o.discount_rate"
        . " FROM orders o"
        . " LEFT JOIN cafes c"
        . " ON o.cafe_id = c.id"
        . " LEFT JOIN users u"
        . " ON o.user_id = u.id"
        . " WHERE o.id = $id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getOrderItemList($order_id) {
    global $db;
    $sql = "SELECT oi.id, i.name AS item, i.price, oi.quantity, oi.comment"
        . " FROM order_item oi"
        . " LEFT JOIN items i"
        . " ON oi.item_id = i.id"
        . " WHERE oi.order_id = $order_id";
    $result = $db->query($sql);
    $item_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item_list[] = $row;
        }
    }
    else {
        $item_list = false;
    }
    return $item_list;
}

function getOrderCount() {
    global $db;
    $sql = "SELECT * FROM orders";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getOrderList($start_value, $data_per_page) {
    global $db;
    $sql = "SELECT o.id, o.date, c.name AS cafe, CONCAT_WS(' ', u.first_name, u.last_name) AS user, o.collection_time"
        . " FROM orders o"
        . " LEFT JOIN cafes c"
        . " ON o.cafe_id = c.id"
        . " LEFT JOIN users u"
        . " ON o.user_id = u.id"
        . " ORDER BY o.date DESC, o.collection_time DESC"
        . " LIMIT $start_value, $data_per_page";
    $result = $db->query($sql);
    $order_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $order_list[] = $row;
        }
    }
    else {
        $order_list = false;
    }
    return $order_list;
}

function getMyCafeOrder($cafe_id, $id) {
    global $db;
    $date = date('Y-m-d');

    $sql = "SELECT o.id, o.date, CONCAT_WS(' ', u.first_name, u.last_name) AS user, o.collection_time, o.discount_rate"
        . " FROM orders o"
        . " LEFT JOIN users u"
        . " ON o.user_id = u.id"
        . " WHERE o.id = $id"
        . " AND o.cafe_id = $cafe_id"
        . " AND o.date = '$date'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getMyCafeOrderItemList($cafe_id, $order_id) {
    global $db;
    $date = date('Y-m-d');

    $sql = "SELECT oi.id, i.name AS item, i.price, oi.quantity, oi.comment"
        . " FROM order_item oi"
        . " LEFT JOIN items i"
        . " ON oi.item_id = i.id"
        . " WHERE oi.order_id = "
        . " (SELECT id FROM orders WHERE id = $order_id AND cafe_id = $cafe_id AND date = '$date')";
    $result = $db->query($sql);
    $item_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item_list[] = $row;
        }
    }
    else {
        $item_list = false;
    }
    return $item_list;
}

function getMyCafeOrderCount($cafe_id) {
    global $db;
    $date = date('Y-m-d');

    $sql = "SELECT * FROM orders WHERE cafe_id = $cafe_id AND date = '$date'";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getMyCafeOrderList($cafe_id, $start_value, $data_per_page) {
    global $db;
    $date = date('Y-m-d');

    $sql = "SELECT o.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user, o.collection_time"
        . " FROM orders o"
        . " LEFT JOIN users u"
        . " ON o.user_id = u.id"
        . " WHERE o.cafe_id = $cafe_id"
        . " AND o.date = '$date'"
        . " ORDER BY o.date DESC, o.collection_time DESC"
        . " LIMIT $start_value, $data_per_page";
    $result = $db->query($sql);
    $order_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $order_list[] = $row;
        }
    }
    else {
        $order_list = false;
    }
    return $order_list;
}