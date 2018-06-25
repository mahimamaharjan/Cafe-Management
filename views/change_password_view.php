<?php include_once 'includes/header.php'; ?>
<div class="container">
    <h1 class="content-heading">Change Password</h1>
    <?php
    if (isset($_SESSION['success_msg']) && $_SESSION['success_msg'] != '') {
        $success_msg = $_SESSION['success_msg'];
        $_SESSION['success_msg'] = '';
        echo '<div class="success-div">' . $success_msg . '</div>';
    }
    if (isset($_SESSION['error_msg']) && $_SESSION['error_msg'] != '') {
        $error_msg = $_SESSION['error_msg'];
        $_SESSION['error_msg'] = '';
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
        <form action="change_password.php" method="post">
            <table>
                <tr>
                    <td><label for="current_password">Current Password<span class="required">*</span></label></td>
                    <td><input type="password" name="current_password" id="current_password" /></td>
                </tr>
                <tr>
                    <td><label for="new_password">New Password<span class="required">*</span></label></td>
                    <td><input type="password" name="new_password" id="new_password" /></td>
                </tr>
                <tr>
                    <td><label for="confirm_new_password">Confirm New Password<span class="required">*</span></label></td>
                    <td><input type="password" name="confirm_new_password" id="confirm_new_password" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button class="orange-button" type="submit">Change Password</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>