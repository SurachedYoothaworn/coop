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
        $data['rs_indgp'] = $this->indgp->get_all();
		$this->output('v_indicator_group', $data);
    }
    
    public function save_indicator_group(){
        // print_r($this->input->post('ind_add'));

        $indgp_name = $this->input->post('indgp_add');
        $indgp_code = $this->input->post('indgp_code_add');
        $this->indgp->indgp_name = $indgp_name;
        $this->indgp->indgp_code  = $indgp_code;
        $this->indgp->insert();
        redirect('Manage_indicator_group', 'refash');
    }

    public function edit_indicator_group(){
        $indgp_id = $this->input->post('indgp_id');
        $data = $this->indgp->get_by_id($indgp_id)->row_array();
        echo json_encode($data);
        // echo $ind_id; die;
    }

    public function update_indicator_group(){
        $indgp_id = $this->input->post('hid_indgp_id');
        $indgp_name = $this->input->post('indgp_edit');
        $indgp_code = $this->input->post('indgp_code_edit');
        $this->indgp->update($indgp_id, $indgp_name, $indgp_code);
        // echo $desc;die;
        redirect('Manage_indicator_group', 'refash');
    }

    public function update_status_indicator_group(){
        $indgp_id = $this->input->post('indgp_id');
        $this->indgp->update_status($indgp_id);
        echo json_encode(true);
    }
}
