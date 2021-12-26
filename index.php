<?php 
	include 'inc/header.php';
	include 'inc/slider.php';
 ?>	

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Sản phẩm nối bật</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
	      	<?php 
	      	$product_featheread = $product->getproduct_featheread();
	      	if($product_featheread){
	      		$i=0;
	      		while ($result = $product_featheread->fetch_assoc()) {
	      			$i++;
	      			if(($i%5)!=0){
	      	 ?>
	      	 	<div class="grid_1_of_4 images_1_of_4">
					 <a  href="details.php?proid=<?php echo $result['productId'] ?>"><img src="admin/uploads/<?php echo $result['image'] ?>" width="150px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result['productName'] ?></h2>
					 <p><span class="price"><?php echo $fm->format_currency($result['price'])." "."VND" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
				</div>
				<?php 
				}elseif(($i%5)==0){
					$i=1;
				?>
				<div class="section group">
					<div class="grid_1_of_4 images_1_of_4">
					 <a  href="details.php?proid=<?php echo $result['productId'] ?>"><img src="admin/uploads/<?php echo $result['image'] ?>" width="150px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result['productName'] ?></h2>
					 <p><span class="price"><?php echo $fm->format_currency($result['price'])." "."VND" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
				 </div>
				<?php	
				}
			}

				}
				 ?>
				</div>
			</div>

			<div class="content_bottom">
    		<div class="heading">
    		<h3>Sản phẩm mới</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
			<div class="section group">
			<?php 
	      	$product_new = $product->getproduct_new();
	      	if($product_new){
	      		$i=0;
	      		while ($result_new = $product_new->fetch_assoc()) {
	      		$i++;
	      			if(($i%5)!=0){	      	
	      	 ?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result_new['productId'] ?>"><img src="admin/uploads/<?php echo $result_new['image'] ?>" width="150px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result_new['productName'] ?></h2>
					<!--  <p><?php echo $fm->textShorten($result_new['product_desc'], 50) ?></p> -->
					 <p><span class="price"><?php echo $fm->format_currency($result_new['price'])." VND" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'] ?>" class="details">Chi tiết</a></span></div>
				</div>
				<?php 
				}elseif(($i%5)==0){
					?>
					<div class="section group">
					<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result_new['productId'] ?>"><img src="admin/uploads/<?php echo $result_new['image'] ?>" width="150px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result_new['productName'] ?></h2>
					<!--  <p><?php echo $fm->textShorten($result_new['product_desc'], 50) ?></p> -->
					 <p><span class="price"><?php echo $fm->format_currency($result_new['price'])." VND" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'] ?>" class="details">Chi tiết</a></span></div>
				</div>
			<?php 
				}
				}
				}
			?>
			
		</div>
	</div>
	</div>
			
 </div>
<?php 
	include 'inc/footer.php';
 ?>
