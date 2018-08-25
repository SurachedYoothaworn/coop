<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_strategy extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_strategy','str');
    }

    public function index(){
		$this->output('v_strategy');
    }

    public function save_strategy(){
        $str_name = $this->input->post('str_name');
        $str_code = $this->input->post('str_code');
		if($str_name != NULL || $str_name != ""){
			$this->str->str_name = $str_name;
			$this->str->str_code = $str_code;
			$this->str->insert();
			echo json_encode(true);
		}
        // redirect('Manage_strategy', 'refash');
    }

    public function edit_strategy(){
        $str_id = $this->input->post('str_id');
        $data = $this->str->get_by_id($str_id)->row_array();
        // print_r($data);die;
        echo json_encode($data);
    }

    public function update_strategy(){
        $str_id = $this->input->post('str_id');
        $str_name = $this->input->post('str_name');
        $str_code = $this->input->post('str_code');
		if($str_name != NULL || $str_name != ""){
			$this->str->update($str_id, $str_name, $str_code);
			echo json_encode(true);
		}
    }

    public function update_status_strategy(){
        $str_id = $this->input->post('str_id');
        $this->str->update_status($str_id);
        echo json_encode(true);
    }
	
	function get_data(){ 
        $rs_str_data = $this->str->get_all();
        $data = array(); 
        if($rs_str_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_str_data->result() as $str){	
                $btn  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'" data-tooltip="แก้ไขยุทธศาสตร์ตัวชี้วัด"  data-toggle="modal" href="#modal_edit_strategy" onclick="edit_strategy('.$str->str_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบยุทธศาสตร์ตัวชี้วัด" onclick="update_status_strategy('.$str->str_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
				
				$str_data = array(
					"str_seq" => "<center>".$seq."</center>",
					"str_id" => $str->str_id,
					"str_name" => $str->str_name,
					"str_code" => "<center>".$str->str_code."</center>",
					"btn_manage" => $btn,
				);
				array_push($data, $str_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
}
?>