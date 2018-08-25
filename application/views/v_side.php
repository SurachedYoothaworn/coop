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
                url: "<?php echo site_url('/Manage_side/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data) {
                        return_data.push({
                            // "ind_seq": data.ind_seq,
                            "seq_queue_show": '<center>'+i+'</center>',
                            "side_id": data.side_id ,
                            "side_name": data.side_name,
                            "side_code": data.side_code,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "side_code"},
                {"data": "side_name"},
                {"data": "btn_manage"},
            ],
			"order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.side_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
        // var table = $("#example").dataTable();
	    // new $.fn.dataTable.FixedHeader(table);
    } //End fn get_data
	
	function open_modal(){
		clear_validate("frm_modal_add");
        $('#side_add').val("");
        $('#side_code_add').val("");
        $('#modal_add_side').modal({show:true});
    } //End fn open_modal

	function save_side(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var side_name = $('#side_add').val();
			var side_code = $('#side_code_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_side/save_side');?>",
				data: {'side_name': side_name, 'side_code': side_code},
				dataType : "json",
				success : function(data){
					// alert(data);
					if(data == true){
						$('#modal_add_side').modal('toggle');
						notify_save("หน่วยงาน");
						get_data();
					} 
				}//End success
			});//End ajax
		}//if
    } //End fn save_side 
	
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
	} //End fn edit_side
	
	function save_edit_side(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var side_id = $("#hid_side_id").val();
			var side_name = $("#side_edit").val();
			var side_code = $("#side_code_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_side/update_side');?>",
				data: {'side_id': side_id,'side_name': side_name,'side_code': side_code},
				dataType : "json",
				success : function(data){
					$('#modal_edit_side').modal('toggle');
					notify_edit("หน่วยงาน");
					get_data();
				}
			});
		}
    } //End fn save_edit_side

     function update_status_side(side_id){
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
                url: "<?php echo site_url().'/Manage_side/update_status_side';?>",
                data: {'side_id': side_id},
                dataType : "json",
                success : function(data){
                    notify_del("หน่วยงาน");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
    } //End fn update_status_side
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
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มหน่วยงาน</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="10%">รหัสหน่วยงาน</th>
                                    <th width="40%">หน่วยงาน</th>
                                    <th width="15%">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot> </tfoot>
                        </table>
                    </div>
                </div><!-- End  col-md-12 -->
            </div>
        </div>
    </div>
</div>

<!--Modal add-->
<div class="modal fade" id="modal_add_side" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
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
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสหน่วยงาน<span></span></label>
                            <div class="col-md-9" id="div_pol_name"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_code_add" id="side_code_add" >
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_side()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_side" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขหน่วยงาน</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">หน่วยงาน<span class="text-danger">*</span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_edit" id="side_edit" rows="2" validate>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class = "col-sm-12">
                            <label class="col-md-3 control-label" style="padding: 8px; text-align: right;">รหัสหน่วยงาน<span></span></label>
                            <div class="col-md-9" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="side_code_edit" id="side_code_edit" rows="2">
                                <input type="hidden" name="hid_side_id" id="hid_side_id">
                            </div>
                        </div> <!-- End col-md-12 -->
                    </div> <!-- End form-group -->
				</form>	
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
				<a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_edit_side()">บันทึก</a>
            </div><!--modal-footer-->
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>