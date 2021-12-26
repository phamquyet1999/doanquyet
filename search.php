<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
?>

 <div class="main">
    <div class="content">
    	<?php
	     	    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			        $tukhoa = $_POST['tukhoa'];
			        $search_product = $product->search_product($tukhoa);
			        
			    }
	      	?>
    	<div class="content_top">
    		
    		<div class="heading">	
    		<h3>Từ khóa tìm kiếm : <?php echo $tukhoa ?></h3>
    		</div>
    		
    		<div class="clear"></div>

    	</div>
    	
	      <div class="section group">
	      	<?php
	      	
	      	 if($search_product){
	      	 	$i=0;
	      	 	while($result = $search_product->fetch_assoc()){
	      	 		$i++;
	      	 		if(($i%5)!=0){
	      	?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview-3.php"><img src="admin/uploads/<?php echo $result['image'] ?>" width="200px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result['productName'] ?></h2>
					 <p><span class="price"><?php echo $fm->format_currency($result['price'])." "."VNĐ" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
				</div>
			<?php
			}if(($i%5)==0){
				$i=1;
			?>
			 <div class="section group">
			<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview-3.php"><img src="admin/uploads/<?php echo $result['image'] ?>" width="200px" alt="" /></a>
					 <p></p>
					 <h2><?php echo $result['productName'] ?></h2>
					 <p><span class="price"><?php echo $fm->format_currency($result['price'])." "."VNĐ" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
				</div>
			</div>
			<?php	
			}}

		}else{
			echo 'Không có sản phẩm nào';
		}
			?>
			</div>

	
	
    </div>
 </div>
<?php 
	include 'inc/footer.php';
	
 ?>
