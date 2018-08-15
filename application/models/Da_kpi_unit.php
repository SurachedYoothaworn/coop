<?php
/*	
* Class Da_test	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_unit extends Kpims_model {

    public $unt_name;

	function __construct() {
		parent::__construct();
	}

	function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit(unt_id,unt_name,unt_status) 
                VALUES ('',?,?)";
		$this->db_KPIMS->query($sql,array($this->unt_name,1));
		// $this->last_insert_id = $this->db_KPIMS->insert_id();
	}

	function update($unt_id, $unt_name){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit 
				SET unt_name='$unt_name'
				WHERE unt_id='$unt_id'";
		$this->db_KPIMS->query($sql);
	}

	function update_status($unt_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit 
				SET unt_status=0 WHERE unt_id='$unt_id'";
		$this->db_KPIMS->query($sql);
	}
	
}//End Class Da_test
?>