<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
	$(document).ready( function () {
		get_table_indicator();
		$("#select2_bgy").select2();
		$("#select2_table_by_bgy").select2();
		$("#select2_by_type").select2();
		
		$('#toggle-event').change(function() {
			$('#console-event').html('Toggle: ' + $(this).prop('checked'));
		})
		get_summary_indicator();
		
		
    });
	
	function get_table_indicator(){
		var bgy_id = $("#select2_table_by_bgy").val();
		// console.log(bgy_id);
		
		$("#example").DataTable({
            bDestroy: true,
            processing: true,
            ajax: {
                type: "POST",
                url: "<?php echo site_url('/Dashborad/get_data_search');?>",
                data: {'bgy_id': bgy_id},
                dataSrc: function (data) {
					
					// get_summary_indicator(bgy_id);
                    var i = $(data).length; //check result row
                    var return_data = new Array();
					var score = 0;
                    $(data).each(function(seq, data ) {
                        return_data.push({
							"seq_queue_show"			:	'<center>'+i+'</center>',
							"dfine_id" 					:	data.dfine_id,
							"ind_name" 					:	'<a href="#">'+data.ind_name+'</a>',
							"ind_name" 					:	'<a>'+data.ind_name+'</a>',
							"bgy_name" 					:	'<center>'+data.bgy_name+'</center>',
							"indgp_name" 				:	'<center>'+data.indgp_name+'</center>',
							"dfine_goal"				: 	'<center>'+data.opt_symbol+' '+data.dfine_goal+' '+data.unt_name+'</center>',
							"dfine_status_assessment"	: 	data.dfine_status_assessment,
							"btn"						:	'<center><input id="toggle-event" type="checkbox"></center>',
                        });
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "ind_name"},
                {"data": "btn"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.dfine_id);
            }
        });//end DataTable
		$('.dataTables_filter input').attr('placeholder', 'ค้นหา');
        // $('.dataTables_filter input').remove();
        // var table = $("#example").dataTable();
	    // new $.fn.dataTable.FixedHeader(table);
		// $('#toggle-trigger').bootstrapToggle('on');
		$("#toggle-event").attr("data-toggle","toggle");
	}
	
	function get_summary_indicator(){
		var val_type = $('#select2_by_type').val();
		// alert("get_summary_indicator => "+val_type);
		var bgy_id = $('#select2_bgy').val();
		if(val_type == 1){
			get_chart_by_bgy(bgy_id);
		}else if(val_type == 2){
			get_chart_by_indgp(bgy_id);
		}
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_summary_indicator');?>",
			data: {'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				// console.log(data);
				var sum_ind = 0;
				$(data).each(function(seq, value) {
					sum_ind =  Number(value.ind_faile) +  Number(value.ind_not) +  Number(value.ind_pass);
					//ตัวชี้วัดทั้งหมด
					$('#head_sum_ind').html(sum_ind);
					$('#body_sum_ind').html("ตัวชี้วัดทั้งหมด ของปีงบประมาณ "+value.bgy_name);
					//ตัวชี้วัดที่ผ่าน
					$('#head_ind_pass').html(value.ind_pass);
					$('#body_ind_pass').html("ตัวชี้วัดที่ผ่าน ของปีงบประมาณ "+value.bgy_name);
					//ตัวชี้วัดที่ไม่ผ่าน
					$('#head_ind_faile').html(value.ind_faile);
					$('#body_ind_faile').html("ตัวชี้วัดที่ไม่ผ่าน ของปีงบประมาณ "+value.bgy_name);
					//ตัวชี้วัดที่ไม่ได้ดำเนินการ
					$('#head_ind_not').html(value.ind_not);
					$('#body_ind_not').html("ตัวชี้วัดไม่ได้ดำเนินการ ของปีงบประมาณ "+value.bgy_name);
				});
			}//End success
		});
	}
	
	function change_type(bgy_id){
		get_summary_indicator();
	}	
		
	function get_chart_by_bgy(bgy_id){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_by_bgy');?>",
			data: {'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				$('#chart').remove(); 
				$('#graph_container').append('<div id="chart" style="width:100%; height:400px;"></div>');
				var ind_not = [];
				var ind_pass = [];
				var ind_faile= [];
				var bgy_id= [];
				var bgy_name;
				var resm_name;
				
				var str_name = [];
				// var count = $(data).length; //check result row
				// console.log(data);
				
				$(data).each(function(seq, value) {
					ind_not.push(Number(value.ind_not));
					ind_pass.push(Number(value.ind_pass));
					ind_faile.push(Number(value.ind_faile));
					// bgy_id.push(value.bgy_id);
					bgy_name = value.bgy_name;
					// resm_name = value.resm_name;
					str_name.push(value.str_name);
				});
				
				// console.log("bgy_name - "+bgy_name);
				
				
				Highcharts.chart('chart', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'สรุปผลการประเมินตัวชี้วัดจำแนกตามยุทธศาสตร์ ปีงบประมาณ '+bgy_name
					},
					subtitle: {
						text: resm_name,
						style: {
							fontSize: '16px'
						}
					},
					xAxis: {
						categories: str_name,
						title: {
							text: 'ยุทธศาสตร์',
							style: {
								fontSize: '16px'
							}
						},
					},
					yAxis: {
						min: 0,
						title: {
							text: 'จำนวนตัวชี้วัด',
							style: {
								fontSize: '16px'
							}
						},
						stackLabels: {
							enabled: true,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
					legend: {
						align: 'right',
						x: -30,
						verticalAlign: 'top',
						y: 25,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						headerFormat: '<b>{point.x}</b><br/>',
						pointFormat: '{series.name}: {point.y}<br/>ตัวชี้วัดทั้งหมด: {point.stackTotal}'
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: true,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
					series: [{
						name: 'ไม่ได้ประเมินผล',
						data: ind_not,
						color: '#ffc266',
					}, 
					{
						name: 'ไม่ผ่าน',
						data: ind_faile,
						color: '#ED561B',
					}, 
					{
						name: 'ผ่าน',
						data: ind_pass,
						color: '#50B432',
					}]
				});
			}//End success
		});
	}
	
	function get_chart_by_indgp(bgy_id){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_by_indgp');?>",
			data: {'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				$('#chart').remove(); 
				$('#graph_container').append('<div id="chart" style="width:100%; height:400px;"></div>');
				var ind_not = [];
				var ind_pass = [];
				var ind_faile= [];
				var bgy_id= [];
				var bgy_name;
				var resm_name;
				
				var indgp_name = [];
				// var count = $(data).length; //check result row
				// console.log(data);
				
				$(data).each(function(seq, value) {
					ind_not.push(Number(value.ind_not));
					ind_pass.push(Number(value.ind_pass));
					ind_faile.push(Number(value.ind_faile));
					// bgy_id.push(value.bgy_id);
					bgy_name = value.bgy_name;
					// resm_name = value.resm_name;
					indgp_name.push(value.indgp_name);
				});
				
				// console.log("bgy_name - "+bgy_name);
				
				
				Highcharts.chart('chart', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'สรุปผลการประเมินตัวชี้วัดจำแนกตามกลุ่มตัวชี้วัด ปีงบประมาณ '+bgy_name
					},
					subtitle: {
						text: resm_name,
						style: {
							fontSize: '16px'
						}
					},
					xAxis: {
						categories: indgp_name,
						title: {
							text: 'ยุทธศาสตร์',
							style: {
								fontSize: '16px'
							}
						},
					},
					yAxis: {
						min: 0,
						title: {
							text: 'จำนวนตัวชี้วัด',
							style: {
								fontSize: '16px'
							}
						},
						stackLabels: {
							enabled: true,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
					legend: {
						align: 'right',
						x: -30,
						verticalAlign: 'top',
						y: 25,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						headerFormat: '<b>{point.x}</b><br/>',
						pointFormat: '{series.name}: {point.y}<br/>ตัวชี้วัดทั้งหมด: {point.stackTotal}'
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: true,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
					series: [{
						name: 'ไม่ได้ประเมินผล',
						data: ind_not,
						color: '#ffc266',
					}, 
					{
						name: 'ไม่ผ่าน',
						data: ind_faile,
						color: '#ED561B',
					}, 
					{
						name: 'ผ่าน',
						data: ind_pass,
						color: '#50B432',
					}]
				});
			}//End success
		});
	}
	
	function get_ind_info(status_ind){
		var bgy_id = $('#select2_bgy').val();
		// alert(bgy_id);
		// alert(status_ind);
		//3 คือ ตัวชี้วัดทั้งหมด
		//2 คือ ตัวชี้วัดที่ผ่าน
		//1 คือ ตัวชี้วัดที่ไม่ผ่าน
		//0 คือ ตัวชี้วัดที่ไม่ได้ดำเนินการ
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_ind_info');?>",
			data: {'status_ind': status_ind,'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				console.log(data);
				// var sum_ind = 0;
				$(data).each(function(seq, value) {
					// sum_ind =  Number(value.ind_faile) +  Number(value.ind_not) +  Number(value.ind_pass);
					// ตัวชี้วัดทั้งหมด
					// $('#head_sum_ind').html(sum_ind);
					// $('#body_sum_ind').html("ตัวชี้วัดทั้งหมด ของปีงบประมาณ "+value.bgy_name);
				});
			}//End success
		});
	}

</script>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="box" id="">
					<div class="box-header with-border" id="head_table">
						<div class="col-md-3">
							<i class="fa fa-bar-chart-o fw" style="color: #ffffff"></i> 
							<h2 class="box-title" style="margin-top:5px">ข้อมูลตัวชี้วัดจำแนกตามปีงบประมาณ</h2>
						</div>	
						<div class="col-md-2 select2-container-active">
							<select class="select2" id="select2_bgy" name="select2_bgy" style="width: 100%;" tabindex="-1" onchange="get_summary_indicator()" >
								<?php foreach($rs_bgy->result() as $bgy){?>
									<option id="bgy" class="select2_wb" value="<?php echo $bgy->bgy_id;?>" ><?php echo $bgy->bgy_name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="box-body" id="body">
						<div class="row">
							<div class="col-lg-6 col-xs-4">
							   <!-- small box -->
								<div class="small-box" id="small-box">
									<div class="inner">
										<h3 id="head_sum_ind" ></h3>
										<p id="body_sum_ind" ></p>
									</div>
									<div class="icon" style="color: #0099ff">
										<i class="fa fa-fw fa-archive"></i>
									</div>
									<a href="#" class="small-box-footer" id="footer_info" data-toggle="modal" data-target="#modal_info_indicator" onclick="get_ind_info(3)" >ดูรายละเอียด   &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-xs-4">
							   <!-- small box -->
								<div class="small-box" id="small-box">
									<div class="inner">
										<h3 id="head_ind_pass"></h3>
										<p id="body_ind_pass"></p>
									</div>
									<div class="icon" style="color: #50B432">
										<i class="fa fa-fw fa-check-circle"></i>
									</div>
									<a href="#" class="small-box-footer" id="footer_info" data-toggle="modal" data-target="#modal_info_indicator" onclick="get_ind_info(2)">ดูรายละเอียด   &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
		
						<div class="row">
							<div class="col-lg-6 col-xs-4">
							   <!-- small box -->
								<div class="small-box" id="small-box">
									<div class="inner">
										<h3 id="head_ind_faile"></h3>
										<p id="body_ind_faile"></p>
									</div>
									<div class="icon" style="color: #ED561B">
										<i class="fa fa-fw fa-times-circle"></i>
									</div>
									<a href="#" class="small-box-footer" id="footer_info" data-toggle="modal" data-target="#modal_info_indicator" onclick="get_ind_info(1)">ดูรายละเอียด   &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-xs-4">
							   <!-- small box -->
								<div class="small-box" id="small-box">
									<div class="inner">
										<h3 id="head_ind_not"></h3>
										<p id="body_ind_not"></p>
									</div>
									<div class="icon" style="color: #ffc266">
										<i class="fa fa-fw fa-ban"></i>
									</div>
									<a href="#" class="small-box-footer" id="footer_info" data-toggle="modal" data-target="#modal_info_indicator" onclick="get_ind_info(0)">ดูรายละเอียด   &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="box">
									<div class="box-header with-border" id="head_table">
										<div class="col-md-3">
											<h2 class="box-title" style="margin-top:5px">รายงานสรุปตัวชี้วัดจำแนกตาม</h2>
										</div>	
										<div class="col-md-2 select2-container-active pull-left">
											<select class="select2" id="select2_by_type" name="select2_by_type" style="width: 100%;" tabindex="-1" onchange="change_type()" >
												<option id="type" class="select2_wb" value="1" >ยุทธศาสตร์</option>
												<option id="type" class="select2_wb" value="2" >กลุ่มตัวชี้วัด</option>
											</select>
										</div>
									</div>
									<div class="box-body" id="">
										<div class="col-md-12" id="graph_container" >
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>







<div class="row">
	<div class="col-md-12">
		<div class="box" id="">
			<div class="box-header with-border" id="head_table">
				<div class="col-md-6">
					<i class="glyphicon glyphicon-list-alt" style="color: #ffffff"></i>
					<h3 class="box-title" style="margin-top:5px" > ข้อมูลตัวชี้วัดจำแนกตามตัวชี้วัด</h3>
				</div>	
			</div>
			<div class="box-body" id="">
				<div class="col-md-5">
					<div class="box" id="box_table_indicator">
						<div class="box-header with-border" id="head_table">
							<div class="col-md-6">
								<h3 class="box-title" style="margin-top:5px">ตัวชี้วัดของปีงบประมาณ</h3>
							</div>	
							<div class="col-md-6 select2-container-active">
								<select class="select2" id="select2_table_by_bgy" name="select2_table_by_bgy" style="width: 100%;" tabindex="-1" onchange="get_table_indicator()" >
									<?php foreach($rs_bgy->result() as $bgy){?>
										<option id="bgy" class="select2_wb" value="<?php echo $bgy->bgy_id;?>" ><?php echo $bgy->bgy_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style=" vertical-align: middle">ลำดับ</th>
										<th style="width: 60%; vertical-align: middle">ตัวชี้วัด</th>
										<th style=" vertical-align: middle">ติดตาม</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot></tfoot>
							</table>
						</div>
						<!-- /.box-body -->
						<div class="box-footer clearfix">
						</div>
					</div>
				</div>
	
				<div class="col-md-7">
					<div class="row">
						<div class="col-lg-12 col-xs-12">
							<div class="box" id="">
								<div class="box-header with-border" id="">
									<div class="col-md-12">
										<h3 ><i class="fa fa-bar-chart-o fw"></i> สรุปผลตัวชี้วัดของปีงบประมาณ </h3>
									</div>
									
							
								
								
								</div>
							</div>
						</div>
					</div>
				</div>
	
			</div>
		</div>
	</div>	
</div>


<!--Modal info_indicator-->
<div class="modal fade" id="modal_info_indicator" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title" style="color: #ffffff" >เพิ่มตัวชี้วัด</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group"> <!-- Start form-group -->
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ชื่อตัวชี้วัด<span class="text-danger">*</span></label>
							<div class="col-md-10" id=""> <!-- Start col-md-9 -->
								<!--<input type="text" class="form-control" value="" name="ind_add" id="ind_add" validate>-->
								 <textarea name="ind_add" id="ind_add" class="form-control" rows="2" cols="50" validate></textarea>
							</div>
						</div>
					</div><label></label>
					<div class="form-group">
						<div class = "col-md-12">
							<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">คำอธิบาย<span></span></label>
							<div class="col-md-10" id=""> <!-- Start col-md-9 -->
								<!-- <input type="text" class="form-control" value="" name="desc_add" id="desc_add"  validate> -->
								<textarea name="desc_add" id="desc_add" class="form-control" rows="4" cols="50" ></textarea>
							</div>
						</div> <!-- End col-md-12 -->
					</div> <!-- End form-group -->
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">ปิด</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <!-- <button type="submit" class="btn btn-success" onclick="save_indicator()" >บันทึก</button> -->
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->






<style>
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }


	#box_table_indicator {
   		max-height: calc(100vh - 212px);
 		overflow-y: auto;
		border-color: #536872;
	}
	
	
	#small-box {
		background-color: #ffffff;
	}
	h3{
		color: black;
	}
	p{
		color: black;
	}
	#footer_info{
		color: black;
	}
	
	#body{
		background-color: #e6f7ff;
	}
	#head_table{
		background-color: #536872;
		// border-color: #e6f7ff;
	}
	.box-title{
		color: #ffffff;
	}
</style>



