<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style type="text/css">
	.modal-body {
   		max-height: calc(100vh - 212px);
 		overflow-y: auto;
	}
</style>

<script>
    function edit_strategy(str_id){
        // alert(str_id);
        var str_id = str_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_strategy/edit_strategy'; ?>",
	 		data: {'str_id': str_id},
	 		dataType : "json",
	 		success : function(data){
                // alert(data.str_name);
	 			$("#str_edit").val(data.str_name);
                $("#str_code_edit").val(data.str_code);
                $("#hid_str_id").val(str_id);
                
	 		}
	 	});
	}

     function update_status_strategy(str_id){
        var str_id = str_id;
        // $.ajax({
	 	// 	type: "POST",
	 	// 	url: "<?php //echo site_url().'/Manage_indicator/update_status_indicator'; ?>",
	 	// 	data: {'ind_id': ind_id},
	 	// 	dataType : "json",
	 	// 	success : function(data){
        //         location.reload();
                
	 	// 	}
	 	// });
        swal({
            title: "คุณต้องการลบใช่หรือไม่?",
            text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url().'/Manage_strategy/update_status_strategy';?>",
                    data: {'str_id': str_id},
                    dataType : "json",
                    success : function(data){
                        location.reload();
                        // setTimeout(location.reload.bind(location), 1000);
                    }
                });

                // swal("Poof! Your imaginary file has been deleted!", {
                //     icon: "success",
                // });
            } else {
                // swal("Your imaginary file is safe!");
            }
        });

        
     }
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">จัดการยุทธศาสตร์ตัวชี้วัด</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#modal_add_strategy" onclick="">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มยุทธศาสตร์ตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสยุทธศาสตร์</th>
                                    <th width="40%">ยุทธศาสตร์</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rs_str->result() as $str){ ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $i;?></td>
                                        <td style="text-align:center"><?php  echo $str->str_code; ?></td>
                                        <td><?php  echo $str->str_name; ?></td>
                                        <td style="text-align:center" >
                                            <button id="btn_edit" name="btn_edit" class="<?php echo $this->config->item('btn_warning');?>" data-toggle="modal" href="#modal_edit_strategy" onclick="edit_strategy(<?php echo $str->str_id; ?>)">
                                                <i class="glyphicon glyphicon-pencil" style="color:white"></i>
                                            </button>
                                            <button id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger');?>" data-toggle="modal" href="#" onclick="update_status_strategy(<?php echo $str->str_id; ?>)">
                                                <i class="glyphicon glyphicon-trash" style="color:white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php $i++; } ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div><!-- End  col-md-12 -->
            </div>
        </div>
    </div>
</div>


<!--Modal add-->
<div class="modal fade" id="modal_add_strategy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มยุทธศาสตร์ตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_strategy/save_strategy');?>" method="post" > <!-- Start form -->        
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">ยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_add" id="str_add"  validate  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_code_add" id="str_code_add"  validate>
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div><!--modal-footer-->
            </form>	
        </div>
          <!-- /.modal-content -->
    </div>
          <!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_strategy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขยุทธศาสตร์ตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit" action="<?php echo site_url('/Manage_strategy/update_strategy');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">ยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_edit" id="str_edit" rows="2" validate  >
                                <!-- <input type="hidden" name="afm_ids" id="afm_ids"> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_code_edit" id="str_code_edit" rows="2" validate  >
                                <input type="hidden" name="hid_str_id" id="hid_str_id">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse pull-left" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div><!--modal-footer-->
            </form>	
        </div>
          <!-- /.modal-content -->
    </div>
          <!-- /.modal-dialog -->
</div>