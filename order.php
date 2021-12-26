<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
?>
<?php 
    $db = new Database();
    $fm = new Format();
    $ct = new cart();
    $us = new user();
    $br = new brand();
    $cat = new category();
    $cs = new customer();
    $product = new product();
 ?>

 <?php
 	$login_check = Session::get('customer_login'); 
	if($login_check==false){
		header('Location:login.php');
	}
	
	
?>
<?php
if(isset($_GET['delid'])){
     	$id = $_GET['delid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$del_shifted = $ct->del_shifted($id,$time,$price);
    }
 ?>  
<?php
	if(isset($_GET['confirmid'])){
     	$id = $_GET['confirmid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$shifted_confirm = $ct->shifted_confirm($id,$time,$price);
    }
?>
<link rel="stylesheet" type="text/css" href="admin/css/bt3.css">
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Danh sách hóa đơn</h2>			    	
			    	
						<table class="tblone">
							<tr>
								<th width="10%">ID</th>
								<th width="15%">Tổng tiền</th>
								<th width="10%">Ngày</th>
								<th width="10%">Trạng thái</th>
								<th width="10%">Xác nhận</th>
								<th width="10%">Tùy chọn</th>
							</tr>
							<?php
							$customer_id = Session::get('customer_id');
							$get_cart_ordered = $ct->get_cart_order($customer_id);
							if($get_cart_ordered){
								$i = 0;
								while($result = $get_cart_ordered->fetch_assoc()){
									$i++;
							?>
							<tr>
								<td><?php echo $i; ?></td>								
								<td><?php echo $fm->format_currency($result['totalprice'])." "."VNĐ" ?></td>
								<td><?php echo $fm->formatDate($result['date_order']) ?></td>
								<td>
									<?php
									if($result['status']=='0'){
										echo 'Đang chờ xử lý';
									}elseif($result['status']==1){ 
									?>
									<span>Đang giao hàng</span>
									
									<?php
									}elseif($result['status']==2){
										echo 'Hoàn thành';
									}

									 ?>
								</td>
								<?php
								if($result['status']=='0'){
								?>
								<td><a href="?delid=<?php echo $result['id'] ?>&price=<?php echo $result['totalprice'] ?>&time=<?php echo $result['date_order'] ?>" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng?')"><?php echo 'Hủy đơn hàng';?></a></td>
								<?php
								
								}elseif($result['status']=='1'){
								
								?>
								
								<td><a href="?confirmid=<?php echo $customer_id ?>&price=<?php echo $result['totalprice'] ?>&time=<?php echo $result['date_order'] ?>" onclick="return confirm('Bạn chắc chắn đã nhận được hàng?')">Đã nhận được hàng</a></td>
								
								<?php
							}else{
								?>

								<td><?php echo 'Thành công'; ?></td>
								<?php
								}	
								?>
								<td><a href="orderdetails.php?id=<?php echo $result['id'] ?>">Chi tiết đơn hàng</a></td>
							</tr>
						<?php
							
							}
						}
						?>
							
						</table>
						
					</div>
					<div class="shopping">
						<div class="shopcenter">
							<a href="index.php" class="btn3">Tiếp tục mua hàng</a>
						</div>
						
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php 
	include 'inc/footer.php';
	
 ?>