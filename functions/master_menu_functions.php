<?php
function getMasterItem($id) {
    global $db;
    $sql = "SELECT * FROM items WHERE id = $id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getMasterItemCount() {
	global $db;
    $sql = "SELECT * FROM items";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getMasterItemList($start_value, $data_per_page) {
	global $db;
    $sql = "SELECT * FROM items ORDER BY date DESC, name ASC LIMIT $start_value, $data_per_page";
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

function getAllMasterItemList($date) {
    global $db;
    $sql = "SELECT * FROM items WHERE date = '$date' ORDER BY name";
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

function addMasterItem($name, $type, $price, $date) {
    global $db;
    $name = $db->real_escape_string($name);
    $type = $db->real_escape_string($type);
    $price = $db->real_escape_string($price);
    $date = $db->real_escape_string($date);
    
    $sql = "INSERT INTO items(name, type, price, date) VALUES('$name', '$type', '$price', '$date')";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $id = $db->insert_id;
        return $id;
    } else {
        return false;
    }
}

function updateMasterItem($name, $type, $price, $date, $id) {
    global $db;
    $name = $db->real_escape_string($name);
    
    $sql = "UPDATE items SET name = '$name', type = '$type', price = '$price', date = '$date' WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function deleteMasterItem($id) {
    global $db;
    $sql = "DELETE FROM items WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}