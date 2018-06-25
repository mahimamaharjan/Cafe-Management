<?php
function checkSession() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function emailExists($email_address, $id = false) {
    global $db;

    $email_address = $db->real_escape_string($email_address);
    
    $sql = "SELECT * FROM users WHERE email_address='$email_address'";
    if ($id) {
        $sql .= " AND id <> $id";
    }
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    else {
        return false;
    }
}

function userIdExists($user_id, $id = false) {
    global $db;

    $user_id = $db->real_escape_string($user_id);
    
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    if ($id) {
        $sql .= " AND id <> $id";
    }
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    else {
        return false;
    }
}

function register($first_name, $last_name, $student_staff_id, $phone, $email_address, $creditcard_number, $password, $type, $confirmation_code) {
    global $db;

    $first_name = $db->real_escape_string($first_name);
    $last_name = $db->real_escape_string($last_name);
    $student_staff_id = $db->real_escape_string($student_staff_id);
    $phone = $db->real_escape_string($phone);
    $email_address = $db->real_escape_string($email_address);
    $creditcard_number = $db->real_escape_string($creditcard_number);
    $password_md5 = md5($password);
    
    $sql = "INSERT INTO users(first_name, last_name, user_id, phone, email_address, creditcard_number, password, type, confirmation_code, is_confirmed) VALUES('$first_name', '$last_name', '$student_staff_id', '$phone', '$email_address', '$creditcard_number', '$password_md5', '$type', '$confirmation_code', TRUE)";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $id = $db->insert_id;
        return $id;
    }
    else {
        return false;
    }
}

function login($email_address, $password) {
    global $db;

    $email_address = $db->real_escape_string($email_address);
    $password_md5 = md5($password);
    
    $sql = "SELECT * FROM users WHERE (email_address = '$email_address' OR user_id = '$email_address') AND password = '$password_md5'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function getUserBalance($id) {
    global $db;
    $sql = "SELECT balance FROM users WHERE id = $id";
    $result = $db->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['balance'];
    }
    else {
        return 0;
    }
}

function getUser($id) {
    global $db;
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

function updateUser($first_name, $last_name, $phone, $email_address, $creditcard_number, $id) {
    global $db;
    $first_name = $db->real_escape_string($first_name);
    $last_name = $db->real_escape_string($last_name);
    $phone = $db->real_escape_string($phone);
    $email_address = $db->real_escape_string($email_address);
    $creditcard_number = $db->real_escape_string($creditcard_number);
    $id = $db->real_escape_string($id);
    
    $sql = "UPDATE users"
        . " SET first_name = '$first_name'"
        . ", last_name = '$last_name'"
        . ", phone = '$phone'"
        . ", email_address = '$email_address'"
        . ", creditcard_number = '$creditcard_number'"
        . " WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function checkPassword($id, $password) {
    global $db;
    $password_md5 = md5($password);

    $sql = "SELECT * FROM users WHERE id = $id AND password = '$password_md5'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function changePassword($id, $new_password) {
    global $db;
    $password_md5 = md5($new_password);

    $sql = "UPDATE users SET password = '$password_md5' WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function depositFund($id, $amount) {
    global $db;
    $amount = $db->real_escape_string($amount);

    $sql = "UPDATE users SET balance = balance + $amount WHERE id = $id";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}

function logout() {
    $_SESSION = array();
    session_destroy();
}

function sendConfirmationEmail($first_name, $last_name, $email_address, $link) {
    $to = $email_address;
    $subject = 'Email Address Confirmation';
    $from = 'noreply@yeom.com';

    $message = 'Dear ' . $first_name . ' ' . $last_name . ',<br/><br/>';
    $message .= 'Please click the following link to confirm your email address:<br/>';
    $message .= '<a href="' . $link .'" target="_blank">' . $link . '</a><br/><br/>';
    $message .= 'Thanks,<br/>';
    $message .= 'YEOM';

    $headers = "From: YEOM <" . $from . ">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    mail($to, $subject, $message, $headers);
}

function confirmUser($id) {
    global $db;

    $sql = "UPDATE users SET is_confirmed = TRUE, confirmation_code = NULL WHERE id = $id AND is_confirmed = FALSE";
    $db->query($sql);
    if ($db->affected_rows >= 0) {
        return true;
    } else {
        return false;
    }
}