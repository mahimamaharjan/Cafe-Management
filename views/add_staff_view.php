<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading"><?php echo isset($id) ? 'Edit Staff' : 'Add Staff'; ?></h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="staff.php?action=<?php echo isset($id) ? 'edit&id=' . $id : 'add'; ?>" method="post">
			<?php
			if (isset($id)) {
				echo '<input type="hidden" name="id" value="' . $id . '"/>';
			}
			?>
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
					<td><label for="user_id">User ID<span class="required">*</span></label></td>
					<td><input type="text" name="user_id" id="user_id" value="<?php if (isset($user_id)) echo $user_id; ?>" placeholder="CSnnnn"/></td>
				</tr>
				<tr>
					<td><label for="type">Type<span class="required">*</span></label></td>
					<td>
						<select name="type" id="type">
							<option value="">Select Type</option>
							<option value="cafe_staff" <?php if(isset($type) && $type == 'cafe_staff') echo 'selected="selected"'; ?>>Cafe Staff</option>
							<option value="cafe_manager" <?php if(isset($type) && $type == 'cafe_manager') echo 'selected="selected"'; ?>>Cafe Manager</option>
						</select>
					</td>
				</tr>
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
					<td><label for="password">Password<?php if(!isset($id)): ?><span class="required">*</span><?php endif; ?></label></td>
					<td><input type="password" name="password" id="password" /></td>
				</tr>
				<tr>
					<td><label for="confirm_password">Confirm Password<?php if(!isset($id)): ?><span class="required">*</span><?php endif; ?></label></td>
					<td><input type="password" name="confirm_password" id="confirm_password" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button class="orange-button" type="submit">Save</button> <a class="orange-button" href="staff.php">Back to List</a></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>