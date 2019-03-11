<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
	<?php if($this->session->userdata('us_permission') == $this->config->item("ref_ug_admin")){ ?>
		<ul class="sidebar-menu">
			<li class="header">เมนู</li>
			<li <?php if($this->session->userdata('menu_active') == 1){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/1"><i class="fa fa-fw fa-dashboard"></i> <span>Dashborad</span></a></li>
			<!-- Optionally, you can add icons to the links -->
			<li <?php if($this->session->userdata('menu_tree_active') == 2){?> class = "active" <?php } ?> class="treeview" id="menu_ind" >
				<a href="#"><i class="glyphicon glyphicon-cog"></i> <span>จัดการข้อมูลพื้นฐาน</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" >
					<li <?php if($this->session->userdata('menu_active') == 2){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/2"><i class="glyphicon glyphicon-cog"></i> <span>จัดการตัวชี้วัด</span></a></li>
					<li <?php if($this->session->userdata('menu_active') == 3){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/3"><i class="glyphicon glyphicon-cog"></i><span>จัดการยุทธศาสตร์ตัวชี้วัด</span></a></li>
					<li <?php if($this->session->userdata('menu_active') == 4){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/4"><i class="glyphicon glyphicon-cog"></i><span>จัดการกลุ่มตัวชี้วัด</span></a></li>
					<li <?php if($this->session->userdata('menu_active') == 5){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/5"><i class="glyphicon glyphicon-cog"></i><span>จัดการหน่วยงาน</span></a></li>
					<li <?php if($this->session->userdata('menu_active') == 6){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/6"><i class="glyphicon glyphicon-cog"></i><span>จัดการปีงบประมาณ</span></a></li>
					<li <?php if($this->session->userdata('menu_active') == 7){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/7"><i class="glyphicon glyphicon-cog"></i><span>จัดการหน่วยนับ</span></a></li>
				</ul>
			</li>
			<li <?php if($this->session->userdata('menu_active') == 8){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/8"><i class="glyphicon glyphicon-edit"></i> <span>กำหนดรายการตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 9){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/9"><i class="glyphicon glyphicon-floppy-save"></i> <span>บันทึกผลตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 10){?>class = "active"<?php } ?>><a href="<?php echo site_url('Routes_menu/link_page');?>/10"><i class="glyphicon glyphicon-list-alt"></i> <span>ประมวลข้อมูลตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 11){?>class = "active"<?php } ?>><a href="<?php echo site_url('Routes_menu/link_page');?>/11"><i class="glyphicon glyphicon-book"></i> <span>คู่มือการใช้งานระบบ</span></a></li>
		</ul>
	<?php }else if($this->session->userdata('us_permission') == $this->config->item("ref_ug_main_side")){ ?>
		<ul class="sidebar-menu">
			<li class="header">เมนู</li>
			<li <?php if($this->session->userdata('menu_active') == 8){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/8"><i class="glyphicon glyphicon-edit"></i> <span>กำหนดรายการตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 9){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/9"><i class="glyphicon glyphicon-floppy-save"></i> <span>บันทึกผลตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 10){?>class = "active"<?php } ?>><a href="<?php echo site_url('Routes_menu/link_page');?>/10"><i class="glyphicon glyphicon-list-alt"></i> <span>ประมวลข้อมูลตัวชี้วัด</span></a></li>
		</ul>
	<?php }else if($this->session->userdata('us_permission') == $this->config->item("ref_ug_lab")){ ?>
		<ul class="sidebar-menu">
			<li class="header">เมนู</li>
			<li <?php if($this->session->userdata('menu_active') == 12){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/12"><i class="glyphicon glyphicon-stats"></i> <span>ติดตามผลงานตัวชี้วัด</span></a></li>
			<li <?php if($this->session->userdata('menu_active') == 9){?>class = "active"<?php } ?> ><a href="<?php echo site_url('Routes_menu/link_page');?>/9"><i class="glyphicon glyphicon-floppy-save"></i> <span>บันทึกผลตัวชี้วัด</span></a></li>
		</ul>
	<?php } ?>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
 <div class="content-wrapper">
            <section class="content">
 
		