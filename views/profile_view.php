<?php include_once 'includes/header.php'; ?>
<div class="container">
    <h1 class="content-heading">Profile</h1>
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
        <form action="profile.php" method="post">
            <table>
                <tr>
                    <td><label for="first_name">First Name<span class="required">*</span></label></td>
                    <td><input type="text" name="first_name" id="first_name" value="<?php if (isset($first_name)) echo $first_name; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="last_name">Last Name<span class="required">*</span></label></td>
                    <td><input type="text" name="last_name" id="last_name" value="<?php if (isset($last_name)) echo $last_name; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="">User ID</label></td>
                    <td><?php if (isset($user_id)) echo $user_id; ?></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone<span class="required">*</span></label></td>
                    <td><input type="text" name="phone" id="phone" value="<?php if (isset($phone)) echo $phone; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="email_address">Email Address<span class="required">*</span></label></td>
                    <td><input type="text" name="email_address" id="email_address" value="<?php if (isset($email_address)) echo $email_address; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="creditcard_number">Credit Card Number<span class="required">*</span></label></td>
                    <td><input type="text" name="creditcard_number" id="creditcard_number" value="<?php if (isset($creditcard_number)) echo $creditcard_number; ?>"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button class="orange-button" type="submit">Save</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>