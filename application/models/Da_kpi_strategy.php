<?php
/*	
* Class Da_kpi_strategy	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_strategy extends Kpims_model {

    // public $ind_name;

	function __construct() {
		parent::__construct();
    }

    function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy(str_id,str_name,str_code,str_status) 
                VALUES ('',?,?,?)";
        $this->db_KPIMS->query($sql,array($this->str_name, $this->str_code, 1));
        // $this->last_insert_id = $this->db_KPIMS->insert_id();
    }

    function update($str_id, $str_name, $str_code){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy 
				SET str_name='$str_name', str_code='$str_code'
				WHERE str_id='$str_id'";
		$this->db_KPIMS->query($sql);
    }
    
    function update_status($str_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy 
				SET str_status=0 WHERE str_id='$str_id'";
		$this->db_KPIMS->query($sql);
	}
	
}//End Class Da_kpi_strategy
?>