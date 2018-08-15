<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manage_budget_year extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kpi_budget_year','bgy');
    }

	public function index()
	{
        $data['rs_bgy'] = $this->bgy->get_all();
		$this->output('v_budget_year', $data);
    }
    
    public function save_budget_year(){
        // print_r($this->input->post('bgy_add'));
        $bgy_name = $this->input->post('bgy_add');
        $this->bgy->bgy_name = $bgy_name;
        $this->bgy->insert();
        redirect('Manage_budget_year', 'refash');
    }

    public function edit_budget_year(){
        $bgy_id = $this->input->post('bgy_id');
        $data = $this->bgy->get_by_id($bgy_id)->row_array();
        echo json_encode($data);
    }

    public function update_budget_year(){
        $bgy_id = $this->input->post('hid_bgy_id');
        $bgy_name = $this->input->post('bgy_edit');
        $this->bgy->update($bgy_id, $bgy_name);
        redirect('Manage_budget_year', 'refash');
    }

    public function update_status_budget_year(){
        $bgy_id = $this->input->post('bgy_id');
        $this->bgy->update_status($bgy_id);
        echo json_encode(true);
    }
}
