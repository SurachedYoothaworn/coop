<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_side extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_side','side');
    }

	public function index(){
		$this->output('v_side');
    } //End fn index
    
    public function save_side(){
        $side_name = $this->input->post('side_name');
        $side_code = $this->input->post('side_code');
		if($side_name != NULL || $side_name != ""){
			$this->side->side_name = $side_name;
			$this->side->side_code  = $side_code;
			$this->side->insert();
			echo json_encode(true);
		}
    } //End fn save_side

    public function edit_side(){
        $side_id = $this->input->post('side_id');
        $data = $this->side->get_by_id($side_id)->row_array();
        echo json_encode($data);
    } //End fn edit_side

    public function update_side(){
        $side_id = $this->input->post('side_id');
        $side_name = $this->input->post('side_name');
        $side_code = $this->input->post('side_code');
		if($side_name != NULL || $side_name != ""){
			$this->side->update($side_id, $side_name, $side_code);
			echo json_encode(true);
		}
    } //End fn update_side

    public function update_status_side(){
        $side_id = $this->input->post('side_id');
        $this->side->update_status($side_id);
        echo json_encode(true);
    } //End fn update_status_side
	
	function get_data(){ 
        $rs_side_data = $this->side->get_all();
        $data = array(); 
        if($rs_side_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_side_data->result() as $side){
                $btn  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขหน่วยงาน" data-toggle="modal" href="#modal_edit_side" onclick="edit_side('.$side->side_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบหน่วยงาน"  onclick="update_status_side('.$side->side_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
				
				$side_data = array(
					"side_seq" => "<center>".$seq."</center>",
					"side_id" => $side->side_id,
					"side_name" => $side->side_name,
					"side_code" => "<center>".$side->side_code."</center>",
					"btn_manage" => $btn,
				);
				array_push($data, $side_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
} //End class
