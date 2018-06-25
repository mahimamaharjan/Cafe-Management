<?php
function getCafe($id) {
    global $db;
    $sql = "SELECT * FROM cafes WHERE id = $id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getCafeCount() {
	global $db;
    $sql = "SELECT * FROM cafes";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getCafeList($start_value, $data_per_page) {
	global $db;
    $sql = "SELECT * FROM cafes ORDER BY name LIMIT $start_value, $data_per_page";
    $result = $db->query($sql);
    $cafe_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cafe_list[] = $row;
        }
    }
    else {
        $cafe_list = false;
    }
    return $cafe_list;
}

function getAllCafeList() {
    global $db;
    $sql = "SELECT * FROM cafes ORDER BY name";
    $result = $db->query($sql);
    $cafe_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cafe_list[] = $row;
        }
    }
    else {
        $cafe_list = false;
    }
    return $cafe_list;
}

function addCafe($name, $opening_time, $closing_time) {
    global $db;
    $name = $db->real_escape_string($name);
    $opening_time = $db->real_escape_string($opening_time);
    $closing_time = $db->real_escape_string($closing_time);

    $opening_time = $opening_time ? "'$opening_time'" : "NULL";
    $closing_time = $closing_time ? "'$closing_time'" : "NULL";
    
    $sql = "INSERT INTO cafes(name, opening_time, closing_time) VALUES('$name', $opening_time, $closing_time)";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $id = $db->insert_id;
        return $id;
    } else {
        return false;
    }
}

function updateCafe($name, $opening_time, $closing_time, $id) {
    global $db;
    $name = $db->real_escape_string($name);
    $opening_time = $db->real_escape_string($opening_time);
    $closing_time = $db->real_escape_string($closing_time);

    $opening_time = $opening_time ? "'$opening_time'" : "NULL";
    $closing_time = $closing_time ? "'$closing_time'" : "NULL";
    
    $sql = "UPDATE cafes SET name = '$name', opening_time = $opening_time, closing_time = $closing_time WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function updateCafeHours($opening_time, $closing_time, $id) {
    global $db;
    $opening_time = $db->real_escape_string($opening_time);
    $closing_time = $db->real_escape_string($closing_time);

    $opening_time = $opening_time ? "'$opening_time'" : "NULL";
    $closing_time = $closing_time ? "'$closing_time'" : "NULL";
    
    $sql = "UPDATE cafes SET opening_time = $opening_time, closing_time = $closing_time WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function deleteCafe($id) {
    global $db;
    $sql = "DELETE FROM cafes WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}