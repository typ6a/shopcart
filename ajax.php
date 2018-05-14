<?php
	session_start();
	require_once('config.php');
	require_once('cart.php');
	$cart = new cart();
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
	}
?>
