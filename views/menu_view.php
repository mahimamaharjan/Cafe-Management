<?php include_once 'includes/header.php'; ?>
<div class="container">
	<div class="cafe-heading">
		<div class="cafe-title"><?php echo $cafe['name']; ?></div>
		<div class="cafe-hours">Cafe Hours: <?php echo get12HourFormat($cafe['opening_time']) . ' - ' . get12HourFormat($cafe['closing_time']); ?></div>
	</div>
	<div id="menu_container">
		<div class="menu-table-div">
			<h2>Food</h2>
			<table id="food_tbl">
				
			</table>
		</div>
		<div class="menu-table-div">
			<h2>Beverages</h2>
			<table id="beverage_tbl">
				
			</table>
		</div>
		<div class="clear"></div>
	</div>
    <?php if($can_place_order): ?>
    <h1 class="content-heading">My Order</h1>
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
	<div>Balance: <span class="balance">0.00</span></div>
	<form action="menu.php?cafe=<?php echo $cafe['id']; ?>" method="post">
		<table id="order_tbl">
			<thead>
				<tr>
					<th>Item</th>
					<th class="price-cell">Price</th>
					<th>Quantity</th>
					<th class="price-cell">Amount</th>
					<th>Comment</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="items-tbody"></tbody>
			<tbody class="empty-tbody">
				<tr>
					<td colspan="6">No Items Added</td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
		<table class="order-extra-table">
			<tr>
				<td>Sub Total</td>
				<td class="price-cell"><span class="sub_total">0.00</span></td>
			</tr>
			<tr>
				<td>Discount</td>
				<td class="price-cell"><span class="discount">0.00</span></td>
			</tr>
			<tr>
				<td>Total</td>
				<td class="price-cell"><span class="total">0.00</span></td>
			</tr>
			<tr>
				<td><label for="collection_time">Collection Time<span class="required">*</span></label></td>
				<td>
					<select name="collection_time" id="collection_time">
						<option value="">Select Time</option>
						<?php foreach($time_list as $time): ?>
						<option value="<?php echo $time; ?>" <?php if(isset($collection_time) && $collection_time == $time) echo 'selected="selected"'; ?>><?php echo $time; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit">Place Order</button></td>
			</tr>
		</table>
	</form>
	<?php endif; ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var items = <?php echo $cafe_item_list ? json_encode($cafe_item_list) : '{}'; ?>;

	$.each(items, function(key, value){
		var html = '<tr data-id="' + key + '">';
		html += '<td>' + value['name'] + '</td>';
		html += '<td class="price-cell">' + value['price'] + '</td>';
		<?php if($can_place_order): ?>
		html += '<td><button class="add-item-btn">Add to Order</button</td>';
		<?php endif; ?>
		html += '</tr>';
		if(value['type'] == 'food') {
			$('#food_tbl').append(html);
		}
		else {
			$('#beverage_tbl').append(html);	
		}
	});

	if($('#food_tbl tr').length == 0) {
		var html = '';
		html += '<tr>';
		html += '<td colspan="<?php echo $can_place_order ? 3 : 2; ?>">No Items Available</td>';
		html += '</tr>';

		$('#food_tbl').append(html);
	}

	if($('#beverage_tbl tr').length == 0) {
		var html = '';
		html += '<tr>';
		html += '<td colspan="<?php echo $can_place_order ? 3 : 2; ?>">No Items Available</td>';
		html += '</tr>';
		
		$('#beverage_tbl').append(html);
	}

	<?php if($can_place_order): ?>
	var discount_rate = <?php echo $_SESSION['user_type'] == 'student' ? 10 : 0 ;?>;
	var balance = <?php echo $user_balance; ?>;
	$('.balance').html(balance.toFixed(2));
	
	$('#menu_container').on('click', '.add-item-btn', function(){
		var id = $(this).closest('tr').data('id');
		addToOrder(id, 1, '');
	});

	$('#order_tbl').on('click', '.remove-item-btn', function(){
		var id = $(this).closest('tr').data('id');
		removeFromOrder(id);
	});

	$('#order_tbl').on('keyup', '.quantity', function(){
		var quantity = +$(this).val().trim();
		if(isNaN(quantity) || quantity < 0) {
			quantity = 0;
		}
		var id = $(this).closest('tr').data('id');
		var item = items[id];
		if(item) {
			var amount = parseInt(quantity) * item.price;
			$('#order_tbl .items-tbody tr[data-id=' + id + '] .amount').html(amount.toFixed(2));
		}
		calculateTotal();
	});

	function addToOrder(id, quantity, comment) {
		var item = items[id];
		if(item && $('#order_tbl .items-tbody tr[data-id=' + id + ']').length == 0) {
			var html = '<tr data-id="' + id + '">';
			html += '<td>' + item['name'] +'</td>';
			html += '<td class="price-cell"><span class="price">' + item['price'] +'</span></td>';
			html += '<td><input type="text" class="quantity" name="quantity[]" value="' + quantity + '" /></td>';

			quantity = +quantity;
			if(isNaN(quantity) || quantity < 0) {
				quantity = 0;
			}

			html += '<td class="price-cell"><span class="amount">' + (item['price'] * quantity).toFixed(2) +'</span></td>';
			html += '<td><input type="text" class="comment" name="comment[]" value="' + comment + '" /></td>';
			html += '<td><button class="remove-item-btn">Remove</button><input type="hidden" name="item[]" value="' + id + '" /></td>';
			html += '</tr>';

			$('#order_tbl .empty-tbody').hide();
			$('#order_tbl .items-tbody').append(html);
			calculateTotal();
		}
	}

	function removeFromOrder(id) {
		$('#order_tbl .items-tbody tr[data-id=' + id +']').remove();
		if($('#order_tbl .items-tbody tr').length == 0) {
			$('#order_tbl .empty-tbody').show();
		}
		calculateTotal();
	}

	function calculateTotal() {
		var sub_total = 0;
		$('#order_tbl .items-tbody tr .amount').each(function(){
			sub_total += +$(this).html();
		});

		var discount = sub_total * discount_rate / 100;
		var total = sub_total - discount;

		$('.sub_total').html(sub_total.toFixed(2));
		$('.discount').html(discount.toFixed(2));
		$('.total').html(total.toFixed(2));
		$('.balance').html((balance - total).toFixed(2));
	}

	<?php
	if(isset($items) && isset($quantities) && isset($comments)):
		for($i = 0; $i < count($items); $i++):
	?>
	addToOrder('<?php echo $items[$i]; ?>', '<?php echo $quantities[$i]; ?>', '<?php echo $comments[$i]; ?>');
	<?php
		endfor;
	endif;
	?>
	<?php endif; ?>
});
</script>
<?php include_once 'includes/footer.php'; ?>