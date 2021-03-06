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
                url: "<?php echo site_url('/Manage_strategy/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data ) {
                        return_data.push({
                            // "ind_seq": data.ind_seq,
                            "seq_queue_show": '<center>'+i+'</center>',
                            "str_id": data.str_id ,
                            "str_name": data.str_name,
                            "str_code": data.str_code,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "str_code"},
                {"data": "str_name"},
                {"data": "btn_manage"},
            ],
			"order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.str_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
    } //End fn get_data

	function open_modal(){
		clear_validate("frm_modal_add");
        $('#str_add').val("");
        $('#str_code_add').val("");
        $('#modal_add_strategy').modal({show:true});
    } //End fn open_modal

	function save_strategy(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var str_name = $('#str_add').val();
			var str_code = $('#str_code_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_strategy/save_strategy');?>",
				data: {'str_name': str_name, 'str_code': str_code},
				dataType : "json",
				success : function(data){
					if(data == true){
						$('#modal_add_strategy').modal('toggle');
						notify_save("ยุทธศาสตร์ตัวชี้วัด");
						get_data();
					} 
				}//End success
			});//End ajax
		}//if
    } //End fn save_strategy

    function edit_strategy(str_id){
        var str_id = str_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_strategy/edit_strategy'; ?>",
	 		data: {'str_id': str_id},
	 		dataType : "json",
	 		success : function(data){
	 			$("#str_edit").val(data.str_name);
                $("#str_code_edit").val(data.str_code);
                $("#hid_str_id").val(str_id);
	 		}
	 	});
	} //End fn edit_strategy
	
	function save_edit_strategy(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var hid_str_id = $("#hid_str_id").val();
			var str_name = $("#str_edit").val();
			var str_code = $("#str_code_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_strategy/update_strategy');?>",
				data: {'str_id': hid_str_id,'str_name': str_name,'str_code': str_code},
				dataType : "json",
				success : function(data){
					$('#modal_edit_strategy').modal('toggle');
					notify_edit("ยุทธศาสตร์ตัวชี้วัด");
					get_data();
				}
			});
		}
    } //End fn save_edit_strategy

    function update_status_strategy(str_id){
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
                url: "<?php echo site_url().'/Manage_strategy/update_status_strategy';?>",
                data: {'str_id': str_id},
                dataType : "json",
                success : function(data){
                    notify_del("ยุทธศาสตร์ตัวชี้วัด");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
    } //End fn update_status_strategy
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
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" data-toggle="modal" href="#" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มยุทธศาสตร์ตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสยุทธศาสตร์</th>
                                    <th width="40%">ยุทธศาสตร์</th>
                                    <th width="15%">ดำเนินการ</th>
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
<div class="modal fade" id="modal_add_strategy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มยุทธศาสตร์ตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add"> <!-- Start form -->        
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">ยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_add" id="str_add"  validate>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสยุทธศาสตร์<span></span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_code_add" id="str_code_add">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" data-toggle="modal" onclick="save_strategy()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_strategy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขยุทธศาสตร์ตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">ยุทธศาสตร์<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_edit" id="str_edit" rows="2" validate  >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสยุทธศาสตร์<span></span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="str_code_edit" id="str_code_edit" rows="2">
                                <input type="hidden" name="hid_str_id" id="hid_str_id">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" data-toggle="modal" onclick="save_edit_strategy()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>