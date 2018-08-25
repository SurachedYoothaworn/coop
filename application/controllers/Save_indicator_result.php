<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Save_indicator_result extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        // $this->load->model('M_kpi_indicator','ind');
    }

	public function index()
	{
        // $data['rs_ind'] = $this->ind->get_all();
		$this->output('v_save_indicator_result');
    }
}
?>