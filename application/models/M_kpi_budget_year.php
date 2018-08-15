<?php
/*	
* Class M_kpi_budget_year	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_budget_year.php");
class M_kpi_budget_year extends Da_kpi_budget_year {	
	
	function __construct() {
		parent::__construct();
		
	}

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year 
				WHERE bgy_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }

    function get_by_id($bgy_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year 
				WHERE bgy_id = '$bgy_id' AND bgy_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }
}
?>