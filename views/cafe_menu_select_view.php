<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Select Cafe and Date</h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="cafe_menu_select.php" method="post">
			<table>
				<tr>
					<td><label for="cafe">Cafe<span class="required">*</span></label></td>
					<td>
						<select name="cafe" id="cafe">
							<option value="">Select Cafe</option>
							<?php 
							if($cafe_list):
								foreach($cafe_list as $cafe):
							?>
							<option value="<?php echo $cafe['id']; ?>" <?php if(isset($cafe_id) && $cafe_id == $cafe['id']) echo 'selected="selected"'; ?>><?php echo $cafe['name']; ?></option>
							<?php
								endforeach;
							endif;
							?>
						</select>
					</td>
				</tr>
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