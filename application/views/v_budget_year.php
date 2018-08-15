<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>

<script>
    $(document).ready( function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    } );

    function edit_budget_year(bgy_id){
        // alert(bgy_id);
        var bgy_id = bgy_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_budget_year/edit_budget_year'; ?>",
	 		data: {'bgy_id': bgy_id},
	 		dataType : "json",
	 		success : function(data){
                // alert(data.bgy_name);
	 			$("#bgy_edit").val(data.bgy_name);
                $("#desc_edit").val(data.bgy_description);
                $("#hid_bgy_id").val(bgy_id);
                
	 		}
	 	});
	}

     function update_status_budget_year(bgy_id){
        // $('.alert').alert()
        var bgy_id = bgy_id;
        // $.ajax({
	 	// 	type: "POST",
	 	// 	url: "<?php echo site_url().'/Manage_budget_year/update_status_budget_year'; ?>",
	 	// 	data: {'bgy_id': bgy_id},
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
                    url: "<?php echo site_url().'/Manage_budget_year/update_status_budget_year'; ?>",
                    data: {'bgy_id': bgy_id},
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
                <h2 class="box-title">จัดการปีงบประมาณ</h2>
                <!-- <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i></button>
                </div> -->
            </div>
            
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#modal_add_budget_year" onclick="">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มปีงบประมาณ</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="40%">ปีงบประมาณ</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rs_bgy->result() as $bgy){ ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $i; ?></td>
                                        <td><?php echo $bgy->bgy_name; ?></td>
                                        <td style="text-align:center" >
                                            <button type="button" id="btn_edit" name="btn_edit" class="btn <?php echo $this->config->item('btn_warning');?>"  data-toggle="modal" title="แก้ไข" href="#modal_edit_budget_year" onclick="edit_budget_year(<?php echo $bgy->bgy_id; ?>)">
                                                <i class="glyphicon glyphicon-pencil" style="color:white"></i>
                                            </button>
                                            <button id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger');?> " data-toggle="modal" href="#" onclick="update_status_budget_year(<?php echo $bgy->bgy_id; ?>)">
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
<div class="modal fade" id="modal_add_budget_year" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มปีงบประมาณ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add" action="<?php echo site_url('/Manage_budget_year/save_budget_year');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="bgy_add" id="bgy_add"  validate  >
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
<div class="modal fade" id="modal_edit_budget_year" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขปีงบประมาณ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit" action="<?php echo site_url('/Manage_budget_year/update_budget_year');?>" method="post" > <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="bgy_edit" id="bgy_edit" rows="2" validate  >
                                <input type="hidden" name="hid_bgy_id" id="hid_bgy_id">
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