<?php
	require_once('loader.php');
	$cart = new Cart();
	$action = strip_tags($_GET['action']);
	switch ($action) 
	{
		case 'add':
			$cart->addToCart();
			break;
		case 'remove':
			$cart->removeFromCart();
			break;
		case 'rate':
			$cart->rateProduct();
			break;
		case 'empty':
			$cart->emptyCart();
			break;
		case 'update':
			$cart->updateCart();
			break;
		case 'pay':
			$cart->pay();
			break;
	}
?>
