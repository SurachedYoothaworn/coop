 <?php
/*	
* Class Da_kpi_report_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_report_indicator extends Kpims_model {

    public $ind_name;
    public $ind_description;

	function __construct() {
		parent::__construct();
	}
	
	function insert(){
		$sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result(indrs_id, indrs_quarter,indrs_score,indrs_resm_id,indrs_dfind_id,indrs_date_edit)
				VALUES ('',?,null,null,?,null)";
		$this->db_KPIMS->query($sql,array($this->indrs_quarter ,$this->indrs_dfind_id));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	} //End fn insert
	
	function update_resm($resm_id, $dfine_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result 
				SET indrs_resm_id='$resm_id'
				WHERE indrs_dfind_id='$dfine_id'";
		$this->db_KPIMS->query($sql);
	} //End fn update_resm
	
	function update_score($indrs_score, $date_edit, $indrs_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result 
				SET indrs_score='$indrs_score', indrs_date_edit='$date_edit'
				WHERE indrs_id='$indrs_id'";
		$this->db_KPIMS->query($sql);
	} //End fn update_score
	
	function delete($dfind_id){
		$sql = "DELETE FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result 
				WHERE indrs_dfind_id  = '$dfind_id'";
		$this->db_KPIMS->query($sql);
	} //End fn delete
}//End class 
?>