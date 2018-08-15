<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_strategy extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_strategy','str');
    }

    public function index(){
        $data['rs_str'] = $this->str->get_all();
		$this->output('v_strategy', $data);
    }

    public function save_strategy(){
        $str_name = $this->input->post('str_add');
        $str_code = $this->input->post('str_code_add');
        $this->str->str_name = $str_name;
        $this->str->str_code = $str_code;
        $this->str->insert();
        redirect('Manage_strategy', 'refash');
    }

    public function edit_strategy(){
        $str_id = $this->input->post('str_id');
        $data = $this->str->get_by_id($str_id)->row_array();
        // print_r($data);die;
        echo json_encode($data);
    }

    public function update_strategy(){
        $str_id = $this->input->post('hid_str_id');
        $str_name = $this->input->post('str_edit');
        $str_code = $this->input->post('str_code_edit');
        $this->str->update($str_id, $str_name, $str_code);
        redirect('Manage_strategy', 'refash');
    }

    public function update_status_strategy(){
        $str_id = $this->input->post('str_id');
        $this->str->update_status($str_id);
        echo json_encode(true);
    }
    

}
?>