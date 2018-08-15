<!------ Include the above in your HEAD tag ---------->

<!-- DataTable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script> 
<!-- <link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url().$this->config->item('template_path');?>plugins/datatables/jquery.dataTables_themeroller.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">


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

<script>
    // $(function () {
    //     $('#example').dataTable( {
    //         "oLanguage": {
    //             "sLengthMenu": "แสดง  _MENU_  รายการ",
    //             "sZeroRecords": "ไม่พบข้อมูล",
    //             "sInfo": "แสดงรายการที่ _START_ ถึง _END_ ของ _TOTAL_ รายการ",
    //             "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
    //             "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
    //             "sSearch": "ค้นหา :",
    //             // "bFilter": false,
    //             "oPaginate": {
    //                 "sFirst":    "หน้าแรก",
    //                 "sPrevious": "ก่อนหน้า",
    //                 "sNext":     "ถัดไป",
    //                 "sLast":     "หน้าสุดท้าย"
    //             }
    //         }
    //     });
    // });

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

</style>