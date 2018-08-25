<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<style>
	th{
        text-align: left;
	}
	
	.select2-choice{
		background: #cccccc;
	}
	
	
</style>
<script>
    $(document).ready( function () {
        get_data();
		$("#select2_indicator").select2();
		$("#select2_budget_year").select2();
		$("#select2_side").select2();
		$("#select2_strategy").select2();
		$("#select2_indicator_group").select2();
		$("#select2_operator").select2();
		$("#select2_unit").select2();
		
		// $( "#select2_budget_year").change(function() {
			// $("#select2_indicator").select2();
			// $('#select2_indicator').val(null).trigger('change');
		// });
    });
	
	function get_data(){
        $("#example").DataTable({
            bDestroy: true,
            processing: true,
            ajax: {
                type: "POST",
                url: "<?php echo site_url('/Define_indicator/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data ) {
                        return_data.push({
							// "ind_seq"			:	data.ind_seq,
							"seq_queue_show"	:	'<center>'+i+'</center>',
							"dfine_id" 			:	data.dfine_id,
							"ind_name" 			:	data.ind_name,	
							"ind_description" 	:	data.ind_description,
							"bgy_name" 			:   '<center>'+data.bgy_name+'</center>',
							"str_name" 			:   data.str_name,
							"indgp_name" 		:   data.indgp_name,
							"opt_name"			:   data.opt_name,
							"opt_symbol"		:   data.opt_symbol,
							"dfine_goal" 		:   data.dfine_goal,
							"unt_name"			:   data.unt_name,
							"side_name" 		:   data.side_name,
							"goal"				:	'<center>'+data.opt_name+' '+data.dfine_goal+' '+data.unt_name+'</center>',
							"btn_rm"			:	data.btn_rm,
							"btn_opt"			:	data.btn_opt,
							
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "bgy_name"},
                {"data": "ind_name"},
                {"data": "goal"},
				{"data": "btn_rm"},
				{"data": "btn_opt"},
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
	
	function get_data_info(dfine_id){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Define_indicator/get_data_info');?>",
			data: {'dfine_id': dfine_id},
			dataType : "json",
			success : function(data){
				// $('#modal_define_indicator').modal('toggle');
				$('#tb_info').html(data);
				// notify_edit("");
				// get_data();
			}//End success
		});
	} //End fn get_data_info
	
	function open_modal(dfine_id){
		if(dfine_id == 0){
			clear_validate("frm_modal_add");
			$("#select2_indicator").attr('disabled',"");
			$('#select2_indicator').val(null).trigger('change');
			$("#select2_budget_year").val(null).trigger('change');
			$("#select2_side").val(null).trigger('change');
			$("#select2_strategy").val(null).trigger('change');
			$("#select2_indicator_group").val(null).trigger('change');
			$("#select2_operator").val(null).trigger('change');
			$("#select2_unit").val(null).trigger('change');
			$("#goal_add").val(null).trigger('change');
			$("#hid_btn_save").val(0);
			$("#hid_dfine_id").val("");
			$('#modal_define_indicator').modal({show:true});
			$("#header").removeClass("modal_header_warning");
			$("#header").addClass("modal_header_success");
			$("#modal_add_title").html("เพิ่มข้อมูลรายการตัวชี้วัด");
		}else{
			// alert(dfine_id);
			$.ajax({
	 		type: "POST",
	 		url: "<?php echo site_url().'/Define_indicator/edit_define_indicator'; ?>",
	 		data: {'dfine_id': dfine_id},
	 		dataType : "json",
				success : function(data){
					var ind_id = data.ind_id;
					// $('#select2_indicator').val(null).trigger('change');
					
					// $("#select2_indicator").removeAttr('disabled',"");
					clear_validate("frm_modal_add");
					$('#modal_define_indicator').modal({show:true});
					$("#select2_budget_year").val(data.bgy_id).trigger('change');
					$("#select2_side").val(data.side_id).trigger('change');
					$("#select2_strategy").val(data.str_id).trigger('change');
					$("#select2_indicator_group").val(data.indgp_id).trigger('change');
					$("#select2_operator").val(data.opt_id).trigger('change');
					$("#select2_unit").val(data.unt_id).trigger('change');
					$("#goal_add").val(data.dfine_goal).trigger('change');
					$('#modal_define_indicator').modal({show:true});
					$("#header").removeClass("modal_header_success");
					$("#header").addClass("modal_header_warning");
					$("#modal_add_title").html("แก้ไขข้อมูลรายการตัวชี้วัด");
					$("#hid_dfine_id").val(data.dfine_id);
					$.ajax({
						type: "POST",
						url: "<?php echo site_url().'/Define_indicator/edit_value_indicator'; ?>",
						data: {'ind_id': data.ind_id, 'bgy_id': data.bgy_id},
						dataType : "json",
						success : function(data){
							$("#hid_btn_save").val(1);
							var row  = "";
								row += '<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกตัวชี้วัด---</option>';
							$.each( data, function( key, value) {
							  // console.log( value.ind_id + ": " + value.ind_name );
								row += '<option class="select2_wb" value="'+value.ind_id+'">'+value.ind_name+'</option>';
								$("#select2_indicator").html(row);				
							});
							$("#select2_indicator").val(ind_id).trigger('change');
							// $("#select2_budget_year").val(data.bgy_id).trigger('change');
						}//End success
					});
				}//End success
			});
		}//End if/else
	} //End fn open_modal
	
	function save_data(){
		var indicator = $("#select2_indicator").val();
		var budget_year = $("#select2_budget_year").val();
		var side = $("#select2_side").val();
		var strategy = $("#select2_strategy").val();
		var indicator_group = $("#select2_indicator_group").val();
		var operator = $("#select2_operator").val();
		var unit = $("#select2_unit").val();
		var goal = $("#goal_add").val();
		var chk_btn = $("#hid_btn_save").val();//เช็คว่าเป็นบันทึก หรืออัพเดท | 1=อัพเดท , 0=เพิ่มใหม่
		var dfine_id = $("#hid_dfine_id").val();
		var frm = validate("frm_modal_add");
		if(frm == true){
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_indicator/save_data');?>",
				data: {'indicator': indicator, 'budget_year': budget_year, 'side': side, 'strategy': strategy, 'indicator_group': indicator_group, 'operator': operator, 'unit': unit, 'goal': goal, 'chk_btn': chk_btn, 'dfine_id': dfine_id},
				dataType : "json",
				success : function(data){
					if(data == 1){
						$('#modal_define_indicator').modal('toggle');
						notify_edit("รายการตัวชี้วัด");
						get_data();
					}else{
						$('#modal_define_indicator').modal('toggle');
						notify_save("รายการตัวชี้วัด");
						get_data();
					}
				}//End success
			});
		}//if
	} //End fn save_data
	
	function get_indicator_by_bgy(){
		var hid_btn_save = $("#hid_btn_save").val();
		var bgy_id = $("#select2_budget_year").val();
		var ind_id = $("#select2_indicator").val();
		
		var chk_btn = $("#hid_btn_save").val();
		// alert('bgy=>'+bgy_id);
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Define_indicator/get_indicator_by_bgy');?>",
			data: {'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				if(bgy_id == null || bgy_id == ""){
					$("#select2_indicator").attr('disabled',"");
					$("#div_ind").attr('data-tooltip',"กรุณาเลือกปีงบประมาณ");
					
				}else{
					$("#select2_indicator").removeAttr('disabled',"");
					$("#div_ind").removeAttr('data-tooltip',"");
				}
				var row = "";
					row += '<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกตัวชี้วัด---</option>';
				$.each( data, function( key, value) {
				  // console.log( value.ind_id + ": " + value.ind_name );
					row += '<option class="select2_wb" value="'+value.ind_id+'">'+value.ind_name+'</option>';
					$("#select2_indicator").html(row);	
					// if(chk_btn == 0){
						// $('#select2_indicator').val(null).trigger('change');	
					// }
				});//End each
			}//End success
		});
	} //End fn get_indicator_by_bgy
	
	function update_status_define_indicator(dfine_id){
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
                url: "<?php echo site_url().'/Define_indicator/update_status_define_indicator'; ?>",
                data: {'dfine_id': dfine_id},
                dataType : "json",
                success : function(data){
                    notify_del("รายการตัวชี้วัด");
                    get_data();
                }
            });
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
    } //End fn update_status_indicator
	
	function get_info_resm(dfine_id){
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Define_indicator/get_info_resm'; ?>",
            data: {'dfine_id': dfine_id},
            dataType : "json",
            success : function(data){
				$('#modal_info_resm').modal('toggle');
				// var row = "";
				// $(data).each(function(seq, data) {
					// seq++;			
				// });
				$("#tb_modal_info_resm").html(data);	
            }
        });
	}
	
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">จัดการข้อมูลรายการตัวชี้วัด</h2>
                <!-- <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i></button>
                </div> -->
            </div>
            
            <div class="box-body">
                <div class="col-md-3">	
                    <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" href="#" onclick="open_modal('0')">
                    <i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มข้อมูลรายการตัวชี้วัด</a>
                </div><br><br><br>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">ลำดับ</th>
                                    <th style="width: 10%; text-align: center;">ปีงบประมาณ</th>
                                    <th style="width: 30%; text-align: center;">ตัวชี้วัด</th>
                                    <th style="width: 10%; text-align: center;">เป้าหมาย</th>
									<th style="width: 10%; text-align: center;">ผู้รับผิดชอบ</th>
                                    <th style="width: 15%; text-align: center;">ดำเนินการ</th>
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
<div class="modal fade" id="modal_define_indicator" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  style="">
        <div class="modal-content">
            <div class="modal-header" id="header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title" id="modal_add_title" ></h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
				
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_budget_year" name="select2_budget_year" style="width: 100%;" tabindex="-1" onchange="get_indicator_by_bgy()" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกปีงบประมาณ---</option>
									<?php foreach($rs_budget_year as $bgy){?>
										<option class="select2_wb" value="<?php echo $bgy->bgy_id;?>"><?php echo $bgy->bgy_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12" id="div_ind">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ตัวชี้วัด<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_indicator" name="select2_indicator" style="width: 100%;" tabindex="-1" validate>
									<option id="opt" class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกตัวชี้วัด---</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยงาน<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_side" name="select2_side" style="width: 100%;" tabindex="-1" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกหน่วยงาน---</option>
									<?php foreach($rs_side as $side){?>
										<option class="select2_wb" value="<?php echo $side->side_id;?>"><?php echo $side->side_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ยุทธศาสตร์<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_strategy" name="select2_strategy" style="width: 100%;" tabindex="-1" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกยุทธศาสตร์---</option>
									<?php foreach($rs_strategy as $str){?>
										<option class="select2_wb" value="<?php echo $str->str_id;?>"><?php echo $str->str_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">กลุุ่มตัวชี้วัด<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_indicator_group" name="select2_indicator_group" style="width: 100%;" tabindex="-1" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกกลุุ่มตัวชี้วัด---</option>
									<?php foreach($rs_indicator_group as $indgp){?>
										<option class="select2_wb" value="<?php echo $indgp->indgp_id;?>"><?php echo $indgp->indgp_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">คำนวนผล<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_operator" name="select2_operator" style="width: 100%;" tabindex="-1" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกการคำนวนผล---</option>
									<?php foreach($rs_operator as $opt){?>
										<option class="select2_wb" value="<?php echo $opt->opt_id;?>"><?php echo $opt->opt_name;?>&nbsp;&nbsp;&nbsp;(<?php echo $opt->opt_symbol;?>)</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group"> <!-- Start form-group -->
                        <div class = "col-md-12">
                            <label class="col-md-2 control-label" style="padding: 8px; text-align: right;">เป้าหมาย<span class="text-danger">*</span></label>
                            <div class="col-md-10"> <!-- Start col-md-9 -->
                                <input type="number" class="form-control" value="" name="goal_add" id="goal_add"  validate  >
                            </div>
                        </div>
                    </div>
					
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">หน่วยนับ<span class="text-danger">*</span></label>
							<div class="col-md-10 select2-container-active">
								<select class="select2" id="select2_unit" name="select2_unit" style="width: 100%;" tabindex="-1" validate>
									<option class="select2_wb" value="" disabled="" selected="">---กรุณาเลือกหน่วยนับ---</option>
									<?php foreach($rs_unit as $unt){?>
										<option class="select2_wb" value="<?php echo $unt->unt_id;?>"><?php echo $unt->unt_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<input type="hidden" id="hid_dfine_id" value="">
					<input type="hidden" id="hid_btn_save" value="">
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <!-- <button type="submit" class="btn btn-success" onclick="save_indicator()" >บันทึก</button> -->
                <a id="btn-add-tab" name="btn-add-tab" class="<?php echo $this->config->item('btn_success');?> pull-right" data-toggle="modal" onclick="save_data()">บันทึก</a>
			</div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->



<!--Modal info-->
<div class="modal fade" id="modal_info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">รายละเอียดข้อมูลรายการตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group"> <!-- Start form-group -->
						<table id="" class="table table-bordered">
							<tbody id="tb_info">
								
							</tbody>
						</table>
					</div> <!-- End form-group -->
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <!-- <button type="submit" class="btn btn-success" onclick="save_indicator()" >บันทึก</button> -->
                </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->

<!--Modal info resm-->
<div class="modal fade" id="modal_info_resm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">ผู้รับผิดชอบตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group"> <!-- Start form-group -->
						<table id="" class="table table-bordered">
							 <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">ลำดับ</th>
                                    <th style="width: 30%; text-align: center;">ชื่อ - สกุล</th>
                                    <th style="width: 30%; text-align: center;">ตำแหน่ง</th>
                                </tr>
                            </thead>
							<tbody id="tb_modal_info_resm">
								
							</tbody>
						</table>
					</div> <!-- End form-group -->
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <!-- <button type="submit" class="btn btn-success" onclick="save_indicator()" >บันทึก</button> -->
                </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->


