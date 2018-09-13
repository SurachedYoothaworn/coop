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
	
	// public function get_all_data_search(){
		// $rs_all_data_search = $this->rpind->get_all();
		// $arr_score = array();
		// $data = array(); 	
		// foreach($rs_all_data_search->result() as $search){
			// $result_score = $this->rsind->get_result_by_id($search->dfine_id);
			// foreach($result_score->result() as $score){
				// array_push($arr_score,$score->indrs_score);
			// }
			// if($search->dfine_status_assessment == 1){
				// $chk_assessment = '<center><span class="label label-danger">ไม่ผ่าน</span></center>';
			// }else{
				// $chk_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
			// }
			// $dfine_data = array(
				// "dfine_id" 			=>	$search->dfine_id,
				// "ind_name" 			=>	$search->ind_name,
				// "bgy_name" 			=>	$search->bgy_name,
				// "indgp_name" 		=>	$search->indgp_name,
				// "opt_symbol"		=>	$search->opt_symbol,
				// "dfine_goal" 		=>	$search->dfine_goal,
				// "unt_name"			=>	$search->unt_name,
				// "dfine_status_assessment"	=> 	$chk_assessment,
				// "rs_score"			=>	$arr_score,	
			// );
			// array_push($data, $dfine_data);
			// $arr_score = array();
		// }//End foreach
		// echo json_encode($data);
    // } //End fn get_all_data_search
	
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
			}else if($search->dfine_status_assessment == 2){
				$chk_assessment = '<center><span class="label label-success">ผ่าน</span></center>';
			}else if($search->dfine_status_assessment == 0){
				$chk_assessment = '<center><span class="label label-warning">ยังไม่ประเมินผล</span></center>';
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
	} //End fn get_graph
	
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
	
	function export_excel(){
		$bgy_id = $this->input->post('bgy_id_excel');
		$indgp_id = $this->input->post('indgp_id_excel');
		$resm_id = $this->input->post('resm_id_excel');
		// pre($_POST);
		
		// $bgy_id = $this->input->post('bgy_id');
		// $indgp_id = $this->input->post('indgp_id');
		// $resm_id = $this->input->post('resm_id');
		
		$rs_search = $this->rpind->get_search_export($bgy_id,$indgp_id,$resm_id);
		// pre($resm_id);
		// pre($rs_search->result());
		$row  = '<table id="table" border="1" style="font-family: TH SarabunPSK; font-size: 26px;">';
		$row .= '	<thead>';
		$row .= '		<tr>';
		$row .= '			<th colspan="10" style="text-align: center;">ตารางสรุปผลการประเมินตัวชี้วัด</th>';
		$row .= '		</tr>';
		$row .= '		<tr>';
		$row .= '			<th rowspan="2">ลำดับ</th>';
		$row .= '			<th rowspan="2">ปีงบประมาณ</th>';
		$row .= '			<th rowspan="2">ตัวชี้วัด</th>';
		$row .= '			<th rowspan="2">กลุ่มตัวชี้วัด</th>';
		$row .= '			<th rowspan="2">เป้าหมาย</th>';
		$row .= '			<th rowspan="2">ผลประเมิน</th>';
		$row .= '			<th colspan="4">ผลประเมินแบ่งตามไตรมาส</th>';
		$row .= '		</tr>';
		$row .= '		<tr>';
		$row .= '			<th>1<br>(ต.ค. - ธ.ค.)</th>';
		$row .= '			<th>2<br>(ม.ค. - มี.ค.)</th>';
		$row .= '			<th>3<br>(เม.ย. - มิ.ย.)</th>';
		$row .= '			<th>4<br>(ก.ค. - ก.ย.)</th>';
		$row .= '		</tr>';
		$row .= '	</thead>';
		$row .= '	<tbody>';
					$count=1;
					foreach($rs_search->result() as $search){
						$result_score = $this->rsind->get_result_by_id($search->dfine_id);
						// pre($result_score->result());
							$row .= '<tr>';
							$row .= '	<td style="vertical-align: middle; text-align: center;">'.$count.'</td>';
							$row .= '	<td style="vertical-align: middle; text-align: center;">'.$search->bgy_name.'</td>';
							$row .= '	<td style="vertical-align: middle">'.$search->ind_name.'</td>';
							$row .= '	<td style="vertical-align: middle; text-align: center;">'.$search->indgp_name.'</td>';
							if($search->opt_id == 3){
								$row .= "	<td style='vertical-align: middle; text-align: center;'>'".$search->opt_symbol." ".$search->dfine_goal." ".$search->unt_name."</td>";
								
							}else{
								$row .= "	<td style='vertical-align: middle; text-align: center;'>".$search->opt_symbol." ".$search->dfine_goal." ".$search->unt_name."</td>";
							}
							if($search->dfine_status_assessment == 1){
								$row .= '	<td style="vertical-align: middle; text-align: center;">ไม่ผ่าน</td>';
							}else if($search->dfine_status_assessment == 2){
								$row .= '	<td style="vertical-align: middle; text-align: center;">ผ่าน</td>';
							}else if($search->dfine_status_assessment == 0){
								$row .= '	<td style="vertical-align: middle; text-align: center;">ยังไม่ประเมินผล</td>';
							}
							foreach($result_score->result() as $score){
								$row .= '	<td style="vertical-align: middle; text-align: center;">'.$score->indrs_score.'</td>';
							}
						$row .= '</tr>';
						$count++;
					}//End foreach
		$row .= '	</tbody>';
		$row .= '	<tfoot></tfoot>';
		$row .= '</table>';
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header("Content-Encoding: UTF-8");
		// header("Content-Type: application/vnd.ms-excel");
		
		// header("Content-Type: application/xls");
		// header("Content-Disposition: attachment; filename=summary_indicator.xls");
		// header("Pragma: no-cache");
		
		
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Encoding: UTF-8");
		header('Content-type: application/ms-excel');
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=summary_indicator.xls");
		header("Pragma: no-cache"); // บอก Browser ว่าไม่ต้อง เก็บ cache 
		echo $row;
	} //End fn export_excel
	
	
}

?>
