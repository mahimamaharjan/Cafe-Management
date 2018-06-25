<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">My Cafe Hours</h1>
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
		<form action="my_cafe_hours.php" method="post">
			<table>
				<tr>
					<td><label for="">Opening Time<span class="required">*</span></label></td>
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
					<td><label for="">Closing Time<span class="required">*</span></label></td>
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
					<td><button class="orange-button" type="submit">Save</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>