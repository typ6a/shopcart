<?php
	session_start();
	$_SESSION["cash"] = 100;
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
            $cash = json_decode($_SESSION["cash"], true);
        ?>
        <div class="container-fluid">
		<h1>CART</h1>
        	<a class="btn btn-primary" href="index.php">Back to shop</a>
            <a class="emptyCart btn btn-danger">Empty cart</a>
            <a class="pay btn btn-success">&nbsp&nbsp&nbsp&nbspPay&nbsp&nbsp&nbsp&nbsp</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                	$cartTotal = 0;
                    foreach($products as $product){
                    	$cartTotal = $cartTotal + $product->total;
                ?>
                    <tr productId="<?=$product->id; ?>">
                        <td><img src="<?= $product->picture; ?>" class="rounded float-left" style="max-height: 50px"></td>
                        <td><?= $product->name; ?></td>
                        <td>$<?= $product->price; ?></td>
                        <td>
                            <input type="text" class="qty form-control" placeholder="<?= $product->qty; ?>">
                        </td>
                        <td>$<?= $product->total; ?></td>
                       
                        <td><button class="update btn btn-outline-danger">Update</button></td>
                        <td><button class="removeFromCart btn btn-outline-danger">Remove</button></td>
                    </tr>
                <?php 
                    }
                ?>
    		</table>
            <div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text">Transport</label>
				</div>
				<select class="transport custom-select" id="">
					<option selected>N/A</option>
                    <option value="0">pick up</option>
                    <option value="5">UPS</option>
				</select>
			</div>
			<br>
        	<p class="font-weight-bold">Cash: $<span class="cash"><?=$cash?></span>  </p>
        	<p class="font-weight-bold">Cost: $<span class="cost"><?=$cartTotal?></span>  </p>
        	<p class="font-weight-bold">Rest: $<span class="rest"><?=$cash - $cartTotal?></span>  </p>
        </div>
	</body>
</html>