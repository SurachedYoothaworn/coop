 <?php
/*	
* Class Da_Define_responsibility_sub	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_Define_responsibility_sub extends Kpims_model {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function insert_ress(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub(ress_id,ress_name,ress_pt_name,ress_dept,ress_ps_id,ress_resm_id) 
                VALUES ('',?,?,?,?,?)";
		$this->db_KPIMS->query($sql,array($this->ress_name ,$this->ress_pt_name ,$this->ress_dept,$this->ress_ps_id,$this->ress_resm_id));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	} //End fn insert_ress
	
	function delete_ress($ress_id){
		$sql = "DELETE FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub 
				WHERE ress_id  = '$ress_id'";
		$this->db_KPIMS->query($sql);
	} //End fn insert_ress
	
	function delete_ress_by_resm_id($resm_id){
		$sql = "DELETE FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub 
				WHERE ress_resm_id  = '$resm_id'";
		$this->db_KPIMS->query($sql);
	} //End fn insert_ress
} //End class
?>