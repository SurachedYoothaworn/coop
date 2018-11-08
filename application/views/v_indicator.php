<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
    $(document).ready( function () {
        get_data();
    });
	
    function get_data(){
        $("#example").DataTable({
            bDestroy: true,
            processing: true,
            ajax: {
                type: "POST",
                url: "<?php echo site_url('/Manage_indicator/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data ) {
                        return_data.push({
                            "seq_queue_show": '<center>'+i+'</center>',
                            "ind_id": data.ind_id ,
                            "ind_name": data.ind_name,
                            "ind_description": data.ind_description,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "ind_name"},
                {"data": "ind_description"},
                {"data": "btn_manage"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.ind_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
    } //End fn get_data

    function open_modal(){
        $('#ind_add').val("");
        $('#desc_add').val("");
        $('#modal_add_indicator').modal({show:true});
    } //End fn open_modal

    function save_indicator(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var ind_name = $('#ind_add').val();
			var ind_desc = $('#desc_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_indicator/save_indicator');?>",
				data: {'ind_name': ind_name, 'ind_desc': ind_desc},
				dataType : "json",
				success : function(data){
					if(data == true){
						$('#modal_add_indicator').modal('toggle');
						notify_save("ตัวชี้วัด");
						get_data();
					} 
				}//End success
			});
		}//if
    } //End fn save_indicator

    function edit_indicator(ind_id){
        var ind_id = ind_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_indicator/edit_indicator'; ?>",
	 		data: {'ind_id': ind_id},
	 		dataType : "json",
	 		success : function(data){
	 			$("#ind_edit").val(data.ind_name);
                $("#desc_edit").val(data.ind_description);
                $("#hid_ind_id").val(ind_id);
	 		}
	 	});
	} //End fn edit_indicator

    function save_edit_indicator(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var hid_ind_id = $("#hid_ind_id").val();
			var ind_edit = $("#ind_edit").val();
			var desc_edit = $("#desc_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_indicator/update_indicator');?>",
				data: {'hid_ind_id': hid_ind_id,'ind_edit': ind_edit,'desc_edit': desc_edit},
				dataType : "json",
				success : function(data){
					$('#modal_edit_indicator').modal('toggle');
					notify_edit("ตัวชี้วัด");
					get_data();
				}
			});
		}
    } //End fn save_edit_indicator

    function update_status_indicator(ind_id){
        swal({ //start swal
			title: "คุณต้องการลบใช่หรือไม่?",
			text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dd4b39",
			confirmButtonText: "ยืนยัน",
			closeOnConfirm: true ,
			cancelButtonText: 'ยกเลิก'
		},function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url().'/Manage_indicator/update_status_indicator'; ?>",
                data: {'ind_id': ind_id},
                dataType : "json",
                success : function(data){
                    notify_del("ตัวชี้วัด");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
    } //End fn update_status_indicator
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">จัดการตัวชี้วัด</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" href="#" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 8%;">ลำดับ</th>
                                    <th style="width: 40%;">ชื่อตัวชี้วัด</th>
                                    <th style="width: 40%;">คำอธิบาย</th>
                                    <th style="width: 15%;">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div><!-- End  col-md-12 -->
            </div>
        </div>
    </div>
</div>

<!--Modal add-->
<div class="modal fade" id="modal_add_indicator" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">เพิ่มตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ชื่อตัวชี้วัด<span class="text-danger">*</span></label>
							<div class="col-md-10" id=""> <!-- Start col-md-9 -->
								<textarea name="ind_add" id="ind_add" class="form-control" rows="2" cols="50" validate></textarea>
							</div>
						</div>
					</div><label></label>
					<div class="form-group">
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">คำอธิบาย<span></span></label>
							<div class="col-md-10" id=""> <!-- Start col-md-9 -->
								<textarea name="desc_add" id="desc_add" class="form-control" rows="4" cols="50" ></textarea>
							</div>
						</div> <!-- End col-md-12 -->
					</div> <!-- End form-group -->
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" data-toggle="modal" onclick="save_indicator()">บันทึก</a>
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->

<!--Modal edit-->
<div class="modal fade" id="modal_edit_indicator" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-md-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ชื่อตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <textarea name="ind_edit" id="ind_edit" class="form-control" rows="2" cols="50" validate></textarea>
                            </div>
                        </div>
                    </div><label></label>
                    <div class="form-group">
                        <div class = "col-md-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">คำอธิบาย<span></span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <textarea name="desc_edit" id="desc_edit" class="form-control" rows="4" cols="50" value=""></textarea>
                                <input type="hidden" name="hid_ind_id" id="hid_ind_id">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_edit_indicator()">บันทึก</a>
            </div><!--modal-footer-->
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->