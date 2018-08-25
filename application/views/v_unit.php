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
                url: "<?php echo site_url('/Manage_unit/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data) {
                        return_data.push({
                            "seq_queue_show": '<center>'+i+'</center>',
                            "unt_id": data.unt_id ,
                            "unt_name": data.unt_name,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns" : [
                {"data": "seq_queue_show"},
                {"data": "unt_name"},
                {"data": "btn_manage"},
            ],
			"order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.unt_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
        // var table = $("#example").dataTable();
	    // new $.fn.dataTable.FixedHeader(table);
    } //End fn get_data
	
	function open_modal(){
		clear_validate("frm_modal_add");
        $('#unt_add').val("");
        $('#modal_add_unit').modal({show:true});
    } //End fn open_modal

	function save_unit(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var unt_name = $('#unt_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_unit/save_unit');?>",
				data: {'unt_name': unt_name},
				dataType : "json",
				success : function(data){
					if(data == true){
						$('#modal_add_unit').modal('toggle');
						notify_save("หน่วยนับ");
						get_data();
					} 
				}//End success
			});//End ajax
		}//if
    } //End fn save_unit

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
	} //End fn edit_unit
	
	function save_edit_unit(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var unt_id = $("#hid_unt_id").val();
			var unt_name = $("#unt_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_unit/update_unit');?>",
				data: {'unt_id': unt_id,'unt_name': unt_name},
				dataType : "json",
				success : function(data){
					$('#modal_edit_unit').modal('toggle');
					notify_edit("หน่วยนับ");
					get_data();
				}
			});
		}
    } //End fn save_edit_unit

    function update_status_unit(unt_id){
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
                url: "<?php echo site_url().'/Manage_unit/update_status_unit'; ?>",
                data: {'unt_id': unt_id},
                dataType : "json",
                success : function(data){
                    notify_del("หน่วยนับ");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
     } //End fn update_status_unit
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">จัดการหน่วยนับ</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มหน่วยนับ</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="40%">หน่วยนับ</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div><!-- End  col-md-12 -->
            </div>
        </div>
    </div>
</div>

<!--Modal add-->
<div class="modal fade" id="modal_add_unit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มหน่วยนับ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-md-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยนับ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="unt_add" id="unt_add" validate>
                            </div>
                        </div><!-- End col-md-12 -->
                    </div><!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_unit()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_unit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขหน่วยนับ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class="col-md-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยนับ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="unt_edit" id="unt_edit" rows="2" validate  >
                                <input type="hidden" name="hid_unt_id" id="hid_unt_id">
                            </div>
                        </div><!-- End col-md-12 -->
                    </div><!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_edit_unit()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>