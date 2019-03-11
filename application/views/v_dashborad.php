<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
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
		
		var bgy_chk = '<?php echo $bgy_chk;?>';
		$("#select2_bgy").val(bgy_chk).trigger('change');
		$("#select2_table_by_bgy").val(bgy_chk).trigger('change');
		
		get_chart_following_indicator(); //เรียก chart ที่ติดตามตัวชี้วัด
		get_following_gauge(); //เรียก cockpit ที่ติดตาม
	});
	
	function get_table_indicator(){
		var bgy_id = $("#select2_table_by_bgy").val();
		$("#example").DataTable({
            bDestroy: true,
            processing: true,
            ajax: {
                type: "POST",
                url: "<?php echo site_url('/Dashborad/get_data_search');?>",
                data: {'bgy_id': bgy_id},
                dataSrc: function (data){
					$(data).each(function(seq, data ) {
						$('#th_follow').html(data.chk_all);
					});
                    var i = $(data).length; //check result row
                    var return_data = new Array();
					var score = 0;
					
					//เลือกแสดงตัวชี้วัดอัตโนมัติ
					var chk_dfine_id = [];
					$(data).each(function(seq, data ) {
						chk_dfine_id.push(data.dfine_id);
					});
					var count_dfine_id = chk_dfine_id.length-1;
					var default_chk_ind = chk_dfine_id[count_dfine_id];
					select_chart_follow_indicator(default_chk_ind);
					
                    $(data).each(function(seq, data) {
                        return_data.push({
							"seq_queue_show"			:	'<center>'+i+'</center>',
							"dfine_id" 					:	data.dfine_id,
							"ind_name" 					:	''+data.dfine_status_assessment+'&nbsp;&nbsp;&nbsp;<a id="des_ind" onclick="select_chart_follow_indicator('+data.dfine_id+')">'+data.ind_name+'</a>',
							"bgy_name" 					:	'<center>'+data.bgy_name+'</center>',
							"indgp_name" 				:	'<center>'+data.indgp_name+'</center>',
							"btn_chk_follow"			:	data.btn_chk_follow,
							"chk_all"					:	data.chk_all,
						});
                        i--;
                    });//end project for
                    return return_data;
                }//end dataSrc
            }, //end ajax
            "columns"    : [
                {"data": "seq_queue_show"},
                {"data": "ind_name"},
                {"data": "btn_chk_follow"},
            ],
            "order": [[ 0, "asc" ]], //เรียงลำดับการแสดงผล
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                nRow.setAttribute("id","tr_"+aData.dfine_id);
            }
        });//end DataTable
		$('.dataTables_filter input').attr('placeholder', 'ค้นหา');
		$("#toggle-event").attr("data-toggle","toggle");
	} //End fn get_table_indicator
	
	function get_summary_indicator(){
		var val_type = $('#select2_by_type').val();
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
				var sum_ind = 0;
				$(data).each(function(seq, value) {
					
					console.log("ind_faile : "+value.ind_faile);
					console.log("ind_not : "+value.ind_not);
					console.log("ind_pass : "+value.ind_pass);
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
					$('#body_ind_not').html("ตัวชี้วัดที่ไม่ได้ประเมินผล ของปีงบประมาณ "+value.bgy_name);
				});
			}//End success
		});
	} //End fn get_summary_indicator
	
	function change_type(bgy_id){
		get_summary_indicator();
	} //End fn change_type
		
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
				$(data).each(function(seq, value) {
					ind_not.push(Number(value.ind_not));
					ind_pass.push(Number(value.ind_pass));
					ind_faile.push(Number(value.ind_faile));
					bgy_name = value.bgy_name;
					str_name.push(value.str_name);
				});
				
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
	} //End fn get_chart_by_bgy
	
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
				$(data).each(function(seq, value) {
					ind_not.push(Number(value.ind_not));
					ind_pass.push(Number(value.ind_pass));
					ind_faile.push(Number(value.ind_faile));
					bgy_name = value.bgy_name;
					indgp_name.push(value.indgp_name);
				});
				
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
	} //End fn get_chart_by_indgp
	
	function get_ind_info(status_ind){
		var bgy_id = $('#select2_bgy').val();
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
				$('#tb_ind_all').html(data);
			}//End success
		});
	} //End fn get_ind_info
	
	function select_chart_follow_indicator(dfine_id){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_follow_indicator');?>",
			data: {'dfine_id': dfine_id},
			dataType : "json",
			success : function(data){
				get_chart_following_indicator(); //เรียก chart ที่ติดตามตัวชี้วัด
				get_following_gauge(); //เรียก cockpit ที่ติดตาม
				get_chart_with_indicator(data);
				get_gauge_with_indicator(data);
			}//End success
		});
	} //End fn select_chart_follow_indicator
	
	function get_chart_with_indicator(data){
		var dfine_id = [];
		var ind_name = [];
		var arr_dfine_goal = [];
		var dfine_goal;
		var resm_name;
		var opt_symbol;
		var unt_name;
		var score = [];
		var sum_score=0;
		var quarter = [];
		var dfine_status_assessment = [];
		var status_assessment;
		var indgp_name = [];
		var str_name = [];
		$(data).each(function(seq, value) {
			resm_name = value.resm_name;
			dfine_goal = Number(value.dfine_goal);
			status_assessment = value.status_assessment;
			opt_symbol = value.opt_symbol;
			unt_name = value.unt_name;
			dfine_id.push(value.dfine_id);
			ind_name.push(value.ind_name);
			dfine_status_assessment.push(value.dfine_status_assessment);
			indgp_name.push(value.indgp_name);
			str_name.push(value.str_name);
			$(value.rs_score).each(function(seq, value2) {
				sum_score += Number(value2.indrs_score);
				score.push(Number(value2.indrs_score));
				quarter.push('ไตรมาส  '+Number(value2.indrs_quarter));
			});
			quarter.push("คะแนนรวม");
			score.push(sum_score); //รวมคะแนนก่อนใส่ลงกราฟ
			for(var i=0;i<=4;i++){
				arr_dfine_goal.push(Number(value.dfine_goal));
			}//ทำให้เป้าหมายมีทั้งหมด 4 ไตรมาส + คะแนนรวม
		});
		$('#head_follow_ind').html('<i class="fa fa-bar-chart-o fw"></i>&nbsp;&nbsp;&nbsp;'+ind_name);
		if(resm_name == null){
			$('#follow_resm').text('ผู้รับผิดชอบ :   -');
		}else{
			$('#follow_resm').text('ผู้รับผิดชอบ :  '+resm_name);
		}
		$('#result_ind').html('ผลการประเมิน :  '+dfine_status_assessment);
		$('#follow_indgp_name').text(indgp_name);
		$('#follow_str_name').text('ยุทธศาสตร์ :  '+str_name);
		
		//Zone summary
		//Remove Class
		$('#icon_result_assessment').removeClass("text-green");
		$('#icon_result_assessment').removeClass("text-red");
		$('#icon_result_assessment').removeClass("text-orange");
		if(status_assessment == 1){
			var icon_faile = '<i class="fa fa-fw fa-times-circle"></i>';
			$('#icon_result_assessment').html(icon_faile);
			$('#icon_result_assessment').addClass("text-red");
			$('#result_assessment').text("ไม่ผ่าน");
		}else if(status_assessment == 2){
			var icon_pass = '<i class="fa fa-fw fa-check-circle"></i>';
			$('#icon_result_assessment').html(icon_pass);
			$('#icon_result_assessment').addClass("text-green");
			$('#result_assessment').text("ผ่าน");
		}else if(status_assessment == 0){
			var icon_not = '<i class="fa fa-fw fa-ban"></i>';
			$('#icon_result_assessment').html(icon_not);
			$('#icon_result_assessment').addClass("text-orange");
			$('#result_assessment').text("ไม่ได้ประเมินผล");
		}
		$('#goal_ind').text(opt_symbol+' '+dfine_goal+' '+unt_name);
		$('#sum_score').text(sum_score);
		
		//Zone chart
		$('#follow_chart').remove(); 
		$('#graph_container_follow_ind').append('<div id="follow_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>');
		Highcharts.chart('follow_chart', {
			title: {
				text: ind_name
			},
			xAxis: {
				categories: quarter
			},
			yAxis: {
				min: 0,
				title: {
					text: 'คะแนน',
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
			labels: {
				items: [{
					// html: 'Total fruit consumption',
					style: {
						left: '50px',
						top: '18px',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
					}
				}]
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
				type: 'column',
				name: 'คะแนน',
				data: score,
				color: '#944dff', 
			},{
				type: 'spline',
				name: 'เป้าหมาย',
				data: arr_dfine_goal,
				marker: {
					lineWidth: 2,
					lineColor: Highcharts.getOptions().colors[1],
					fillColor: 'red'
				},
				tooltip: {
					valuePrefix: opt_symbol+' ',
					valueSuffix: ' '+unt_name
				}
			},	
			]
		});
	} //End fn get_chart_with_indicator
	
	function get_gauge_with_indicator(data){
		var dfine_id = [];
		var ind_name = [];
		var arr_dfine_goal = [];
		var dfine_goal=0;
		var resm_name;
		var score = [];
		var quarter = [];
		var dfine_status_assessment = [];
		var indgp_name = [];
		var str_name = [];
		$(data).each(function(seq, value) {
			resm_name = value.resm_name;
			dfine_goal = Number(value.dfine_goal);
			dfine_id.push(value.dfine_id);
			ind_name.push(value.ind_name);
			dfine_status_assessment.push(value.dfine_status_assessment);
			indgp_name.push(value.indgp_name);
			str_name.push(value.str_name);
			
			$(value.rs_score).each(function(seq, value2) {
				arr_dfine_goal.push(Number(value.dfine_goal));
				score.push(Number(value2.indrs_score));
				quarter.push('ไตรมาส  '+Number(value2.indrs_quarter));
			});
		});
		$('#head_follow_ind').html('<i class="fa fa-bar-chart-o fw"></i>&nbsp;&nbsp;&nbsp;'+ind_name);
		if(resm_name == null){
			$('#follow_resm').text('ผู้รับผิดชอบ :   -');
		}else{
			$('#follow_resm').text('ผู้รับผิดชอบ :  '+resm_name);
		}
		
		//รวมคะแนนทั้ง 4 ไตรมาส
		var sum_score=0;
		for (i = 0; i < score.length; ++i) {
			sum_score += Number(score[i]);
		}
		
		//คิดร้อยละ
		var percent_score=0;
		var percent_goal=0;
		percent_score = (sum_score/100)*100;
		percent_goal = (dfine_goal/100)*100;
		if(percent_score > 100){
			percent_score = 100;
		}
		
		$('#gauge_follow_chart').remove(); 
		$('#graph_container_gauge_follow_ind').append('<div id="gauge_follow_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>');
		Highcharts.chart('graph_container_gauge_follow_ind', {
			chart: {
				type: 'gauge',
				plotBackgroundColor: null,
				plotBackgroundImage: null,
				plotBorderWidth: 0,
				plotShadow: false
			},

			title: {
				text: ind_name
			},

			pane: {
				startAngle: -150,
				endAngle: 150,
				background: [{
					backgroundColor: {
						linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
						stops: [
							[0, '#FFF'],
							[1, '#333']
						]
					},
					borderWidth: 0,
					outerRadius: '109%'
				}, {
					backgroundColor: {
						linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
						stops: [
							[0, '#333'],
							[1, '#FFF']
						]
					},
					borderWidth: 1,
					outerRadius: '107%'
				}, {
					// default background
				}, {
					backgroundColor: '#DDD',
					borderWidth: 0,
					outerRadius: '105%',
					innerRadius: '103%'
				}]
			},

			// the value axis
			yAxis: {
				min: 0,
				max: 100,

				minorTickInterval: 'auto',
				minorTickWidth: 1,
				minorTickLength: 10,
				minorTickPosition: 'inside',
				minorTickColor: '#666',

				tickPixelInterval: 30,
				tickWidth: 2,
				tickPosition: 'inside',
				tickLength: 10,
				tickColor: '#666',
				labels: {
					step: 2,
					rotation: 'auto'
				},
				title: {
					text: 'ร้อยละ'
				},
				plotBands: [{
					from: 0,
					to: percent_goal,
					color: '#DF5353' // red 
				}, {
					from: dfine_goal,
					to: 100,
					color: '#55BF3B' // green
				}]
			},
			series: [{
				name: 'ร้อยละ',
				data: [percent_score],
				tooltip: {
					valueSuffix: ' %'
				},
				dataLabels: {
					enabled: true,
					format: '{point.y:.2f}'
				},
			}]
		});
	} //End fn get_gauge_with_indicator
	
	function checkAll(){
		var bgy_id = $("#select2_table_by_bgy").val();
		var chk_all = $("#chk_all_follow_ind").is(':checked');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/following_all_indicator');?>",
			data: {'chk_all': chk_all,'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				get_chart_following_indicator();
				get_following_gauge();
				notify_follow();
				get_table_indicator();
			}//End success
		});
	} //End fn checkAll
	
	function select_following_indicator(dfine_id){
		var bgy_id = $("#select2_table_by_bgy").val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_following_indicator');?>",
			data: {'dfine_id': dfine_id,'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				$("#chk_all_follow_ind").prop("checked", false);
				notify_follow();
				get_chart_following_indicator();
			}//End success
		});
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_gauge_following');?>",
			data: {'dfine_id': dfine_id,'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				// get_table_indicator();
				get_following_gauge();
			}//End success
		});
	} //End fn select_following_indicator
	
	function get_chart_following_indicator(){
		var bgy_id = $("#select2_table_by_bgy").val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_following_indicator');?>",
			data: {"bgy_id": bgy_id},
			dataType : "json",
			success : function(data){
				var dfine_id = [];
				var ind_name = [];
				var dfine_goal = [];
				var resm_name;
				var bgy_name;
				var score = [];
				var quarter = [];
				var dfine_status_assessment = [];
				var indgp_name = [];
				var str_name = [];
				var opt_symbol;
				var unt_name;
				$(data).each(function(seq, value) {
					bgy_name = value.bgy_name;
					opt_symbol = value.opt_symbol;
					unt_name = value.unt_name;
					resm_name = value.resm_name;
					dfine_id.push(value.dfine_id);
					ind_name.push(value.ind_name);
					score.push(value.sum_score);
					dfine_goal.push(Number(value.dfine_goal));
				});
				
				if(data != 0){
					//Zone chart
					$('#following_chart').remove(); 
					$('#graph_container_following_ind').append('<div id="following_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>');
					Highcharts.setOptions({
						colors: ['#0066ff']
					});
					Highcharts.chart('following_chart', {
						title: {
							text: "ตัวชี้วัดที่ติดตามปีงบประมาณ "+bgy_name
						},
						xAxis: {
							categories: ind_name
						},
						yAxis: {
							min: 0,
							title: {
								text: 'คะแนน',
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
						labels: {
							items: [{
								// html: 'Total fruit consumption',
								style: {
									left: '50px',
									top: '18px',
									color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
								}
							}]
						},
						plotOptions: {
							column: {
								stacking: 'normal',
								dataLabels: {
									enabled: true,
									color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
								}
							}
						},
						series: [{
							type: 'column',
							name: 'คะแนน',
							color: '#A7D21F',
							data: score
						},{
							type: 'spline',
							name: 'เป้าหมาย',
							data: dfine_goal,
							marker: {
								lineWidth: 2,
								lineColor: Highcharts.getOptions().colors[8],
								fillColor: 'red'
							},
							tooltip: {
								valuePrefix: opt_symbol+' ',
								valueSuffix: ' '+unt_name
							}
						},	
						]
					});
				}else {
					$('#following_chart').remove(); 
					$('#graph_container_following_ind').append('<div id="following_chart" style="color: red; text-align: center;">ไม่มีตัวชี้วัดที่ติดตาม</div>');
				}
			}//End success
		});
	} //End fn get_chart_following_indicator
	
	function get_following_gauge(){
		var bgy_id = $("#select2_table_by_bgy").val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_following_indicator');?>",
			data: {"bgy_id": bgy_id},
			dataType : "json",
			success : function(data){
				// console.log(data);
				var dfine_id = [];
				var ind_name = [];
				var dfine_goal = [];
				var resm_name;
				var bgy_name;
				var score = [];
				var quarter = [];
				// var dfine_status_assessment = [];
				var indgp_name = [];
				var str_name = [];
				var opt_symbol = [];
				var unt_name = [];
				var status_assessment = [];
				
				var arr_gauge = [];
				$(data).each(function(seq, value) {
					// console.log(value.opt_symbol);
					bgy_name = value.bgy_name;
					resm_name = value.resm_name;
					dfine_id.push(value.dfine_id);
					ind_name.push(value.ind_name);
					score.push(value.sum_score);
					dfine_goal.push(Number(value.dfine_goal));
					opt_symbol.push(Number(value.opt_symbol));
					unt_name.push(Number(value.unt_name));
					arr_gauge.push(dfine_goal);
					status_assessment.push(value.status_assessment);
					// status_assessment = value.status_assessment
					
				});
				//Zone summary
				//Remove Class
				// $('#icon_result_assessment').removeClass("text-green");
				// $('#icon_result_assessment').removeClass("text-red");
				// $('#icon_result_assessment').removeClass("text-orange");
				// if(value.dfine_status_assessment == 1){
					// var icon_faile = '<i class="fa fa-fw fa-times-circle"></i>';
					// $('#icon_result_assessment').html(icon_faile);
					// $('#icon_result_assessment').addClass("text-red");
					// $('#result_assessment').text("ไม่ผ่าน");
					
					// '<div style="display:inline;width:60px;height:60px;"><canvas width="75" height="75" style="width: 60px; height: 60px;"></canvas>';
					// '<div class="description-block border-right" >';
						// '<span class="description-percentage text-red" id="icon_result_assessment" style="font-size: 50px;"><i class="fa fa-fw fa-times-circle"></i></span>';
						// '<h5 class="description-header" id="result_assessment">ไม่ผ่าน</h5>';
					// '</div>';
					// '</div>';
				// }else if(value.dfine_status_assessment == 2){
					// var icon_pass = '<i class="fa fa-fw fa-check-circle"></i>';
					// $('#icon_result_assessment').html(icon_pass);
					// $('#icon_result_assessment').addClass("text-green");
					// $('#result_assessment').text("ผ่าน");
				// }else if(value.dfine_status_assessment == 0){
					// var icon_not = '<i class="fa fa-fw fa-ban"></i>';
					// $('#icon_result_assessment').html(icon_not);
					// $('#icon_result_assessment').addClass("text-orange");
					// $('#result_assessment').text("ไม่ได้ประเมินผล");
				// }
				
				
				
				//จัดเรียงแถว gauge
				if(data != 0){
					$("#row_following_gauge").remove(); 
					$('#body_following_gauge').append('<div id="row_following_gauge"></div>');
					var row="";
					var count_row=0;
					$(data).each(function(seq, value) {
						// console.log(value.status_assessment);
						count_row = seq+1;
						if(count_row%4 == 0 || count_row == 1){
							row +='<div class="row">';
							row +='<div class="col-md-3" id="box_gauge">';
							row += 	'<div class="box" style="border-color: #2b6688;">';
							row += 		'<div class="box-header">';
							row +=			'<h4 class="">'+value.ind_name+'</h4>';
							row +=		'</div>';
							
							row +='<div class="box-footer no-border">';
							row +=  '<div class="row">';
							row +=		'<div class="col-xs-12 text-center" style="">';
							row +=		  '<div style="display:inline;width:60px;height:60px;"><canvas width="75" height="75" style="width: 0px; height: 60px;"></canvas><input type="text" class="knob" data-readonly="true" value="'+value.opt_symbol+' '+value.dfine_goal+' '+value.unt_name+'" data-width="60" data-height="60" data-fgcolor="#39CCCC" readonly="readonly" style="width: 100px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; -webkit-appearance: none;"></div>';
	
							row +=		  '<div class="knob-label"><b>เป้าหมาย</b></div>';
							row +=		'</div>';
							row +=  '</div>';
									
							row +=  '<div class="row">';
							row +=		'<div class="col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">';
							row +=		  '<div style="display:inline;width:60px;height:60px;"><canvas width="75" height="75" style="width: 60px; height: 60px;"></canvas><input type="text" class="knob" data-readonly="true" value="'+value.sum_score+'" data-width="60" data-height="60" data-fgcolor="#39CCCC" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; -webkit-appearance: none;"></div>';
	
							row +=		  '<div class="knob-label"><b>คะแนนที่ได้</b></div>';
							row +=		'</div>';
							
							row +=		'<div class="col-xs-6 text-center">';
								if(value.status_assessment == 1){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-red" id="" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-times-circle"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ไม่ผ่าน</b></h5>';
									row +='</div>';
								}else if(value.status_assessment == 2){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-green" id="icon_result_assessment" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-check-circle"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ผ่าน</b></h5>';
									row +='</div>';
								}else if(value.status_assessment == 0){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-orange" id="icon_result_assessment" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-ban"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ไม่ได้ประเมินผล</b></h5>';
									row +='</div>';
								}
							row +=		'</div>';
							row +=  '</div>';
							row +='</div>';
							
							
							row +=		'<div class="box-body" >';
							row +=			'<div class="col-md-12" id="container_gauge_following_ind_'+value.dfine_id+'" >';
							row +=				'<div id="following_gauge_'+value.dfine_id+'" style="color: red; text-align: center;">'
										
							row +=				'</div>';
							row +=			'</div>';
							row +=		'</div>';
							
							
							row +=	'</div>';
							row +='</div>';
						}else{
							row +='<div class="col-md-3" id="box_gauge">';
							row += 	'<div class="box" style="border-color: #2b6688;">';
							row += 		'<div class="box-header">';
							row +=			'<h4 class="">'+value.ind_name+'</h4>';
							row +=		'</div>';
							
							row +='<div class="box-footer no-border">';
							row +=  '<div class="row">';
							row +=		'<div class="col-xs-12 text-center" style="">';
							row +=		  '<div style="display:inline;width:60px;height:60px;"><canvas width="75" height="75" style="width: 0px; height: 60px;"></canvas><input type="text" class="knob" data-readonly="true" value="'+value.opt_symbol+' '+value.dfine_goal+' '+value.unt_name+'" data-width="60" data-height="60" data-fgcolor="#39CCCC" readonly="readonly" style="width: 100px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; -webkit-appearance: none;"></div>';
	
							row +=		  '<div class="knob-label"><b>เป้าหมาย</b></div>';
							row +=		'</div>';
							row +=  '</div>';
									
							row +=  '<div class="row">';
							row +=		'<div class="col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">';
							row +=		  '<div style="display:inline;width:60px;height:60px;"><canvas width="75" height="75" style="width: 60px; height: 60px;"></canvas><input type="text" class="knob" data-readonly="true" value="'+value.sum_score+'" data-width="60" data-height="60" data-fgcolor="#39CCCC" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; -webkit-appearance: none;"></div>';
	
							row +=		  '<div class="knob-label"><b>คะแนนที่ได้</b></div>';
							row +=		'</div>';
							
							row +=		'<div class="col-xs-6 text-center">';
								if(value.status_assessment == 1){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-red" id="" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-times-circle"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ไม่ผ่าน</b></h5>';
									row +='</div>';
								}else if(value.status_assessment == 2){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-green" id="icon_result_assessment" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-check-circle"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ผ่าน</b></h5>';
									row +='</div>';
								}else if(value.status_assessment == 0){
									row +='<div style="display:inline;width:60px;height:60px;">';
									row +='<span class="description-percentage text-orange" id="icon_result_assessment" style="font-size: 50px;">';
									row +='<i class="fa fa-fw fa-ban"></i>';
									row +='</span>';
									row +=	'<h5 class="description-header" id=""><b>ไม่ได้ประเมินผล</b></h5>';
									row +='</div>';
								}
							row +=		'</div>';
							row +=  '</div>';
							row +='</div>';
							
							
							row +=		'<div class="box-body" >';
							row +=			'<div class="col-md-12" id="container_gauge_following_ind_'+value.dfine_id+'" >';
							row +=				'<div id="following_gauge_'+value.dfine_id+'" style="color: red; text-align: center;">'		
							row +=				'</div>';
							row +=			'</div>';
							row +=		'</div>';
							row +=	'</div>';
							row +='</div>';
						}
						if(count_row%4 == 0 ){
							row +='</div>';
						}
					});
					$('#row_following_gauge').html(row);
					
					$(data).each(function(seq, value) {
						//คำนวนคะแนนตัวชี้วัด ก่อนจัดลง gauge
						var percent_score=0;
						var percent_goal=0;
						percent_score = (value.sum_score/100)*100;
						percent_goal = (value.dfine_goal/100)*100;
						if(percent_score > 100){
							percent_score = 100;
						}
						//Zone chart
						Highcharts.chart("following_gauge_"+value.dfine_id, {
							chart: {
								type: 'gauge',
								plotBackgroundColor: null,
								plotBackgroundImage: null,
								plotBorderWidth: 0,
								plotShadow: false
							},

							title: {
								text: ''
							},
							pane: {
								startAngle: -150,
								endAngle: 150,
								background: [{
									backgroundColor: {
										linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
										stops: [
											[0, '#FFF'],
											[1, '#333']
										]
									},
									borderWidth: 0,
									outerRadius: '109%'
								}, {
									backgroundColor: {
										linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
										stops: [
											[0, '#333'],
											[1, '#FFF']
										]
									},
									borderWidth: 1,
									outerRadius: '107%'
								}, {
									// default background
								}, {
									backgroundColor: '#DDD',
									borderWidth: 0,
									outerRadius: '105%',
									innerRadius: '103%'
								}]
							},

							// the value axis
							yAxis: {
								min: 0,
								max: 100,

								minorTickInterval: 'auto',
								minorTickWidth: 1,
								minorTickLength: 10,
								minorTickPosition: 'inside',
								minorTickColor: '#666',

								tickPixelInterval: 30,
								tickWidth: 2,
								tickPosition: 'inside',
								tickLength: 10,
								tickColor: '#666',
								labels: {
									step: 2,
									rotation: 'auto'
								},
								title: {
									text: 'ร้อยละ'
								},
								plotBands: [{
									from: 0,
									to: percent_goal,
									color: '#DF5353' // red 
								}, {
									from: value.dfine_goal,
									to: 100,
									color: '#55BF3B' // green
								}]
							},
							series: [{
								name: 'ร้อยละ',
								data: [percent_score],
								tooltip: {
									valueSuffix: ' %',
								},
								dataLabels: {
									enabled: true,
									format: '{point.y:.2f}'
								},
							}]
						});
					});
				}else {
					$("#row_following_gauge").remove(); 
					$('#body_following_gauge').append('<div id="row_following_gauge"></div>');
					$('#row_following_gauge').append('<div id="box_gauge" style="color: red; text-align: center;">ไม่มีตัวชี้วัดที่ติดตาม</div>');
				}
			}//End success
		});
	} //End fn get_following_gauge
</script>
<!--<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="#">Home</a></li>
  <li class="breadcrumb-item"><a href="#">Library</a></li>
  <li class="breadcrumb-item active">Data</li>
</ol>-->
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="box" id="border_main_head">
					<div class="box-header with-border" id="head_table">
						<div class="col-md-3">
							<i class="glyphicon glyphicon-calendar" style="color: #ffffff"></i> 
							<h2 class="box-title" style="margin-top:5px">   ข้อมูลตัวชี้วัดจำแนกตามปีงบประมาณ</h2>
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
									<div class="icon" style="color: #0099ff" >
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
								<div class="box" id="border_sub_head">
									<div class="box-header with-border" id="sub_head_table">
										<div class="col-md-3">
											<i class="fa fa-bar-chart-o fw" style="color: #ffffff"></i>
											<h2 class="box-title" style="margin-top:5px">รายงานสรุปจำแนกตาม</h2>
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
		<div class="box" id="border_main_head">
			<div class="box-header with-border" id="head_table" style="color: #ffffff">
				<div class="col-md-6">
					<i class="glyphicon glyphicon-filter" style="color: #ffffff"></i>
					<h3 class="box-title" style="margin-top:5px" >   ข้อมูลตัวชี้วัดจำแนกตามตัวชี้วัด</h3>
				</div>	
			</div>
			<div class="box-body" id="body">
				<div class="col-md-5">
					<div class="box" id="box_table_indicator" >
						<div class="box-header with-border" id="sub_head_table">
							<div class="col-md-6">
								<i class="fa fa-fw fa-list-ul" style="color: #ffffff"></i>
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
										<th style=" vertical-align: middle; width: 25%;" id="th_follow"></th>
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
							<div class="box" id="border_sub_head">
								<div class="box-header with-border" id="">
									<div class="col-md-2 pull-right" style="margin-top:10px">
										<div class="label label-primary" id="follow_indgp_name" ></div>
									</div>
									<div class="col-md-10">
										<h3 id="head_follow_ind"></h3>
										<div id="follow_str_name" ></div>
										<div id="follow_resm" ></div>
										<div id="result_ind" ></div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="box" id="border_sub_head">
							<div class="box-header with-border" id="sub_head_table">
								<div class="col-md-6">
									<i class="fa fa-bar-chart-o fw" style="color: #ffffff"></i>
									<h2 class="box-title" style="margin-top:5px">รายงานสรุปตัวชี้วัดจำแนกตามไตรมาส</h2>
								</div>
							</div>
							<div class="box-body" id="">
								<div class="col-md-12" id="graph_container_follow_ind" >
									
								</div>
								<div class="box-footer" id="footer_sum">
									<div class="row">
										<div class="col-sm-4" style="margin-top:35px;">
											<div class="description-block border-right">
												<h5 class="description-header" id="goal_ind" ></h5>
												<span class="description-text">เป้าหมาย</span>
											</div>
										</div>
										<div class="col-sm-4" style="margin-top:35px;">
											<div class="description-block border-right">
												<h5 class="description-header" id="sum_score" ></h5>
												<span class="description-text" >คะแนนรวม</span>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="description-block border-right" >
												<span class="description-percentage" id="icon_result_assessment" style="font-size: 50px;"></span>
												<h5 class="description-header" id="result_assessment"></h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="box" id="border_sub_head">
							<div class="box-header with-border" id="sub_head_table">
								<div class="col-md-4">
									<i class="fa fa-fw fa-dashboard" style="color: #ffffff"></i>
									<h2 class="box-title" style="margin-top:5px">Cockpit Report</h2>
								</div>
							</div>
							<div class="box-body" id="">
								<div class="col-md-12" id="graph_container_gauge_follow_ind" >
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box" id="border_main_head">
							<div class="box-header with-border" id="head_table">
								<div class="col-md-6">
									<i class="glyphicon glyphicon-list-alt" style="color: #ffffff"></i>
									<h3 class="box-title" style="margin-top:5px" > ติดตามข้อมูลตัวชี้วัด</h3>
								</div>	
							</div>
							<div class="box-body" id="">
								<div class="row">
									<div class="col-lg-12">
										<div class="box" id="border_sub_head" >
											<div class="box-header with-border" id="sub_head_table">
												<i class="fa fa-bar-chart-o fw" style="color: #ffffff"></i>
												<h2 class="box-title" style="margin-top:5px">กราฟติดตามตัวชี้วัด</h2>
												<div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="color: #ffffff"></i></button>
												</div>
											</div>
											<div class="box-body" id="">	
												<div class="col-md-12" id="graph_container_following_ind" >
									
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box-body" id="">
								<div class="row">
									<div class="col-lg-12">
										<div class="box" id="border_sub_head">
											<div class="box-header with-border" id="sub_head_table">
												<i class="fa fa-fw fa-dashboard" style="color: #ffffff"></i>
												<h2 class="box-title" style="margin-top:5px">Cockpit Report</h2>
												<div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="color: #ffffff"></i></button>
												</div>
											</div>
											<div class="box-body" id="body_following_gauge">		
												<div id="row_following_gauge" >
													
													
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
	</div>
</div>


<!--Modal info_indicator-->
<div class="modal fade" id="modal_info_indicator" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title" id="modal_title" style="color: #ffffff">รายละเอียด</h3>
            </div>
            <div class="modal-body" id="modal_body">
				<table id="tb_ind_all" class="table table-bordered">
							 
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">ปิด</button>
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->


<style>
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }


	#box_table_indicator {
   		max-height: calc(160vh - 50px);
 		overflow-y: auto;
		border-color: #2b6688;
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
		// border-color: #ffffff;
	}
	#border_main_head{
		border-color: #536872;
	}
	#sub_head_table{
		background-color: #2b6688;
	}
	#border_sub_head{
		border-color: #2b6688;
	}
	
	.box-title{
		color: #ffffff;
	}
</style>