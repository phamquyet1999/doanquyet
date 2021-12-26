<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
?>
<?php

	if(!isset($_GET['proid']) || $_GET['proid']==NULL){
       echo "<script>window.location ='404.php'</script>";
    }else{
        $id = $_GET['proid']; 
    }
 	$customer_id = Session::get('customer_id');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {

        $productid = $_POST['productid'];
        $insertCompare = $product->insertCompare($productid, $customer_id);
        
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])) {

        $productid = $_POST['productid'];
        $insertWishlist = $product->insertWishlist($productid, $customer_id); 
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        $insertCart = $ct->add_to_cart($quantity, $id);
    }

?>
 <div class="main">
    <div class="content">
    	<div class="section group">
		<?php

		$get_product_details = $product->get_details($id);
		if($get_product_details){
			while($result_details = $get_product_details->fetch_assoc()){
		

		?>
		<div class="cont-desc span_1_of_2" style="width:60%; ">				
					<div class="grid images_3_of_2">
						<img src="admin/uploads/<?php echo $result_details['image'] ?>" alt="" style="height: 380px;"/>
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result_details['productName'] ?></h2>
					<!-- <p><?php echo $fm->textShorten($result_details['product_desc'],150) ?></p>	 -->				
					<div class="price">
						<p>Giá: <span><?php echo $fm->format_currency($result_details['price'])." "."VNĐ" ?></span></p>
						<p>Danh mục: <span><?php echo $result_details['catName'] ?></span></p>
						<p>Thương hiệu:<span><?php echo $result_details['brandName']?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number" class="buyfield" name="quantity" value="1" min="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Thêm vào giỏ hàng"/>

					</form>


					<?php
						if(isset($insertCart)){
							echo $insertCart;
						}
					?>		
				</div>
				<div class="add-cart">
					<div class="button_details">
					<form action="" method="POST">
					
					<input type="hidden" name="productid" value="<?php echo $result_details['productId'] ?>"/>

					
					<?php
	
					$login_check = Session::get('customer_login'); 
						if($login_check){
							echo '<input type="submit" class="buysubmit" name="compare" value="Thêm vào so sánh"/>'.'  ';
							
						}else{
							echo '';
						}
							
					?>
					
					
					</form>


					<form action="" method="POST">
					
					<input type="hidden" name="productid" value="<?php echo $result_details['productId'] ?>"/>

					
					<?php
	
					$login_check = Session::get('customer_login'); 
						if($login_check){
							
							echo '<input type="submit" class="buysubmit" name="wishlist" value="Thêm vào yêu thích">';
						}else{
							echo '';
						}
							
					?>
					
					
					
					</form>

					</div>
					<div class="clear"></div>
					<p>
					<?php
					if(isset($insertCompare)){
						echo $insertCompare;
					}
					?>
					<?php
					if(isset($insertWishlist)){
						echo $insertWishlist;
					}
					?>
					
					
				</p>
					
				</div>

			</div>
				<div class="product-desc">
				<h2>Nội dung sản phẩm</h2>
				<p><?php echo $result_details['product_desc'] ?></p>
		    </div>
				
		</div>
		
				<div class="rightsidebar span_3_of_1" style="width: 32%; padding-top: 0px;">
    				<h2>Thông số kỹ thuật</h2>
					<p><?php echo $result_details['product_spec'] ?></p>
    	
 				</div>
 				<?php
			}
		}
		?>

 		</div>
 			
 			</textarea>
 		</div>
 	</div>

<?php 
	include 'inc/footer.php';
	
 ?>
