<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Dashborad extends kpims_Controller {

	public function __construct(){
        parent::__construct();
		// $this->load->model('M_Define_responsibility_main','dfine_res');
		// $this->load->model('M_Define_responsibility_sub','dfine_ress');
		$this->load->model('M_kpi_define_indicator','dfine');
		$this->load->model('M_kpi_result_indicator','rsind');
		$this->load->model('M_kpi_budget_year','bgy');
		$this->load->model('M_kpi_report_indicator','rpind');
		$this->load->model('M_Define_responsibility_main','resm');
		$this->load->model('M_kpi_dashborad','dsh');
		$this->load->model('M_kpi_strategy','str');
		$this->load->model('M_kpi_indicator_group','indgp');
		$this->load->model('M_kpi_indicator','ind');
		
    }
	
	public function index(){
		// $arr1 = [1,2,3];
		// $arr2 = [2,3,4,5];
		// $data['rs1'] = $arr1;
		// $data['rs2'] = $arr2;
		// pre($arr1);
		// pre($arr2);
		$day = date("d"); 
		$month = date("d"); 
		$year = date("Y")+543;
		if($day >= "1" && $month >= "10"){
			$sum = $year+1;
		}else{
			$sum = $year;
		}
		$count=0;
		$bgy_chk=0;
		$rs_bgy = $this->dfine->get_budget_year();
		foreach($rs_bgy->result() as $bgy){
			if($bgy->bgy_name == strval($sum)){
				$count=1;
				$bgy_chk = $bgy->bgy_id;
			}
		}
		if($count == 1){
			$data["bgy_chk"] = $bgy_chk;
		}else {
			$data["bgy_chk"] = 1;
		}
		
		$data["rs_bgy"] = $this->dfine->get_budget_year();
		$this->output('v_dashborad',$data);
	}
	
	public function get_data_search(){
		$bgy_id = $this->input->post('bgy_id');
		// $indgp_id = $this->input->post('indgp_id');
		// $resm_id = $this->input->post('resm_id');
		
		$rs_search = $this->rpind->get_search_by_id($bgy_id,0,0);
		// pre($rs_search->result());
		$arr_score = array();
		$data = array(); 	
		foreach($rs_search->result() as $search){
			$result_score = $this->rsind->get_result_by_id($search->dfine_id);
			foreach($result_score->result() as $score){
				array_push($arr_score,$score->indrs_score);
			}
			if($search->dfine_status_assessment == 1){
				$chk_assessment = '<span class="label label-danger">ไม่ผ่าน</span>';
			}else if($search->dfine_status_assessment == 2){
				$chk_assessment = '<span class="label label-success">ผ่าน</span>';
			}else if($search->dfine_status_assessment == 0){
				$chk_assessment = '<span class="label label-warning">ยังไม่ประเมินผล</span>';
			}
			
			
			if($search->dfine_follow_status == 0){
				$btn_chk_follow = '<center><input class="follow_ind" id="follow_ind" name="follow_ind" type="checkbox" value="'.$search->dfine_id.'" onclick="select_following_indicator('.$search->dfine_id.')" ></center>';
			}else if($search->dfine_follow_status == 1){
				$btn_chk_follow = '<center><input class="follow_ind" id="follow_ind" name="follow_ind" type="checkbox" value="'.$search->dfine_id.'" onclick="select_following_indicator('.$search->dfine_id.')" checked></center>';
			}
			
			$dfine_data = array(
				"dfine_id" 			=>	$search->dfine_id,
				"ind_name" 			=>	$search->ind_name,
				"bgy_name" 			=>	$search->bgy_name,
				"indgp_name" 		=>	$search->indgp_name,
				"opt_symbol"		=>	$search->opt_symbol,
				"dfine_goal" 		=>	$search->dfine_goal,
				"unt_name"			=>	$search->unt_name,
				"dfine_status_assessment"	=> 	$chk_assessment,
				"btn_chk_follow"		=>	$btn_chk_follow,
				"rs_score"			=>	$arr_score,	
			);
			array_push($data, $dfine_data);
			$arr_score = array();
		}//End foreach
		echo json_encode($data);
    } //End fn get_data_search
	
	function get_summary_indicator(){
		$bgy_id = $this->input->post('bgy_id');
		
		$ind_faile = $this->rpind->get_indicator_faile($bgy_id,0,0)->row_array();
		$ind_pass = $this->rpind->get_indicator_pass($bgy_id,0,0)->row_array();
		$ind_not = $this->rpind->get_indicator_notprocessed($bgy_id,0,0)->row_array();
		$bgy_name = $this->bgy->get_name($bgy_id)->row_array();
		// $resm_name = $this->resm->get_name_by_id($resm_id)->row_array();
		
		
		$data = array(); 
		$rs_data = array(
			"ind_not" 		=>	$ind_not['dfine_status_assessment'],
			"ind_pass" 		=>	$ind_pass['dfine_status_assessment'],
			"ind_faile" 	=>	$ind_faile['dfine_status_assessment'],
			"bgy_id" 		=>	$bgy_id,
			"bgy_name" 		=>	$bgy_name['bgy_name'],
			// "resm_name"		=>	$resm_name['resm_name']
		);
		array_push($data, $rs_data);
		echo json_encode($data);
	}
	
	function get_chart_by_bgy(){
		$bgy_id = $this->input->post('bgy_id');
		$rs_bgy = $this->bgy->get_by_id($bgy_id)->row_array();;
		$rs_str = $this->str->get_all();
		// pre($bgy_id);
		$data = array(); 
		// $resm_name = $this->resm->get_name_by_id($resm_id)->row_array();
		foreach($rs_str->result() as $str){
			$ind_faile = $this->dsh->get_indicator_faile(1,$bgy_id,$str->str_id)->row_array();
			$ind_pass = $this->dsh->get_indicator_pass(1,$bgy_id,$str->str_id)->row_array();
			$ind_not = $this->dsh->get_indicator_notprocessed(1,$bgy_id,$str->str_id)->row_array();
			$ra_data = array(
				"ind_not" 		=>	$ind_not['dfine_status_assessment'],
				"ind_pass" 		=>	$ind_pass['dfine_status_assessment'],
				"ind_faile" 	=>	$ind_faile['dfine_status_assessment'],
				"str_id"		=>	$str->str_id,
				"str_name"		=>	$str->str_name,
				// "bgy_id" 		=>	$bgy->bgy_id,
				"bgy_name" 		=>	$rs_bgy['bgy_name'], 
				// "resm_name"		=>	$resm_name['resm_name']
			);
			array_push($data, $ra_data);
		}
		// pre($data);
		echo json_encode($data);
	}//End fn get_chart_by_bgy
	
	function get_chart_by_indgp(){
		$bgy_id = $this->input->post('bgy_id');
		$rs_bgy = $this->bgy->get_by_id($bgy_id)->row_array();
		$rs_indgp = $this->indgp->get_all();
		$data = array(); 
		// $resm_name = $this->resm->get_name_by_id($resm_id)->row_array();
		foreach($rs_indgp->result() as $indgp){
			$ind_faile = $this->dsh->get_indicator_faile(2,$bgy_id,$indgp->indgp_id)->row_array();
			$ind_pass = $this->dsh->get_indicator_pass(2,$bgy_id,$indgp->indgp_id)->row_array();
			$ind_not = $this->dsh->get_indicator_notprocessed(2,$bgy_id,$indgp->indgp_id)->row_array();
			$ra_data = array(
				"ind_not" 		=>	$ind_not['dfine_status_assessment'],
				"ind_pass" 		=>	$ind_pass['dfine_status_assessment'],
				"ind_faile" 	=>	$ind_faile['dfine_status_assessment'],
				"indgp_id"		=>	$indgp->indgp_id,
				"indgp_name"		=>	$indgp->indgp_name,
				"bgy_name" 		=>	$rs_bgy['bgy_name'], 
				// "resm_name"		=>	$resm_name['resm_name']
			);
			array_push($data, $ra_data);
		}
		echo json_encode($data);
	} //End fn get_chart_by_indgp
	
	function get_ind_info(){
		$status_ind = $this->input->post('status_ind');
		$bgy_id = $this->input->post('bgy_id');
		if($status_ind == 3){ //ตัวชี้วัดทั้งหมดของปีที่เลือก
			$data = $this->rpind->get_name_indicator_by_status_assessment($bgy_id,$status_ind)->result();
			$row  ='<thead>';
			$row .=		'<tr>';
			$row .=			'<th style="width: 5%; text-align: center;">ลำดับ</th>';
			$row .=			'<th style="width: 30%; text-align: center;">ตัวชี้วัด</th>';
			$row .=	        '<th style="width: 25%; text-align: center;">กลุ่มตัวชี้วัด</th>';
			$row .=	    '</tr>';
			$row .='</thead>';
			$row .='<tbody id="tb_modal_add_resm">';
			
			$chk_head=0;
			$seq=1;
			foreach($data as $index => $rs_ind_all){ 
				if($rs_ind_all->str_id != $chk_head){
					$chk_head =  $rs_ind_all->str_id;
					$row .='<tr>';
					$row .= 	'<td colspan="3" style="background: #eeeeee;"><b>ยุทธศาสตร์ :</b>'.$rs_ind_all->str_name.'</td>';
					$row .='</tr>';
				}
					
				$row .='<tr>';
				$row .= 	'<td style="text-align: center;">'.$seq.'</td>';
				$row .= 	'<td>'.$rs_ind_all->ind_name.'</td>';
				$row .= 	'<td style="text-align: center;">'.$rs_ind_all->indgp_name.'</td>';
				$row .='</tr>';
				$seq++;
			} //End foreach	
			$row .='</tbody>';
		}else{
			$data = $this->rpind->get_name_indicator_by_status_assessment($bgy_id,$status_ind);
			// pre($data->result());
			$row  ='<thead>';
			$row .=		'<tr>';
			$row .=			'<th style="width: 5%; text-align: center;">ลำดับ</th>';
			$row .=			'<th style="width: 30%; text-align: center;">ตัวชี้วัด</th>';
			$row .=	        '<th style="width: 25%; text-align: center;">กลุ่มตัวชี้วัด</th>';
			$row .=	    '</tr>';
			$row .='</thead>';
			$row .='<tbody id="tb_modal_add_resm">';
			
			$chk_head=0;
			$seq=1;
			if($data->num_rows() > 0){	
				foreach($data->result() as $index => $rs_ind_all){
								
						if($rs_ind_all->str_id != $chk_head){
							$chk_head =  $rs_ind_all->str_id;
							$row .='<tr>';
							$row .= 	'<td colspan="3" style="background: #eeeeee;"><b>ยุทธศาสตร์ :</b>'.$rs_ind_all->str_name.'</td>';
							$row .='</tr>';
						}
						$row .='<tr>';
						$row .= 	'<td style="text-align: center;">'.$seq.'</td>';
						$row .= 	'<td>'.$rs_ind_all->ind_name.'</td>';
						$row .= 	'<td style="text-align: center;">'.$rs_ind_all->indgp_name.'</td>';
						$row .='</tr>';
					$seq++;
				} //End foreach	
			}else{
				$row .='<tr>';
				$row .= 	'<td colspan="3" style="background: #eeeeee; color: red; text-align: center;">ไม่มีข้อมูล</td>';
				$row .='</tr>';
			}
			$row .='</tbody>';
		}
		echo json_encode($row);
	}//End fn get_ind_info
	
	function get_chart_follow_indicator(){
		$dfine_id = $this->input->post('dfine_id');
		$rs_ind = $this->rpind->get_report_indicator_by_id($dfine_id);
		$rs_ind_result = $this->rpind->get_ind_result_by_id($dfine_id);
		
		// pre($rs_ind->result());
		// pre($rs_ind_result->result());
		
		$rs_score = array(); 
		foreach($rs_ind_result->result() as $indrs){
			$arr_score = array(
				"indrs_quarter" 	=>	$indrs->indrs_quarter,
				"indrs_score" 		=>	$indrs->indrs_score,
			);
			array_push($rs_score, $arr_score);
		}
		// pre($rs_score);
		
		foreach($rs_ind->result() as $ind){
			if($ind->dfine_status_assessment == 1){
				$chk_assessment = '<span class="label label-danger">ไม่ผ่าน</span>';
			}else if($ind->dfine_status_assessment == 2){
				$chk_assessment = '<span class="label label-success">ผ่าน</span>';
			}else if($ind->dfine_status_assessment == 0){
				$chk_assessment = '<span class="label label-warning">ยังไม่ประเมินผล</span>';
			}
			$data = array(); 
			$rs_data = array(
				"dfine_id" 		=>	$ind->dfine_id,
				"ind_name" 		=>	$ind->ind_name,
				"resm_name"		=>	$ind->resm_name,
				"dfine_goal" 	=>	$ind->dfine_goal,
				"rs_score" 		=>	$rs_score,
				"dfine_status_assessment"	=>	$chk_assessment,
				"status_assessment"			=>	$ind->dfine_status_assessment,
				"indgp_name"	=>	$ind->indgp_name,
				"str_name"		=>	$ind->str_name,
				"opt_symbol"	=>	$ind->opt_symbol,
				"unt_name"		=>	$ind->unt_name,
			);
			array_push($data, $rs_data);
		}
		// pre($data);
		echo json_encode($data);
	}//End fn get_chart_follow_indicator
	
	function get_following_indicator(){
		// $dfine_id = $this->input->post('follow_ind_checked');
		$dfine_id = $this->input->post('dfine_id');
		$bgy_id = $this->input->post('bgy_id');
		$rs_follow_status = $this->dfine->get_follow_status_by_dfine_id($dfine_id)->row_array();
		
		if($rs_follow_status['dfine_follow_status'] == 0){
			$this->dfine->update_follow_status($dfine_id,1);
		}else if($rs_follow_status['dfine_follow_status'] == 1){
			$this->dfine->update_follow_status($dfine_id,0);
		}
		echo json_encode(true);
	} //End fn get_follow_indicator
	
	function get_chart_following_indicator(){
		$bgy_id = $this->input->post('bgy_id');
		$rs_ind = $this->rpind->get_report_indicator_by_follow_status($bgy_id);
		$arr_score = array();
		$data = array();
		if($rs_ind->num_rows() > 0){
			foreach($rs_ind->result() as $ind){
				$rs_ind_result = $this->rpind->get_ind_result_by_id($ind->dfine_id);
				$sum_score=0;
				foreach($rs_ind_result->result() as $indrs){
					if($ind->dfine_id == $indrs->indrs_dfind_id){
						$sum_score += $indrs->indrs_score;
					}
				}
				$rs_data = array(
					"dfine_id" 		=>	$ind->dfine_id,
					"ind_name" 		=>	$ind->ind_name,
					"resm_name"		=>	$ind->resm_name,
					"dfine_goal" 	=>	$ind->dfine_goal,
					"indgp_name"	=>	$ind->indgp_name,
					"str_name"		=>	$ind->str_name,
					"bgy_name"		=>	$ind->bgy_name,
					"sum_score"		=>	$sum_score,
				);
				array_push($data, $rs_data);
			}
			echo json_encode($data);
		}else{
			echo json_encode(0);
		}
	} //End fn get_chart_following_indicator
	
	function get_gauge_following(){
		$bgy_id = $this->input->post('bgy_id');
		$rs_ind = $this->rpind->get_report_indicator_by_follow_status($bgy_id);
		$arr_score = array();
		$data = array();
		if($rs_ind->num_rows() > 0){
			foreach($rs_ind->result() as $ind){
				$rs_ind_result = $this->rpind->get_ind_result_by_id($ind->dfine_id);
				$sum_score=0;
				foreach($rs_ind_result->result() as $indrs){
					if($ind->dfine_id == $indrs->indrs_dfind_id){
						$sum_score += $indrs->indrs_score;
					}
				}
				$rs_data = array(
					"dfine_id" 		=>	$ind->dfine_id,
					"ind_name" 		=>	$ind->ind_name,
					"resm_name"		=>	$ind->resm_name,
					"dfine_goal" 	=>	$ind->dfine_goal,
					"indgp_name"	=>	$ind->indgp_name,
					"str_name"		=>	$ind->str_name,
					"bgy_name"		=>	$ind->bgy_name,
					"sum_score"		=>	$sum_score,
				);
				array_push($data, $rs_data);
			}
			// pre($data);
			echo json_encode($data);
		}else{
			echo json_encode(0);
		}
	}
}
?>