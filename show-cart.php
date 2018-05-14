<?php
require_once '../kdg/libs/debug.php';
	session_start();
	require_once("config.php");
	require_once("cart.php");
?>
<html>
	<head>
		<title>CART</title>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.x-git.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
		<script type="text/javascript" src="main.js"></script>
	</head>
	<body>
        <?php
            $cart = new cart();
            $products = $cart->getCart();
        ?>
        <div class="container-fluid">
		<h1>CART</h1>
            <a class="btn btn-primary" href="index.php">Back to shop</a>
            <a class="emptyCart btn btn-danger">Empty cart</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Qty</th>
                        <th>Transport</th>
                      
                        <th></th>
                    </tr>
                </thead>
                <?php
                    foreach($products as $product){
                ?>
                    <tr productId="<?=$product->id; ?>">
                        <td><img src="<?= $product->picture; ?>" class="rounded float-left" style="max-height: 50px"></td>
                        <td><?= $product->name; ?></td>
                        <td>$<?= $product->price; ?></td>
                        <td>$<?= $product->total; ?></td>
                    
                        <td>
                            <input type="text" class="qty form-control" placeholder="<?= $product->qty; ?>">
                        </td>
                        <td>
                            <div class="input-group">
                                <select class="transport custom-select" id="">
                                    <option selected></option>
                                    <option value="0">pick up</option>
                                    <option value="5">UPS</option>
                                </select> 
                            </div>
                        </td>
                 
                        <td><button class="refresh btn btn-outline-danger">Refresh</button></td>
                    </tr>
                <?php 
                    } 
                ?>
    		</table>
        </div>
		<br /><a href="index.php" title="go back to products">Go back to products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="emptyCart" title="empty cart">Empty cart</a>
	</body>
</html>