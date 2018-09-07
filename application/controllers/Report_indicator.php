<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Report_indicator extends kpims_Controller {

    public function __construct(){
        parent::__construct();
		// $this->load->model('M_Define_responsibility_main','dfine_res');
		// $this->load->model('M_Define_responsibility_sub','dfine_ress');
		$this->load->model('M_kpi_define_indicator','dfine');
		$this->load->model('M_kpi_result_indicator','rsind');
		$this->load->model('M_kpi_budget_year','bgy');
		$this->load->model('M_kpi_indicator_group','indgp');
		$this->load->model('M_kpi_report_indicator','rpind');
    }

	public function index(){
        // $data['rs_ind'] = $this->ind->get_all();
		// pre($this->rsind->get_all()->result());
		// $dfine_id = $this->input->post('dfine_id');
		// $data['dfine_id'] = $dfine_id ;
		// $data['rs_bgy'] = $this->bgy->get_all();
		$data["rs_bgy"] = $this->dfine->get_budget_year();
		$data['rs_indgp'] = $this->indgp->get_all();
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$data['rs_person'] = json_decode($json, TRUE);
		$this->output('v_report_indicator', $data);
    }
	
	public function get_all_data_search(){
		$rs_all_data_search = $this->rpind->get_all();
		$arr_score = array();
		$data = array(); 	
		foreach($rs_all_data_search->result() as $search){
			$result_score = $this->rsind->get_result_by_id($search->dfine_id);
			foreach($result_score->result() as $score){
				array_push($arr_score,$score->indrs_score);
			}
			if($search->dfine_status_assessment == 1){
				$chk_assessment = '<center><span class="label label-danger">ไม่ผ่าน</span></center>';
			}else{
				$chk_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
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
				"rs_score"			=>	$arr_score,	
			);
			array_push($data, $dfine_data);
			$arr_score = array();
		}//End foreach
		echo json_encode($data);
    } //End fn get_all_data_search
	
	public function get_data_search(){
		$bgy_id = $this->input->post('bgy_id');
		$indgp_id = $this->input->post('indgp_id');
		$resm_id = $this->input->post('resm_id');
		
		$rs_search = $this->rpind->get_search_by_id($bgy_id,$indgp_id,$resm_id);
		$arr_score = array();
		$data = array(); 	
		foreach($rs_search->result() as $search){
			$result_score = $this->rsind->get_result_by_id($search->dfine_id);
			foreach($result_score->result() as $score){
				array_push($arr_score,$score->indrs_score);
			}
			if($search->dfine_status_assessment == 1){
				$chk_assessment = '<center><span class="label label-danger">ไม่ผ่าน</span></center>';
			}else{
				$chk_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
			}
			$dfine_data = array(
				"dfine_id" 			=>	$search->dfine_id,
				"ind_name" 			=>	$search->ind_name,
				// "ind_description" 	=>	$search->ind_description,
				"bgy_name" 			=>	$search->bgy_name,
				// "str_name" 			=>	$search->str_name,
				"indgp_name" 		=>	$search->indgp_name,
				// "opt_name"			=>	$search->opt_name,
				"opt_symbol"		=>	$search->opt_symbol,
				"dfine_goal" 		=>	$search->dfine_goal,
				"unt_name"			=>	$search->unt_name,
				// "side_name" 		=>	$search->side_name,
				// "ind_id" 			=> 	$search->ind_id,
				// "bgy_id" 			=> 	$search->bgy_id,
				// "str_id" 			=> 	$search->str_id,
				// "indgp_id" 			=> 	$search->indgp_id,
				// "opt_id" 			=> 	$search->opt_id,
				// "unt_id" 			=> 	$search->unt_id,
				// "side_id" 			=> 	$search->side_id,
				// "dfine_status_action" 		=> 	$search->dfine_status_action,
				"dfine_status_assessment"	=> 	$chk_assessment,
				// "btn_rm"			=>	$btn_rm,
				// "btn_opt"			=>	$btn_opt,
				"rs_score"			=>	$arr_score,	
			);
			array_push($data, $dfine_data);
			$arr_score = array();
		}//End foreach
		echo json_encode($data);
    } //End fn get_data_search
	
	function get_graph(){
		$bgy_id = $this->input->post('bgy_id');
		// pre($bgy_id);
		$ind_faile = $this->rpind->get_indicator_faile($bgy_id)->row_array();
		$ind_pass = $this->rpind->get_indicator_pass($bgy_id)->row_array();
		$ind_not = $this->rpind->get_indicator_notprocessed($bgy_id)->row_array();
		$bgy_name = $this->bgy->get_name($bgy_id)->row_array();
		// pre($ind_faile->row_array());
		// pre($ind_faile);
		
		$data = array(); 
		$dfine_data = array(
			"ind_not" 		=>	$ind_not['dfine_status_assessment'],
			"ind_pass" 		=>	$ind_pass['dfine_status_assessment'],
			"ind_faile" 	=>	$ind_faile['dfine_status_assessment'],
			"bgy_id" 		=>	$bgy_id,
			"bgy_name" 		=>	$bgy_name['bgy_name'],
		);
		array_push($data, $dfine_data);
		// pre($data);
		
		
		echo json_encode($data);
	}
	
	function get_all_graph(){
		$bgy_id = $this->input->post('bgy_id');
		$rs_bgy = $this->bgy->get_all();
		
		$data = array(); 
		foreach($rs_bgy->result() as $bgy){
			$ind_pass = $this->rpind->get_indicator_pass($bgy->bgy_id)->row_array();
			$ind_faile = $this->rpind->get_indicator_faile($bgy->bgy_id)->row_array();
			$ind_not = $this->rpind->get_indicator_notprocessed($bgy->bgy_id)->row_array();
			$ra_data = array(
				"ind_not" 		=>	$ind_not['dfine_status_assessment'],
				"ind_pass" 		=>	$ind_pass['dfine_status_assessment'],
				"ind_faile" 	=>	$ind_faile['dfine_status_assessment'],
				"bgy_id" 		=>	$bgy->bgy_id,
				"bgy_name" 		=>	$bgy->bgy_name,
			);
			array_push($data, $ra_data);
		}
		echo json_encode($data);
	} //End fn get_all_graph
}
?>