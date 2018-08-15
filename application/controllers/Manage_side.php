<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_side extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_side','side');
    }

	public function index()
	{
        $data['rs_side'] = $this->side->get_all();
		$this->output('v_side', $data);
    }
    
    public function save_side(){
        // print_r($this->input->post('side_add'));
        $side_name = $this->input->post('side_add');
        $side_code = $this->input->post('side_code_add');
        $this->side->side_name = $side_name;
        $this->side->side_code  = $side_code;
        $this->side->insert();
        redirect('Manage_side', 'refash');
    }

    public function edit_side(){
        $side_id = $this->input->post('side_id');
        $data = $this->side->get_by_id($side_id)->row_array();
        echo json_encode($data);
    }

    public function update_side(){
        $side_id = $this->input->post('hid_side_id');
        $side_name = $this->input->post('side_edit');
        $side_code = $this->input->post('side_code_edit');
        $this->side->update($side_id, $side_name, $side_code);
        redirect('Manage_side', 'refash');
    }

    public function update_status_side(){
        $side_id = $this->input->post('side_id');
        $this->side->update_status($side_id);
        echo json_encode(true);
    }
}
