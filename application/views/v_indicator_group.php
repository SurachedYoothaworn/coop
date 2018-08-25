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
                url: "<?php echo site_url('/Manage_indicator_group/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data ) {
                        return_data.push({
                            // "ind_seq": data.ind_seq,
                            "seq_queue_show": '<center>'+i+'</center>',
                            "indgp_id": data.indgp_id ,
                            "indgp_name": data.indgp_name,
                            "indgp_code": data.indgp_code,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "indgp_code"},
                {"data": "indgp_name"},
                {"data": "btn_manage"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.ind_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
        // var table = $("#example").dataTable();
	    // new $.fn.dataTable.FixedHeader(table);
    } //End fn get_data
	
	function open_modal(){
		clear_validate("frm_modal_add");
        $('#indgp_add').val("");
        $('#indgp_code_add').val("");
        $('#modal_add_indicator_group').modal({show:true});
    } //End fn open_modal
	
	function save_indicator_group(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var indgp_name = $('#indgp_add').val();
			var indgp_code = $('#indgp_code_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_indicator_group/save_indicator_group');?>",
				data: {'indgp_name': indgp_name, 'indgp_code': indgp_code},
				dataType : "json",
				success : function(data){
					if(data == true){
						$('#modal_add_indicator_group').modal('toggle');
						notify_save("กลุ่มตัวชี้วัด");
						get_data();
					} 
				}//End success
			});
		}//if
    } //End fn save_indicator_group
	
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
	
	function save_edit_indicator_group(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var indgp_id = $("#hid_indgp_id").val();
			var indgp_name = $("#indgp_edit").val();
			var indgp_code = $("#indgp_code_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_indicator_group/update_indicator_group');?>",
				data: {'indgp_id': indgp_id,'indgp_name': indgp_name,'indgp_code': indgp_code},
				dataType : "json",
				success : function(data){
					$('#modal_edit_indicator_group').modal('toggle');
					notify_edit("กลุ่มตัวชี้วัด");
					get_data();
				}
			});
		}
    } //End fn save_edit_indicator

    function update_status_indicator_group(indgp_id){
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
                url: "<?php echo site_url().'/Manage_indicator_group/update_status_indicator_group'; ?>",
                data: {'indgp_id': indgp_id},
                dataType : "json",
                success : function(data){
                    notify_del("กลุ่มตัวชี้วัด");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
    } //End fn update_status_indicator_group
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
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" href="#" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มกลุ่มตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสกลุ่มตัวชี้วัด</th>
                                    <th width="40%">กลุ่มตัวชี้วัด</th>
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
<div class="modal fade" id="modal_add_indicator_group" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มกลุ่มตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_add"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">กลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_add" id="indgp_add"  validate>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสกลุ่มตัวชี้วัด<span></span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_code_add" id="indgp_code_add">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_indicator_group()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_indicator_group" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">กลุ่มตัวชี้วัด<span class="text-danger">*</span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_edit" id="indgp_edit" rows="2" validate>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสกลุ่มตัวชี้วัด<span></span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="indgp_code_edit" id="indgp_code_edit" rows="2">
                                <input type="hidden" name="hid_indgp_id" id="hid_indgp_id">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" data-toggle="modal" onclick="save_edit_indicator_group()">บันทึก</a>
			</div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>