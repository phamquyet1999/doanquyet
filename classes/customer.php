<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class customer
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_customer($date)
		{
			$name = mysqli_real_escape_string($this->db->link, $date['name']);
			$city = mysqli_real_escape_string($this->db->link, $date['city']);
			$email = mysqli_real_escape_string($this->db->link, $date['email']);
			$address = mysqli_real_escape_string($this->db->link, $date['address']);
			$phone = mysqli_real_escape_string($this->db->link, $date['phone']);
			$password = mysqli_real_escape_string($this->db->link, md5($date['password']));

			if($name == "" || $city == "" || $email == "" || $address == "" || $phone == "" || $password == ""){
				$alert = "<span class='error'>Không được để trống các trường</span>";
				return $alert;
			}else{
				$check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
				$result_check = $this->db->select($check_email);
				if ($result_check) {
					$alert = "<span class='error'>Email này đã được đăng ký! Vui lòng nhập Email khác </span>";
					return $alert;
				}else {
					$query = "INSERT INTO tbl_customer(name,city,email,address,phone,password) VALUES('$name','$city','$email','$address','$phone','$password') ";
					$result = $this->db->insert($query);
					if($result){
						$alert = "<span class='success'>Thêm thành công</span>";
						return $alert;
					}else {
						$alert = "<span class='error'>Thêm không thành công</span>";
						return $alert;
					}
				}
			}
		}
		public function login_customer($date)
		{
			$email =  $date['email'];
			$password = md5($date['password']);
			if($email == '' || $password == ''){
				$alert = "<span class='error'>Email và Password không được để trống</span>";
				return $alert;
			}else{
				$check_login = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password' ";
				$result_check = $this->db->select($check_login);
				if ($result_check != false) {
					$value = $result_check->fetch_assoc();
					Session::set('customer_login', true);
					Session::set('customer_id', $value['id']);
					Session::set('customer_name', $value['name']);
					header('Location:index.php');
				}else {
					$alert = "<span class='error'>Email hoặc Password không đứng</span>";
					return $alert;
				}
			}
		}
		public function locus_customer($date){
			$password1 = mysqli_real_escape_string($this->db->link, md5($date['password']));
			$password2 = mysqli_real_escape_string($this->db->link, md5($date['password']));
			$email =  $date['email'];
			$check_email="SELECT * FROM tbl_customer WHERE email='$email'";
			$result_check = $this->db->select($check_email);
			if($result_check && $password1==$password2){
				$query="UPDATE tbl_customer SET password='$password2' WHERE email='$email'";
				$result = $this->db->update($query);
				if($result){
						$alert = "<span class='success'>Cập nhật thành công mật khẩu mới</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Cập nhật không thành công</span>";
						return $alert;
					}
			}
			else{
				$alert = "<span class='error'>Email hoặc mật khẩu không trùng khớp!</span>";
						return $alert;
			}
		}
		public function show_customers($id)
		{
			$query = "SELECT * FROM tbl_customer WHERE id='$id' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_customerlist()
		{
			$query = "SELECT * FROM tbl_customer order by id desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_customers_ad($id){
			$name = mysqli_real_escape_string($this->db->link, $data['name']);
			$city = mysqli_real_escape_string($this->db->link, $data['city']);
			$email = mysqli_real_escape_string($this->db->link, $data['email']);
			$address = mysqli_real_escape_string($this->db->link, $data['address']);
			$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
			
			if($name=="" || $city=="" || $email=="" || $address=="" || $phone ==""){
				$alert = "<span class='error'>Các trường không được để trống</span>";
				return $alert;
			}else{
				$query = "UPDATE tbl_customer SET name='$name',city='$city',email='$email',address='$address',phone='$phone' WHERE id ='$id'";
				$result = $this->db->insert($query);
				if($result){
						$alert = "<span class='success'>Cập nhập thành công</span>";
						return $alert;
				}else{
						$alert = "<span class='error'>Cập nhập không thành công</span>";
						return $alert;
				}
				
			}
		}
		public function update_customers($data, $id){
			$name = mysqli_real_escape_string($this->db->link, $data['name']);
			$city = mysqli_real_escape_string($this->db->link, $data['city']);
			$email = mysqli_real_escape_string($this->db->link, $data['email']);
			$address = mysqli_real_escape_string($this->db->link, $data['address']);
			$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
			
			if($name=="" || $city=="" || $email=="" || $address=="" || $phone ==""){
				$alert = "<span class='error'>Các trường không được để trống</span>";
				return $alert;
			}else{
				$query = "UPDATE tbl_customer SET name='$name',city='$city',email='$email',address='$address',phone='$phone' WHERE id ='$id'";
				$result = $this->db->insert($query);
				if($result){
						$alert = "<span class='success'>Cập nhập thành công</span>";
						return $alert;
				}else{
						$alert = "<span class='error'>Cập nhập không thành công</span>";
						return $alert;
				}
				
			}
		}
		public function del_customer($id)
		{
			$query = "DELETE FROM tbl_customer where id = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa khách hàng thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa khách hàng không thành công</span>";
				return $alert;
			}
		}

	}
 ?>