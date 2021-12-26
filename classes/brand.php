<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>



<?php 
	/**
	* 
	*/
	class brand
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_brand($brandName){
			$brandName = $this->fm->validation($brandName); //gọi ham validation để ktra có rỗng hay ko để ktra
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			if(empty($brandName)){
				$alert = "<span class='error'>Các trường không được trống</span>";
				return $alert;
			}else{
				$query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Thêm thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Thêm thương hiệu thất bại</span>";
					return $alert;
				}
			}
		}
		public function show_brand()
		{
			$query = "SELECT * FROM tbl_brand order by brandId desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getbrandbyId($id)
		{
			$query = "SELECT * FROM tbl_brand where brandId = '$id' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_brand($brandName,$id)
		{
			$brandName = $this->fm->validation($brandName); //gọi ham validation từ file Format để ktra
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			if(empty($brandName)){
				$alert = "<span class='error'>Các trường không được trống</span>";
				return $alert;
			}else{
				$query = "UPDATE tbl_brand SET brandName= '$brandName' WHERE brandId = '$id' ";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='success'>Cập nhật thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Cập nhật thất bại</span>";
					return $alert;
				}
			}

		}
		// public function show_brand_home(){
		// 	$query = "SELECT * FROM tbl_brand order by brandId desc";
		// 	$result = $this->db->select($query);
		// 	return $result;
		// }
		public function get_name_by_brand($id){
			$query = "SELECT tbl_product.*,tbl_brand.brandName,tbl_brand.brandId FROM tbl_product,tbl_brand WHERE tbl_product.brandId=tbl_brand.brandId AND tbl_brand.brandId ='$id' LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_product_by_brand($id){
			$query = "SELECT * FROM tbl_product WHERE brandId='$id' order by brandId desc LIMIT 8";
			$result = $this->db->select($query);
			return $result;
		}
		public function del_brand($id)
		{
			$query = "DELETE FROM tbl_brand where brandId = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa thương hiệu thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa thương hiệu thất bại</span>";
				return $alert;
			}
		}
		
	}
 ?>