<?php
function cafeItemExists($cafe_id, $item_id) {
    global $db;

    $cafe_id = $db->real_escape_string($cafe_id);
    $item_id = $db->real_escape_string($item_id);
    
    $sql = "SELECT * FROM cafe_item WHERE cafe_id = $cafe_id AND item_id = $item_id";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    else {
        return false;
    }
}

function getCafeItemCount($cafe_id, $date) {
	global $db;
    $sql = "SELECT ci.id"
    	. " FROM cafe_item ci"
    	. " JOIN items i"
    	. " ON ci.item_id = i.id"
    	. " WHERE ci.cafe_id = $cafe_id"
    	. " AND i.date = '$date'";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getCafeItemList($cafe_id, $date, $start_value, $data_per_page) {
	global $db;
    $sql = "SELECT ci.id, ci.item_id, i.name, i.type, i.price"
        . " FROM cafe_item ci"
        . " JOIN items i"
        . " ON ci.item_id = i.id"
        . " WHERE ci.cafe_id = $cafe_id"
        . " AND i.date = '$date'"
        . " ORDER BY i.name"
        . " LIMIT $start_value, $data_per_page";
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

function getTodayCafeItemList($cafe_id) {
    global $db;
    $cafe_id = $db->real_escape_string($cafe_id);
    $date = date('Y-m-d');

    $sql = "SELECT ci.id, ci.item_id, i.name, i.type, i.price"
        . " FROM cafe_item ci"
        . " JOIN items i"
        . " ON ci.item_id = i.id"
        . " WHERE ci.cafe_id = $cafe_id"
        . " AND i.date = '$date'"
        . " ORDER BY i.name";
    $result = $db->query($sql);
    
    $item_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item_list[$row['item_id']] = $row;
        }
    }
    else {
        $item_list = false;
    }
    return $item_list;
}

function getTodayCafeItem($cafe_id, $item_id) {
    global $db;
    $cafe_id = $db->real_escape_string($cafe_id);
    $item_id = $db->real_escape_string($item_id);
    $date = date('Y-m-d');

    $sql = "SELECT ci.id, ci.item_id, i.name, i.type, i.price"
        . " FROM cafe_item ci"
        . " JOIN items i"
        . " ON ci.item_id = i.id"
        . " WHERE ci.cafe_id = $cafe_id"
        . " AND ci.item_id = $item_id"
        . " AND i.date = '$date'"
        . " ORDER BY i.name";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }
    else {
        return false;
    }
}

function addCafeItem($cafe_id, $item_id) {
    global $db;
    $cafe_id = $db->real_escape_string($cafe_id);
    $item_id = $db->real_escape_string($item_id);
    
    $sql = "INSERT INTO cafe_item(cafe_id, item_id) VALUES('$cafe_id', '$item_id')";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $id = $db->insert_id;
        return $id;
    } else {
        return false;
    }
}

function deleteCafeItem($cafe_id, $item_id) {
    global $db;
    $sql = "DELETE FROM cafe_item WHERE cafe_id = $cafe_id AND item_id = $item_id";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}