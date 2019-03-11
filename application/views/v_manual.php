<!DOCTYPE html>
<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<html>
<head>
	<style>
		#sub_head_table{
			background-color: #536872;
			color: #ffffff;
		}
	</style>
</head>
<body>	
	<div class="box box-solid">
		<div class="box-header with-border" id="sub_head_table">
			<i class="fa fa-fw fa-stack-overflow"></i><h3 class="box-title" style="padding: 8px;">ลำดับการทำงานของระบบบันทึกข้อมูลตัวชี้วัด</h3>
			<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">คู่มือการใช้งาน</a>
		</div>
		<div class="box-body text-center">
			<center>
				<img src="<?php echo base_url();?>/images/Folw_kpims.PNG" width="70%" height="70%">
			</center>
		</div>
	</div>
</body>	
     		
<!--Modal info-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">คู่มือระบบบันทึกข้อมูลตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
				<embed src="<?php echo base_url();?>/docs/UserManual.pdf" frameborder="0" width="100%" height="450px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog --> 
</html>