<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
 ?>
 <?php 
	  $login_check = Session::get('customer_login');
	  if ($login_check==false) {
	  	header('Location:login.php');
	  }
	   ?>
<?php 
	// if(!isset($_GET['proid']) || $_GET['proid'] == NULL){
 //        echo "<script> window.location = '404.php' </script>";
        
 //    }else {
 //        $id = $_GET['proid']; // Lấy productid trên host
 //    }
    $id = Session::get('customer_id');
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
        // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
        $UpdateCustomers = $cs -> update_customers($_POST, $id); // hàm check catName khi submit lên
    } 
 ?>
 <link rel="stylesheet" type="text/css" href="admin/css/bt2.css">
 <div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="content_top">
    		<div class="heading">
    		<h3>Thông tin khách hàng</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
        <form action="" method="post">
    	<table class="tblone" style="width: 100%">
            <tr>
                <?php 
                if (isset($UpdateCustomers)) {
                    echo '<td colspan="3">'.$UpdateCustomers.'</td>';
                }
                 ?>
            </tr>

    		<?php 
    		$id = Session::get('customer_id');
    		$get_customers = $cs->show_customers($id);
    		if ($get_customers) {
    			while ($result = $get_customers->fetch_assoc()) {
    			
    		 ?>
    		<tr>
    			<td style="width: 30%">Họ tên</td>
    			<td style="width: 2%">:</td>
    			<td style="width: 65%"><input type="text" name="name" value="<?php echo $result['name']; ?>" style="width: 70%"></td>
    		</tr>
    		<tr>
    			<td>Tỉnh thành</td>
    			<td>:</td>
                <td><input type="text" name="city" value="<?php echo $result['city']; ?>" style="width: 70%"></td>
    			
    		</tr>
    		<tr>
    			<td>Số điện thoại</td>
    			<td>:</td>
                <td><input type="text" name="phone" value="<?php echo $result['phone']; ?>" style="width: 70%"></td>
    			
    		</tr>
    		<tr>
    			<td>Email</td>
    			<td>:</td>
                <td><input type="text" name="email" value="<?php echo $result['email']; ?>" style="width: 70%"></td>
    			
    		</tr>
    		<tr>
    			<td>Địa chỉ</td>
    			<td>:</td>
                <td><input type="text" name="address" value="<?php echo $result['address']; ?>" style="width: 70%"></td>
    			
    		</tr>
            <tr>
                <td colspan="3"><input style="float: right;" type="submit" name="save" value="Lưu" class="btn2" ><a href="offlinepayment.php" style="background:#3E3737; color: white; float: left; border-radius: 4px;padding: 1px 2px 1px 2px;">Quay về</a></td>
                <td></td>
               
            </tr>
    		
    		<?php 
    		}
    		}
    		 ?>
    	</table>
        </form>

    	</div>	
 	</div>

<?php 
	include 'inc/footer.php';
 ?>