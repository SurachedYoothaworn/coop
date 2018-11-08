<?php
/*	
* Class M_kpi_strategy	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_strategy.php");
class M_kpi_strategy extends Da_kpi_strategy {	
	
	function __construct() {
		parent::__construct();
		
    }

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy 
				WHERE str_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_all

    function get_by_id($str_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy 
				WHERE str_id = '$str_id' AND str_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_by_id
} //End class
?>