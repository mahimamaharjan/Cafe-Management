<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Select Date</h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="my_cafe_menu_select.php" method="post">
			<table>
				<tr>
					<td><label for="date">Date<span class="required">*</span></label></td>
					<td><input type="text" name="date" id="date" value="<?php if (isset($date)) echo $date; ?>" placeholder="YYYY-MM-DD" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button class="orange-button" type="submit">Select</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>