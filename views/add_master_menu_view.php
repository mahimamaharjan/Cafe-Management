<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading"><?php echo isset($id) ? 'Edit Master Menu Item' : 'Add Master Menu Item'; ?></h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="master_menu.php?action=<?php echo isset($id) ? 'edit&id=' . $id : 'add'; ?>" method="post" enctype="multipart/form-data">
			<?php
			if (isset($id)) {
				echo '<input type="hidden" name="id" value="' . $id . '"/>';
			}
			?>
			<table>
				<tr>
					<td><label for="name">Name<span class="required">*</span></label></td>
					<td><input type="text" name="name" id="name" value="<?php if (isset($name)) echo $name; ?>"/></td>
				</tr>
				<tr>
					<td><label for="type">Type<span class="required">*</span></label></td>
					<td>
						<select name="type" id="type">
							<option value="">Select Type</option>
							<option value="food" <?php if(isset($type) && $type == 'food') echo 'selected="selected"'; ?>>Food</option>
							<option value="beverage" <?php if(isset($type) && $type == 'beverage') echo 'selected="selected"'; ?>>Beverage</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="price">Price<span class="required">*</span></label></td>
					<td><input type="text" name="price" id="price" value="<?php if (isset($price)) echo $price; ?>"/></td>
				</tr>
				<tr>
					<td><label for="date">Date<span class="required">*</span></label></td>
					<td><input type="text" name="date" id="date" value="<?php if (isset($date)) echo $date; ?>" placeholder="YYYY-MM-DD" /></td>
				</tr>
                <tr>
                    <td>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </td>
                </tr>
				<tr>
					<td>&nbsp;</td>
					<td><button class="orange-button" type="submit">Save</button> <a class="orange-button" href="master_menu.php">Back to List</a></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>
