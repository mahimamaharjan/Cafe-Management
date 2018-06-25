<?php
function getStaff($id) {
    global $db;
    $sql = "SELECT * FROM users WHERE (type = 'cafe_staff' OR type = 'cafe_manager') AND id = $id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getStaffCount() {
	global $db;
    $sql = "SELECT * FROM users WHERE type = 'cafe_staff' OR type = 'cafe_manager'";
    $result = $db->query($sql);
    return $result->num_rows;
}

function getStaffList($start_value, $data_per_page) {
	global $db;
    $sql = "SELECT u.id, u.first_name, u.last_name, u.type, c.name AS cafe"
        . " FROM users u"
        . " LEFT JOIN cafes c"
        . " ON u.cafe_id = c.id"
        . " WHERE u.type = 'cafe_staff' OR u.type = 'cafe_manager'"
        . " ORDER BY u.first_name, u.last_name"
        . " LIMIT $start_value, $data_per_page";
    $result = $db->query($sql);
    $staff_list = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $staff_list[] = $row;
        }
    }
    else {
        $staff_list = false;
    }
    return $staff_list;
}

function addStaff($first_name, $last_name, $user_id, $type, $cafe_id, $phone, $email_address, $creditcard_number, $password) {
    global $db;
    $first_name = $db->real_escape_string($first_name);
    $last_name = $db->real_escape_string($last_name);
    $user_id = $db->real_escape_string($user_id);
    $type = $db->real_escape_string($type);
    $cafe_id = $db->real_escape_string($cafe_id);
    $phone = $db->real_escape_string($phone);
    $email_address = $db->real_escape_string($email_address);
    $creditcard_number = $db->real_escape_string($creditcard_number);
    $password_md5 = md5($password);
    
    $sql = "INSERT INTO users(first_name, last_name, user_id, type, cafe_id, phone, email_address, creditcard_number, password) VALUES('$first_name', '$last_name', '$user_id', '$type', '$cafe_id', '$phone', '$email_address', '$creditcard_number', '$password_md5')";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $id = $db->insert_id;
        return $id;
    } else {
        return false;
    }
}

function updateStaff($first_name, $last_name, $user_id, $type, $cafe_id, $phone, $email_address, $creditcard_number, $password, $id) {
    global $db;
    $first_name = $db->real_escape_string($first_name);
    $last_name = $db->real_escape_string($last_name);
    $user_id = $db->real_escape_string($user_id);
    $type = $db->real_escape_string($type);
    $cafe_id = $db->real_escape_string($cafe_id);
    $phone = $db->real_escape_string($phone);
    $email_address = $db->real_escape_string($email_address);
    $creditcard_number = $db->real_escape_string($creditcard_number);
    
    $sql = "UPDATE users"
        . " SET first_name = '$first_name'"
        . ", last_name = '$last_name'"
        . ", user_id = '$user_id'"
        . ", type = '$type'"
        . ", cafe_id = '$cafe_id'"
        . ", phone = '$phone'"
        . ", email_address = '$email_address'"
        . ", creditcard_number = '$creditcard_number'"
        . ( $password ? ", password = '" . md5($password) . "'" : "" )
        . " WHERE (type = 'cafe_staff' OR type = 'cafe_manager') AND id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function removeCafeManagers($cafe_id, $user_id) {
    global $db;
    $cafe_id = $db->real_escape_string($cafe_id);
    $user_id = $db->real_escape_string($user_id);
    
    $sql = "UPDATE users"
        . " SET type = 'cafe_staff'"
        . " WHERE type = 'cafe_manager' AND cafe_id = $cafe_id AND id <> $user_id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function deleteStaff($id) {
    global $db;
    $sql = "DELETE FROM users WHERE (type = 'cafe_staff' OR type = 'cafe_manager') AND id = $id";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}