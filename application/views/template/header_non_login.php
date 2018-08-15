<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

	<!-- Main Header -->
	
	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a href="#" class="navbar-brand"><b><?php echo $this->config->item('title_system');?></b> <?php echo $this->config->item('title_sub_system');?> | <?php echo $this->config->item('org_name');?></a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>
		
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo site_url('/Page_public');?>"><i class="fa fa-home"></i> หน้าหลัก<span class="sr-only">(current)</span></a></li>
					<li><a href="<?php echo site_url('/Authen');?>"><i class="fa fa-user"></i> เข้าสู่ระบบ</a></li>
				</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu pull-left">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
					</li>
				</ul>
			</div>
			
			<!-- /.container-fluid -->
		</nav>
	</header>
  
  