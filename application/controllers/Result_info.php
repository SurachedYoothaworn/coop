<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Result_info extends kpims_Controller {

    public function __construct(){
        parent::__construct();
		$this->load->model('M_Define_responsibility_main','dfine_res');
		$this->load->model('M_Define_responsibility_sub','dfine_ress');
		$this->load->model('M_kpi_result_indicator','rsind');
		$this->load->model('M_kpi_define_indicator','dfine');
    }

	public function index(){
		$dfine_id = $this->input->post('dfine_id');
		$data['dfine_id'] = $dfine_id ;
		$this->output('v_result_info', $data);
    } //End fn index
	
	public function Show_info($dfine_id){
		// $dfine_id = $this->input->post('dfine_id');
		$rs_dfine = $this->rsind->get_by_id($dfine_id)->row_array();
		$result_ind = $this->rsind->get_result_by_id($rs_dfine['dfine_id']);
		$rs_ress = $this->dfine_ress->get_by_id($rs_dfine['resm_id']);
		
		$data['rs_dfine'] = $rs_dfine;
		$data['result_ind'] = $result_ind;
		$data['rs_ress'] = $rs_ress;
		$this->output('v_result_info', $data);
    } //End fn Show_info
} //End class
?>