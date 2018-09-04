<?php
/*	
* Class Da_Define_responsibility_main	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_Define_responsibility_main extends Kpims_model {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function insert_resm(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main(resm_id,resm_name,resm_pt_name,resm_dept,resm_ps_id,resm_dfine_id) 
                VALUES ('',?,?,?,?,?)";
		$this->db_KPIMS->query($sql,array($this->resm_name ,$this->resm_pt_name ,$this->resm_dept,$this->resm_ps_id,$this->resm_dfine_id));
		return $this->db_KPIMS->insert_id();
	}
	
	function delete_resm($resm_id){
		$sql = "DELETE FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main 
				WHERE resm_id  = '$resm_id'";
		$this->db_KPIMS->query($sql);
	}
	
	function delete_all_resm($dfine_id){
		$sql = "DELETE FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main 
				WHERE resm_dfine_id  = '$dfine_id'";
		$this->db_KPIMS->query($sql);
	}
   
}
?>