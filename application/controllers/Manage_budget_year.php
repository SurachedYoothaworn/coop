<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_budget_year extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_budget_year','bgy');
    }

	public function index(){
		$this->output('v_budget_year');
    } //End fn index
    
    public function save_budget_year(){
        $bgy_name = $this->input->post('bgy_name');
		if($bgy_name != NULL || $bgy_name != ""){
			$this->bgy->bgy_name = $bgy_name;
			$this->bgy->insert();
			echo json_encode(true);
		}
    } //End fn save_budget_year

    public function edit_budget_year(){
        $bgy_id = $this->input->post('bgy_id');
        $data = $this->bgy->get_by_id($bgy_id)->row_array();
        echo json_encode($data);
    } //End fn edit_budget_year

    public function update_budget_year(){
        $bgy_id = $this->input->post('bgy_id');
		$bgy_name = $this->input->post('bgy_name');
		if($bgy_name != NULL || $bgy_name != ""){
			$this->bgy->update($bgy_id, $bgy_name);
			echo json_encode(true);
		}
    } //End fn update_budget_year

    public function update_status_budget_year(){
        $bgy_id = $this->input->post('bgy_id');
        $this->bgy->update_status($bgy_id);
        echo json_encode(true);
    } //End fn update_status_budget_year
	
	function get_data(){ 
        $rs_bgy_data = $this->bgy->get_all();
        $data = array(); 
        if($rs_bgy_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_bgy_data->result() as $bgy){	
                $btn  = '<center><button type="button" id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขปีงบประมาณ" data-toggle="modal" href="#modal_edit_budget_year" onclick="edit_budget_year('.$bgy->bgy_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบปีงบประมาณ" onclick="update_status_budget_year('.$bgy->bgy_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
				
				$bgy_data = array(
					"bgy_seq" => "<center>".$seq."</center>",
					"bgy_id" => $bgy->bgy_id,
					"bgy_name" => $bgy->bgy_name,
					"btn_manage" => $btn,
				);
				array_push($data, $bgy_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
} //End class
