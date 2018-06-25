<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Add Item to My Cafe Menu (<?php echo $date; ?>)</h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="my_cafe_menu.php?date=<?php echo $date; ?>" method="post">
			<table>
				<tr>
					<td><label for="item">Item<span class="required">*</span></label></td>
					<td>
						<select name="item" id="item">
							<option value="">Select Item</option>
							<?php 
							if($master_item_list):
								foreach($master_item_list as $item):
							?>
							<option value="<?php echo $item['id']; ?>" <?php if(isset($item_id) && $item_id == $item['id']) echo 'selected="selected"'; ?>><?php echo $item['name']; ?></option>
							<?php
								endforeach;
							endif;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button class="orange-button" type="submit">Add</button> <a class="orange-button" href="my_cafe_menu.php?date=<?php echo $date; ?>">Back to List</a></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>