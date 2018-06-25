<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Cafes</h1>
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
	<a class="orange-button" href="cafes.php?action=add">Add Cafe</a>
	<table class="list-table">
		<thead>
			<tr>
				<th>Cafe</th>
				<th>Opening Time</th>
				<th>Closing Time</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if($cafe_list): ?>
			<?php foreach($cafe_list as $cafe): ?>
			<tr>
				<td><?php echo $cafe['name']; ?></td>
				<td><?php echo $cafe['opening_time'] ? get12HourFormat($cafe['opening_time']) : 'Not Set'; ?></td>
				<td><?php echo $cafe['closing_time'] ? get12HourFormat($cafe['closing_time']) : 'Not Set'; ?></td>
				<td><a href="cafes.php?action=edit&id=<?php echo $cafe['id']; ?>">Edit</a> | <a href="cafes.php?action=delete&id=<?php echo $cafe['id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="4">No Data Available</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="pagination">
		<?php
		if($cafe_list) {
			if($current_page != 1){
				$prev = $current_page - 1;
				echo "<div class='page-nav'><a href='cafes.php?page=$prev'>Prev</a></div>";
			}
			for($i = 1; $i <= $num_pages; $i++) {
				echo "<div class='page-num" . ($i == $current_page ? " page-num-active" : "") . "'><a href='cafes.php?page=$i'>$i</a></div>";
			}
			if($current_page != $num_pages) {
				$next = $current_page + 1;
				echo "<div class='page-nav'><a href='cafes.php?page=$next'>Next</a></div>";
			}
		}
		?>
		<div class="clear"></div>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>