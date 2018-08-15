<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_indicator extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_indicator','ind');
    }

	public function index()
	{
        $data['rs_ind'] = $this->ind->get_all();
		$this->output('v_indicator', $data);
    }
    
    public function save_indicator(){
        // print_r($this->input->post('ind_add'));
        $ind_name = $this->input->post('ind_name');
        $desc = $this->input->post('ind_desc');
        if($ind_name != NULL){
            $this->ind->ind_name = $ind_name;
            $this->ind->ind_description  = $desc;
            $this->ind->insert();
            echo json_encode(true);
        }
        // redirect('Manage_indicator', 'refash');
    } //End fn save_indicator

    public function edit_indicator(){
        $ind_id = $this->input->post('ind_id');
        $data = $this->ind->get_by_id($ind_id)->row_array();
        echo json_encode($data);
        // echo $ind_id; die;
    } //End fn edit_indicator

    public function update_indicator(){
        $ind_id = $this->input->post('hid_ind_id');
        $ind_name = $this->input->post('ind_edit');
        $desc = $this->input->post('desc_edit');
        if($ind_name != NULL){
            $this->ind->update($ind_id, $ind_name, $desc);
            // redirect('Manage_indicator', 'refash');
            echo json_encode(true);
        }
    } //End fn update_indicator

    public function update_status_indicator(){
        $ind_id = $this->input->post('ind_id');
        $this->ind->update_status($ind_id);
        echo json_encode(true);
    } //End fn update_status_indicator

    function get_data(){ 
        $rs_ind_data = $this->ind->get_all();
        $data = array(); 
        if($rs_ind_data->num_rows() > 0){
            $seq = 1;
			foreach($rs_ind_data->result() as $ind){	
                $btn  = '<center><button id="btn_edit" name="btn_edit" class="'.$this->config->item('btn_warning').'"data-toggle="modal" data-tooltip="แก้ไขตัวชี้วัด" href="#modal_edit_indicator" onclick="edit_indicator('.$ind->ind_id.')">';
                $btn .= '<i class="glyphicon glyphicon-pencil" style="color:white" ></i>';
                $btn .= '</button>&nbsp';
                $btn .= '<button id="btn_del" name="btn_del" class="'.$this->config->item('btn_danger').'" data-tooltip="ลบตัวชี้วัด" onclick="update_status_indicator('.$ind->ind_id.')">';
                $btn .= '<i class="glyphicon glyphicon-trash" style="color:white"></i>';
                $btn .= '</button></center>';
                $ind_data = array(
                    "ind_seq" => "<center>".$seq."</center>",
                    "ind_id" => $ind->ind_id,
					"ind_name" => $ind->ind_name,
					"ind_description" => $ind->ind_description,
					"btn_manage" => $btn,
                );
                array_push($data, $ind_data);
				$seq++;
            } //End for
        } //End if
        echo json_encode($data);
    }//End fn get_data
} //End class
