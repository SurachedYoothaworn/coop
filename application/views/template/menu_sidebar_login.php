  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar -->
    <section class="sidebar">

      <!-- Sidebar Menu -->
	<?php if($this->session->userdata('us_permission') == 1){ ?>
		<ul class="sidebar-menu">
			<li class="header">เมนู</li>
			<li class="active" id="home" ><a href="<?php echo site_url('Home');?>"><i class="glyphicon glyphicon-home"></i><span>หน้าหลัก</span></a></li>
			<!-- Optionally, you can add icons to the links -->
			<li class="treeview " id="menu_ind" >
				<a href="#"><i class="glyphicon glyphicon-cog"></i> <span>จัดการข้อมูลพื้นฐาน</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" >
					<li><a href="<?php echo site_url('Manage_indicator');?>"><i class="glyphicon glyphicon-cog"></i> <span>จัดการตัวชี้วัด</span></a></li>
					<li><a href="<?php echo site_url('Manage_strategy');?>"><i class="glyphicon glyphicon-cog"></i><span>จัดการยุทธศาสตร์ตัวชี้วัด</span></a></li>
					<li><a href="<?php echo site_url('Manage_indicator_group');?>"><i class="glyphicon glyphicon-cog"></i><span>จัดการกลุ่มตัวชี้วัด</span></a></li>
					<li><a href="<?php echo site_url('Manage_side');?>"><i class="glyphicon glyphicon-cog"></i><span>จัดการหน่วยงาน</span></a></li>
					<li><a href="<?php echo site_url('Manage_budget_year');?>"><i class="glyphicon glyphicon-cog"></i><span>จัดการปีงบประมาณ</span></a></li>
					<li><a href="<?php echo site_url('Manage_unit');?>"><i class="glyphicon glyphicon-cog"></i><span>จัดการหน่วยนับ</span></a></li>
				</ul>
			</li>
			<li class=""><a href="<?php echo site_url('Define_indicator');?>"><i class="glyphicon glyphicon-edit"></i> <span>กำหนดรายการตัวชี้วัด</span></a></li>
			<li class=""><a href="<?php echo site_url('Result_indicator');?>"><i class="glyphicon glyphicon-floppy-save"></i> <span>บันทึกผลตัวชี้วัด</span></a></li>
			<li class=""><a href="<?php echo site_url('Report_indicator');?>"><i class="glyphicon glyphicon-list-alt"></i> <span>ประมวลข้อมูลตัวชี้วัด</span></a></li>
		</ul>
	<?php }else{ ?>
		<ul class="sidebar-menu">
			<li class="header">เมนู</li>
			<li class=""><a href="<?php echo site_url('Result_indicator');?>"><i class="glyphicon glyphicon-floppy-save"></i> <span>บันทึกผลตัวชี้วัด</span></a></li>
		</ul>
	<?php } ?>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
            <section class="content">
		