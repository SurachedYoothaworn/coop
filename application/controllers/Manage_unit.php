<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_unit extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_unit','unt');
    }

	public function index()
	{
        $data['rs_unt'] = $this->unt->get_all();
		$this->output('v_unit', $data);
    }
    
    public function save_unit(){
        // print_r($this->input->post('unt_add'));
        $unt_name = $this->input->post('unt_add');
        $this->unt->unt_name = $unt_name;
        $this->unt->insert();
        redirect('Manage_unit', 'refash');
    }

    public function edit_unit(){
        $unt_id = $this->input->post('unt_id');
        $data = $this->unt->get_by_id($unt_id)->row_array();
        echo json_encode($data);
    }

    public function update_unit(){
        $unt_id = $this->input->post('hid_unt_id');
        $unt_name = $this->input->post('unt_edit');
        $this->unt->update($unt_id, $unt_name);
        redirect('Manage_unit', 'refash');
    }

    public function update_status_unit(){
        $unt_id = $this->input->post('unt_id');
        $this->unt->update_status($unt_id);
        echo json_encode(true);
    }
}
