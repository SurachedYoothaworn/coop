<?php
/*	
* Class Da_kpi_budget_year	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_budget_year extends Kpims_model {

    public $bgy_name;

	function __construct() {
		parent::__construct();
	}

	function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year(bgy_id,bgy_name,bgy_status) 
                VALUES ('',?,?)";
		$this->db_KPIMS->query($sql,array($this->bgy_name,1));
		// $this->last_insert_id = $this->db_KPIMS->insert_id();
	} //End fn insert

	function update($bgy_id, $bgy_name){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year 
				SET bgy_name='$bgy_name'
				WHERE bgy_id='$bgy_id'";
		$this->db_KPIMS->query($sql);
	} //End fn insert

	function update_status($bgy_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year 
				SET bgy_status=0 WHERE bgy_id='$bgy_id'";
		$this->db_KPIMS->query($sql);
	} //End fn insert
	
}//End class
?>