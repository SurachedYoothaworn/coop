<!--<body class="hold-transition skin-blue sidebar-mini">-->
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
	<?php if($this->session->userdata('us_permission') == 1){ ?>
		<a href="<?php echo site_url('Routes_menu/link_page');?>/1" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels --> 
			<span class="logo-mini"><b>KPI</b></span>
			<span class="logo-lg">
				<img src="<?php echo base_url()."/assets/img/med_logo.PNG";?>" height="50" width="50">
				<?php echo $this->config->item('title_system_th');?>
			</span>
		</a>
	<?php }else{ ?>
		<a href="" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels --> 
			<span class="logo-mini"><b>KPI</b></span>
			<span class="logo-lg">
				<img src="<?php echo base_url()."/assets/img/med_logo.PNG";?>" height="50" width="50">
				<?php echo $this->config->item('title_system_th');?>
			</span>
		</a>
	<?php } ?>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<b><?php echo $this->session->userdata('us_ps_name');?></b>
					</a>
					<ul class="dropdown-menu">
					<li>
						<!-- inner menu: contains the actual data -->
						<ul class="menu">
							<li> <!-- start message -->
								<a href="#">
									<h4>
										<i class="glyphicon glyphicon-briefcase"></i> &nbsp;&nbsp;
										ตำแหน่ง :  <br><?php echo $this->session->userdata('pt_title_th');?>
									</h4>
								</a>
							</li>
							<li> <!-- start message -->
								<a href="<?php echo site_url('/Login/logout');?>">
									<h4>
										<i class="fa fa-power-off"></i> &nbsp;&nbsp;
										ออกจากระบบ
									</h4>
								</a>
							</li>
						<!-- end message -->
						</ul>
					</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
  </header>
  
<style>
	.logo-lg{
		color: #ffffff;
		font-size: 14px;
		vertical-align: middle;
	}
</style>
  