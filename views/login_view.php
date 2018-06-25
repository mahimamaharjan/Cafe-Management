<?php include_once 'includes/header.php'; ?>
<section id="showcase">
    <div class="container_registration">
        <h1>login</h1>
        <div  id="registerform_div">
            <form id="registerform" method="post" action="login.php">
                <?php
                if (isset($error_msg) && $error_msg != '') {
                    echo '<div class="error-div">' . $error_msg . '</div>';
                }
                ?>
                <div class="form-row">
                    <label>Email Address/User ID<span class="required">*</span></label>
                    <input id="email_address" name="email_address" class="text" type="text" value="<?php if (isset($email_address)) echo $email_address; ?>" placeholder="you@domain.com">
                </div>
                <div class="form-row">
                    <label for="password">Password<span class="required">*</span></label>
                    <input id="password" name="password" class="text" type="password" value="">
                </div>
                <div class="form-row loginbtn">
                    <button type="submit" id="login">Login</button>
                </div>
                <div class="form-row footer">
                    <label>Don't have an account? <a href="register.php"> Sign Up</a></label>
                </div>
            </form>
        </div>
    </div>
</section>
<?php include_once 'includes/footer.php'; ?>