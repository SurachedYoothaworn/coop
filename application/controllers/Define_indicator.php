<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Define_indicator extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_define_indicator','dfine');
		$this->load->model('M_Define_responsibility_main','dfine_res');
		$this->load->model('M_Define_responsibility_sub','ress');
    }

	public function index(){
		$data["rs_budget_year"] = $this->dfine->get_budget_year()->result();
		$data["rs_side"] = $this->dfine->get_side()->result();
		$data["rs_strategy"] = $this->dfine->get_strategy()->result();
		$data["rs_indicator_group"] = $this->dfine->get_indicator_group()->result();
		$data["rs_unit"] = $this->dfine->get_unit()->result();
		$data["rs_operator"] = $this->dfine->get_operator()->result();
		$this->output('v_define_indicator',$data);
    } //End fn index
	
	public function get_data(){
		$rs_dfine_data = $this->dfine->get_all();
        $data = array(); 
        if($rs_dfine_data->num_rows() > 0){
            // $seq = 1;
			foreach($rs_dfine_data->result() as $dfine){
				//ปุ่มเพิ่มผู้รับผิดชอบ
				$btn_rm  = '<center>';
				$rs_resm = $this->dfine_res->get_by_id($dfine->dfine_id);
				if($rs_resm->num_rows() != 0){
					$btn_rm .= '<button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_success').'"data-toggle="modal" data-tooltip="ผู้รับผิดชอบ" href="#modal_edit_indicator" onclick="get_info_resm('.$dfine->dfine_id.')">';
					$btn_rm .= '<i class="glyphicon glyphicon-user" style="color:white" ></i>';
					$btn_rm .= '<i class="glyphicon glyphicon-ok" style="color:white" ></i>';
					$btn_rm .= '</button>&nbsp';
				}else{
					$btn_rm .= '<button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_danger').'"data-toggle="modal" href="" onclick="" disabled >';
					$btn_rm .= '<i class="glyphicon glyphicon-user" style="color:white" ></i>';
					$btn_rm .= '<i class="glyphicon glyphicon-remove" style="color:white" ></i>';
					$btn_rm .= '</button>&nbsp';
				}
                $btn_rm .= '<a id="btn_del" name="btn_del" class="'.$this->config->item('btn_warning').'" data-tooltip="กำหนดผู้รับผิดชอบ"  href="'.site_url('/Define_responsibility_main/detail/'.$dfine->dfine_id.'').'" >';
                $btn_rm .= '<i class="glyphicon glyphicon-cog" style="color:white"></i>';
                $btn_rm .= '</a></center>';
				//ปุ่มดำเนินการ
				$btn_opt  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_primary').'" data-toggle="modal" data-tooltip="รายละเอียดรายการตัวชี้วัด" href="#modal_info" onclick="get_data_info('.$dfine->dfine_id.')">';
                $btn_opt .= '<i class="glyphicon glyphicon-info-sign" style="color:white" ></i>';
                $btn_opt .= '</button>&nbsp';
                $btn_opt .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขข้อมูลรายการตัวชี้วัด"  onclick="open_modal('.$dfine->dfine_id.')">';
                $btn_opt .= '<i class="glyphicon glyphicon-pencil" style="color:white"></i>';
                $btn_opt .= '</button>&nbsp';
				$btn_opt .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบข้อมูลรายการตัวชี้วัด" onclick="update_status_define_indicator('.$dfine->dfine_id.')">';
                $btn_opt .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn_opt .= '</button></center>&nbsp';
				
				// if($ind->ind_description == "" || $ind->ind_description == null){
					// $dfine_data = array(
						// "ind_seq" => "<center>".$seq."</center>",
						// "ind_id" => $ind->ind_id,
						// "ind_name" => $ind->ind_name,
						// "ind_description" => "-",
						// "btn_manage" => $btn,
					// );
					// array_push($data, $dfine_data);
				// }else{
					$dfine_data = array(
						// "ind_seq" => "<center>".$seq."</center>",
						"dfine_id" 			=>	$dfine->dfine_id,
						"ind_name" 			=>	$dfine->ind_name,
						"ind_description" 	=>	$dfine->ind_description,
						"bgy_name" 			=>	$dfine->bgy_name,
						"str_name" 			=>	$dfine->str_name,
						"indgp_name" 		=>	$dfine->indgp_name,
						"opt_name"			=>	$dfine->opt_name,
						"opt_symbol"		=>	$dfine->opt_symbol,
						"dfine_goal" 		=>	$dfine->dfine_goal,
						"unt_name"			=>	$dfine->unt_name,
						"side_name" 		=>	$dfine->side_name,
					//สว่นของ id
						"ind_id" 			=> 	$dfine->ind_id,
						"bgy_id" 			=> 	$dfine->bgy_id,
						"str_id" 			=> 	$dfine->str_id,
						"indgp_id" 			=> 	$dfine->indgp_id,
						"opt_id" 			=> 	$dfine->opt_id,
						"unt_id" 			=> 	$dfine->unt_id,
						"side_id" 			=> 	$dfine->side_id,
						"dfine_status_action" 		=> 	$dfine->dfine_status_action,
						"dfine_status_assessment"	=> 	$dfine->dfine_status_assessment,
						"btn_rm"			=>	$btn_rm,
						"btn_opt"			=>	$btn_opt,
					);
					array_push($data, $dfine_data);
				// }
				// $seq++;
            } //End for
        } //End if
        echo json_encode($data);
	} //End fn get_data
	
	public function get_data_info(){
		$dfine_id = $this->input->post('dfine_id');
		$rs_data = $this->dfine->get_by_id($dfine_id)->result(); //ข้อมูลตัวชี้วัด
		$rs_resm = $this->dfine_res->get_by_id($dfine_id); //ผู้รับผิดชอบ
		foreach($rs_data as $row){
			$data  = '<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee; align: left;" >ตัวชี้วัด</th>';
			$data .=	'<td>'.$row->ind_name.'</td>';
			$data .='</tr>';
			$data .='<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee;">ปีงบประมาณ</th>';
			$data .=	'<td>'.$row->bgy_name.'</td>';
			$data .='</tr>';
			$data .='<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee;">ยุทธศาสตร์</th>';
			$data .=	'<td>'.$row->str_name.'</td>';
			$data .='</tr>';
			$data .='<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee;">กลุ่มตัวชี้วัด</th>';
			$data .=	'<td>'.$row->indgp_name.'</td>';
			$data .='</tr>';
			$data .='<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee;">เป้าหมาย</th>';
			$data .=	'<td>'.$row->opt_name.' '.$row->dfine_goal.' '.$row->unt_name.'</td>';
			$data .='</tr>';
			$data .='<tr>';
			$data .=	'<th width="20%" style="background-color: #eeeeee;">หน่วยงาน</th>';
			$data .=	'<td>'.$row->side_name.'</td>';
			$data .='</tr>';
			if($rs_resm->num_rows() > 0){
				foreach($rs_resm->result() as $resm){
					$rs_ress = $this->ress->get_by_id($resm->resm_id);
					$data .='<tr>';
					$data .=	'<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบ</th>';
					$data .=	'<td>'.$resm->resm_name.' (<b>ตำแหน่ง : </b>'.$resm->resm_pt_name.')</td>';
					$data .='</tr>';
					$data .='<tr>';
					$data .=	'<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบร่วม</th>';
					$data .='<td>';
					foreach($rs_ress->result() as $ress){
						$data .=	''.$ress->ress_name.' (<b>ตำแหน่ง : </b>'.$ress->ress_pt_name.')<br>';
					}//End foreach
					$data .='</td>';
					$data .='</tr>';
				}//End foreach
			}else{
				$data .='<tr>';
				$data .=	'<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบ</th>';
				$data .=	'<td>-</td>';
				$data .='</tr>';
				$data .='<tr>';
				$data .=	'<th width="20%" style="background-color: #eeeeee;">ผู้รับผิดชอบร่วม</th>';
				$data .='<td>-</td>';
				$data .='</tr>';
			}
		} //End foreach
		echo json_encode($data);
	} //End fn get_data_info
	
	public function save_data(){
		$ind_id = $this->input->post('indicator');
		$bgy_id = $this->input->post('budget_year');
		$side_id = $this->input->post('side');
		$str_id = $this->input->post('strategy');
		$indgp_id = $this->input->post('indicator_group');
		$opt_id = $this->input->post('operator');
		$unt_id = $this->input->post('unit');
		$dfine_goal = $this->input->post('goal');
		$chk_btn = $this->input->post('chk_btn');
		$dfine_id = $this->input->post('dfine_id');
		if($chk_btn == 1){
			//กรณีแก้ไข
			$this->dfine->update($dfine_id,$dfine_goal,$ind_id,$bgy_id,$str_id,$indgp_id,$opt_id,$unt_id,$side_id);
			echo json_encode(1);
		}else if($chk_btn == "" || $chk_btn == null || $chk_btn == 0){
			//กรณีเพิ่ม
			$this->dfine->dfine_goal = $dfine_goal;
			$this->dfine->dfine_ind_id = $ind_id;
			$this->dfine->dfine_bgy_id = $bgy_id;
			$this->dfine->dfine_str_id = $str_id;
			$this->dfine->dfine_indgp_id = $indgp_id;
			$this->dfine->dfine_opt_id = $opt_id;
			$this->dfine->dfine_unt_id = $unt_id;
			$this->dfine->dfine_side_id = $side_id;
			$this->dfine->insert();
			echo json_encode(0);
		}
	} //End fn save_data
	
	public function edit_define_indicator(){
		$dfine_id = $this->input->post('dfine_id');
		$data = $this->dfine->get_by_id($dfine_id)->row_array();
		
		// echo "<pre>";
		// print_r($this->dfine->get_by_id($dfine_id)->result());die;
		// echo "</pre>";
		
		echo json_encode($data);
	}
	
	public function edit_value_indicator(){
		$ind_id = $this->input->post('ind_id');
		$bgy_id = $this->input->post('bgy_id');
		$data = $this->dfine->get_indicator_edit($ind_id,$bgy_id)->result();
		
		// echo "<pre>";
		// print_r($data);die;
		// echo "</pre>";
		
		echo json_encode($data);
	}
	
	public function update_status_define_indicator(){
        $dfine_id = $this->input->post('dfine_id');
        $this->dfine->update_status($dfine_id);
        echo json_encode(true); 
    } //End fn update_status_indicator
	
	function get_indicator_by_bgy(){
		$bgy_id = $this->input->post('bgy_id');
		$data = $this->dfine->get_indicator($bgy_id)->result();
		echo json_encode($data); 
	} //End fn get_indicator_by_bgy
	
	function get_info_resm(){
		$dfine_id = $this->input->post('dfine_id');
		$rs_resm = $this->dfine_res->get_by_id($dfine_id);
		$seq=1;
		$resm_dept = "";
		$row="";
		
		foreach($rs_resm->result() as $rs_m){
			if($resm_dept != $rs_m->resm_dept){
				$resm_dept = $rs_m->resm_dept;
				$row .='<tr>';
				$row .= 	'<td colspan="3" style="background: #eeeeee;"><b>ฝ่ายงาน :</b> '.$rs_m->resm_dept.'</td>';
				$row .='</tr>';
			}
			$row .= '<tr>';
			$row .= 		'<td><center>'.$seq++.'</center></td>';
			$row .= 		'<td>'.$rs_m->resm_name.'</td>';
			$row .= 		'<td>'.$rs_m->resm_dept.'</td>';
			$row .= '</tr>';
		}       
		echo json_encode($row); 
	}//End fn get_info_resm
}
?>