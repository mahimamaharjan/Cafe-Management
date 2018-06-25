<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading"><?php echo isset($id) ? 'Edit Cafe' : 'Add Cafe'; ?></h1>
	<?php
    if (isset($error_msg) && $error_msg != '') {
        echo '<div class="error-div">' . $error_msg . '</div>';
    }
    ?>
    <div class="form-div">
		<form action="cafes.php?action=<?php echo isset($id) ? 'edit&id=' . $id : 'add'; ?>" method="post">
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
					<td><label for="">Opening Time</label></td>
					<td>
						<select name="opening_hh" class="time-select">
							<option value="">hh</option>
							<?php 
							foreach($hh_list as $hh):
							?>
							<option value="<?php echo $hh; ?>" <?php if(isset($opening_hh) && $opening_hh == $hh) echo 'selected="selected"'; ?>><?php echo $hh; ?></option>
							<?php
							endforeach;
							?>
						</select>
						<select name="opening_mm" class="time-select">
							<option value="">mm</option>
							<?php 
							foreach($mm_list as $mm):
							?>
							<option value="<?php echo $mm; ?>" <?php if(isset($opening_mm) && $opening_mm == $mm) echo 'selected="selected"'; ?>><?php echo $mm; ?></option>
							<?php
							endforeach;
							?>
						</select>
						<select name="opening_tt" class="time-select">
							<option value="">tt</option>
							<?php 
							foreach($tt_list as $tt):
							?>
							<option value="<?php echo $tt; ?>" <?php if(isset($opening_tt) && $opening_tt == $tt) echo 'selected="selected"'; ?>><?php echo $tt; ?></option>
							<?php
							endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="">Closing Time</label></td>
					<td>
						<select name="closing_hh" class="time-select">
							<option value="">hh</option>
							<?php 
							foreach($hh_list as $hh):
							?>
							<option value="<?php echo $hh; ?>" <?php if(isset($closing_hh) && $closing_hh == $hh) echo 'selected="selected"'; ?>><?php echo $hh; ?></option>
							<?php
							endforeach;
							?>
						</select>
						<select name="closing_mm" class="time-select">
							<option value="">mm</option>
							<?php 
							foreach($mm_list as $mm):
							?>
							<option value="<?php echo $mm; ?>" <?php if(isset($closing_mm) && $closing_mm == $mm) echo 'selected="selected"'; ?>><?php echo $mm; ?></option>
							<?php
							endforeach;
							?>
						</select>
						<select name="closing_tt" class="time-select">
							<option value="">tt</option>
							<?php 
							foreach($tt_list as $tt):
							?>
							<option value="<?php echo $tt; ?>" <?php if(isset($closing_tt) && $closing_tt == $tt) echo 'selected="selected"'; ?>><?php echo $tt; ?></option>
							<?php
							endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button class="orange-button" type="submit">Save</button> <a class="orange-button" href="cafes.php">Back to List</a></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>