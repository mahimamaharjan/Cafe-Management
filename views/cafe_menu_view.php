<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading"><?php echo $cafe['name']; ?> Menu (<?php echo $date; ?>)</h1>
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
	<a class="orange-button" href="cafe_menu.php?cafe=<?php echo $cafe_id; ?>&date=<?php echo $date; ?>&action=add">Add Item</a>
	<table class="list-table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Type</th>
				<th>Price</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if($cafe_item_list): ?>
			<?php foreach($cafe_item_list as $item): ?>
			<tr>
				<td><?php echo $item['name']; ?></td>
				<td><?php echo $item['type']; ?></td>
				<td><?php echo $item['price']; ?></td>
				<td><a href="cafe_menu.php?cafe=<?php echo $cafe_id; ?>&date=<?php echo $date; ?>&action=delete&item_id=<?php echo $item['item_id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
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
		if($cafe_item_list) {
			if($current_page != 1){
				$prev = $current_page - 1;
				echo "<div class='page-nav'><a href='cafe_menu.php?cafe=$cafe_id&date=$date&page=$prev'>Prev</a></div>";
			}
			for($i = 1; $i <= $num_pages; $i++) {
				echo "<div class='page-num" . ($i == $current_page ? " page-num-active" : "") . "'><a href='cafe_menu.php?cafe=$cafe_id&date=$date&page=$i'>$i</a></div>";
			}
			if($current_page != $num_pages) {
				$next = $current_page + 1;
				echo "<div class='page-nav'><a href='cafe_menu.php?cafe=$cafe_id&date=$date&page=$next'>Next</a></div>";
			}
		}
		?>
		<div class="clear"></div>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>