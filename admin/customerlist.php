<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/customer.php');
    include_once ($filepath.'/../helpers/format.php');
 ?>
<?php
    $pd = new customer();
    $fm = new Format();
    if(!isset($_GET['id']) == NULL){
        // echo "<script> window.location = 'catlist.php' </script>";
        
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $del_customer = $pd->del_customer($id);
    }
  ?>
  <div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách khách hàng</h2>
        <div class="block">  
             <table class="data display datatable" id="example">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Địa Chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Xử lý</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                $pdlist = $pd->show_customerlist();
                $i = 0;
                
                
                    if($pdlist){
                    
                            while ($result = $pdlist->fetch_assoc()){
                                $i++;
                                    
                                    
                 ?>
                <tr class="odd gradeX">
                    <td><?php echo $i ?></td>
                    <td><?php echo $result['name'] ?></td>
                    <td>
                        <?php echo $result['address'] ?>

                    </td>
                    <td>
                        <?php echo $result['phone'] ?>

                    </td>
                    <td><?php echo $result['email'] ?></td>
                    
                    <td><a href="?id=<?php echo $result['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa!');" >Xóa</a>||<a href="customer.php?customerid=<?php echo $result['id'] ?>">Xem</a></td>
                </tr>
                <?php
                            
                        
                    }
                }
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