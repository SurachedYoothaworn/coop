  <?php
/*	
* Class M_Define_responsibility_sub	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_Define_responsibility_sub.php");
class M_Define_responsibility_sub extends Da_Define_responsibility_sub {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_by_id($resm_id){ 
		$sql = "SELECT *FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress
				WHERE ress.ress_resm_id = '$resm_id' 
				ORDER BY ress.ress_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_by_id
	
	// function get_by_id($resm_id, $dfine_id){ 
		// $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress
				// LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm
				// ON resm.resm_id = ress.ress_resm_id
				// WHERE ress.ress_resm_id = '$resm_id' AND resm.resm_dfine_id = '$dfine_id'
				// ORDER BY ress.ress_dept";
        // $query = $this->db_KPIMS->query($sql);
        // return $query;
	// } //End fn get_by_id
   
} //End class
?>