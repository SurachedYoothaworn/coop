<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_indicator_group extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_indicator_group','indgp');
    }

	public function index()
	{
		$this->output('v_indicator_group');
    }
    
    public function save_indicator_group(){
        $indgp_name = $this->input->post('indgp_name');
        $indgp_code = $this->input->post('indgp_code');
        $this->indgp->indgp_name = $indgp_name;
        $this->indgp->indgp_code  = $indgp_code;
        $this->indgp->insert();
		if($indgp_name != NULL || $indgp_name != ""){
			echo json_encode(true);
		}
    }

    public function edit_indicator_group(){
        $indgp_id = $this->input->post('indgp_id');
        $data = $this->indgp->get_by_id($indgp_id)->row_array();
        echo json_encode($data);
        // echo $ind_id; die;
    }

    public function update_indicator_group(){
        $indgp_id = $this->input->post('indgp_id');
        $indgp_name = $this->input->post('indgp_name');
        $indgp_code = $this->input->post('indgp_code');
        $this->indgp->update($indgp_id, $indgp_name, $indgp_code);
		if($indgp_name != NULL || $indgp_name != ""){
			echo json_encode(true);
		}
    }

    public function update_status_indicator_group(){
        $indgp_id = $this->input->post('indgp_id');
        $this->indgp->update_status($indgp_id);
        echo json_encode(true);
    }
	
	function get_data(){ 
        $rs_indgp_data = $this->indgp->get_all();
        $data = array(); 
        if($rs_indgp_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_indgp_data->result() as $indgp){	
				
                $btn  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขกลุ่มตัวชี้วัด"  data-toggle="modal" href="#modal_edit_indicator_group" onclick="edit_indicator_group('.$indgp->indgp_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบกลุ่มตัวชี้วัด" onclick="update_status_indicator_group('.$indgp->indgp_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
				
				$indgp_data = array(
					"indgp_seq" => "<center>".$seq."</center>",
					"indgp_id" => $indgp->indgp_id,
					"indgp_name" => $indgp->indgp_name,
					"indgp_code" => "<center>".$indgp->indgp_code."</center>",
					"btn_manage" => $btn,
				);
				array_push($data, $indgp_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
}
