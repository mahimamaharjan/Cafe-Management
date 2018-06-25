<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Staff</h1>
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
	?>
	<a class="orange-button" href="staff.php?action=add">Add Staff</a>
	<table class="list-table">
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Type</th>
				<th>Cafe</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if($staff_list): ?>
			<?php foreach($staff_list as $staff): ?>
			<tr>
				<td><?php echo $staff['first_name']; ?></td>
				<td><?php echo $staff['last_name']; ?></td>
				<td><?php echo $staff['type']; ?></td>
				<td><?php echo $staff['cafe']; ?></td>
				<td><a href="staff.php?action=edit&id=<?php echo $staff['id']; ?>">Edit</a> | <a href="staff.php?action=delete&id=<?php echo $staff['id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="5">No Data Available</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="pagination">
		<?php
		if($staff_list) {
			if($current_page != 1){
				$prev = $current_page - 1;
				echo "<div class='page-nav'><a href='staff.php?page=$prev'>Prev</a></div>";
			}
			for($i = 1; $i <= $num_pages; $i++) {
				echo "<div class='page-num" . ($i == $current_page ? " page-num-active" : "") . "'><a href='staff.php?page=$i'>$i</a></div>";
			}
			if($current_page != $num_pages) {
				$next = $current_page + 1;
				echo "<div class='page-nav'><a href='staff.php?page=$next'>Next</a></div>";
			}
		}
		?>
		<div class="clear"></div>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>