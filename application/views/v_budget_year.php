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
                url: "<?php echo site_url('/Manage_budget_year/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data) {
                        return_data.push({
                            // "ind_seq": data.ind_seq,
                            "seq_queue_show": '<center>'+i+'</center>',
                            "bgy_id": data.bgy_id ,
                            "bgy_name": data.bgy_name,
                            "btn_manage": data.btn_manage,
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "bgy_name"},
                {"data": "btn_manage"},
            ],
			"order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.bgy_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
    } //End fn get_data
	
	function open_modal(){
		clear_validate("frm_modal_add");
        $('#bgy_add').val("");
        $('#modal_add_budget_year').modal({show:true});
    } //End fn open_modal

	function save_budget_year(){
		var frm = validate("frm_modal_add");
		if(frm == true){
			var bgy_name = $('#bgy_add').val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_budget_year/save_budget_year');?>",
				data: {'bgy_name': bgy_name},
				dataType : "json",
				success : function(data){
					if(data == true){
						$('#modal_add_budget_year').modal('toggle');
						notify_save("ปีงบประมาณ");
						get_data();
					} 
				}//End success
			});//End ajax
		}//if
    } //End fn save_indicator

    function edit_budget_year(bgy_id){
        var bgy_id = bgy_id;
	 	$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Manage_budget_year/edit_budget_year'; ?>",
	 		data: {'bgy_id': bgy_id},
	 		dataType : "json",
	 		success : function(data){
	 			$("#bgy_edit").val(data.bgy_name);
                $("#hid_bgy_id").val(bgy_id);
                
	 		}
	 	});
	} //End fn edit_budget_year
	
	function save_edit_budget_year(){
		var frm = validate("frm_modal_edit");
		if(frm == true){
			var bgy_id = $("#hid_bgy_id").val();
			var bgy_name = $("#bgy_edit").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Manage_budget_year/update_budget_year');?>",
				data: {'bgy_id': bgy_id,'bgy_name': bgy_name},
				dataType : "json",
				success : function(data){
					$('#modal_edit_budget_year').modal('toggle');
					notify_edit("ปีงบประมาณ");
					get_data();
				}
			});
		}
    } //End fn save_edit_budget_year

     function update_status_budget_year(bgy_id){
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
                url: "<?php echo site_url().'/Manage_budget_year/update_status_budget_year'; ?>",
                data: {'bgy_id': bgy_id},
                dataType : "json",
                success : function(data){
                    notify_del("ปีงบประมาณ");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
     } //End fn update_status_budget_year
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">จัดการปีงบประมาณ</h2>
            </div>
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" onclick="open_modal()">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มปีงบประมาณ</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="40%">ปีงบประมาณ</th>
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
<div class="modal fade" id="modal_add_budget_year" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">เพิ่มปีงบประมาณ</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ<span class="text-danger">*</span></label>
                            <div class="col-md-10"> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="bgy_add" id="bgy_add" validate>
                            </div>
                        </div>
                    </div>
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_budget_year()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --> 
</div>

<!--Modal edit-->
<div class="modal fade" id="modal_edit_budget_year" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal_header_warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">แก้ไขปีงบประมาณ</h3>
            </div>
            <div class="modal-body">
                <form id="frm_modal_edit"> <!-- Start form -->
                    <div class="form-group"> <!-- Start form-group -->
                        <div class = "col-sm-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ<span class="text-danger">*</span></label>
                            <div class="col-md-10" id=""> <!-- Start col-md-9 -->
                                <input type="text" class="form-control" value="" name="bgy_edit" id="bgy_edit" rows="2" validate  >
                                <input type="hidden" name="hid_bgy_id" id="hid_bgy_id">
                            </div>
                        </div>
                    </div>
				</form>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <a id="btn-edit-tab" name="btn-edit-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" onclick="save_edit_budget_year()">บันทึก</a>
            </div><!--modal-footer-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->   
</div>