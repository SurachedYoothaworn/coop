<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
    $(document).ready( function () {

    } );

    function edit_unit(unt_id){
        var unt_id = unt_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_unit/edit_unit'; ?>",
	 		data: {'unt_id': unt_id},
	 		dataType : "json",
	 		success : function(data){
                // alert(data.unt_name);
	 			$("#unt_edit").val(data.unt_name);
                $("#desc_edit").val(data.unt_description);
                $("#hid_unt_id").val(unt_id);
                
	 		}
	 	});
	}

     function update_status_unit(unt_id){
        // $('.alert').alert()
        var unt_id = unt_id;
        // $.ajax({
	 	// 	type: "POST",
	 	// 	url: "<?php echo site_url().'/Manage_unit/update_status_unit'; ?>",
	 	// 	data: {'unt_id': unt_id},
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
                    url: "<?php echo site_url().'/Manage_unit/update_status_unit'; ?>",
                    data: {'unt_id': unt_id},
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
                <h2 class="box-title">จัดการหน่วยนับ</h2>
                <!-- <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i></button>
                </div> -->
            </div>
            
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#modal_add_unit" onclick="">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มหน่วยนับ</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="40%">หน่วยนับ</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rs_unt->result() as $unt){ ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $i; ?></td>
                                        <td><?php echo $unt->unt_name; ?></td>
                                        <td style="text-align:center" >
                                            <button id="btn_edit" name="btn_edit" class="<?php echo $this->config->item('btn_warning');?>" data-toggle="modal" href="#modal_edit_unit" onclick="edit_unit(<?php echo $unt->unt_id; ?>)">
                                                <i class="glyphicon glyphicon-pencil" style="color:white"></i>
                                            </button>
                                            <button id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger');?>" data-toggle="modal" href="#" onclick="update_status_unit(<?php echo $unt->unt_id; ?>)">
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
<div class="modal fade" id="modal_add_unit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มหน่วยนับ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_unit/save_unit');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยนับ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="unt_add" id="unt_add"  validate  >
                            </div>
                        </div>
                    </div>
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
<div class="modal fade" id="modal_edit_unit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขหน่วยนับ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit" action="<?php echo site_url('/Manage_unit/update_unit');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยนับ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="unt_edit" id="unt_edit" rows="2" validate  >
                                <input type="hidden" name="hid_unt_id" id="hid_unt_id">
                            </div>
                        </div>
                    </div>
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