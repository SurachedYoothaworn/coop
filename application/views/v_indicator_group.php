<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style type="text/css">
	.modal-body {
   		max-height: calc(100vh - 212px);
 		overflow-y: auto;
	}
</style>

<script>
    function edit_indicator_group(indgp_id){
        // alert(ind_id);
        var indgp_id = indgp_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_indicator_group/edit_indicator_group'; ?>",
	 		data: {'indgp_id': indgp_id},
	 		dataType : "json",
	 		success : function(data){
                // alert(data.ind_name);
	 			$("#indgp_edit").val(data.indgp_name);
                $("#indgp_code_edit").val(data.indgp_code);
                $("#hid_indgp_id").val(indgp_id);
                
	 		}
	 	});
	}

     function update_status_indicator_group(indgp_id){
        // $('.alert').alert()
        var indgp_id = indgp_id;
        // $.ajax({
	 	// 	type: "POST",
	 	// 	url: "<?php echo site_url().'/Manage_indicator_group/update_status_indicator_group'; ?>",
	 	// 	data: {'indgp_id': indgp_id},
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
                    url: "<?php echo site_url().'/Manage_indicator_group/update_status_indicator_group'; ?>",
                    data: {'indgp_id': indgp_id},
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
                <h2 class="box-title">จัดการกลุ่มตัวชี้วัด</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#modal_add_indicator_group" onclick="">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มกลุ่มตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสกลุ่มตัวชี้วัด</th>
                                    <th width="40%">กลุ่มตัวชี้วัด</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rs_indgp->result() as $indgp){ ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $i; ?></td>
                                        <td style="text-align:center"><?php echo $indgp->indgp_code; ?></td>
                                        <td><?php echo $indgp->indgp_name; ?></td>
                                        <td style="text-align:center" >
                                            <button id="btn_edit" name="btn_edit" class="<?php echo $this->config->item('btn_warning');?>" data-toggle="modal" href="#modal_edit_indicator_group" onclick="edit_indicator_group(<?php echo $indgp->indgp_id; ?>)">
                                                <i class="glyphicon glyphicon-pencil" style="color:white"></i>
                                            </button>
                                            <button id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger');?>" data-toggle="modal" href="#" onclick="update_status_indicator_group(<?php echo $indgp->indgp_id; ?>)">
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
<div class="modal fade" id="modal_add_indicator_group" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มกลุ่มตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_indicator_group/save_indicator_group');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">กลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_add" id="indgp_add"  validate  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสกลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_code_add" id="indgp_code_add"  validate  >
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
<div class="modal fade" id="modal_edit_indicator_group" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_indicator_group/update_indicator_group');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">กลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_edit" id="indgp_edit" rows="2" validate  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสกลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_code_edit" id="indgp_code_edit" rows="2" validate  >
                                <input type="hidden" name="hid_indgp_id" id="hid_indgp_id">
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