<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Define_responsibility_main extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_Define_responsibility_main','dfine_res');
		$this->load->model('M_Define_responsibility_sub','dfine_ress');
		$this->load->model('M_kpi_define_indicator','dfine');
		$this->load->model('M_kpi_result_indicator','rsind');
    }

	public function detail($dfine_id){
		$data['dfine_id'] = $dfine_id;
		$data['rs_dfine'] = $this->dfine->get_by_id($dfine_id)->result();
		//เช็คปุ่มลบทั้งหมด
		$data['rs_resm'] = $this->dfine_res->get_by_id($dfine_id)->result();
		$this->output('v_define_responsibility_main', $data);
    } //End fn detail
	
	function get_data(){
		$permission_us = $this->session->userdata('us_permission');
		$dfine_id = $this->input->post('dfine_id');
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		$rs_resm = $this->dfine_res->get_by_id($dfine_id);
		$row = "";
		$seq = 1;
		if($rs_resm->num_rows() > 0){
			$resm_dept = "";
			foreach($rs_resm->result() as $rs_m){
				$rs_ress = $this->dfine_ress->get_by_id($rs_m->resm_id);
				if($resm_dept != $rs_m->resm_dept){
					$resm_dept = $rs_m->resm_dept;
					$row .='<tr>';
					$row .= 	'<td colspan="5" style="background: #eeeeee;"><b>ฝ่ายงาน :</b> '.$rs_m->resm_dept.'</td>';
					$row .='</tr>';
				}
				$row .='<tr>';
				$row .= 	'<td style="text-align: center;">'.$seq.'</td>';
				$row .=		'<td>'.$rs_m->resm_name.'</td>';
				$row .=		'<td>'.$rs_m->resm_pt_name.'</td>';
				$row .=		'<td>';
				$row .=		'<center>';
				if($rs_ress->num_rows() > 0){
					$row .= 		'<button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_success').' "data-toggle="modal" data-tooltip="จัดการผู้รับผิดชอบร่วม" href="#modal_info_ress" onclick="get_info_ress('.$rs_m->resm_id.')">';
					$row .= 		'<i class="glyphicon glyphicon-user" style="color:white" ></i>';
					$row .= 		'<i class="glyphicon glyphicon-ok" style="color:white" ></i>';
					$row .= 		'</button>&nbsp';
				}else{
					$row .= 		'<button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_danger').' "data-toggle="modal" data-tooltip="ไม่มีผู้รับผิดชอบร่วม" href="" onclick="" disabled>';
					$row .= 		'<i class="glyphicon glyphicon-user" style="color:white" ></i>';
					$row .= 		'<i class="glyphicon glyphicon-remove" style="color:white" ></i>';
					$row .= 		'</button>&nbsp';
				}
				
				$row .=			'<a id="btn-add-tab" name="btn-add-tab" class="'.$this->config->item('btn_primary').'" data-tooltip="เพิ่มผู้รับผิดชอบร่วม" href="#" onclick="get_resm(1,'.$rs_m->resm_id.','.$rs_m->resm_dm_id.')">';
				$row .=			'<i class="glyphicon glyphicon-plus" style="color:white"></i><i class="glyphicon glyphicon-user" style="color:white" ></i></a></center>';
				$row .= 	'</td>';
				$row .=		'<td>';
				if($permission_us == $this->config->item("ref_ug_main_side")){ //หัวหน้าฝ่ายงาน
					$row .= 		'<center><button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ไม่สามารถลบตนเองได้" onclick="" disabled>';
				}else{
					$row .= 		'<center><button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบผู้รับผิดชอบตัวชี้วัด" onclick="del_resm('.$rs_m->resm_id.','.$dfine_id.')">';	
				}
				$row .= 		'<i class="glyphicon glyphicon-trash" style="color:white"></i>';
				$row .= 		'</button></center>';
				$row .=		'</td>';
				$row .='</tr>';
				$seq ++;
			}//End foreach
		}else{
			$row .='<tr>';
			$row .= 	'<td colspan="5" style="text-align: center; color: red; background: #eeeeee;" >ไม่มีข้อมูล</td>';
			$row .='</tr>';
		}
		echo json_encode($row);
	} //End fn get_data
	
	function get_resm(){
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		$dfine_id = $this->input->post('dfine_id');
		$rs_resm = $this->dfine_res->get_by_id($dfine_id);
		$dpt = 0;
		$count=0;
		$row  ='<thead>';
		$row .=		'<tr>';
		$row .=			'<th style="width: 17%; text-align: center;"> เลือกผู้รับผิดชอบ</th>';
        $row .=			'<th style="width: 25%; text-align: center;">ชื่อ - สกุล</th>';
        $row .=	        '<th style="width: 30%; text-align: center;">ตำแหน่ง</th>';
		$row .=			'<th style="width: 30%; text-align: center;">แผนก</th>';
        $row .=	    '</tr>';
		$row .='</thead>';
		$row .='<tbody id="tb_modal_add_resm">';
		foreach($rs_person['data_result'] as $rs_ps){ //คนทั้งหมด
			$count=0;
			foreach($rs_resm->result() as $resm){ //คนที่ถูกใช้
				if($rs_ps['ps_id'] == $resm->resm_ps_id){
					$count++;
				}
			} //End foreach.
			$count_main = 0;
			if($rs_ps['dm_main_dept'] == 1){
				if($count == 0){
					$count_main++;
					if($dpt != $rs_ps['dm_id']){
						$dpt = $rs_ps['dm_id'];
						if($rs_ps['ptm_id'] == 1){
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน1 :</b> '.$rs_ps['dm_title_th'].'</td>';
							$row .='</tr>';
							$row .='<tr>';
							$row .= 	'<td style="text-align: center;" ><input class="flat-red" type="radio" id="chk_ps_add" name="chk_ps_add" value="'.$rs_ps["ps_id"].'" class="chk_preson_add"></td>';
							$row .= 	'<td>'.$rs_ps["pf_title_th"].''.$rs_ps["ps_fname_th"].' '.$rs_ps["ps_lname_th"].'</td>';
							$row .= 	'<td>'.$rs_ps["pt_title_th"].'</td>';
							$row .= 	'<td>'.$rs_ps["dm_title_th"].'</td>';
							$row .='</tr>';
							
						}else{
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน2 :</b> '.$rs_ps['dm_title_th'].'</td>';
							$row .='</tr>';
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="text-align:center; color:red;" >ยังไม่กำหนดหัวหน้าฝ่ายงาน</td>';
							$row .='</tr>';
						}
					}
				}
			}
		} //End foreach
		$row .='</tbody>';
		echo json_encode($row);
	} //End fn get_resm
	
	function get_resm_dept(){
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		$dfine_id = $this->input->post('dfine_id');
		$rs_resm = $this->dfine_res->get_by_id($dfine_id);
		$dpt = "";
		$row  ='<thead>';
		$row .=		'<tr>';
		$row .=			'<th style="width: 17%; text-align: center;"> เลือกผู้รับผิดชอบ</th>';
        $row .=			'<th style="width: 30%; text-align: center;">ชื่อ - สกุล</th>';
        $row .=	        '<th style="width: 25%; text-align: center;">ตำแหน่ง</th>';
		$row .=			'<th style="width: 30%; text-align: center;">แผนก</th>';
        $row .=	    '</tr>';
		$row .='</thead>';
		$row .='<tbody id="tb_modal_add_resm_buh">';
		foreach($rs_person['data_result'] as $rs_ps){ //คนทั้งหมด
			$count=0;
			foreach($rs_resm->result() as $resm){ //คนที่ถูกใช้
				if($rs_ps['ps_id'] == $resm->resm_ps_id){
					$count++;
				}
			} //End foreach.
			$count_main = 0;
			if($rs_ps['dm_main_dept'] == 2){
				if($count == 0){
					$count_main++;
					if($dpt != $rs_ps['dm_id']){
						$dpt = $rs_ps['dm_id'];
						if($rs_ps['ptm_id'] == 1){
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน1 :</b> '.$rs_ps['dm_title_th'].'</td>';
							$row .='</tr>';
							$row .='<tr>';
							$row .= 	'<td style="text-align: center;" ><input class="flat-red" type="radio" id="chk_ps_add" name="chk_ps_add" value="'.$rs_ps["ps_id"].'" class="chk_preson_add"></td>';
							$row .= 	'<td>'.$rs_ps["pf_title_th"].''.$rs_ps["ps_fname_th"].' '.$rs_ps["ps_lname_th"].'</td>';
							$row .= 	'<td>'.$rs_ps["pt_title_th"].'</td>';
							$row .= 	'<td>'.$rs_ps["dm_title_th"].'</td>';
							$row .='</tr>';
							
						}else{
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน2 :</b> '.$rs_ps['dm_title_th'].'</td>';
							$row .='</tr>';
							$row .='<tr>';
							$row .= 	'<td colspan="4" style="text-align:center; color:red;" >ยังไม่กำหนดหัวหน้าฝ่ายงาน</td>';
							$row .='</tr>';
						}
						
					}
				}
			}
		} //End foreach
		$row .='</tbody>';
		echo json_encode($row);
	} //End fn get_resm_dept
	
	function get_ress(){
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		$resm_id = $this->input->post('resm_id');
		$dfine_id = $this->input->post('dfine_id');
		// $resm_dm_id = $this->input->post('resm_dm_id');
	
		// $rs_resm = $this->dfine_res->get_all();
		$rs_resm = $this->dfine_res->get_resm_by_id($resm_id);
		$rs_ress = $this->dfine_ress->get_by_id($resm_id);
		$dpt = "";
		$row  ='<thead>';
		$row .=		'<tr>';
		$row .=			'<th style="width: 17%; text-align: center;"><input type="checkbox" name="checkAll_add" id="checkAll_add" onclick="checkAll_person_add()">&nbsp;เลือกทั้งหมด</th>';
        $row .=			'<th style="width: 30%; text-align: center;">ชื่อ - สกุล</th>';
        $row .=	        '<th style="width: 25%; text-align: center;">ตำแหน่ง</th>';
		$row .=			'<th style="width: 30%; text-align: center;">แผนก</th>';
        $row .=	    '</tr>';
		$row .='</thead>';
		$row .='<tbody id="tb_modal_add_resm">';
		foreach($rs_person['data_result'] as $rs_ps){ //คนทั้งหมด
			$count_main=0;
			foreach($rs_resm->result() as $resm){ //คนที่ถูกใช้ ของผู้รับผิดชอบหลัก
				if($rs_ps['ps_id'] == $resm->resm_ps_id ){
					if($resm->resm_dfine_id == $dfine_id){
					$count_main++;	
					}
				}
				$count_sub=0;
				foreach($rs_ress->result() as $ress ){
					if($rs_ps['ps_id'] == $ress->ress_ps_id){
						if($resm->resm_dfine_id == $dfine_id){
							$count_sub++;
						}else{
							$count_sub--;
						}
					}
				}
			} //End foreach
			if($count_main == 0 && $count_sub == 0){
				// pre($resm->resm_dm_id); die;
				if($resm->resm_dm_id == $rs_ps["dm_id"]){
					if($dpt != $rs_ps['dm_title_th']){
						$dpt = $rs_ps['dm_title_th'];
						$row .='<tr>';
						$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน :</b> '.$rs_ps['dm_title_th'].'</td>';
						$row .='</tr>';
					}
					$row .='<tr>';
					$row .= 	'<td style="text-align: center;" ><input type="checkbox" id="chk_ps_add" name="chk_ps_add" value="'.$rs_ps["ps_id"].'" class="chk_preson_add"></td>';
					$row .= 	'<td>'.$rs_ps["pf_title_th"].''.$rs_ps["ps_fname_th"].' '.$rs_ps["ps_lname_th"].'</td>';
					$row .= 	'<td>'.$rs_ps["pt_title_th"].'</td>';
					$row .= 	'<td>'.$rs_ps["dm_title_th"].'</td>';
					$row .='</tr>';
					$row .='<input type="hidden" id="hid_resm_id" value="'.$resm_id.'" >';
				}
			}
		} //End foreach
		$row .='</tbody>';
		echo json_encode($row);
		
		
		
		
		
	} //End fn get_ress
	
	function save_resm(){
		$dfine_id = $this->input->post('dfine_id');
		$ps_checked = $this->input->post('ps_id');
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		
		foreach($rs_person['data_result'] as $rs_ps){
			if($rs_ps['ps_id'] == $ps_checked){
				$this->dfine_res->resm_name = $rs_ps["pf_title_th"].''.$rs_ps["ps_fname_th"].' '.$rs_ps["ps_lname_th"];
				$this->dfine_res->resm_pt_name = $rs_ps["pt_title_th"];
				$this->dfine_res->resm_dm_id = $rs_ps["dm_id"];
				$this->dfine_res->resm_dept = $rs_ps["dm_title_th"];
				$this->dfine_res->resm_ps_id = $rs_ps["ps_id"];
				$this->dfine_res->resm_dfine_id = $dfine_id;
				$last_id = $this->dfine_res->insert_resm();
				$this->rsind->update_resm($last_id, $dfine_id);
			}
		}
		// print_r($ps_checked);
		echo json_encode(true);
	} //End fn save_resm
	
	function save_ress(){
		$resm_id = $this->input->post('resm_id');
		$ps_checked = $this->input->post('ps_checked');
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		
		foreach($rs_person['data_result'] as $rs_ps){
			foreach($ps_checked as $ps_chk){
				if($rs_ps['ps_id'] == $ps_chk){
					$this->dfine_ress->ress_name = $rs_ps["pf_title_th"].''.$rs_ps["ps_fname_th"].' '.$rs_ps["ps_lname_th"];
					$this->dfine_ress->ress_pt_name = $rs_ps["pt_title_th"];
					$this->dfine_ress->ress_dept = $rs_ps["dm_title_th"];
					$this->dfine_ress->ress_ps_id = $rs_ps["ps_id"];
					$this->dfine_ress->ress_resm_id = $resm_id;
					$this->dfine_ress->insert_ress();
				}
			}
		}
		echo json_encode(true);
	} //End fn save_ress
	
	function del_resm(){
		$resm_id = $this->input->post('resm_id');
		$dfine_id = $this->input->post('dfine_id');
		$this->dfine_ress->delete_ress_by_resm_id($resm_id);//ลบผู้รับผิดชอบร่วม
		$this->dfine_res->delete_resm($resm_id);//ลบผู้รับผิดชอบหลัก
		$this->rsind->update_resm('', $dfine_id);
		echo json_encode(true);
	} //End fn del_resm
	
	function del_ress(){
		$ress_id = $this->input->post('ress_id');
		$resm_id = $this->input->post('resm_id');
		$this->dfine_ress->delete_ress($ress_id);
		$rs_ress = $this->dfine_ress->get_by_id($resm_id);
		if($rs_ress->num_rows() > 0){
			echo json_encode(1);
		}else{
			return 0;
			echo json_encode(0);
		}	
	} //End fn del_ress
	
	function del_all_ress(){
		$resm_id = $this->input->post('resm_id');
		$this->dfine_ress->delete_ress_by_resm_id($resm_id);
	} //End fn del_all_ress
	
	function get_info_ress(){
		$resm_id = $this->input->post('resm_id');
		$rs_ress = $this->dfine_ress->get_by_id($resm_id);
		$seq=1;
		$ress_dept = "";
		
		$row  ='<thead>';
        $row .=		'<tr>';
        $row .=			'<th style="width: 5%; text-align: center;">ลำดับ</th>';
        $row .=			'<th style="width: 30%; text-align: center;">ชื่อ - สกุล</th>';
        $row .=			'<th style="width: 30%; text-align: center;">ตำแหน่ง</th>';
		$row .=			'<th style="width: 15%; text-align: center;">ดำเนินการ';
		$row .=			'</th>';
        $row .=		'</tr>';
        $row .='</thead>';
		$row .='<tbody id="tb_modal_info_ress">';
		if($rs_ress->num_rows() > 0){
			foreach($rs_ress->result() as $ress){
				if($ress_dept != $ress->ress_dept){
					$ress_dept = $ress->ress_dept;
					$row .='<tr>';
					$row .= 	'<td colspan="4" style="background: #eeeeee;"><b>ฝ่ายงาน :</b> '.$ress->ress_dept.'</td>';
					$row .='</tr>';
				}
				$row .= '<tr>';
				$row .= 		'<td><center>'.$seq++.'</center></td>';
				$row .= 		'<td>'.$ress->ress_name.'</td>';
				$row .= 		'<td>'.$ress->ress_pt_name.'</td>';
				$row .= 		'<td>';
				$row .=				'<center><a id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบผู้รับผิดชอบตัวชี้วัดร่วม" onclick="del_ress('.$ress->ress_id.','.$ress->ress_resm_id.')">';
				$row .=				'<i class="glyphicon glyphicon-trash" style="color:white"></i>';
				$row .=				'</a></center>';
				$row .=			'</td>';
				$row .= '</tr>';
				
			}   
		}else{
			$row .='<tr>';
			$row .= 	'<td colspan="4" style="text-align: center; background: #eeeeee;">ไม่มีผู้รับผิดชอบร่วม</td>';
			$row .='</tr>'; 
		}		
		$row .='</tbody>';
		echo json_encode($row); 
	}//End fn get_info_ress
}
?>	
   
   
   
   
   
   