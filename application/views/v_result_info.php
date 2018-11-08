<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<style>
	th{
        text-align: left;
	}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">สรุปผลงานตัวชี้วัด</h2>
            </div>
            <div class="box-body">
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
						<form id="frm_modal_add"> <!-- Start form -->
							<div class="form-group"> <!-- Start form-group -->
							<?php $date=""; 
							foreach($result_ind->result() as $rs_ind){ 
								if($rs_ind->indrs_date_edit == ""){
									$date = "ไม่มีการบันทึกผล";
								}else{
									$date = fullDateTH3($rs_ind->indrs_date_edit); //แปลงวันที่
								}
							} //End foreach
							?>
								<table id="" class="table table-bordered">
									<tbody id="tb_info">
											<tr>
												<th width="15%" style="background-color: #eeeeee; align: left;" >ตัวชี้วัด</th>
												<td><?php echo $rs_dfine['ind_name']; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">ปีงบประมาณ</th>
												<td><?php echo $rs_dfine['bgy_name']; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">วันที่บันทึก</th>
												<td><?php echo $date; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">ยุทธศาสตร์</th>
												<td><?php echo $rs_dfine['str_name']; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">กลุ่มตัวชี้วัด</th>
												<td><?php echo $rs_dfine['indgp_name']; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">หน่วยงาน</th>
												<td><?php echo $rs_dfine['side_name']; ?></td>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">ผู้รับผิดชอบ</th>
												<?php if($rs_dfine['resm_name'] == ""){?>
													<td>-</td>
												<?php }else{ ?>
													<td><?php echo $rs_dfine['resm_name']; ?> (<?php echo $rs_dfine['resm_pt_name']; ?>)</td>
												<?php } ?>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">ผู้รับผิดชอบร่วม</th>
												<?php if($rs_ress->num_rows() > 0){?>
													<td>
														<?php foreach($rs_ress->result() as $ress){ ?>
															<?php echo $ress->ress_name; ?> (<?php echo $ress->ress_pt_name; ?>)<br>
														<?php } ?>
													</td>
												<?php }else{?>
													<td>-</td> 
												<?php } ?>
											</tr>
											<tr>
												<th width="15%" style="background-color: #eeeeee;">เป้าหมาย</th>
												<td><?php echo $rs_dfine['opt_symbol']?> <?php echo$rs_dfine['dfine_goal']?> <?php echo$rs_dfine['unt_name'];?> </td>
											</tr>
									</tbody>
								</table>
							</div> <!-- End form-group -->
						</form>
						<br>
						
						<table id="" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th style="width: 15%; text-align: center;">ไตรมาส</th>
									<th style="width: 50%; text-align: center;">ผลงาน</th>
								</tr>
							</thead>
							<tbody id="tb_res" style="text-align: center;">
							<?php $sum_score=0; foreach($result_ind->result() as $index=>$rs_score){ ?>
								<?php if($rs_score->indrs_score == 0){?>
									<tr>
										<td><?php echo $index+1; ?></td>
										<td>-</td>
									</tr>
								<?php }else{ ?>
									<tr>
										<td><?php echo $index+1; ?></td>
										<td><?php echo $rs_score->indrs_score; ?></td>
									</tr>
								<?php } ?>
								<?php $sum_score += $rs_score->indrs_score;?>
							<?php } ?>
							<?php if($sum_score == 0){?>
								<tr style="background-color: #d9d9d9;">
									<td>ผลงานรวมทั้งหมด</td>
									<td>-</td>
								</tr>
							<?php }else{ ?>	
								<tr style="background-color: #d9d9d9;">
									<td>ผลงานรวมทั้งหมด</td>
									<td><?php echo $sum_score;?></td>
								</tr>
							<?php } ?>
								<?php if($rs_dfine['dfine_status_assessment'] == 0){ ?>
									<tr style="background-color: #ffd699;">
										<td>สถานะการประเมิน</td>
										<td>ยังไม่ประเมินผล</td>
									
								<?php }else if($rs_dfine['dfine_status_assessment'] == 1){ ?>
									<tr style="background-color: #ffb3b3;">
										<td>สถานะการประเมิน</td>
										<td>ไม่ผ่าน</td>
									</tr>
								<?php }else if($rs_dfine['dfine_status_assessment'] == 2){ ?>
									<tr style="background-color: #b3ffb3;">
										<td>สถานะการประเมิน</td>
										<td>ผ่าน</td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot></tfoot>
						</table>
                    </div>
                </div><!-- End  col-md-12 -->
				<a type="button" class="btn btn-default pull-left" href="<?php echo site_url('/Result_indicator')?>">ย้อนกลับ</a>
            </div>
        </div>
    </div>
</div>