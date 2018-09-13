<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Result_indicator extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        // $this->load->model('M_kpi_define_indicator','dfine');
		$this->load->model('M_Define_responsibility_main','dfine_res');
		$this->load->model('M_kpi_result_indicator','rsind');
		$this->load->model('M_kpi_define_indicator','dfine');
    }

	public function index(){
        // $data['rs_ind'] = $this->ind->get_all();
		// pre($this->rsind->get_all()->result());
		$this->output('v_result_indicator');
    }
	
	public function get_data(){
		$permission_us = $this->session->userdata('us_permission');
		if($permission_us == 1){ //ผู้ใช้ที่เป็น Admin
			$rs_dfine_data = $this->rsind->get_all();
			// pre($rs_dfine_data->result());
			$data = array(); 
			if($rs_dfine_data->num_rows() > 0){
				// $seq = 1;
				foreach($rs_dfine_data->result() as $rsind){
					if($rsind->dfine_status_assessment != 0){
						//ปุ่มบันทึกผลตัวชี้วัด
						$btn_save_result  = '<center>';
						$btn_save_result .= '<a id="btn_save_result" name="btn_save_result" class="'.$this->config->item('btn_success').'" data-toggle="modal" data-tooltip="ไม่สามารถบันทึกผลตัวชี้วัดได้"  disabled>';
						$btn_save_result .= '<i class="glyphicon glyphicon-floppy-save" style="color:white"></i>';
						$btn_save_result .= '</a></center>';
					}else{
						//ปุ่มบันทึกผลตัวชี้วัด
						$btn_save_result  = '<center>';
						$btn_save_result .= '<a id="btn_save_result" name="btn_save_result" class="'.$this->config->item('btn_success').'" data-toggle="modal" data-tooltip="บันทึกผลตัวชี้วัด"  href="#modal_save_result" onclick="get_data_save_result('.$rsind->dfine_id.')" >';
						$btn_save_result .= '<i class="glyphicon glyphicon-floppy-save" style="color:white"></i>';
						$btn_save_result .= '</a></center>';
					}
					
					if($rsind->dfine_status_action == 0){
						//ปุ่มยืนยันผลตัวชี้วัด
						$btn_confirm  = '<center>';
						$btn_confirm .= '<a id="btn_del" name="btn_del" class="'.$this->config->item('btn_primary').'" data-tooltip="กรุณาบันทึกผลตัวชี้วัด"   disabled>';
						$btn_confirm .= '<i class="glyphicon glyphicon-floppy-saved" style="color:white"></i>';
						$btn_confirm .= '</a></center>';				
					}else{
						//ปุ่มยืนยันผลตัวชี้วัด
						$btn_confirm  = '<center>';
						$btn_confirm .= '<a id="btn_del" name="btn_del" class="'.$this->config->item('btn_primary').'" data-tooltip="ประเมินผล"  data-toggle="modal" href="#modal_assessment" onclick="get_data_assessment('.$rsind->dfine_id.')">';
						$btn_confirm .= '<i class="glyphicon glyphicon-floppy-saved" style="color:white"></i>';
						$btn_confirm .= '</a></center>';		
					}
					//ปุ่มดำเนินการ
					$btn_opt  = '<center><a id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_primary').'" data-tooltip="รายละเอียดผลตัวชี้วัด" href="'.site_url('/Result_info/Show_info/'.$rsind->dfine_id.'').'">';
					$btn_opt .= '<i class="glyphicon glyphicon-info-sign" style="color:white" ></i>';
					$btn_opt .= '</a>&nbsp';
						
					if($rsind->dfine_status_action == 0){
						$btn_action = '<center><span class="label label-danger">ยังไม่ดำเนินการ</span></center>';
					}else if($rsind->dfine_status_action == 1){
						$btn_action = '<center><span class="label label-warning">กำลังดำเนินการ</span></center></center>';
					}else if($rsind->dfine_status_action == 2){
						$btn_action = '<center><span class="label label-success">เสร็จสิ้น</span></center></center>';
					}
					
					if($rsind->dfine_status_assessment == 0){
						$btn_assessment = '<center><span class="label label-warning">ยังไม่ประเมินผล</span></center>';
					}else if($rsind->dfine_status_assessment == 1){
						$btn_assessment = '<center><span class="label label-danger">ไม่ผ่าน</span></center>';
					}else if($rsind->dfine_status_assessment == 2){
						$btn_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
					}
						
					$rsind_data = array(
						// "ind_seq" => "<center>".$seq."</center>",
						"dfine_id" 			=>	$rsind->dfine_id,
						"ind_name" 			=>	$rsind->ind_name,
						"ind_description" 	=>	$rsind->ind_description,
						"bgy_name" 			=>	$rsind->bgy_name,
						"str_name" 			=>	$rsind->str_name,
						"indgp_name" 		=>	$rsind->indgp_name,
						"opt_name"			=>	$rsind->opt_name,
						"opt_symbol"		=>	$rsind->opt_symbol,
						"dfine_goal" 		=>	$rsind->dfine_goal,
						"unt_name"			=>	$rsind->unt_name,
						"side_name" 		=>	$rsind->side_name,
					//สว่นของ id
						"ind_id" 			=> 	$rsind->ind_id,
						"bgy_id" 			=> 	$rsind->bgy_id,
						"str_id" 			=> 	$rsind->str_id,
						"indgp_id" 			=> 	$rsind->indgp_id,
						"opt_id" 			=> 	$rsind->opt_id,
						"unt_id" 			=> 	$rsind->unt_id,
						"side_id" 			=> 	$rsind->side_id,
						"status_action"		=>	$btn_action,
						"status_assessment"	=> 	$btn_assessment,
						"btn_save_result"	=>	$btn_save_result,
						"btn_confirm"		=>	$btn_confirm,
						"btn_opt"			=>	$btn_opt,
					);
					array_push($data, $rsind_data);
					// $seq++;
				} //End for
			} //End if
			echo json_encode($data);
		}else{ //ผู้ทั่วไป
			$rs_dfine_data = $this->rsind->get_by_ps_id($this->session->userdata('us_ps_id'));
			// pre($rs_dfine_data->result());die;
			$data = array(); 
			if($rs_dfine_data->num_rows() > 0){
				// $seq = 1;
				foreach($rs_dfine_data->result() as $rsind){
					if($rsind->dfine_status_assessment != 0){
						//ปุ่มบันทึกผลตัวชี้วัด
						$btn_save_result  = '<center>';
						$btn_save_result .= '<a id="btn_save_result" name="btn_save_result" class="'.$this->config->item('btn_success').'" data-toggle="modal" data-tooltip="ไม่สามารถบันทึกผลตัวชี้วัดได้"  disabled>';
						$btn_save_result .= '<i class="glyphicon glyphicon-floppy-save" style="color:white"></i>';
						$btn_save_result .= '</a></center>';
					}else{
						//ปุ่มบันทึกผลตัวชี้วัด
						$btn_save_result  = '<center>';
						$btn_save_result .= '<a id="btn_save_result" name="btn_save_result" class="'.$this->config->item('btn_success').'" data-toggle="modal" data-tooltip="บันทึกผลตัวชี้วัด"  href="#modal_save_result" onclick="get_data_save_result('.$rsind->dfine_id.')" >';
						$btn_save_result .= '<i class="glyphicon glyphicon-floppy-save" style="color:white"></i>';
						$btn_save_result .= '</a></center>';
					}
					
					if($rsind->dfine_status_action == 0){
						//ปุ่มยืนยันผลตัวชี้วัด
						$btn_confirm  = '<center>';
						$btn_confirm .= '<a id="btn_del" name="btn_del" class="'.$this->config->item('btn_primary').'" data-tooltip="กรุณาบันทึกผลตัวชี้วัด"   disabled>';
						$btn_confirm .= '<i class="glyphicon glyphicon-floppy-saved" style="color:white"></i>';
						$btn_confirm .= '</a></center>';				
					}else{
						//ปุ่มยืนยันผลตัวชี้วัด
						$btn_confirm  = '<center>';
						$btn_confirm .= '<a id="btn_del" name="btn_del" class="'.$this->config->item('btn_primary').'" data-tooltip="ประเมินผล"  data-toggle="modal" href="#modal_assessment" onclick="get_data_assessment('.$rsind->dfine_id.')">';
						$btn_confirm .= '<i class="glyphicon glyphicon-floppy-saved" style="color:white"></i>';
						$btn_confirm .= '</a></center>';		
					}
					//ปุ่มดำเนินการ
					$btn_opt  = '<center><a id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_primary').'" data-toggle="modal" data-tooltip="รายละเอียดผลตัวชี้วัด" href="'.site_url('/Result_info/Show_info/'.$rsind->dfine_id.'').'">';
					$btn_opt .= '<i class="glyphicon glyphicon-info-sign" style="color:white" ></i>';
					$btn_opt .= '</a>&nbsp';
						
					if($rsind->dfine_status_action == 0){
						$btn_action = '<center style="color: red;" >ยังไม่ดำเนินการ</center>';
					}else if($rsind->dfine_status_action == 1){
						$btn_action = '<center style="color: orange;" >กำลังดำเนินการ</center>';
					}else if($rsind->dfine_status_action == 2){
						$btn_action = '<center style="color: green;" >เสร็จสิ้น</center>';
					}
					
					if($rsind->dfine_status_assessment == 0){
						$btn_assessment = '<center><span class="label label-warning">ไม่มีผลประเมิน</span></center>';
					}else if($rsind->dfine_status_assessment == 1){
						$btn_assessment = '<center><span class="label label-danger">ไม่ผ่าน</span></center>';
					}else if($rsind->dfine_status_assessment == 2){
						$btn_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
					}
						
					$rsind_data = array(
						// "ind_seq" => "<center>".$seq."</center>",
						"dfine_id" 			=>	$rsind->dfine_id,
						"ind_name" 			=>	$rsind->ind_name,
						"ind_description" 	=>	$rsind->ind_description,
						"bgy_name" 			=>	$rsind->bgy_name,
						"str_name" 			=>	$rsind->str_name,
						"indgp_name" 		=>	$rsind->indgp_name,
						"opt_name"			=>	$rsind->opt_name,
						"opt_symbol"		=>	$rsind->opt_symbol,
						"dfine_goal" 		=>	$rsind->dfine_goal,
						"unt_name"			=>	$rsind->unt_name,
						"side_name" 		=>	$rsind->side_name,
					//สว่นของ id
						"ind_id" 			=> 	$rsind->ind_id,
						"bgy_id" 			=> 	$rsind->bgy_id,
						"str_id" 			=> 	$rsind->str_id,
						"indgp_id" 			=> 	$rsind->indgp_id,
						"opt_id" 			=> 	$rsind->opt_id,
						"unt_id" 			=> 	$rsind->unt_id,
						"side_id" 			=> 	$rsind->side_id,
						"status_action"		=>	$btn_action,
						"status_assessment"	=> 	$btn_assessment,
						"btn_save_result"	=>	$btn_save_result,
						"btn_confirm"		=>	$btn_confirm,
						"btn_opt"			=>	$btn_opt,
					);
					array_push($data, $rsind_data);
					// $seq++;
				} //End for
				echo json_encode($data);
			}else{
				echo json_encode(0);
			}
		}//if check permission
	} //End fn get_data
	
	function get_data_save_result(){
		$dfine_id = $this->input->post('dfine_id');
		
		// $rs_dfine = $this->rsind->get_by_id($dfine_id);
		// pre($rs_dfine->result());
		
		$rs_dfine = $this->rsind->get_by_id($dfine_id)->row_array();
		// pre($rs_dfine);
		
		$result_ind = $this->rsind->get_result_by_id($dfine_id);
		// pre($result_ind->result());
		
		$row  = '<form id="frm_modal_add">';
		$row .=	'<div class="form-group">';
		$row .=	'		<div class = "col-md-12">';
		$row .=	'			<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">ตัวชี้วัด</label>';
		$row .=	'			<div class="col-md-10" id="">';
		$row .=	'				 <textarea name="ind_add" id="ind_add" class="form-control" rows="2" cols="50" disabled>'.$rs_dfine['ind_name'].'</textarea>';
		$row .=	'			</div>';
		$row .=	'		</div>';
		$row .=	'	</div><label></label>';
		$row .=	'	<div class="form-group">';
		$row .=	'		<div class = "col-md-12">';
		$row .=	'			<label class="col-md-2 control-label" style="padding: 8px; text-align: right;">เป้าหมาย</label>';
		$row .=	'			<div class="col-md-10" id="">';
		$row .=	'				<input type="text" class="form-control" value="'.$rs_dfine['opt_symbol'].' '.$rs_dfine['dfine_goal'].' '.$rs_dfine['unt_name'].'" name="ind_add" id="ind_add" disabled>';
		$row .=	'			</div>';
		$row .=	'		</div>';
		$row .=	'	</div><label></label>';
		$row .=	'	<div class="form-group">';
		$row .=	'		<div class = "col-md-12">';

		$row .=	'			<label class="col-md-2 control-label" style="text-align: right;">การดำเนินการ</label>';
		$row .=	'			<div class="col-md-3" id=""> ';
		$row .=	'				<input  type="radio" value="0" name="status_action" id="status_action_1" ';
								if($rs_dfine['dfine_status_action']==0){
									$row .= 'checked>';
								}else{
									$row .= 'disabled>';
								};
		$row .=	'				<span class="label label-danger">ยังไม่ดำเนินการ</span>';
		$row .=	'			</div>';
		$row .=	'			<div class="col-md-3"> ';
		$row .=	'				<input  type="radio" value="1" name="status_action" id="status_action_2" ';
								if($rs_dfine['dfine_status_action']==1){
									$row .= 'checked>';
								}else{
									$row .= '>';
								};
		$row .=	'				<span class="label label-warning">กำลังดำเนินการ</span>';
		$row .=	'			</div>';
		$row .=	'			<div class="col-md-3" id="">'; 
		$row .=	'				<input  type="radio" value="2" name="status_action" id="status_action_3" ';
								if($rs_dfine['dfine_status_action']==2){
									$row .= 'checked>';
								}else{
									$row .= '>';
								};
		$row .=	'				<span class="label label-success">เสร็จสิ้น</span>';
		$row .=	'			</div>';
		
		$row .=	'		</div>';
		$row .=	'	</div><label></label>';
		$row .=	'	<div class="form-group">'; 
		$row .=	'		<table id="" class="table table-bordered">';
		$row .=	'			<thead>';
        $row .=	'                      <tr>';
        $row .=	'                          <th style="width: 5%; text-align: center;">ไตรมาส</th>';
        $row .=	'                          <th style="width: 30%; text-align: center;">ผลงาน</th>';
        $row .=	'                      </tr>';
        $row .=	'                  </thead>';
		$row .=	'			<tbody id="tb_modal_info_resm">';
							foreach($result_ind->result() as $index=>$rs_ind){
							$index++;
								if($rs_ind->indrs_score == 0){
		$row .=	'				<tr>';
		$row .=	'					<td style="text-align: center;">'.$rs_ind->indrs_quarter.'</td>';
		$row .=	'					<td><input type="number" class="form-control" value="" name="score" id="score_'.$index.'" placeholder="กรุณากรอกผลงานของท่าน"  onkeyup="change_action()"></td>';
		$row .=	'				</tr>';
								}else{
		$row .=	'				<tr>';
		$row .=	'					<td style="text-align: center;">'.$rs_ind->indrs_quarter.'</td>';
		$row .=	'					<td><input type="number" class="form-control" value="'.$rs_ind->indrs_score.'" name="score" id="score_'.$index.'" placeholder="กรุณากรอกผลงานของท่าน"  onkeyup="change_action()"></td>';
		$row .=	'				</tr>';						
								}
							}
		$row .=	'			</tbody>';
		$row .=	'		</table>';
		$row .=	'	</div>';
		$row .=	'	<input type="hidden" id="hid_dfine_id" value="'.$dfine_id.'" >';
		$row .=	'</form>';
		echo json_encode($row);
	}
	
	function get_data_assessment(){
		$dfine_id = $this->input->post('dfine_id');
		$rs_dfine = $this->rsind->get_by_id($dfine_id)->row_array();
		$result_ind = $this->rsind->get_result_by_id($rs_dfine['dfine_id']);
		// pre($rs_dfine);
		// pre($result_ind->result());
		$sum_score=0;
		$date="";
		foreach($result_ind->result() as $rs_ind){
			$sum_score += $rs_ind->indrs_score;
			if($rs_ind->indrs_date_edit == ""){
				$date = "ไม่มีการบันทึกผล";
			}else{
				$date = fullDateTH3($rs_ind->indrs_date_edit); //แปลงวันที่
			}
		} //End foreach
		
		$row  =	'<table id="" class="table table-bordered">';
		$row .=	'	<tbody id="tb_info">';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">ตัวชี้วัด</th>';
		$row .=	'			<td>'.$rs_dfine['ind_name'].'</td>';
		$row .=	'		</tr>';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">วันที่บันทึก</th>';
		$row .=	'			<td>'.$date.'</td>';
		$row .=	'		</tr>';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">หน่วยงาน</th>';
		$row .=	'			<td>'.$rs_dfine['side_name'].'</td>';
		$row .=	'		</tr>';
		$row .=	'		<tr>';
						if($rs_dfine['resm_pt_name'] == ""){
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบ</th>';
		$row .=	'			<td>ไม่มีผู้รับผิดชอบตัวชี้วัด</td>';
						}else{
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบ</th>';
		$row .=	'			<td>'.$rs_dfine['resm_name'].' ('.$rs_dfine['resm_pt_name'].')</td>';						
						}
		$row .=	'		</tr>';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">เป้าหมาย</th>';
		$row .=	'			<td>'.$rs_dfine['opt_symbol'].' '.$rs_dfine['dfine_goal'].' '.$rs_dfine['unt_name'].'</td>';
		$row .=	'		</tr>';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">ผลงานทั้งหมด</th>';
		$row .=	'			<td>'.$sum_score.'</td>';
		$row .=	'		</tr>';
		$row .=	'		<tr>';
		$row .=	'			<th width="20%" style="background-color: #eeeeee;">ผลประเมิน</th>';
		$row .=	'			<td>';
		
		//กรณียังไม่ทำการประเมินผล
		if($rs_dfine['dfine_status_assessment'] == 0){
								if($rs_dfine['opt_id'] == 1){ //เช็ค >
									if($sum_score > $rs_dfine['dfine_goal']){
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}else{
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}
								}else if($rs_dfine['opt_id'] == 2){ //เช็ค  <
									if($sum_score < $rs_dfine['dfine_goal']){
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}else{
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}
								}
								else if($rs_dfine['opt_id'] == 3){ //เช็ค  =
									if($sum_score == $rs_dfine['dfine_goal']){
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}else{
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}
								}
								else if($rs_dfine['opt_id'] == 4){ //เช็ค >=
									if($sum_score >= $rs_dfine['dfine_goal']){
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}else{
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}
								}
								else if($rs_dfine['opt_id'] == 5){ //เช็ค <=
									if($sum_score <= $rs_dfine['dfine_goal']){
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}else{
										$row .=	'				<div class="col-md-2"> ';
										$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
										$row .=	'					<span class="label label-success">ผ่าน</span>';
										$row .=	'				</div>';
										$row .=	'				<div class="col-md-3"> ';
										$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
										$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
										$row .=	'				</div>';
									}
								} //End check
		}
		//กรณีทำการประเมินผลแล้ว
		if($rs_dfine['dfine_status_assessment'] == 1){ //ไม่ผ่าน
			$row .=	'				<div class="col-md-2"> ';
			$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" >';
			$row .=	'					<span class="label label-success">ผ่าน</span>';
			$row .=	'				</div>';
			$row .=	'				<div class="col-md-3"> ';
			$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" checked>';
			$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
			$row .=	'				</div>';
		}
		if($rs_dfine['dfine_status_assessment'] == 2){ //ผ่าน
			$row .=	'				<div class="col-md-2"> ';
			$row .=	'					<input  type="radio" value="2" name="status_assessment" id="status_assessment_1" checked>';
			$row .=	'					<span class="label label-success">ผ่าน</span>';
			$row .=	'				</div>';
			$row .=	'				<div class="col-md-3"> ';
			$row .=	'					<input  type="radio" value="1" name="status_assessment" id="status_assessment_0" >';
			$row .=	'					<span class="label label-danger">ไม่ผ่าน</span>';
			$row .=	'				</div>';
			
		}
		
		$row .=	'			<span class="text-danger">* หากประเมินผลแล้วจะไม่สามารถบันทึกผลตัวชี้วัดได้อีก</span></td>';
		$row .=	'		</tr>';
		$row .=	'	</tbody>';
		$row .=	'</table>';
		$row .=	'<table id="" class="table table-bordered">';
		$row .=	'	<thead>';
		$row .=	'   	<tr>';
		$row .=	'   	    <th style="width: 5%; text-align: center;">ไตรมาส</th>';
		$row .=	'   	    <th style="width: 30%; text-align: center;">ผลงาน</th>';
		$row .=	'   	</tr>';
		$row .=	'   </thead>';
		$row .=	'	<tbody id="tb_modal_info_resm">';
					foreach($result_ind->result() as $index=>$rs_ind){
					$index++;
						if($rs_ind->indrs_score == 0){
		$row .=	'		<tr style="text-align: center;">';
		$row .=	'			<td style="text-align: center;">'.$rs_ind->indrs_quarter.'</td>';
		$row .=	'			<td>-</td>';
		$row .=	'		</tr>';
						}else{
		$row .=	'		<tr style="text-align: center;">';
		$row .=	'			<td style="text-align: center;">'.$rs_ind->indrs_quarter.'</td>';
		$row .=	'			<td>'.$rs_ind->indrs_score.'</td>';
		$row .=	'		</tr>';						
						}
					}
		$row .=	'	</tbody>';
		$row .=	'</table>';
		$row .=	'<input type="hidden" id="hid_assessment_dfine_id" value="'.$dfine_id.'" >';
		echo json_encode($row);
	}
	
	function save_result(){
		$arr_score = $this->input->post('arr_score');
		
		if($arr_score[0] == ""){
			// pre("null");
		}
		$dfine_id = $this->input->post('dfine_id');
		$status_action = $this->input->post('status_action');
		$result_ind = $this->rsind->get_result_by_id($dfine_id);
		foreach($result_ind->result() as $index=>$rs_ind){
			$this->rsind->update_score($arr_score[$index],date("Y-m-d"),$rs_ind->indrs_id);
		}
		$this->dfine->update_status_action($status_action,$dfine_id);
		echo json_encode(true);
	}
	
	function save_assessment(){
		$status_assessment = $this->input->post('status_assessment');
		$dfine_id = $this->input->post('dfine_id');
		$this->dfine->update_status_assessment($status_assessment,$dfine_id);
		echo json_encode(true);
	}
	
} //End class
?>