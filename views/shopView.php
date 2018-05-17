<html>
    <head>
        <title>SHOP</title>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.x-git.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <script type="text/javascript" src="../main.js"></script>
    </head>
    <body>
        <?php
            $cart = new Cart();
            $products = $cart->getProducts();
            $cash = $cart->cartCalc()[0];
        ?>
        <div class="container-fluid">
        <h1>SHOP <?= $_SESSION['username'] ?></h1>
            <a href="../cart.php" class="btn btn-primary">Go to cart</a>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Qty</th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                    foreach($products as $product){
                ?>
                    <tr productId="<?=$product->id; ?>">
                        <td><img src="../<?= $product->picture; ?>" class="rounded float-left" style="height: 75"></td>
                        <td><?= $product->name; ?></td>
                        <td>$<?= $product->price; ?></td>
                        <td>
                            <div class="input-group">
                                <select class="rateSelect custom-select" id="">
                                    <option selected>5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="rate btn btn-outline-info">Rate</button>
                                </div>
                            </div>
                            <div>Current rating: <?=number_format($product->rate, 2, '.', ''); ?></div><div> Votes: <?=$product->ratesCount; ?></div>
                        </td>
                        <td>
                            <input type="text" class="qty form-control" placeholder="">
                        </td>

                        <td>
                            <button class="addToCart btn btn-outline-danger">Add to cart</button>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </table>
            <p class="font-weight-bold">Cash: $<span class="cash"><?=$cash?></span>  </p>
        </div>
    </body>
</html>