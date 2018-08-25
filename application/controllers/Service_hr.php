  <?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS, HEAD");
	header("Content-type: application/json");
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require_once("kpims_Controller.php");

	class Service_hr extends Kpims_controller {
	
		public function __construct(){
			parent::__construct();
			$this->load->model('M_service','sv');
		}
		
		function get_person(){
			header ('Content-type: application/json; charset=utf-8');
			$rs_person = $this->sv->get_person()->result();
			echo json_encode($rs_person);
		}
	
	
	}
?>