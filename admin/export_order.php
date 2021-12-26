<?php 
    include '../lib/session.php';
     Session::checkSession();
 ?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Xuất hóa đơn</title>
    
    <!-- BEGIN: load jquery -->
    <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.accordion.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.slide.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.sortable.min.js" type="text/javascript"></script>
    <script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
    <!-- END: load jquery -->
    <script type="text/javascript" src="js/table/table.js"></script>
    <script src="js/setup.js" type="text/javascript"></script>
     <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();
            setSidebarHeight();
        });
    </script>

</head>
<body onLoad="window.print()">
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
       echo "<script>window.location ='orderdetail_admin.php'</script>";
    }else{
         $id = $_GET['id']; 
    }

?>
<link href="css/hd.css" rel="stylesheet" type="text/css" media="all"/>
<div id="page" class="page">
    <div class="header">
        <div class="logo"><img src="img/Logocuong.PNG"/></div>
        <div class="company">Cửa hàng điện thoại Mạnh Cường</div>
    </div>
  <br/>
  <br/>
  <br/>

  <div class="title">
        HÓA ĐƠN THANH TOÁN
        <br/>
        -------oOo-------
  </div>
  <br/>
  <br/>
  <h3 style="text-align: center;">Thông tin khách hàng</h3>
  <table class="TableData">
    <tr>
      <!-- <th>STT</th> -->
      <th>Họ tên</th>
      <th>Số điện thoại</th>
      <th>Email</th>
      <th>Địa chỉ</th>
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
      </table>
      <br/>
      <br/>
      <h3 style="text-align: center;">Hóa đơn chi tiết</h3>
        <table class="TableData">
        <tr>
          <th>STT</th>
          <th>Tên sản phẩm</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Tổng tiền</th>
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
             <tr>
              <td colspan="4" class="tong">Tổng giá</td>
              <td class="cotSo"><?php 
                    echo $fm->format_currency($subtotal).' '.'VNĐ' ;
                    Session::set('sum',$subtotal);
                    Session::set('qty',$qty);
                ?></td>
              </tr>
              <tr>
              <td colspan="4" class="tong">Phí vận chuyển</td>
              <td class="cotSo">30.000 VNĐ</td>
              </tr>
              <tr>
              <td colspan="4" class="tong">Tổng thanh toán</td>
              <td class="cotSo"><?php
                $vat=30000; 
                $grandTotal = $subtotal + $vat;

                echo $fm->format_currency($grandTotal).' '.'VNĐ' ;
                 ?> </td>
              </tr>
              </table>
            <div class="footer-left"> Hà Nội, ngày 11 tháng 08 năm 2021<br/>
    Khách hàng </div>
  <div class="footer-right"> Hà Nội, ngày 11 tháng 08 năm 2021<br/>
    Chủ quán </div>
          </div>
      </div>    
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
</body>  