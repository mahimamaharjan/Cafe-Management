<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Master Menu</h1>
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
	<a class="orange-button" href="master_menu.php?action=add">Add Master Menu Item</a>
	<table class="list-table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Type</th>
				<th>Price</th>
				<th>Date</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if($item_list): ?>
			<?php foreach($item_list as $item): ?>
			<tr>
				<td><?php echo $item['name']; ?></td>
				<td><?php echo $item['type']; ?></td>
				<td><?php echo $item['price']; ?></td>
				<td><?php echo $item['date']; ?></td>
				<td><a href="master_menu.php?action=edit&id=<?php echo $item['id']; ?>">Edit</a> | <a href="master_menu.php?action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
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
		if($item_list) {
			if($current_page != 1){
				$prev = $current_page - 1;
				echo "<div class='page-nav'><a href='master_menu.php?page=$prev'>Prev</a></div>";
			}
			for($i = 1; $i <= $num_pages; $i++) {
				echo "<div class='page-num" . ($i == $current_page ? " page-num-active" : "") . "'><a href='master_menu.php?page=$i'>$i</a></div>";
			}
			if($current_page != $num_pages) {
				$next = $current_page + 1;
				echo "<div class='page-nav'><a href='master_menu.php?page=$next'>Next</a></div>";
			}
		}
		?>
		<div class="clear"></div>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>