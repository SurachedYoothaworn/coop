<!--<body class="hold-transition skin-blue sidebar-mini">-->
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo site_url()."/Home";?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels --> 
		<span class="logo-mini"><b>K</b>PI</span>
		<!--<img class="logo-mini"  src="<?php echo base_url()."/assets/img/med_logo.PNG";?>" height="55" width="55">--> 
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b><?php echo $this->config->item('title_system');?></b> </span>
    </a>

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
						<b><?php echo $this->session->userdata('us_username');?></b>
					</a>
					<ul class="dropdown-menu">
					<li>
						<!-- inner menu: contains the actual data -->
						<ul class="menu">
						<li> <!-- start message -->
							<a href="<?php echo site_url('/Authen/logout');?>">
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
  