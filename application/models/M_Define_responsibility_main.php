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
	} //End fn get_all
	
	function get_by_id($dfine_id){ 
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_dfine_id = '$dfine_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_by_id
	
	function get_resm_by_id($resm_id){ 
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_id = '$resm_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_resm_by_id
	
	function get_name_by_id($resm_ps_id){
		$sql = "SELECT * FROM kpi_responsibility_main
				WHERE resm_ps_id = '$resm_ps_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_name_by_id
	
	function get_name_by_id_resm_and_ress($resm_ps_id,$ptm_id){
		$where_resm = "";
		if($ptm_id == 1){
			if($resm_ps_id > 0){
				$where_resm = "WHERE resm.resm_ps_id='$resm_ps_id'";
			}
		}else if($ptm_id == 2){
			if($resm_ps_id > 0){
				$where_resm = "WHERE ress.ress_ps_id='$resm_ps_id'";
			}
		}
		$sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id
				".$where_resm."
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_name_by_id
	
	function get_id_resm_ress($dfine_id){
		$sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main
				LEFT JOIN kpi_responsibility_sub ON resm_id = ress_resm_id
				WHERE resm_dfine_id = '$dfine_id'
				ORDER BY resm_dept";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
}  //End class 
?>