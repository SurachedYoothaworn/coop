<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<style>
	th{
        text-align: left;
	}
	
	.label-danger {
		font-size: 15px;
	}
	
	.label-success {
		font-size: 15px;
	}
	
	.label-warning {
		font-size: 15px;
	}
</style>
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
                url: "<?php echo site_url('/Result_indicator/get_data');?>",
                data: {},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
                    $(data).each(function(seq, data ) {
                        return_data.push({
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
							"btn_save_result"	:	data.btn_save_result,
							"btn_confirm"		:	data.btn_confirm,
							"btn_opt"			:	data.btn_opt,
							"status_action"		:	data.status_action,
							"status_assessment"	:	data.status_assessment,
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
                {"data": "status_action"},
				{"data": "status_assessment"},
				{"data": "btn_save_result"},
				{"data": "btn_confirm"},
				{"data": "btn_opt"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.ind_id);
            }
        });//end DataTable
        $('.dataTables_filter input').attr('placeholder', 'ค้นหา');
    } //End fn get_data
	
	function get_data_save_result(dfine_id){
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Result_indicator/get_data_save_result'; ?>",
            data: {'dfine_id': dfine_id},
            dataType : "json",
            success : function(data){
				$("#modal_body_save_result").html(data);	
            }
        });
	} //End fn get_data_save_result
	
	function get_data_assessment(dfine_id){
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Result_indicator/get_data_assessment'; ?>",
            data: {'dfine_id': dfine_id},
            dataType : "json",
            success : function(data){
				$("#modal_body_modal_assessment").html(data);	
            }
        });
	} //End fn get_data_assessment
	
	function save_result(){
		var dfine_id = $("#hid_dfine_id").val();
		var arr_score = [];
		for(i=1;i<=4;i++){	
			arr_score.push($('#score_'+i).val());
		}
		var status_action = $('input:radio[name=status_action]:checked').val();
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Result_indicator/save_result'; ?>",
            data: {'arr_score': arr_score, 'dfine_id': dfine_id, 'status_action': status_action},
            dataType : "json",
            success : function(data){
				get_data();
				$('#modal_save_result').modal('toggle');
				notify_save("");				
            }
        });
	} //End fn save_result
	
	function save_assessment(){
		var dfine_id = $("#hid_assessment_dfine_id").val();
		var status_assessment = $('input:radio[name=status_assessment]:checked').val();
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Result_indicator/save_assessment'; ?>",
            data: {'status_assessment': status_assessment, 'dfine_id': dfine_id},
            dataType : "json",
            success : function(data){
				get_data();
				$('#modal_assessment').modal('toggle');	
				notify_save_assessment("");
            }
        });
	} //End fn save_assessment
	 
	function change_action(){
		var val_action = $('input:radio[name=status_action]:checked').val();
		var arr_score = [];
		for(i=1;i<=4;i++){	
			arr_score.push($('#score_'+i).val());
		}
		var count_not=0; //เช็คยังไม่ดำเนินการ
		var count_wait=1; //เช็คกำลังดำเนินการ
		var count_success=0; //เช็คเสร็จสิ้น
		for(i=0;i<arr_score.length;i++){
			if(arr_score[i] == ""){
				count_not++;
			}else{
				count_success++;
			}
			if(count_not==4){//เช็คยังไม่ดำเนินการ
				 count_wait = 0;
				$('#status_action_1').prop('checked', true);
				$('#status_action_1').removeAttr('disabled');
			}
			if(count_wait == 1){ //เช็คกำลังดำเนินการ
				$('#status_action_2').prop('checked', true);
				$('#status_action_1').attr('disabled','');
			}
			if(count_success==4){ //เช็คเสร็จสิ้น
				$('#status_action_3').prop('checked', true);
			}
		} //End for
	} //End fn change_action
</script>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">บันทึกผลงานตัวชี้วัด</h2>
            </div>
            
            <div class="box-body">
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
                        <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">ลำดับ</th>
                                    <th style="width: 8%; text-align: center;">ปีงบประมาณ</th>
                                    <th style="width: 25%; text-align: center;">ตัวชี้วัด</th>
                                    <th style="width: 12%; text-align: center;">สถานะการบันทึกผล</th>
									<th style="width: 5%; text-align: center;">ผลประเมิน</th>
                                    <th style="width: 10%; text-align: center;">บันทึกผลตัวชี้วัด</th>
									<th style="width: 10%; text-align: center;">ประเมินผล</th>
									<th style="width: 8%; text-align: center;">ดำเนินการ</th>
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

<!--Modal save result-->
<div class="modal fade" id="modal_save_result" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">บันทึกผลงานตัวชี้วัด</h3>
            </div>
            <div class="modal-body" id="modal_body_save_result">
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <input type="button" class="btn btn-success" onclick="save_result()" value="บันทึก">
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->

<!--Modal assessment-->
<div class="modal fade" id="modal_assessment" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">ประเมินผล</h3>
            </div>
            <div class="modal-body" id="modal_body_modal_assessment">
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <input type="button" class="btn btn-success" onclick="save_assessment()" value="บันทึก">
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->