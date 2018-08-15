<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
    function edit_side(side_id){
        // alert(side_id);
        var side_id = side_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_side/edit_side'; ?>",
	 		data: {'side_id': side_id},
	 		dataType : "json",
	 		success : function(data){
                // alert(data.side_name);
	 			$("#side_edit").val(data.side_name);
                $("#side_code_edit").val(data.side_code);
                $("#hid_side_id").val(side_id);
                
	 		}
	 	});
	}

     function update_status_side(side_id){
        var side_id = side_id;
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
                    url: "<?php echo site_url().'/Manage_side/update_status_side';?>",
                    data: {'side_id': side_id},
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
                <h2 class="box-title">จัดการหน่วยงาน</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#modal_add_side" onclick="">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มหน่วยงาน</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสหน่วยงาน</th>
                                    <th width="40%">หน่วยงาน</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rs_side->result() as $side){ ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $i;?></td>
                                        <td style="text-align:center"><?php  echo $side->side_code; ?></td>
                                        <td><?php  echo $side->side_name; ?></td>
                                        <td style="text-align:center" >
                                            <button id="btn_edit" name="btn_edit" class="<?php echo $this->config->item('btn_warning');?>" data-toggle="modal" href="#modal_edit_side" onclick="edit_side(<?php echo $side->side_id; ?>)">
                                                <i class="glyphicon glyphicon-pencil" style="color:white"></i>
                                            </button>
                                            <button id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger');?>" data-toggle="modal" href="#" onclick="update_status_side(<?php echo $side->side_id; ?>)">
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
<div class="modal fade" id="modal_add_side" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มหน่วยงาน</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_side/save_side');?>" method="post" > <!-- Start form -->        
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">หน่วยงาน<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_add" id="side_add"  validate  >
                              </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสหน่วยงาน<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_code_add" id="side_code_add"  validate  >
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                    <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div><!--modal-footer-->
            </form>	
        </div>
          <!-- /.modal-content -->
    </div>
          <!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_side" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขหน่วยงาน</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit" action="<?php echo site_url('/Manage_side/update_side');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยงาน<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_edit" id="side_edit" rows="2" validate  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">รหัสหน่วยงาน<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_code_edit" id="side_code_edit" rows="2" validate  >
                                <input type="hidden" name="hid_side_id" id="hid_side_id">
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