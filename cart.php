<?php
/*
 * Shopping Cart - Manipulate the item of a shopping cart using AJAX
 *
 * @category    E-Commerce
 * @package     AJAX
 * @author      Ashraf Gheith <nurazije@gmail.com>
 * @license     http://www.php.net/license/2_02.txt   The PHP License
 * @link        http://www.phpclasses.org/browse/package/3188.html
 */
 require_once '../kdg/libs/debug.php';
 class cart{
	private $db;
	
	function __construct(){
		$this->db = new mysqli(MYSQLSERVER, MYSQLUSER, MYSQLPASSWORD, MYSQLDB);
	}
	
	function __destruct(){
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
			$products[]       = $product;
	    }
		// pre($products);
		return $products;
	}


	// {
	// 	$arr = array();
	// 	$dbConnection = $this->dbConnection;
	// 	$dbConnection->query( "SET NAMES 'UTF8'" );
	// 	$statement = $dbConnection->prepare("select id, product, price from products order by product asc");
	// 	$statement->execute();
	// 	$statement->bind_result( $id, $product, $price);
	// 	while ($statement->fetch()){
	// 		$line = new stdClass;
	// 		$line->id = $id; 
	// 		$line->product = $product; 
	// 		$line->price = $price;
	// 		$arr[] = $line;
	// 	}
	// 	$statement->close();
	// 	return $arr;
	// }
	
	public function addToCart(){
		$id = intval($_GET["id"]);
		$qty = intval($_GET["qty"]);
		// pre($id);
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				$found = false;
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["product"] == $id){
						$cart[$i]["qty"] = $cart[$i]["qty"]+$qty;
						$found = true;
						break;
					}
				}
				if(!$found){
					$line = new stdClass;
					$line->product = $id; 
					$line->qty = $qty;
					$cart[] = $line;
				}
				$_SESSION['cart'] = json_encode($cart);
			}else{
				$line = new stdClass;
				$line->product = $id; 
				$line->qty = $qty;
				$cart[] = $line;
				$_SESSION['cart'] = json_encode($cart);
			}
	
	}
	
	public function removeFromCart(){
		$id = intval($_GET["id"]);
		// $qty = intval($_GET["qty"]);

		if($id > 0){
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["product"] == $id){
						$cart[$i]["qty"] = $cart[$i]["qty"]-1;
						if($cart[$i]["qty"] < 1){
							unset($cart[$i]);
						}
						break;
					}
				}
				$cart = array_values($cart);
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}
	
	public function emptyCart(){
		$_SESSION['cart'] = "";
	}
	
	public function getCart(){
		$cartArray = array();
		if($_SESSION['cart'] != ""){
			$cart = json_decode($_SESSION['cart'], true);
			for($i=0;$i<count($cart);$i++){
				$row = $this->getProduct($cart[$i]["product"]);
				$product = new stdClass;
				$product->id      = $cart[$i]["product"];
				$product->qty     = $cart[$i]["qty"];
				$product->name    = $row->name;
				$product->price   = $row->price;
				$product->total   = ($row->price*$cart[$i]["qty"]);
				$product->picture = $row->picture;
				$cartArray[]      = $product;
			}
		}
			pre($cartArray);
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
		// pre($product,1);

		// $db = $this->db;
		// // $db->query( "SET NAMES 'UTF8'" );
		// $statement = $db->prepare("select name, price from products where id = ? limit 1");
		// $statement->bind_param( 'i', $id);
		// $statement->execute();
		// $statement->bind_result( $product, $price);
		// $statement->fetch();
		// $line = new stdClass;
		// $line->product = $product; 
		// $line->price = $price;
		// $statement->close();
		return $product;
	}
 }
 

 // {
	// 	$query=mysqli_query($this->db, 'select * from products');
	// 	$allProducts = array();
	// 	while ($row=mysqli_fetch_row($query))
	//     {
	//     	$line = new stdClass;
	// 		$line->id      = $row[0]; 
	// 		$line->name    = $row[1]; 
	// 		$line->price   = $row[2]; 
	// 		$line->rate    = $row[3]; 
	// 		$line->picture = $row[4]; 
	// 		$products[] = $line;
	//     }
	// 	// pre($products);
	// 	return $products;
	// }