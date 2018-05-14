<?php
 class cart
 {
	private $db;

	function __construct()
	{
		$this->db = new mysqli(MYSQLSERVER, MYSQLUSER, MYSQLPASSWORD, MYSQLDB);
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

	public function rateProduct()
	{
		$id = $_GET["id"];
		$rate = $_GET["rate"];
		$row = $this->getProduct($id);
		$currentRate = $row->rate;
		$ratesCount = $row->ratesCount;
		$newRatesCount = $ratesCount + 1;
		$newRate = (($currentRate*$ratesCount) + $rate) / ($newRatesCount);
		$sql = 'update products set rate='. $newRate .', rates_count='. $newRatesCount .' where id='.$id;
		$query = mysqli_query($this->db, $sql);
	}

	public function emptyCart()
	{
		$_SESSION['cart'] = "";
	}

	public function getCart()
	{
		$cartArray = array();
		if ($_SESSION['cart'] != "")
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

	private function getProduct($id)
	{
		$sql = 'select * from products where id ='. $id .' limit 1';
		$query = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_row($query);
		$product = new stdClass;
		$product->id         = $row[0];
		$product->name       = $row[1];
		$product->price      = $row[2];
		$product->rate       = $row[3];
		$product->ratesCount = $row[4];
		$product->picture    = $row[5];
		return $product;
	}
 }
