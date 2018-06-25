<?php include_once 'includes/header.php'; ?>
<div class="container">
    <h1 class="content-heading">Deposit Fund</h1>
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
        <form action="deposit_fund.php" method="post">
            <table>
                <tr>
                    <td><label for="">Current Balance</label></td>
                    <td><?php if (isset($balance)) echo $balance; ?></td>
                </tr>
                <tr>
                    <td><label for="amount">Amount<span class="required">*</span></label></td>
                    <td><input type="text" name="amount" id="amount" value="<?php if (isset($amount)) echo $amount; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="password">Password<span class="required">*</span></label></td>
                    <td><input type="password" name="password" id="password" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button class="orange-button" type="submit">Deposit</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>