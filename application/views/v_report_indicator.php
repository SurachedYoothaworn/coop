<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<script>
	$(document).ready( function () {
        $("#select2_bgy").select2();
		$("#select2_indicator_group").select2();
		$("#select2_ps").select2();
		$("#select2_graph_bgy").select2();
		search_data();
		// get_data_select(0,0,0);
    });
	
	// function search_all_data(){
		// var bgy_id = $("#select2_bgy").val();
		// var indgp_id = $("#select2_indicator_group").val();
		// var resm_id = $("#select2_ps").val();
		
		// $("#example").DataTable({
            // bDestroy: true,
            // processing: true,
            // ajax: {
                // type: "POST",
                // url: "<?php echo site_url('/Report_indicator/get_all_data_search');?>",
                // data: {},
                // dataSrc: function (data) {
                    // var i = $(data).length; //check result row
                    // var return_data = new Array();
                    // $(data).each(function(seq, data ) {
                        // return_data.push({
							// "seq_queue_show"			:	'<center>'+i+'</center>',
							// "dfine_id" 					:	data.dfine_id,
							// "ind_name" 					:	data.ind_name,
							// "bgy_name" 					:	'<center>'+data.bgy_name+'</center>',
							// "indgp_name" 				:	'<center>'+data.indgp_name+'</center>',
							// "dfine_goal"				: 	'<center>'+data.opt_symbol+' '+data.dfine_goal+' '+data.unt_name+'</center>',
							// "dfine_status_assessment"	: 	data.dfine_status_assessment,
							// "rs_score0"					:	'<center>'+data.rs_score[0]+'</center>',
							// "rs_score1"					:	'<center>'+data.rs_score[1]+'</center>',
							// "rs_score2"					:	'<center>'+data.rs_score[2]+'</center>',
							// "rs_score3"					:	'<center>'+data.rs_score[3]+'</center>',
                        // });
                        // i--;
                    // });//end project for
                    // return return_data;
                // }//end dataSrc
            // }, //end ajax
            // "columns"    : [
                // {"data": "seq_queue_show"},
                // {"data": "bgy_name"},
                // {"data": "ind_name"},
                // {"data": "indgp_name"},
				// {"data": "dfine_goal"},
				// {"data": "dfine_status_assessment"},
				// {"data": "rs_score0"},
				// {"data": "rs_score1"},
				// {"data": "rs_score2"},
				// {"data": "rs_score3"},
            // ],
            // "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            // "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                // nRow.setAttribute("id","tr_"+aData.dfine_id);
            // }
        // });//end DataTable
        // $('.dataTables_filter input').remove();
	// } //End fn search_all_data
	
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
        // var table = $("#example").dataTable();
	    // new $.fn.dataTable.FixedHeader(table);
	
	}
	
	function clear_data(){
		$("#select2_bgy").val(0).trigger('change');
		$("#select2_indicator_group").val(0).trigger('change');
		$("#select2_ps").val(0).trigger('change');
		search_data();	
	} //End fn clear_data
	
	function get_data_select(bgy_id,indgp_id,resm_id){
		// var bgy_id = $("#select2_graph_bgy").val();
		// alert(indgp_id);
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
					// get_chart(data);
					get_doughnut_chart(data);
				}//End success
			});
		}
	} //End fn get_data_select
	
	function get_chart(data){
		$('#chart').remove(); 
		$('#graph_container').append('<canvas id="chart" width="" height="120"><canvas>');
		var ind_not = [];
		var ind_pass = [];
		var ind_faile= [];
		var bgy_id= [];
		var bgy_name= [];
		var count = $(data).length; //check result row
		
		// for(var i in data) {
			// ind_pass.push(data[i].ind_pass);
			// ind_faile.push(data[i].ind_faile);
			// bgy_id.push(data[i].bgy_id);
			// bgy_name.push(data[i].bgy_name);
		// }
		
        $(data).each(function(seq, value) {
			ind_not.push(value.ind_not);
			ind_pass.push(value.ind_pass);
			ind_faile.push(value.ind_faile);
			bgy_id.push(value.bgy_id);
			bgy_name.push(value.bgy_name);
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
		percent_not= (sum_ind_not / count_sum_ind) * percent_sum;
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
			var ctx = document.getElementById('chart');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: bgy_name,
					datasets: [
						{
							label: 'ไม่ผ่าน',
							data: ind_faile,
							backgroundColor: '#ff8080'
						},
						{
							label: 'ผ่าน',
							data: ind_pass,
							backgroundColor: '#99ff99'
						},
						{
							label: 'ไม่ได้ประเมินผล',
							data: ind_not,
							backgroundColor: '#ffc266'
						},
					]},
				options: {
					scales: {
						yAxes: [{ 
							stacked: true,
							scaleLabel: {
								display: true,
								labelString: 'จำนวนตัวชี้วัด',
								fontSize: 16
							}
						}],
						xAxes: [{ 
							stacked: true,
							scaleLabel: {
								display: true,
								labelString: 'ปีงบประมาณ',
								fontSize: 16
							},
							barPercentage: 0.2
						}]
					},
					title: {
						display: true,
						text: 'รายงานสรุปผลการประเมินตัวชี้วัด',
						fontSize: 20
					},
					hover: {
						mode: 'nearest',
					},
				}//End option
			});
		}else{
			$('#graph_container').hide();
			$('#no_data').show();
			// $('#footer_sum').hide();
		}
	} //End fn get_chart
	
	function get_doughnut_chart(data){
		$('#chart').remove(); 
		$('#graph_container').append('<canvas id="chart" width="" height="120"><canvas>');
		var ind_not = [];
		var ind_pass = [];
		var ind_faile= [];
		var bgy_id= [];
		var bgy_name= [];
		var count = $(data).length; //check result row
		
		var result = [];
		
        $(data).each(function(seq, value) {
			ind_not.push(value.ind_not);
			ind_pass.push(value.ind_pass);
			ind_faile.push(value.ind_faile);
			bgy_id.push(value.bgy_id);
			bgy_name.push(value.bgy_name);
			result.push(value.ind_not, value.ind_pass, value.ind_faile);
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
			var ctx = document.getElementById('chart');
			var myChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: ['ไม่ได้ประเมินผล','ผ่าน','ไม่ผ่าน'],
					datasets: [
						{
						  label: "",
						  backgroundColor: ["#ffc266", "#99ff99","#ff8080"],
						  data: result
						}
					]},
				options: {
				  title: {
					display: true,
					text: 'รายงานสรุปผลการประเมินตัวชี้วัดปีงบประมาณ '+bgy_name,
					fontSize: 20
				  }
				}
			});
		}else{
			$('#graph_container').hide();
			$('#no_data').show();
		}
	} //End fn get_doughnut_chart
	
	// function export_excel(){
		// var bgy_id = $("#select2_bgy").val();
		// var indgp_id = $("#select2_indicator_group").val();
		// var resm_id = $("#select2_ps").val();
		// console.log(bgy_id);
		// console.log(indgp_id);
		// console.log(resm_id);
		// var url = '<?php echo site_url('/Report_indicator/export_excel/');?>'+bgy_id+'/'+indgp_id+'/'+resm_id+'';
		
		// $.ajax({
			// type: "POST",
			// url: "<?php echo site_url('/Report_indicator/export_excel');?>",
			// data: {'bgy_id':bgy_id,'indgp_id':indgp_id,'resm_id':resm_id},
			// dataType : "json",
			// success : function(data){
				// alert("export");
				// window.open(url, '_blank');
				// window.location.href = '<?php echo site_url('/Report_indicator/export_excel');?>';
			// }//End success
		// });
		
		// var url = '<?php echo site_url('/Report_indicator/export_excel2');?>';
		// $.post(url,{"bgy_id" : bgy_id, "indgp_id" : indgp_id, "resm_id" : resm_id},function(data){
			// window.location.href = '<?php echo site_url('/Report_indicator/export_excel');?>';
			// window.open(url, '_blank');
			// alert("post");
		// });
	// } //End fn export_excel
	
	function print(){
		// window.print();
		// setTimeout(function(){ history.back() }, 100);
	}
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
								<i class="glyphicon glyphicon-stats"></i>
								<h2 class="box-title">ค้นหา</h2>
								<!--<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
								</div>-->
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
										<div class="form-group"> <!-- Start form-group -->
											<div class = "col-md-12" id="div_ind">
												<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ผู้รับผิดชอบ</label>
												<div class="col-md-10 select2-container-active">
													<select class="select2" id="select2_ps" name="select2_ps" style="width: 100%;" tabindex="-1" validate>
														<option id="rs_ps" class="select2_wb" value="0" >ทั้งหมด</option>
														<?php foreach($rs_person['data_result'] as $rs_ps){?>
															<option id="rs_ps" class="select2_wb" value="<?php echo $rs_ps['ps_id'];?>" ><?php echo $rs_ps['pf_title_th'];?><?php echo $rs_ps['ps_fname_th'];?> <?php echo $rs_ps['ps_lname_th'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
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
								<!--<div class = "col-md-12" id="div_ind">
									<label class="col-md-10 control-label" style="padding: 8px; text-align: right;">ปีงบประมาณ</label>
									<div class="col-md-2 select2-container-active">
										<select class="select2" id="select2_graph_bgy" name="select2_graph_bgy" style="width: 100%;" tabindex="-1" onchange="get_data_select();">
											<option id="graph_bgy" class="select2_wb" value="0" >ทั้งหมด</option>
											<?php //foreach($rs_bgy->result() as $bgy){?>
												<option id="graph_bgy" class="select2_wb" value="<?php //echo $bgy->bgy_id;?>" ><?php //echo $bgy->bgy_name;?></option>
											<?php //} ?>
										</select>
									</div>
								</div>-->
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
								<div class="pull-right">
									<!--<form action="" method="POST" target="_blank">-->
										<a onclick="print();" type="button" class="margin <?php echo $this->config->item('btn_success');?>"><i class="fa fa-fw fa-print" style="color:white"></i>&nbsp;Print</a>
									<!--</form>-->
									<!--<a href="#"><i class="fa fa-fw fa-print" style="color:black">&nbsp;&nbsp;&nbsp;Print</i></a>-->
								</div>
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
// table, th, td{
	// font-family: "TH SarabunPSK";
	// font-size: 24px;
	// border: 1px solid black;
// }	

// .btn-outline-success {
    // color: #28a745;
    // background-color: transparent;
    // background-image: none;
    // border-color: #28a745;
// }

// .btn-outline-success:hover{
    // color: #ffffff;
    // background-color: #28a745;
// }

</style>
