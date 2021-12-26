<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
ob_start(); 
	/**
	* 
	*/
	class cart
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function doanhthungay(){
			$query="SELECT Date(date_order) as 'Ngay', Sum(totalprice) as 'DT' FROM tbl_order WHERE status='2' Group by Date(date_order) LIMIT 30";
			$result = $this->db->select($query);
			return $result;
		}
		public function doanhthungay2(){
			$query="SELECT Date(date_order) as 'Ngay', Sum(totalprice) as 'DT' FROM tbl_order WHERE status='2' Group by Date(date_order) LIMIT 30";
			$result = $this->db->select($query);
			return $result;
		}
		public function add_to_cart($quantity, $id){
			$quantity = $this->fm->validation($quantity);
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$id = mysqli_real_escape_string($this->db->link, $id);
			$sId = session_id();
			$check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId ='$sId'";
			$result_check_cart = $this->db->select($check_cart);
			if($result_check_cart){
				$msg = "<span class='error'>Sản phẩm đã có trong giỏ hàng của bạn rồi</span>";
				return $msg;
			}else{

				$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
				$result = $this->db->select($query)->fetch_assoc();
				
				$image = $result["image"];
				$price = $result["price"];
				$productName = $result["productName"];

				$query_insert = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName) VALUES('$id','$quantity','$sId','$image','$price','$productName')";
				$insert_cart = $this->db->insert($query_insert);
				if($insert_cart){
					header('Location:cart.php');
					$msg = "<span class='error'>Thêm sản phẩm thành công</span>";
					return $msg;
					
				}
			}
		}
		public function get_product_cart()
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_quantity_Cart($proId,$cartId, $quantity)
		{
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$cartId = mysqli_real_escape_string($this->db->link, $cartId);
			$proId = mysqli_real_escape_string($this->db->link, $proId);

			$query_product = "SELECT * FROM tbl_product WHERE productId = '$proId' ";
			$result_product = $this->db->select($query_product)->fetch_assoc();
			if($quantity<=$result_product['product_remain']){
				$query = "UPDATE tbl_cart SET

				quantity = '$quantity'

				WHERE cartId = '$cartId'";

				$result = $this->db->update($query);
				if ($result) {
					header('Location:cart.php');
				}else {
					$msg = "<span class='erorr'> Cập nhật số lượng sản phẩm không thành công!</span> ";
					return $msg;
				}
			}else{
				$msg = "<span class='erorr'> Số lượng ".$quantity." bạn đặt quá số lượng chúng tôi chỉ còn ".$result_product['product_remain']." chiếc</span> ";
				return $msg;
			}

		}
		public function del_product_cart($cartid){
			$cartid = mysqli_real_escape_string($this->db->link, $cartid);
			$query = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";
			$result = $this->db->delete($query);
			if($result){
				header('Location:cart.php');
			}else{
				$msg = "<span class='error'>Sản phẩm đã được xóa</span>";
				return $msg;
			}
		}

		public function check_cart()
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function check_order($customer_id)
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function del_all_data_cart()
		{
			$sId = session_id();
			$query = "DELETE FROM tbl_cart WHERE sId = '$sId' ";
			$result = $this->db->delete($query);
		}
		public function del_compare($customer_id){
			$sId = session_id();
			$query = "DELETE FROM tbl_compare WHERE customer_id = '$customer_id'";
			$result = $this->db->delete($query);
			return $result;
		}
		
		public function insertOrdercon($customer_id){
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE  sId= '$sId'";
			$get_product = $this->db->select($query);
			if($get_product){
				while($result = $get_product->fetch_assoc()){
					$quantity = $result['quantity'];
					$ship=30000;
					$price += $result['price'] * $quantity +$ship;
					}
					$customer_id = $customer_id;
					$query_order = "INSERT INTO tbl_order(totalprice,customer_id) VALUES('$price','$customer_id')";
					$insert_order = $this->db->insert($query_order);

			}
			if($insert_order){
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart,tbl_order WHERE sId = '$sId' and id=(SELECT MAX(id) FROM tbl_order) ";
			$get_product = $this->db->select($query);
			if($get_product){
				while($result = $get_product->fetch_assoc()){
					$id=$result['id'];
					$productid = $result['productId'];
					$productName = $result['productName'];
					$quantity = $result['quantity'];
					$price = $result['price'];
					$image = $result['image'];
					$customer_id = $customer_id;
					// $query_order = "INSERT INTO tbl_orderdetail(oder_id,product_id,productName,quantity,price,image,customer_id) VALUES('$oder_id','$productid','$productName','$quantity','$price','$image','$customer_id')";
					$query_order = "INSERT INTO tbl_orderdetail(order_id,product_id,productName,quantity,price,image,customer_id) VALUES('$id','$productid','$productName','$quantity','$price','$image','customer_id')";
					$insert_order = $this->db->insert($query_order);
				}
			}
				}
	}
		public function getAmountPrice($customer_id)
		{
			$query = "SELECT totalprice FROM tbl_order WHERE customer_id = '$customer_id' ";
			$get_price = $this->db->select($query);
			return $get_price;
		}
		// public function get_cart_ordered($customer_id)
		// {
		// 	$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id' order by date_order desc ";
		// 	$get_cart_ordered = $this->db->select($query);
		// 	return $get_cart_ordered;
		// }
		public function get_cart_order($customer_id){
			$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id' order by date_order desc ";
			$get_cart_ordered = $this->db->select($query);
			return $get_cart_ordered;
		}
		public function get_cart_orderdetail($order_id){
			$query = "SELECT * FROM tbl_orderdetail WHERE order_id='$order_id'";
			$get_cart_ordered = $this->db->select($query);
			return $get_cart_ordered;
		}
		public function get_cart_customers($id){
			$query = "SELECT customer_id FROM tbl_order WHERE id='$id'";
			$get_cart_ordered = $this->db->select($query);
			return $get_cart_ordered;
		}
		public function get_order_list()
		{
			$query = "SELECT * FROM tbl_order order by date_order desc";
			$get_inbox_cart = $this->db->select($query);
			return $get_inbox_cart;
		}
		
		public function shifted($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$a="SELECT * FROM tbl_orderdetail WHERE order_id='$id'";
			$get=$this->db->select($a);
			if ($get){
				while ($result = $get->fetch_assoc() ) {
					$proid=$result['product_id'];
					$qty=$result['quantity'];
					$query_select = "SELECT * FROM tbl_product WHERE productId='$proid'";
					$get_select = $this->db->select($query_select);

					if($get_select){
						while($result = $get_select->fetch_assoc()){
							$soluong_new = $result['product_remain'] - $qty;
							$qty_soldout = $result['product_soldout'] + $qty;

							$query_soluong = "UPDATE tbl_product SET

							product_remain = '$soluong_new',product_soldout = '$qty_soldout' WHERE productId = '$proid'";
							$result = $this->db->update($query_soluong);
				}
			}
				}
				

			}
			

			$query = "UPDATE tbl_order SET

			status = '1'

			WHERE id = '$id' AND date_order = '$time' AND totalprice = '$price' ";


			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Cập nhật đơn thành thành công</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Cập nhật đơn hàng không thành công</span> ";
				return $msg;
			}
		}
		public function shifted2($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			
			$query = "UPDATE tbl_order SET

			status = '2'

			WHERE id = '$id' AND date_order = '$time' AND totalprice = '$price' ";


			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Cập nhật đơn thành thành công</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Cập nhật đơn hàng không thành công</span> ";
				return $msg;
			}
		}
		public function del_shifted($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$query = "DELETE FROM tbl_order 
					  WHERE id = '$id' AND date_order = '$time' AND totalprice = '$price' ";

			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Xóa thành công đơn hàng</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Xóa không thành công đơn hàng</span> ";
				return $msg;
			}
		}
		public function shifted_confirm($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$query = "UPDATE tbl_order SET

			status = '2'

			WHERE customer_id = '$id' AND date_order = '$time' AND totalprice = '$price' ";

			$result = $this->db->update($query);
			return $result;
		}
	}
 ?>