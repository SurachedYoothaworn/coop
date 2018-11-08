<?php
/*	
* Class Da_kpi_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_indicator extends Kpims_model {

    public $ind_name;
    public $ind_description;

	function __construct() {
		parent::__construct();
	}

	function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator(ind_id,ind_name ,ind_description ,ind_status) 
                VALUES ('',?,?,?)";
		$this->db_KPIMS->query($sql,array($this->ind_name, $this->ind_description, 1));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	} //End fn insert

	function update($ind_id, $ind_name, $ind_description){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator 
				SET ind_name='$ind_name', ind_description='$ind_description'
				WHERE ind_id='$ind_id'";
		$this->db_KPIMS->query($sql);
	} //End fn update

	function update_status($ind_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator 
				SET ind_status=0 WHERE ind_id='$ind_id'";
		$this->db_KPIMS->query($sql);
	} //End fn update_status
	
}//End class 
?>