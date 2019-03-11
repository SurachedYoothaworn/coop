<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
	$(document).ready( function () {
        $("#select2_bgy").select2();
		$("#select2_indicator_group").select2();
		$("#select2_ps").select2();
		$("#select2_graph_bgy").select2();
		search_data();
    });

	function search_data(){
		var bgy_id = $("#select2_bgy").val();
		var indgp_id = $("#select2_indicator_group").val();
		var resm_id = $("#select2_ps").val();
		get_data_select(bgy_id,indgp_id,resm_id); //เรียก chart
		
		$("#bgy_id_excel").val(bgy_id);
		$("#indgp_id_excel").val(indgp_id);
		$("#resm_id_excel").val(resm_id);
		
		$("#example").DataTable({
            bDestroy: true,
            processing: true,
            ajax: {
                type: "POST",
                url: "<?php echo site_url('/Report_indicator/get_data_search');?>",
                data: {'bgy_id': bgy_id, 'indgp_id': indgp_id, 'resm_id': resm_id},
                dataSrc: function (data) {
                    var i = $(data).length; //check result row
                    var return_data = new Array();
					var score = 0;
                    $(data).each(function(seq, data ) {
                        return_data.push({
							"seq_queue_show"			:	'<center>'+i+'</center>',
							"dfine_id" 					:	data.dfine_id,
							"ind_name" 					:	data.ind_name,
							"bgy_name" 					:	'<center>'+data.bgy_name+'</center>',
							"indgp_name" 				:	'<center>'+data.indgp_name+'</center>',
							"dfine_goal"				: 	'<center>'+data.opt_symbol+' '+data.dfine_goal+' '+data.unt_name+'</center>',
							"dfine_status_assessment"	: 	data.dfine_status_assessment,
							"rs_score0"					:	'<center>'+data.rs_score[0]+'</center>',
							"rs_score1"					:	'<center>'+data.rs_score[1]+'</center>',
							"rs_score2"					:	'<center>'+data.rs_score[2]+'</center>',
							"rs_score3"					:	'<center>'+data.rs_score[3]+'</center>',
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
                {"data": "indgp_name"},
				{"data": "dfine_goal"},
				{"data": "dfine_status_assessment"},
				{"data": "rs_score0"},
				{"data": "rs_score1"},
				{"data": "rs_score2"},
				{"data": "rs_score3"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.dfine_id);
            }
        });//end DataTable
        $('.dataTables_filter input').remove();
	}
	
	function clear_data(){
		var ps_id = '<?php echo $this->session->userdata('us_ps_id');?>';
		if(<?php echo $this->session->userdata('us_permission');?> == <?php echo $this->config->item("ref_ug_admin");?>){
			$("#select2_bgy").val(0).trigger('change');
			$("#select2_indicator_group").val(0).trigger('change');
			$("#select2_ps").val(0).trigger('change');
		}else if(<?php echo $this->session->userdata('us_permission');?> == <?php echo $this->config->item("ref_ug_main_side");?>){
			$("#select2_bgy").val(0).trigger('change');
			$("#select2_indicator_group").val(0).trigger('change');
			$("#select2_ps").val(ps_id).trigger('change');
		}
		search_data();	
	} //End fn clear_data
	
	function get_data_select(bgy_id,indgp_id,resm_id){
		if(bgy_id == 0){
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Report_indicator/get_all_graph');?>",
				data: {'bgy_id': bgy_id,'indgp_id': indgp_id,'resm_id': resm_id},
				dataType : "json",
				success : function(data){
					get_chart(data);
				}//End success
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Report_indicator/get_graph');?>",
				data: {'bgy_id': bgy_id,'indgp_id': indgp_id,'resm_id': resm_id},
				dataType : "json",
				success : function(data){
					get_doughnut_chart(data);
				}//End success
			});
		}
	} //End fn get_data_select
	
	function get_chart(data){
		$('#chart').remove(); 
		$('#graph_container').append('<div id="chart" style="width:100%; height:400px;"></div>');
		var ind_not = [];
		var ind_pass = [];
		var ind_faile= [];
		var bgy_id= [];
		var bgy_name= [];
		var resm_name;
		var count = $(data).length; //check result row
		
        $(data).each(function(seq, value) {
			ind_not.push(Number(value.ind_not));
			ind_pass.push(Number(value.ind_pass));
			ind_faile.push(Number(value.ind_faile));
			bgy_id.push(value.bgy_id);
			bgy_name.push(value.bgy_name);
			resm_name = value.resm_name;
        });
		
		var sum_ind_pass = 0;
		var sum_ind_faile = 0;
		var sum_ind_not = 0;
		var count_sum_ind = 0;
		$(data).each(function(seq, value) {
			sum_ind_pass  += Number(value.ind_pass);
			sum_ind_faile += Number(value.ind_faile);
			sum_ind_not += Number(value.ind_not);
		});
		count_sum_ind = sum_ind_pass + sum_ind_faile + sum_ind_not;
		$('#sum_ind').text(count_sum_ind);
		$('#ind_pass').text(sum_ind_pass);
		$('#ind_faile').text(sum_ind_faile);
		$('#ind_not').text(sum_ind_not);
		
		var percent_sum = 100;
		var percent_pass;
		var percent_faile;
		var percent_not;
		$('#percent_sum').text(percent_sum+" %");
		percent_pass = (sum_ind_pass / count_sum_ind) * percent_sum;
		percent_faile = (sum_ind_faile / count_sum_ind) * percent_sum;
		percent_not = (sum_ind_not / count_sum_ind) * percent_sum;
		if(count_sum_ind == 0){
			$('#percent_pass').text(0+" %");
			$('#percent_faile').text(0+" %");
			$('#percent_not').text(0+" %");
		}else{
			$('#percent_pass').text(percent_pass.toFixed(2)+" %");
			$('#percent_faile').text(percent_faile.toFixed(2)+" %");
			$('#percent_not').text(percent_not.toFixed(2)+" %");
		}
		
		if(count_sum_ind != 0){
			$('#graph_container').show();
			$('#no_data').hide();
			
			Highcharts.chart('chart', {
				chart: {
					type: 'column'
				},
				title: {
					text: 'รายงานสรุปผลการประเมินตัวชี้วัด'
				},
				subtitle: {
					text: resm_name,
					style: {
						fontSize: '16px'
					}
				},
				xAxis: {
					categories: bgy_name,
					title: {
						text: 'ปีงบประมาณ',
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
		}else{
			$('#graph_container').hide();
			$('#no_data').show();
		}
	} //End fn get_chart
	
	function get_doughnut_chart(data){
		
		$('#chart').remove(); 
		$('#graph_container').append('<div id="chart" style="width:100%; height:400px;"></div>');
		var ind_not = [];
		var ind_pass = [];
		var ind_faile= [];
		var bgy_id= [];
		var bgy_name= [];
		var resm_name;
		var count = $(data).length; //check result row
		
		var arr_pass = [];
		var arr_faile = [];
		var arr_not = [];
		
        $(data).each(function(seq, value) {
			ind_not.push(value.ind_not);
			ind_pass.push(value.ind_pass);
			ind_faile.push(value.ind_faile);
			bgy_id.push(value.bgy_id);
			bgy_name.push(value.bgy_name);
			arr_pass.push('ผ่าน',Number(value.ind_pass));
			arr_faile.push( 'ไม่ผ่าน',Number(value.ind_faile));
			arr_not.push('ไม่ได้ดำเนินการ',Number(value.ind_not));
			resm_name = value.resm_name;
		});
		
		var count_sum_ind;
		count_sum_ind = Number(ind_not)+Number(ind_pass)+Number(ind_faile);
		$('#sum_ind').text(count_sum_ind);
		$('#ind_pass').text(ind_pass);
		$('#ind_faile').text(ind_faile);
		$('#ind_not').text(ind_not);
		
		var percent_sum = 100;
		var percent_pass;
		var percent_faile;
		var percent_not;
		$('#percent_sum').text(percent_sum+" %");
		percent_pass = (Number(ind_pass) / Number(count_sum_ind))*percent_sum;
		percent_faile = (Number(ind_faile) / Number(count_sum_ind))*percent_sum;
		percent_not = (Number(ind_not) / Number(count_sum_ind))*percent_sum;
		if(count_sum_ind == 0){
			$('#percent_pass').text(0+" %");
			$('#percent_faile').text(0+" %");
			$('#percent_not').text(0+" %");
		}else{
			$('#percent_pass').text(percent_pass.toFixed(2)+" %");
			$('#percent_faile').text(percent_faile.toFixed(2)+" %");
			$('#percent_not').text(percent_not.toFixed(2)+" %");
		}
		
		if(count_sum_ind != 0){
			$('#graph_container').show();
			$('#no_data').hide();
			
			Highcharts.setOptions({
				colors: ['#50B432', '#ED561B', '#ffc266']
			});
			
			Highcharts.chart('chart', {
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45
					}
				},
				title: {
					text: 'รายงานสรุปผลการประเมินตัวชี้วัดปีงบประมาณ '+bgy_name,
				},
				subtitle: {
					text: resm_name,
					style: {
						fontSize: '16px'
					}
				},
				plotOptions: {
					pie: {
						innerSize: 100,
						depth: 45,
						dataLabels: {
							enabled: true,
							format: '<b>{point.name} </b>: {point.percentage:.2f} %'
						}
					}
				},
				series: [{
					name: 'จำนวนตัวชี้วัด',
					data: [
						arr_pass,
						arr_faile,
						arr_not
					]
				}]
			});
		}else{
			$('#graph_container').hide();
			$('#no_data').show();
		}
	} //End fn get_doughnut_chart
	
	// function print(){
		// window.print();
		// setTimeout(function(){ history.back() }, 100);
	// }
</script>


<div class="row">
    <div class="col-md-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="glyphicon glyphicon-list-alt"></i>
                <h2 class="box-title">รายงานผลการประเมินตัวชี้วัด</h2>
            </div>
            <div class="box-body" >
				<div class="col-md-3"></div>
				<div class="row">
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header">
								<i class="glyphicon glyphicon-search"></i>
								<h2 class="box-title">ค้นหา</h2>
							</div>
							<div class="box-body" >
								<div class="col-md-12"><!-- Start  col-md-12 -->
										<div class="form-group"> <!-- Start form-group -->
											<div class = "col-md-12" id="div_ind">
												<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ</label>
												<div class="col-md-10 select2-container-active">
													<select class="select2" id="select2_bgy" name="select2_bgy" style="width: 100%;" tabindex="-1" validate>
														<option id="bgy" class="select2_wb" value="0" >ทั้งหมด</option>
														<?php foreach($rs_bgy->result() as $bgy){?>
															<option id="bgy" class="select2_wb" value="<?php echo $bgy->bgy_id;?>" ><?php echo $bgy->bgy_name;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div> 
										<div class="form-group"> <!-- Start form-group -->
											<div class = "col-md-12" id="div_ind">
												<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">กลุ่มตัวชี้วัด</label>
												<div class="col-md-10 select2-container-active">
													<select class="select2" id="select2_indicator_group" name="select2_indicator_group" style="width: 100%;" tabindex="-1" validate>
														<option id="indgp" class="select2_wb" value="0" >ทั้งหมด</option>
														<?php foreach($rs_indgp->result() as $indgp){?>
															<option id="indgp" class="select2_wb" value="<?php echo $indgp->indgp_id;?>" ><?php echo $indgp->indgp_name;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										
										<?php if($this->session->userdata('us_permission') == $this->config->item("ref_ug_admin")){?>
											<div class="form-group"> <!-- Start form-group -->
												<div class = "col-md-12" id="div_ind">
													<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ผู้รับผิดชอบ</label>
													<div class="col-md-10 select2-container-active">
														<select class="select2" id="select2_ps" name="select2_ps" style="width: 100%;" tabindex="-1" validate>
															<option id="rs_ps" class="select2_wb" value="0" >ทั้งหมด</option>
															<?php foreach($rs_person as $rs_ps){?>
																<option id="rs_ps" class="select2_wb" value="<?php echo $rs_ps['ps_id'];?>" ><?php echo $rs_ps['pf_title_th'];?><?php echo $rs_ps['ps_fname_th'];?> <?php echo $rs_ps['ps_lname_th'];?></option>
															<?php } ?>
														</select>
													</div>
													
												</div>
											</div>
										<?php }else if($this->session->userdata('us_permission') == $this->config->item("ref_ug_main_side")){ ?>
											<div class="form-group"> <!-- Start form-group -->
												<div class = "col-md-12" id="div_ind">
													<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ผู้รับผิดชอบ</label>
													<div class="col-md-10 select2-container-active">
														<select class="select2" id="select2_ps" name="select2_ps" style="width: 100%;" tabindex="-1" validate>
															<?php foreach($rs_person as $rs_ps){?>
																<option id="rs_ps" class="select2_wb" value="<?php echo $rs_ps['ps_id'];?>" ><?php echo $rs_ps['pf_title_th'];?><?php echo $rs_ps['ps_fname_th'];?> <?php echo $rs_ps['ps_lname_th'];?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										<?php } ?>
								</div><!-- End  col-md-12 -->
							</div>
							<div class="box-footer clearfix">
								<a type="button" class="btn btn-default pull-left" onclick="clear_data()">เครียร์</a>
								<a class="btn btn-primary pull-right" onclick="search_data();">ค้นหา</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<i class="glyphicon glyphicon-stats"></i>
								<h2 class="box-title">กราฟสรุปผลการประเมินตัวชี้วัด</h2>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" >
								<div class="col-md-12"><!-- Start  col-md-12 -->
									<div class="box box-solid" id="body_graph">
										<div class="col-md-12" id="graph_container" >
											
										</div>
										<center><h3 id="no_data" style="color: red;" >ไม่มีข้อมูลที่ค้นหา...ไม่สามารถแสดงกราฟได้<h3></center>
									</div>
									
									<div class="box-footer" id="footer_sum">
										<div class="row">
											<div class="col-sm-3 col-xs-6">
												<div class="description-block border-right">
													<span class="description-percentage text-green" id="percent_sum"><i class="fa fa-caret-up"></i></span>
													<h5 class="description-header" id="sum_ind" ></h5>
													<span class="description-text">จำนวนตัวชี้วัดทั้งหมด</span>
												</div>
											  <!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-xs-6">
												<div class="description-block border-right">
													<span class="description-percentage text-green" id="percent_pass"><i class="fa fa-caret-left"></i></span>
													<h5 class="description-header" id="ind_pass" ></h5>
													<span class="description-text">ตัวชี้วัดที่ผ่าน</span>
												</div>
											  <!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-xs-6">
												<div class="description-block border-right" >
													<span class="description-percentage text-red" id="percent_faile" ><i class="fa fa-caret-up"></i></span>
													<h5 class="description-header" id="ind_faile"></h5>
													<span class="description-text">ตัวชี้วัดที่ไม่ผ่าน</span>
												</div>
											  <!-- /.description-block -->
											</div>
											<!-- /.col -->
											<div class="col-sm-3 col-xs-6">
												<div class="description-block">
													<span class="description-percentage text-yellow" id="percent_not" ><i class="fa fa-caret-down"></i></span>
													<h5 class="description-header" id="ind_not" ></h5>
													<span class="description-text">ตัวชี้วัดที่ไม่ได้ดำเนินการ</span>
												</div>
											  <!-- /.description-block -->
											</div>
										</div>
									  <!-- /.row -->
									</div>
									
								</div><!-- End  col-md-12 -->
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="box box-primary color">
							<div class="box-header color">
								<i class="fa fa-fw fa-table"></i>
								<h2 class="box-title" style="margin-top:15px">ตารางรายงานผลงานตัวชี้วัด</h2>
								<div class="pull-right">
									<form action="<?php echo site_url('/Report_indicator/export_excel/');?>" method="POST" target="_blank">
										<button type="submit" class="margin <?php echo $this->config->item('btn_success');?>"><i class="fa fa-fw fa-file-excel-o" style="color:white"></i>&nbsp;ส่งออก Excel</button>
										<input type="hidden" name="bgy_id_excel" id="bgy_id_excel" value="">
										<input type="hidden" name="indgp_id_excel" id="indgp_id_excel" value="">
										<input type="hidden" name="resm_id_excel" id="resm_id_excel" value="">
									</form>
								</div>
								<!--<div class="pull-right">
									<a onclick="print();" type="button" class="margin <?php echo $this->config->item('btn_success');?>"><i class="fa fa-fw fa-print" style="color:white"></i>&nbsp;Print</a>
								</div>-->
							</div>
						   
							<div class="box-body">
								<br>
								<div class="col-md-12"><!-- Start  col-md-12 -->
									<div class="box box-solid">
										<table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
										   <thead>
												<tr>
													<th rowspan="2" style=" vertical-align: middle">ลำดับ</th>
													<th rowspan="2" style=" vertical-align: middle">ปีงบประมาณ</th>
													<th rowspan="2" style=" width: 35%; vertical-align: middle">ตัวชี้วัด</th>
													<th rowspan="2" style=" vertical-align: middle">กลุ่มตัวชี้วัด</th>
													<th rowspan="2" style=" vertical-align: middle">เป้าหมาย</th>
													<th rowspan="2" style=" vertical-align: middle">ผลประเมิน</th>
													<th colspan="4" >ผลประเมินแบ่งตามไตรมาส</th>
												</tr>
												<tr>
													<th>1<br>(ต.ค. - <br>ธ.ค.)</th>
													<th>2<br>(ม.ค. - <br>มี.ค.)</th>
													<th>3<br>(เม.ย. - <br>มิ.ย.)</th>
													<th>4<br>(ก.ค. - <br>ก.ย.)</th>
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
			</div>
        </div>
    </div>
</div>

<style>
.box-header.color{
	background: #2b6688;
	color: #ffffff;
}

.box.box-primary.color{
	border: 1px solid #2b6688;
}
</style>
