 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Follow_result extends kpims_Controller {

    public function __construct(){
        parent::__construct();
        // $this->load->model('M_kpi_define_indicator','dfine');
		// $this->load->model('M_Define_responsibility_main','dfine_res');
		// $this->load->model('M_Define_responsibility_sub','ress');
		// $this->load->model('M_kpi_result_indicator','rsind');
		
    }
	
	public function index(){
		$this->output('v_follow_result');
	}
}?>