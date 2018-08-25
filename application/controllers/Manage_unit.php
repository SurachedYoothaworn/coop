<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_unit extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_unit','unt');
    }

	public function index(){
		$this->output('v_unit');
    }
    
    public function save_unit(){
        $unt_name = $this->input->post('unt_name');
		if($unt_name != NULL || $unt_name != ""){
			$this->unt->unt_name = $unt_name;
			$this->unt->insert();
		echo json_encode(true);
		}
    }

    public function edit_unit(){
        $unt_id = $this->input->post('unt_id');
        $data = $this->unt->get_by_id($unt_id)->row_array();
        echo json_encode($data);
    }

    public function update_unit(){
        $unt_id = $this->input->post('unt_id');
        $unt_name = $this->input->post('unt_name');
		if($unt_name != NULL || $unt_name != ""){
			$this->unt->update($unt_id, $unt_name);
			echo json_encode(true);
		}
    }

    public function update_status_unit(){
        $unt_id = $this->input->post('unt_id');
        $this->unt->update_status($unt_id);
        echo json_encode(true);
    }
	
	function get_data(){ 
        $rs_unt_data = $this->unt->get_all();
        $data = array(); 
        if($rs_unt_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_unt_data->result() as $unt){
                $btn  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขหน่วยนับ" data-toggle="modal" href="#modal_edit_unit" onclick="edit_unit('.$unt->unt_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบหน่วยนับ"  onclick="update_status_unit('.$unt->unt_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
				
				$unt_data = array(
					"unt_seq" => "<center>".$seq."</center>",
					"unt_id" => $unt->unt_id,
					"unt_name" => $unt->unt_name,
					"btn_manage" => $btn,
				);
				array_push($data, $unt_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
}
