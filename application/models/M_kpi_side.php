<?php
/*	
* Class M_kpi_side	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_side.php");
class M_kpi_side extends Da_kpi_side {	
	
	function __construct() {
		parent::__construct();
		
    }

    function get_all(){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side 
				WHERE side_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_all

    function get_by_id($side_id){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side 
				WHERE side_id = '$side_id' AND side_status = 1";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_by_id
} //End class
?>