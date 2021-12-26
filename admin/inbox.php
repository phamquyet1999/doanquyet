<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php 

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/cart.php');
include_once ($filepath.'/../helpers/format.php');

?>
<?php
	$ct = new cart();
	if(isset($_GET['shiftid'])){
     	$id = $_GET['shiftid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$shifted = $ct->shifted($id,$time,$price);
    }
    if(isset($_GET['shift2id'])){
     	$id = $_GET['shift2id'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$shifted = $ct->shifted2($id,$time,$price);
    }
   
    if(isset($_GET['delid'])){
     	$id = $_GET['delid'];
     	$time = $_GET['time'];
     	$price = $_GET['price'];
     	$del_shifted = $ct->del_shifted($id,$time,$price);
    }

?>
 

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách đơn hàng</h2>
                <div class="block">
                <?php 
                if(isset($shifted)){
                	echo $shifted;
                }              
                ?>
                <?php 
                if(isset($shifted2)){
                	echo $shifted2;
                }              
                ?>   
                <?php 
                if(isset($del_shifted)){
                	echo $del_shifted;
                }
                
                ?>        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Thứ tự</th>
							<th>Thời gian</th>							
							<th>Tổng tiền</th>
							<th>Trạng thái</th>
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$ct = new cart();
						$fm = new Format();
						$get_inbox_cart = $ct->get_order_list();
						if($get_inbox_cart){
							$i = 0;
							while($result = $get_inbox_cart->fetch_assoc()){
								$i++;
						 ?>
						
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $fm->formatDate($result['date_order']) ?></td>							
							<td><?php echo $result['totalprice'].' '.'VNĐ' ?></td>
							<td>
							<?php 
							if($result['status']==0){
							?>

								<a href="? shiftid= <?php echo $result['id'] ?>&price=<?php echo $result['totalprice'] ?>&time=<?php echo $result['date_order'] ?>" onclick="return confirm('Bạn chắc chắn đã chuẩn bị hàng?')">Chờ xử lý</a>
								<?php
							}elseif($result['status']==1){
								?>
								<a
								href="? shift2id= <?php echo $result['id'] ?>&price=<?php echo $result['totalprice'] ?>&time=<?php echo $result['date_order'] ?>" onclick="return confirm('Bạn chắc chắn đã giao hàng thành công?')" >Đang vận chuyển</a>

							<?php
							}elseif($result['status']==2){
							?>
								<?php
								echo 'Hoàn thành đơn hàng';
								?>

							<?php
								}
							
							?>
							</td>
							<td><a href="?delid=<?php echo $result['id'] ?>&price=<?php echo $result['totalprice'] ?>&time=<?php echo $result['date_order'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')" >Xóa</a>||<a href="orderdetail_admin.php?id=<?php echo $result['id'] ?>">Chi tiết</a></td>
						</tr>
						<?php
					}}
						?>
					</tbody>
				</table>
               </div>
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
