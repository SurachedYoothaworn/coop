<?php
class Kpims_model extends CI_Model {
	
	public $db_KPIMS = NULL;
	public $db_kpims;
	
	function __construct() {
		parent::__construct();
		
		$this->db_KPIMS = $this->load->database("kpims",TRUE);
		$this->db_kpims = $this->config->item("kpims_dbname");
		
	}
}//end class Kpims_model

?>
