<?php include_once 'includes/header.php'; ?>
<div class="container">
	<h1 class="content-heading">Order Details</h1>
	<table>
		<tr>
			<td>Order ID</td>
			<td><?php echo $order['id']; ?></td>
		</tr>
		<tr>
			<td>Date</td>
			<td><?php echo $order['date']; ?></td>
		</tr>
		<tr>
			<td>Cafe</td>
			<td><?php echo $order['cafe']; ?></td>
		</tr>
		<tr>
			<td>User</td>
			<td><?php echo $order['user']; ?></td>
		</tr>
		<tr>
			<td>Collection Time</td>
			<td><?php echo get12HourFormat($order['collection_time']); ?></td>
		</tr>
	</table>
	<h1 class="content-heading">Order Items</h1>
	<table class="list-table">
		<thead>
			<tr>
				<th>Item</th>
				<th class="price-cell">Price</th>
				<th>Quantity</th>
				<th class="price-cell">Amount</th>
				<th>Comment</th>
			</tr>
		</thead>
		<tbody>
			<?php $sub_total = 0; ?>
			<?php if($item_list): ?>
			<?php foreach($item_list as $item): ?>
			<tr>
				<td><?php echo $item['item']; ?></td>
				<td class="price-cell"><?php echo $item['price']; ?></td>
				<td><?php echo $item['quantity']; ?></td>
				<?php $amount = $item['quantity'] * $item['price']; $sub_total += $amount; ?>
				<td class="price-cell"><?php echo number_format($amount, 2, '.', ''); ?></td>
				<td><?php echo $item['comment']; ?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="3">Sub Total</td>
				<td class="price-cell"><?php echo number_format($sub_total, 2, '.', ''); ?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3">Discount</td>
				<?php $discount = $sub_total * $order['discount_rate'] / 100; ?>
				<td class="price-cell"><?php echo number_format($discount, 2, '.', ''); ?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3">Total</td>
				<td class="price-cell"><?php echo number_format($sub_total - $discount, 2, '.', ''); ?></td>
				<td></td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="5">No Data Available</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
<?php include_once 'includes/footer.php'; ?>