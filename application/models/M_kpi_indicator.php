<?php
/*	
* Class M_kpi_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_indicator.php");
class M_kpi_indicator extends Da_kpi_indicator {	
	
	function __construct() {
		parent::__construct();
		
	}

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator 
				WHERE ind_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }

    function get_by_id($ind_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator 
				WHERE ind_id = '$ind_id' AND ind_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }
}
?>