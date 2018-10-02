<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
	$(document).ready( function () {
		//เช็คถ้ากดปุ่ม Enter ให้คลิ๊กปุ่มเข้าสู่ระบบ
        var input = document.getElementById("username");
		input.addEventListener("keyup", function(event) {
			event.preventDefault();
			if (event.keyCode === 13) {
				document.getElementById("btn_login").click();
			}
		});
		var input = document.getElementById("password");
		input.addEventListener("keyup", function(event) {
			event.preventDefault();
			if (event.keyCode === 13) {
				document.getElementById("btn_login").click();
			}
		});
    });
	
	function chk_login(){
		var username = $('#username').val();
		var password = $('#password').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url()."/Login/checklogin";?>",
			data: {'username': username,'password': password},
			dataType : "json",
			success : function(data){
				if(data == false){
					notify_check_login();
					$('#username').val("");
					$('#password').val("");
				}else{
					location.reload();
				}
			}//End success
		});
	}
</script>
<body class="skin-blue layout-top-nav" style="height: auto; min-height: 100%;">
	<div class="wrapper" style="height: auto; min-height: 100%;">
		<header class="main-header">
			<nav class="navbar navbar-static-top">
				<div class="col-md-5">
					<img src="<?php echo base_url()."/assets/img/med_logo.PNG";?>" height="55" width="55">
					<span class="logo-lg"><b><?php echo $this->config->item('title_system');?></b> | <?php echo $this->config->item('title_system_th');?></span>
				</div>
			</nav>
		</header>
		<!-- Full Width Column -->
		<div class="content-wrapper" style="min-height: 600px;">
			<div class="container"><br><br><br><br><br>
				<div class="col-md-12 ">
					<div class="col-md-2"></div>
					<div class="col-md-8 system-name" style="text-align: center;">
						<b><?php echo $this->config->item('title_system_full');?></b>
					</div>
					<div class="col-md-2"></div>
				</div><br>
				
				<div class="login-box">
					<div class="box box-primary">
						<div class="box-header with-border">
							<center><h3 class="box-title">เข้าสู่<?php echo $this->config->item('title_system_th');?></h3></center>
						</div>
						<div class="login-box-body">
							<form action="<?php echo site_url()."/Login/checklogin";?>" method="post">
								<div class="form-group has-feedback">
									<input type="text" class="form-control" placeholder="ชื่อผู้ใช้" name="username" id="username" >
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
								<div class="form-group has-feedback">
									<input type="password" class="form-control" placeholder="รหัสผ่าน" name="password" id="password">
									<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								</div>
								<div class="row">
									<div class="col-xs-4 pull-right">
									<a id="btn_login" type="button" onclick="chk_login();" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				
				
				<!--<div class="login-box">
					<div class="box box-widget widget-user">
						<div class="widget-user-header bg-aqua-active">
							<h3 class="widget-user-username"><b><?php echo $this->config->item('title_system_full');?></b></h3>
							<h4 class="widget-user-desc">เข้าสู่<?php echo $this->config->item('title_system_th');?></h4>
						</div>
						<div class="box-footer">
								<div class="form-group has-feedback">
									<input type="text" class="form-control" placeholder="ชื่อผู้ใช้" name="username" id="username" >
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
								<div class="form-group has-feedback">
									<input type="password" class="form-control" placeholder="รหัสผ่าน" name="password" id="password">
									<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								</div>
								<div class="row">
									<div class="col-xs-4 pull-right"><a id="btn_login" type="button" onclick="chk_login();" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</a>
									</div>
								</div>
						</div>
					</div>
				</div>-->
				
				
			</div> <!-- /.container -->
			
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2018 <a href="https://deanoffice.medbuu.info/">สำนักงานคณบดี คณะแพทยศาสตร์</a></strong> 
            <strong class="pull-right">CREATE & DESIGN BY <a>SURACHED YOOTHAWORN</a></strong>
		</footer>
	</div>
</body>


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<style>
	.logo-lg{
		color: #ffffff;
		font-size: 24px;
		vertical-align: middle;
	}
	
	.system-name{
		font-size: 28px;
	}
	
	#box-headder{
		vertical-align: middle;
	}
	// .login-box{
		// width: 50%;
	// } 
	
	.content-wrapper{
		// background: url(<?php echo base_url()."/assets/img/test3.JPG";?>); 
		background-color: #e6f7ff;
		// background-repeat: no-repeat;
		// background-size: cover;
		// background-position: top 200px;
		// width: 100%;
		// background-position: center; 
		
	}
</style>
</body>
</html>