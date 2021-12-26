<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/cart.php');
include_once ($filepath.'/../helpers/format.php');
include_once ($filepath.'/../classes/customer.php');	
 ?>
 <?php
 
	$fm = new Format();
	
	?>
 <?php
	$ct = new cart();
	$cs = new customer();
	if(isset($_GET['shiftid'])){
     	$id = $_GET['shiftid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$shifted = $ct->shifted($id,$time,$price);
    }
   
    if(isset($_GET['delid'])){
     	$id = $_GET['delid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$del_shifted = $ct->del_shifted($id,$time,$price);
    }
?>
<?php
   
    if(!isset($_GET['id']) || $_GET['id']==NULL){
       echo "<script>window.location ='inbox.php'</script>";
    }else{
         $id = $_GET['id']; 
    }

?>
<link rel="stylesheet" type="text/css" href="css/bt2.css">
<link href="../css/style2.css" rel="stylesheet" type="text/css" media="all"/>
 <div class="grid_10">
    <div class="box round first grid">
    	<h2>Chi tiết đơn hàng</h2>	
    	<div class="block">
    		<div class="cartpage">
    			<table class="tblone">
							<h3 style="text-align: center; margin-bottom: 10px;">Thông tin khách hàng</h3>
							<tr>
								<th width="15%">Họ tên</th>
								<th width="15%">Số điện thoại</th>
								<th width="15%">Email</th>
								<th width="55%">Địa chỉ</th>
							</tr>
							<?php
                 				$a= $ct->get_cart_customers($id);
                 				$b= $a->fetch_assoc();
                	 			$get_customer = $cs->show_customers($b['customer_id']);
                    			if($get_customer){
                        			while($result = $get_customer->fetch_assoc()){
                       
                			?>
							<tr>
								<td><?php echo $result['name'] ?></td>
								<td><?php echo $result['phone'] ?></td>
								<td><?php echo $result['email'] ?></td>
								<td>
										<?php echo $result['address'] ?>
								</td>
							</tr> 

						<?php
							
							}
						}
						?>
    		</div>	
			<div class="cartpage">
                
						<table class="tblone">
							<h3 style="text-align: center; margin-bottom: 10px;">Thông tin đơn hàng</h3>
							<tr>
								<th width="10%">ID</th>
								<th width="20%">Tên sản phẩm</th>
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
									$total = $result['price']*$result['quantity'];
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['productName'] ?></td>
								<!-- <td><img src="uploads/<?php echo $result['image'] ?>" alt=""/></td> -->
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
					   					
					</div>
    	</div>
    	<a href="export_order.php?id=<?php echo $id ?>" class="btn2" style="float: right;";>In hóa đơn</a>

    	<a href="inbox.php" class="btn2" style="float: left;";>Thoát</a>			   	
       <div class="clear"></div>
    </div>
 </div>
 <script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>