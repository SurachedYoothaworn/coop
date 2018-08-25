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
	
	// function get_all(){
		// $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub";
        // $query = $this->db_KPIMS->query($sql);
        // return $query;
	// }
	
	function get_by_id($resm_id){ 
		$sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub
				WHERE ress_resm_id = '$resm_id'
				ORDER BY ress_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
   
}
?>