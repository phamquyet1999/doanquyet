<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php' ?>

<?php 

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/cart.php');
include_once ($filepath.'/../helpers/format.php');

?>
<?php
	$ct = new cart();
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.highcharts.com/highcharts.js"></script> 
						<?php
						$ct = new cart();
						$doanhthungay = $ct->doanhthungay();
						if($doanhthungay){
							while($row = $doanhthungay->fetch_assoc()){
								$row_values1=$row['DT'];
								$date=$row['Ngay'];
								$time=strtotime($row['Ngay'])*1000.0045;								
								$data[]="[$time,$row_values1]";
							}
							
						}
						 ?>
<script type="text/javascript">
 
$(function () { 
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Doanh thu theo ngày'
        },
        xAxis: {
            type:'datetime',
             dateTimeLabelFormats:{
                            day: '%d-%m-%Y',
                        },

        	title:{
        	text:'Ngày'
        }
       
        },

        yAxis: {title: {
                text: 'Tổng tiền'
            }
            
        },
        series: [{
            name: 'Vị trí',
            data: [<?php echo join($data, ',') ?>]

        }]
    });
	
});
</script>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Doanh thu theo ngày</h2>
                <div class="block">
                	<div id="container"></div>
                
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
