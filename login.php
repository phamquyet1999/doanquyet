<?php 
	include 'inc/header.php';
	//include 'inc/slider.php';
?>

<?php
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        
        $insertCustomers = $cs->insert_customer($_POST);
        
    }
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        
        $login_Customers = $cs->login_customer($_POST);
        
    }
?>
 <div class="main">
    <div class="content">
    	 <div class="login_panel">
        	<h3>Đăng nhập tài khoản</h3>
        	
        	<?php
			if(isset($login_Customers)){
    			echo $login_Customers;
    		}
        	?>
        	<form action="" method="post">
                	<input  type="text" name="email" class="field" placeholder="Nhập Email....">
                    <input  type="password" name="password" class="field"  placeholder="Nhập Password...." >
                 
                 <p class="note"><a href="logincus.php">Quên mật khẩu?</a></p>
                    <div class="buttons"><div><input type="submit" name="login" class="grey" value="Đăng nhập"></div></div>
             </form>
          </div>
         <?php

         ?> 
    	<div class="register_account">
    		<h3>Đăng ký tài khoản mới</h3>
    		<?php
    		if(isset($insertCustomers)){
    			echo $insertCustomers;
    		}
    		?>
    		<form action="" method="POST">
		   			 <table>
		   				<tbody>
						<tr>
						<td>
							<div>
							<input type="text" name="name" placeholder="Nhập họ tên..." >
							</div>
							
							<div>
							   <input type="text" name="city"  placeholder="Nhập tỉnh thành..."  >
							</div>
							
							
							<div>
								<input type="text" name="email"  placeholder="Nhập email..."  >
							</div>
		    			 </td>
		    			<td>
						<div>
							<input type="text" name="address"  placeholder="Nhập địa chỉ..."  >
						</div>
		    		<div>
						
				 </div>		        
	
		           <div>
		          <input type="text" name="phone"  placeholder="Nhập số điện thoại..." >
		          </div>
				  
				  <div>
					<input type="text" name="password"  placeholder="Nhập Password..." >
				</div>
		    	</td>
		    </tr> 
		    </tbody></table> 
		   <div class="search"><div><input type="submit" name="submit" class="grey" value="Đăng ký"></div></div>
		    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php 
	include 'inc/footer.php';
	
 ?>
