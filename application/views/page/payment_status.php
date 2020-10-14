<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Stripe Payment Status</title>
<meta charset="utf-8">

<!-- Stylesheet file -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
<div class="container">
	<div class="status">
		<?php if(!empty($order)){ ?>
			
			<!-- Display transaction status -->
			<?php if($order['payment_status'] == 'succeeded'){ ?>
			<h1 class="success">Your Payment has been Successful!</h1>
			<?php }else{ ?>
			<h1 class="error">The transaction was successful! But your payment has been failed!</h1>
			<?php } ?>
			
			<h4>Payment Information</h4>
			<p><b>Reference Number:</b> <?php echo $order['id']; ?></p>
			<p><b>Transaction ID:</b> <?php echo $order['txn_id']; ?></p>
			<p><b>Paid Amount:</b> <?php echo $order['paid_amount'].' '.$order['paid_amount_currency']; ?></p>
			<p><b>Payment Status:</b> <?php echo $order['payment_status']; ?></p>
			
			<h4>Product Information</h4>
			<p><b>Name:</b> <?php echo $order['product_name']; ?></p>
			<p><b>Price:</b> <?php echo $order['product_price'].' '.$order['product_price_currency']; ?></p>
		<?php }else{ ?>
			<h1 class="error">The transaction has failed</h1>
		<?php } ?>
	</div>
	<a href="<?php echo base_url('products/'); ?>" class="btn-link">Back to Product Page</a>
</div>
</body>
</html>