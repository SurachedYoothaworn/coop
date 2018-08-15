<?php
/*	
* Class M_kpi_indicator_group	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_indicator_group.php");
class M_kpi_indicator_group extends Da_kpi_indicator_group {	
	
	function __construct() {
		parent::__construct();
		
	}

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group 
				WHERE indgp_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }

    function get_by_id($indgp_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group 
				WHERE indgp_id = '$indgp_id' AND indgp_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }
}
?>