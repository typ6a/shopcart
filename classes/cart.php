<?php
class Cart
 {
	private $db;

	function __construct()
	{
		$this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	}

	function __destruct()
	{
		$this->db->close();
	}


	public function getProducts()
	{
		$query=mysqli_query($this->db, 'select * from products');
		$allProducts = array();
		while ($row=mysqli_fetch_row($query))
	    {
	    	$product = new stdClass;
			$product->id         = $row[0];
			$product->name       = $row[1];
			$product->price      = $row[2];
			$product->rate       = $row[3];
			$product->ratesCount = $row[4];
			$product->picture    = $row[5];
			$products[] = $product;
	    }
		return $products;
	}

	public function addToCart()
	{
		$id = intval($_GET["id"]);
		$qty = intval($_GET["qty"]);
			if($_SESSION['cart'] != "")
			{
				$cart = json_decode($_SESSION['cart'], true);
				$found = false;
				for($i = 0; $i < count($cart); $i++){
					if($cart[$i]["product"] == $id){
						$cart[$i]["qty"] = $cart[$i]["qty"]+$qty;
						$found = true;
						break;
					}
				}
				if(!$found)
				{
					$line = new stdClass;
					$line->product = $id;
					$line->qty = $qty;
					$cart[] = $line;
				}
				$_SESSION['cart'] = json_encode($cart);
			}
			else
			{
				$line = new stdClass;
				$line->product = $id;
				$line->qty = $qty;
				$cart[] = $line;
				$_SESSION['cart'] = json_encode($cart);
			}
	}

	public function UpdateCart()
	{
		$id = intval($_GET["id"]);
		$qty = intval($_GET["qty"]);
		$row = $this->getProduct($id);
		$cart = json_decode($_SESSION['cart'], true);
		for($i = 0; $i < count($cart); $i++)
		{
			if($cart[$i]["product"] == $id)
			{
				$cart[$i]["qty"] = $qty;
				$cart[$i]["total"] = $qty * $this->getProduct($id)->price;
			}
		}
		$_SESSION['cart'] = json_encode($cart);
	}

	protected function getProduct($id)
	{
		$sql = 'select * from products where id ='. $id .' limit 1';
		$query = mysqli_query($this->db, $sql);
		$result = mysqli_fetch_assoc($query);
		return (object) $result;
	}

	
	public function cartCalc() 
	{
		$cash = $_SESSION['cash'];
		$products = $this->getCart();
		$cartTotal = 0;
		foreach ($products as $product) 
		{
			$cartTotal = $cartTotal + $product->total;
		}
		$cost = $cartTotal;
		$rest = $cash - $cost;
		return [$cash, $cost, $rest];
	}

	public function pay() 
	{
		$transport = $_GET["transport"];
		$_SESSION['cash'] = $_SESSION['cash'] - $this->cartCalc()[1] - $transport;
	}

	public function removeFromCart()
	{
		$id = $_GET["id"];
		if($id > 0)
		{
			if($_SESSION['cart'] != "")
			{
				$cart = json_decode($_SESSION['cart'], true);
				for($i = 0; $i < count($cart); $i++)
				{
					if($cart[$i]["product"] == $id)
					{
							unset($cart[$i]);
						break;
					}
				}
				$cart = array_values($cart);
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}
	
	public function getUserId($name)
	{
		$sql = "select id from users where username = '$name' limit 1";
		$query = mysqli_query($this->db, $sql);
		$result = mysqli_fetch_assoc($query);
		return $result['id'];
	}

	public function isRated($userId, $productId)
	{
		$sql = "select value from rates where user_id = '$userId' && product_id = '$productId' limit 1";
		$query = mysqli_query($this->db, $sql);
		$result = mysqli_fetch_assoc($query);
		return $result;
	}

	public function rateProduct()
	{
		$productId = intval($_GET["id"]);
		$userId = intval($this->getUserId($_SESSION['username']));

		if ($this->isRated($userId, $productId) != NULL) {
			return false;
		}
		elseif ($this->isRated($userId, $productId) == NULL) {
			$rate = intval($_GET["rate"]);
			$userName = $_SESSION['username'];
			$row = $this->getProduct($productId);
			$currentRate = $row->rate;
			$ratesCount = $row->rates_count;
			$newRatesCount = $ratesCount + 1;
			$newRate = (($currentRate*$ratesCount) + $rate) / ($newRatesCount);
			$sqlProducts = 'update products set rate='. $newRate .', rates_count='. $newRatesCount .' where id='.$productId;
			mysqli_query($this->db, $sqlProducts);
			$sqlRates = "insert into rates (value, user_id, product_id) values ('".$rate."', '".$userId."', '".$productId."')";
			mysqli_query($this->db, $sqlRates);
		}
	}

	public function emptyCart()
	{
		$_SESSION['cart'] = "";
	}

	public function getCart()
	{
		$cartArray = array();
		if (!empty($_SESSION['cart']))
		{
			$cart = json_decode($_SESSION['cart'], true);
			for ($i = 0; $i < count($cart); $i++)
			{
				$row = $this->getProduct($cart[$i]["product"]);
				$product = new stdClass;
				$product->id      = $cart[$i]["product"];
				$product->qty     = $cart[$i]["qty"];
				$product->name    = $row->name;
				$product->price   = $row->price;
				$product->total   = $row->price*$cart[$i]["qty"];
				$product->picture = $row->picture;
				$cartArray[]      = $product;
			}
		}
		return $cartArray;
	}

 }
