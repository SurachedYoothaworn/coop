<?php
/*	
* Class M_kpi_unit	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_unit.php");
class M_kpi_unit extends Da_kpi_unit {	
	
	function __construct() {
		parent::__construct();
		
	}

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit 
				WHERE unt_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_all

    function get_by_id($unt_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit 
				WHERE unt_id = '$unt_id' AND unt_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_by_id
} //End class
?>