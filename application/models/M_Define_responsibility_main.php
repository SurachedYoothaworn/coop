 <?php
/*	
* Class M_Define_responsibility_main	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_Define_responsibility_main.php");
class M_Define_responsibility_main extends Da_Define_responsibility_main {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_all(){
		$sql = "SELECT * FROM kpi_responsibility_main";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_by_id($dfine_id){ 
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_dfine_id = '$dfine_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_resm_by_id($resm_id){ 
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_id = '$resm_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_name_by_id($resm_ps_id){
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_ps_id = '$resm_ps_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
   
}
?>