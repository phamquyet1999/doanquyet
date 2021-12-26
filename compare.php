<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
 ?>
<?php 

    if(isset($_GET['proid'])){
    	$customer_id = Session::get('customer_id');
     	$proid = $_GET['proid']; 
      	$delcompare = $product->del_compare($proid,$customer_id);
 	}
  ?>
 <link rel="stylesheet" type="text/css" href="admin/css/bt3.css">
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>So sánh sản phẩm</h2>
			    	<?php
			    	 if(isset($update_quantity_cart)){
			    	 	echo $update_quantity_cart;
			    	 }
			    	?>
			    	<?php
			    	 if(isset($delcart)){
			    	 	echo $delcart;
			    	 }
			    	?>
						<table class="tblone">
							<tr>
								<th width="10%">STT</th>
								<th width="20%">Tên sản phẩm</th>
								<th width="20%">Hình ảnh</th>
								<th width="15%">Giá</th>
								<th width="15%">Xử lý</th>
	
							</tr>
							<?php 
							$customer_id = Session::get('customer_id');
							$get_compare = $product->get_compare($customer_id);
							if($get_compare){
								$i = 0;
								while ($result = $get_compare->fetch_assoc()) {
								$i++;	
								
							 ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['image'] ?>" alt=""/></td>
								<td><?php echo $result['price'] ?></td>
								
								<td><a href="?proid=<?php echo $result['productId'] ?>">Xóa</a>||<a href="details.php?proid=<?php echo $result['productId'] ?>">Xem chi tiết</a></td>
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
