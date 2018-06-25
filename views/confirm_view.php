<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Email Address Confirmation</h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    if (isset($success_msg) && $success_msg != '') {
        echo '<div class="success-div">' . $success_msg . '</div>';
    }
    ?>
	<a href="index.php" class="orange-button">Go to Home Page</a>
</div>
<?php include_once 'includes/footer.php'; ?>