<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="https://code.highcharts.com/highcharts-more.js"></script>
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
		
		
		get_chart_following_indicator();
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
                dataSrc: function (data) {
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
					
                    $(data).each(function(seq, data ) {
                        return_data.push({
							"seq_queue_show"			:	'<center>'+i+'</center>',
							"dfine_id" 					:	data.dfine_id,
							"ind_name" 					:	''+data.dfine_status_assessment+'&nbsp;&nbsp;&nbsp;<a id="des_ind" onclick="select_chart_follow_indicator('+data.dfine_id+')">'+data.ind_name+'</a>',
							"bgy_name" 					:	'<center>'+data.bgy_name+'</center>',
							"indgp_name" 				:	'<center>'+data.indgp_name+'</center>',
							"btn_chk_follow"			:	data.btn_chk_follow,
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
				$('#tb_ind_all').html(data);
				// $(data).each(function(seq, value) {
					// sum_ind =  Number(value.ind_faile) +  Number(value.ind_not) +  Number(value.ind_pass);
					// ตัวชี้วัดทั้งหมด
					// $('#head_sum_ind').html(sum_ind);
					// $('#body_sum_ind').html("ตัวชี้วัดทั้งหมด ของปีงบประมาณ "+value.bgy_name);
				// });
			}//End success
		});
	}
	
	function select_chart_follow_indicator(dfine_id){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_chart_follow_indicator');?>",
			data: {'dfine_id': dfine_id},
			dataType : "json",
			success : function(data){
				get_chart_following_indicator();
				get_chart_with_indicator(data);
				get_grage_with_indicator(data);
			}//End success
		});
	}
	
	function get_chart_with_indicator(data){
		var dfine_id = [];
		var ind_name = [];
		var dfine_goal = [];
		var resm_name;
		var score = [];
		var quarter = [];
		var dfine_status_assessment = [];
		var indgp_name = [];
		var str_name = [];
		$(data).each(function(seq, value) {
			resm_name = value.resm_name;
			dfine_id.push(value.dfine_id);
			ind_name.push(value.ind_name);
			dfine_status_assessment.push(value.dfine_status_assessment);
			indgp_name.push(value.indgp_name);
			str_name.push(value.str_name);
			$(value.rs_score).each(function(seq, value2) {
				dfine_goal.push(Number(value.dfine_goal));
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
		$('#result_ind').html('ผลการประเมิน :  '+dfine_status_assessment);
		$('#follow_indgp_name').text(indgp_name);
		$('#follow_str_name').text('ยุทธศาสตร์ :  '+str_name);
		
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
				data: score
			},{
				type: 'spline',
				name: 'เป้าหมาย',
				data: dfine_goal,
				marker: {
					lineWidth: 2,
					lineColor: Highcharts.getOptions().colors[3],
					fillColor: 'white'
				}
			},	
			]
		});
	} //End fn get_chart_with_indicator
	
	function get_grage_with_indicator(data){
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
		percent_score = (sum_score/dfine_goal)*100;
		percent_goal = (dfine_goal/100)*100;
		
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
				max: percent_score,

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
					to: percent_score,
					color: '#55BF3B' // green
				}]
			},

			series: [{
				name: 'ร้อยละ',
				data: [percent_score],
				tooltip: {
					valueSuffix: ' %'
				}
			}]

		});
	} //End fn get_grage_with_indicator
	
	function select_follow_indicator(){
		var bgy_id = $("#select2_table_by_bgy").val();
		var follow_ind_checked = [];
		$("input:checkbox[name=follow_ind]:checked").each(function() {
			follow_ind_checked.push($(this).attr('value'));
		});
		// alert(follow_ind_all);
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Dashborad/get_follow_indicator');?>",
			data: {'follow_ind_checked': follow_ind_checked,'bgy_id': bgy_id},
			dataType : "json",
			success : function(data){
				notify_save_assessment();
				get_chart_following_indicator();
			}//End success
		});
	}
	
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
				var score = [];
				var quarter = [];
				var dfine_status_assessment = [];
				var indgp_name = [];
				var str_name = [];
				$(data).each(function(seq, value) {
					resm_name = value.resm_name;
					dfine_id.push(value.dfine_id);
					ind_name.push(value.ind_name);
					// dfine_status_assessment.push(value.dfine_status_assessment);
					// indgp_name.push(value.indgp_name);
					// str_name.push(value.str_name);
					score.push(value.sum_score);
					dfine_goal.push(Number(value.dfine_goal));
				});
				
				if(data != 0){
					//Zone chart
					$('#following_chart').remove(); 
					$('#graph_container_following_ind').append('<div id="following_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>');
					Highcharts.chart('following_chart', {
						title: {
							text: "ตัวชี้วัดที่ติดตาม"
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
									color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
								}
							}
						},
						series: [{
							type: 'column',
							name: 'คะแนน',
							data: score
						},{
							type: 'spline',
							name: 'เป้าหมาย',
							data: dfine_goal,
							marker: {
								lineWidth: 2,
								lineColor: Highcharts.getOptions().colors[3],
								fillColor: 'white'
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
	}
	
	function sum_income(){
		// var num1 = $(".income").val();
		// var num2 = $(".income").val();
		// alert(num1);
		// alert(num2);
		var sum=0;
		$(".income").each(function() {
			sum += Number(this.value);
		});
		$('#sum').html(sum);
		
	}

</script>

<!--
<input type="number" class="income">
<input type="number" class="income">
<input type="button" onclick="sum_income()" value="sum">
<div id="sum"></div>
-->

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
								<div class="box">
									<div class="box-header with-border" id="head_table">
										<div class="col-md-3">
											<h2 class="box-title" style="margin-top:5px">รายงานสรุปจำแนกตามตัวชี้วัด</h2>
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
			<div class="box-body" id="body">
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
							<div class="box" id="" style="border-color: #536872;">
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
						<div class="box">
							<div class="box-header with-border" id="head_table">
								<div class="col-md-6">
									<h2 class="box-title" style="margin-top:5px">รายงานสรุปตัวชี้วัดจำแนกตาม</h2>
								</div>
							</div>
							<div class="box-body" id="">
								<div class="col-md-12" id="graph_container_follow_ind" >
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="box">
							<div class="box-header with-border" id="head_table">
								<div class="col-md-4">
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
						<div class="box" id="">
							<div class="box-header with-border" id="head_table">
								<div class="col-md-6">
									<i class="glyphicon glyphicon-list-alt" style="color: #ffffff"></i>
									<h3 class="box-title" style="margin-top:5px" > ข้อมูลตัวชี้วัดที่ติดตาม</h3>
								</div>	
							</div>
							<div class="box-body" id="">
								<div class="row">
									<div class="col-lg-12">
										<div class="box" id="" style="border-color: #536872;">
											<div class="box-header with-border" id="">
												<div class="col-md-12" id="graph_container_following_ind" >
									
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
   		max-height: calc(500vh - 100px);
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



