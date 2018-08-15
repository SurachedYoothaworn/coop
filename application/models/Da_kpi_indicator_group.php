<?php
/*	
* Class Da_kpi_indicator_gruop	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_indicator_group extends Kpims_model {

    public $indgp_name;
    public $indgp_code;

	function __construct() {
		parent::__construct();
	}

	function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group(indgp_id,indgp_name,indgp_code,indgp_status) 
                VALUES ('',?,?,?)";
		$this->db_KPIMS->query($sql,array($this->indgp_name, $this->indgp_code, 1));
		// $this->last_insert_id = $this->db_KPIMS->insert_id();
	}

	function update($indgp_id, $indgp_name, $indgp_code){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group 
				SET indgp_name='$indgp_name', indgp_code='$indgp_code'
				WHERE indgp_id='$indgp_id'";
		$this->db_KPIMS->query($sql);
	}

	function update_status($indgp_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group 
				SET indgp_status=0 WHERE indgp_id='$indgp_id'";
		$this->db_KPIMS->query($sql);
	}
	
}//End Class Da_test
?>