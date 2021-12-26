<?php 
	include 'inc/header.php';
	// include 'inc/slider.php';
?>
<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/classes/cart.php');
include_once ($filepath.'/helpers/format.php');

 ?>
<?php
   
    if(!isset($_GET['id']) || $_GET['id']==NULL){
       echo "<script>window.location ='order.php'</script>";
    }else{
         $id = $_GET['id']; 
    }
     $cs = new cart();
  

?>
<link rel="stylesheet" type="text/css" href="admin/css/bt3.css">
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Chi tiết đơn hàng</h2>			    	
						<table class="tblone">
							<tr>
								<th width="10%">ID</th>
								<th width="20%">Tên sản phẩm</th>
								<th width="10%">Ảnh</th>
								<th width="15%">Giá</th>
								<th width="15%">Số lượng</th>
								<th width="15%">Tổng tiền</th>
							</tr>
							<?php
							$get_cart_ordered = $ct->get_cart_orderdetail($id);
							if($get_cart_ordered){
								$i = 0;
								$qty = 0;
								$total = 0;
								$subtotal=0;
								while($result = $get_cart_ordered->fetch_assoc()){
									$i++;
									$total = $result['price'] * $result['quantity'];
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['image'] ?>" alt=""/></td>
								<td><?php echo $fm->format_currency($result['price'])." "."VNĐ" ?></td>
								<td>
									
										
										<?php echo $result['quantity'] ?>
									
									
								</td>
								
								<td><?php echo $fm->format_currency($total)." "."VNĐ" ?></td>
							</tr> 

						<?php
							$subtotal += $total;
							$qty = $qty + $result['quantity'];
							}
						}
						?>
							</table>
						
						<table style="float:right;text-align:left;margin:5px" width="40%">
								<tr>
								<th>Tổng giá : </th>
								<td>
								<?php 
										echo $fm->format_currency($subtotal).' '.'VNĐ' ;
									  Session::set('sum',$subtotal);
									  Session::set('qty',$qty);
								?>
								</td>
							</tr>
							<tr>
								<th>Phí vận chuyển : </th>
								<td>30.000 VND</td>
							</tr>
							<tr>
								<th>Tổng tiền thanh toán :</th>
								<td><?php
								$vat=30000; 
								$grandTotal = $subtotal + $vat;

								echo $fm->format_currency($grandTotal).' '.'VNĐ' ;
								 ?> </td>
							</tr>
					   </table>
					   
							
						</table>
						
						
					 
					
					
					</div>
					<div class="shopping">
						<div class="shopcenter">
							<a href="order.php" class="btn3">Thoát</a>
						</div>
						
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php 
	include 'inc/footer.php';
	
 ?>