<!------ Include the above in your HEAD tag ---------->
<!-- DataTable -->
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/dataTables.bootstrap4.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/dataTables.bootstrap4.min.css">

<!-- DataTable_old -->
<!-- <link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/jquery.dataTables_themeroller.css"> -->
<!-- <script src="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<!-- <script src="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/jquery.dataTables.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/jquery.dataTables.min.css"> -->


<!-- Sweetalert -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/sweetalert/sweetalert.css">

<!-- pnotify -->
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/notify/pnotify.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/notify/pnotify.css">

<!--tooltip-->
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/tooltip/tooltip.css">

<!--validate-->
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/validate/validate.js"></script>

<!-- select2 -->
<script src="<?php echo base_url().$this->config->item('template_path');?>plugins/select2/select2.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/select2.css">

<!--<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/iCheck/all.css">-->
<script>
    //แจ้งเตือนการบันทึก
    function notify_save(name){
        PNotify.desktop.permission();
        (new PNotify({
            title: 'บันทึก'+name+'สำเร็จ',
            text: '',
            type: "success",
            delay: 1500
        }))
    } 

    //แจ้งเตือนการลบ
    function notify_del(name){
        PNotify.desktop.permission();
        (new PNotify({
            title: 'ลบ'+name+'สำเร็จ',
            text: '',
            type: "error",
            delay: 1500
        }))
        
    }

    //แจ้งเตือนการแก้ไข
    function notify_edit(name){
        PNotify.desktop.permission();
        (new PNotify({
            title: 'แก้ไข'+name+'สำเร็จ',
            text: '',
            type: "danger",
            delay: 1500
        }))
    }
	
	 function notify_save_assessment(name){
        PNotify.desktop.permission();
        (new PNotify({
            title: 'ประเมินผล'+name+'สำเร็จ',
            text: '',
            type: "info",
            delay: 1500
        }))
    }

    //tooltip
    $(function () {
        $('[data-tooltip="tooltip"]').tooltip();
    })
	
</script>

<style type="text/css">
	.modal-body {
   		max-height: calc(100vh - 212px);
 		overflow-y: auto;
	}

    th{
        height: 40px;
        text-align: center;
	}/*ความสูงหัวตาราง*/

    thead{
        background-color: #e4f6ff;
	}/*สีหัวตาราง*/

    tr{
        word-break: break-all;
	}/*ตัดบรรทัดตัวอักษร data table*/
	
	textarea { 
		resize: vertical; 
	}
	
	.select2_wb{
		word-break: break-all;
	}
	
	/*color header modal*/
	.modal_header_info{
		color: #ffffff;
		background-color: #3c8dbc;
	}
	
	.modal_header_success{
		color: #ffffff;
		background-color: #00a65a;
	}
	
	.modal_header_warning{
		color: #ffffff;
		background-color: #f39c12;
	}
	
	/*ปุ่มยกเลิก และ ปุ่มปิด*/
	.btn-default {
		background-color: #999999;
		color: #ffffff;
		border-color: #ddd;
	}
	.btn-default:hover,
	.btn-default:active,
	.btn-default.hover {
		background-color: #8c8c8c;
		color: #ffffff;
	}
	
	[type="checkbox"]{
		 width: 1.5em; 
		 height: 1.5em;
	}
	[type="radio"]{
		 width: 1.5em; 
		 height: 1.5em;
	}
</style>