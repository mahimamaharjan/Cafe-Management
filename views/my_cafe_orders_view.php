<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">My Cafe Orders (<?php echo date('Y-m-d'); ?>)</h1>
	<table class="list-table">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>User</th>
				<th>Collection Time</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if($order_list): ?>
			<?php foreach($order_list as $order): ?>
			<tr>
				<td><?php echo $order['id']; ?></td>
				<td><?php echo $order['user']; ?></td>
				<td><?php echo get12HourFormat($order['collection_time']); ?></td>
				<td><a href="my_cafe_orders.php?action=details&id=<?php echo $order['id']; ?>">View Details</a></td>
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
		if($order_list) {
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