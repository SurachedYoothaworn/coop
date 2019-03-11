<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="box" id="border_main_head">
					<div class="box-header with-border" id="head_table">
						<div class="col-md-3">
							<i class="glyphicon glyphicon-calendar" style="color: #ffffff"></i> 
							<h2 class="box-title" style="margin-top:5px; color: #ffffff;">   ข้อมูลตัวชี้วัดจำแนกตามปีงบประมาณ</h2>
						</div>	
					</div>
					<div class="box-body" id="body">
						<div class="row">
							<div class="col-lg-4"></div>
							<div class="col-lg-4">
								<div class="small-box bg-aqua">
									<div class="inner">
									  <h3>150</h3>
									  <p>ตัวชี้วัดทั้งหมดที่รับผิดชอบ</p>
									</div>
									<div class="icon">
									  <i class="fa fa-fw fa-archive"></i>
									</div>
									<a href="#" class="small-box-footer">ดูรายละเอียด <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4"></div>
						</div>
					
						<div class="row">
							<div class="col-lg-12">
							<div class="col-lg-4">
								<div class="box-body" id="small-box">
									<div class="progress-group">
										<span class="progress-text">ตัวชี้วัดที่ผ่าน</span>
										<span class="progress-number"><b>480</b>/800</span>
										<div class="progress sm">
										  <div class="progress-bar progress-bar-green" style="width: 80%"></div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="box-body" id="small-box">
									<div class="progress-group">
										<span class="progress-text">ตัวชี้วัดที่ไม่ผ่าน</span>
											<span class="progress-number"><b>250</b>/500</span>
											<div class="progress sm">
												<div class="progress-bar progress-bar-red" style="width: 80%"></div>
											</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<div class="box-body" id="small-box">
									<div class="progress-group">
										<span class="progress-text">ตัวชี้วัดที่ยังไม่ได้ดำเนินการ</span>
											<span class="progress-number"><b>250</b>/500</span>
											<div class="progress sm">
												<div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
											</div>
									</div>
								</div>
							</div>
							</div>
						</div> <br>
						
						
						<div class="col-xs-12">
						<div class="box box-primary color">
							<div class="box-header color">
								<i class="fa fa-fw fa-table"></i>
								<h2 class="box-title" style="margin-top:15px">ตารางรายงานผลงานตัวชี้วัด</h2>
								<div class="pull-right">
									<form action="http://localhost/kpims/index.php/Report_indicator/export_excel/" method="POST" target="_blank">
										<button type="submit" class="margin btn btn-success"><i class="fa fa-fw fa-file-excel-o" style="color:white"></i>&nbsp;ส่งออก Excel</button>
										<input type="hidden" name="bgy_id_excel" id="bgy_id_excel" value="0">
										<input type="hidden" name="indgp_id_excel" id="indgp_id_excel" value="0">
										<input type="hidden" name="resm_id_excel" id="resm_id_excel" value="0">
									</form>
								</div>
								<!--<div class="pull-right">
									<a onclick="print();" type="button" class="margin btn btn-success"><i class="fa fa-fw fa-print" style="color:white"></i>&nbsp;Print</a>
								</div>-->
							</div>
						   
							<div class="box-body">
								<br>
								<div class="col-md-12"><!-- Start  col-md-12 -->
									<div class="box box-solid">
										<div id="example_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="example_length"><label>แสดง <select name="example_length" aria-controls="example" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="-1">ทั้งหมด</option></select> รายการ</label></div></div><div class="col-sm-12 col-md-6"><div id="example_filter" class="dataTables_filter"><label></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
										   <thead>
												<tr role="row"><th rowspan="2" style="vertical-align: middle; width: 38px;" class="sorting_asc" tabindex="0" aria-controls="example" colspan="1" aria-label="ลำดับ: activate to sort column descending" aria-sort="ascending">ลำดับ</th><th rowspan="2" style="vertical-align: middle; width: 85px;" class="sorting" tabindex="0" aria-controls="example" colspan="1" aria-label="ปีงบประมาณ: activate to sort column ascending">ปีงบประมาณ</th><th rowspan="2" style="width: 429px; vertical-align: middle;" class="sorting" tabindex="0" aria-controls="example" colspan="1" aria-label="ตัวชี้วัด: activate to sort column ascending">ตัวชี้วัด</th><th rowspan="2" style="vertical-align: middle; width: 77px;" class="sorting" tabindex="0" aria-controls="example" colspan="1" aria-label="กลุ่มตัวชี้วัด: activate to sort column ascending">กลุ่มตัวชี้วัด</th><th rowspan="2" style="vertical-align: middle; width: 62px;" class="sorting" tabindex="0" aria-controls="example" colspan="1" aria-label="เป้าหมาย: activate to sort column ascending">เป้าหมาย</th><th rowspan="2" style="vertical-align: middle; width: 70px;" class="sorting" tabindex="0" aria-controls="example" colspan="1" aria-label="ผลประเมิน: activate to sort column ascending">ผลประเมิน</th><th colspan="4" rowspan="1">ผลประเมินแบ่งตามไตรมาส</th></tr>
												<tr role="row"><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="1(ต.ค. - ธ.ค.): activate to sort column ascending" style="width: 46px;">1<br>(ต.ค. - <br>ธ.ค.)</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="2(ม.ค. - มี.ค.): activate to sort column ascending" style="width: 45px;">2<br>(ม.ค. - <br>มี.ค.)</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="3(เม.ย. - มิ.ย.): activate to sort column ascending" style="width: 50px;">3<br>(เม.ย. - <br>มิ.ย.)</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="4(ก.ค. - ก.ย.): activate to sort column ascending" style="width: 46px;">4<br>(ก.ค. - <br>ก.ย.)</th></tr>
											</thead>
											<tbody><tr role="row" class="odd" id="tr_14"><td class="sorting_1"><center>1</center></td><td><center>2562</center></td><td>1 ร้อยละของนิสิตแพทย์ที่สอบผ่านการประเมินความรู้ความสามารถในการประกอบ วิชาชีพเวชกรรมในการสอบครั้งแรก</td><td><center>งานประจำ</center></td><td><center>&gt; 80 %</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>70</center></td><td><center>60</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="even" id="tr_15"><td class="sorting_1"><center>2</center></td><td><center>2562</center></td><td>2 หลักสูตรผ่านเกณฑ์มาตรฐานสากลสำหรับแพทยศาสตรศึกษา (WFME)</td><td><center>ยุทธศาสตร์</center></td><td><center>&gt; 50 %</center></td><td><center><span class="label label-danger">ไม่ผ่าน</span></center></td><td><center>10</center></td><td><center>15</center></td><td><center>20</center></td><td><center>0</center></td></tr><tr role="row" class="odd" id="tr_1"><td class="sorting_1"><center>3</center></td><td><center>2561</center></td><td>1 ร้อยละของนิสิตแพทย์ที่สอบผ่านการประเมินความรู้ความสามารถในการประกอบ วิชาชีพเวชกรรมในการสอบครั้งแรก</td><td><center>ยุทธศาสตร์</center></td><td><center>&gt;= 80 %</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>70</center></td><td><center>10</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="even" id="tr_2"><td class="sorting_1"><center>4</center></td><td><center>2561</center></td><td>2 หลักสูตรผ่านเกณฑ์มาตรฐานสากลสำหรับแพทยศาสตรศึกษา (WFME)</td><td><center>ยุทธศาสตร์</center></td><td><center>= 10 ผ่าน</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>80</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="odd" id="tr_3"><td class="sorting_1"><center>5</center></td><td><center>2561</center></td><td>3 จำนวนของการผ่านเกณฑ์ข้อพัฒนาจากการประเมินของ IMEAC หรือการประเมินตนเอง</td><td><center>ยุทธศาสตร์</center></td><td><center>&gt;= 77 ครั้ง</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>77</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="even" id="tr_5"><td class="sorting_1"><center>6</center></td><td><center>2561</center></td><td>5 ร้อยละของบัณฑิตที่สอบผ่านใบประกอบวิชาชีพเวชกรรม</td><td><center>ยุทธศาสตร์</center></td><td><center>= 100 %</center></td><td><center><span class="label label-danger">ไม่ผ่าน</span></center></td><td><center>100</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="odd" id="tr_6"><td class="sorting_1"><center>7</center></td><td><center>2561</center></td><td>6 คะแนนความพึงพอใจต่อหลักสูตรและผลการจัดการข้อร้องเรียน</td><td><center>ยุทธศาสตร์</center></td><td><center>= 4 สัดส่วน</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>4</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="even" id="tr_7"><td class="sorting_1"><center>8</center></td><td><center>2561</center></td><td>7 ร้อยละสะสมของนิสิตที่เข้าร่วมโครงการส่งเสริมจิตอาสาตลอดหลักสูตร รวม 7 ครั้ง</td><td><center>ยุทธศาสตร์</center></td><td><center>= 80 %</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>80</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="odd" id="tr_8"><td class="sorting_1"><center>9</center></td><td><center>2561</center></td><td>8 ร้อยละของนิสิตแพทย์ที่สำเร็จการศึกษาตามระยะเวลาที่กำหนดในหลักสูตรภายใน 6 ปี</td><td><center>ยุทธศาสตร์</center></td><td><center>= 90 %</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>90</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr><tr role="row" class="even" id="tr_9"><td class="sorting_1"><center>10</center></td><td><center>2561</center></td><td>9 จำนวนสาขาวิชาที่มีความพร้อมในการเปิดหลักสูตรหลังปริญญา</td><td><center>ยุทธศาสตร์</center></td><td><center>&gt;= 2 สาขา</center></td><td><center><span class="label label-success">ผ่าน</span></center></td><td><center>88</center></td><td><center>0</center></td><td><center>0</center></td><td><center>0</center></td></tr></tbody>
											<tfoot></tfoot>
										</table><div id="example_processing" class="dataTables_processing card" style="display: none;">กำลังประมวลผล...</div></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example_info" role="status" aria-live="polite">แสดงรายการที่ 1 ถึง 10 จาก 19 รายการ</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example_previous"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">ก่อนหน้า</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="example_next"><a href="#" aria-controls="example" data-dt-idx="3" tabindex="0" class="page-link">ถัดไป</a></li></ul></div></div></div></div>
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
</div>
				
				
<style>
	#small-box {
		background-color: #ffffff;
	}
	
	#border_main_head{
		border-color: #536872;
	}
	
	#head_table{
		background-color: #536872;
		// border-color: #ffffff;
	}
	
	#body{
		background-color: #e6f7ff;
	}
</style>