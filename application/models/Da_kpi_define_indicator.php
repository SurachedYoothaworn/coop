 <?php
/*	
* Class Da_kpi_define_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_define_indicator extends Kpims_model {

    public $ind_name;
    public $ind_description;

	function __construct() {
		parent::__construct();
	}

	function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator(dfine_id,dfine_goal ,dfine_ind_id ,dfine_bgy_id,dfine_str_id,dfine_indgp_id,dfine_opt_id,dfine_unt_id,dfine_side_id,dfine_status) 
                VALUES ('',?,?,?,?,?,?,?,?,?)";
		$this->db_KPIMS->query($sql,array($this->dfine_goal ,$this->dfine_ind_id ,$this->dfine_bgy_id,$this->dfine_str_id,$this->dfine_indgp_id,$this->dfine_opt_id,$this->dfine_unt_id,$this->dfine_side_id, 1));
		return $this->db_KPIMS->insert_id();
		
	}

	function update($dfine_id,$dfine_goal,$dfine_ind_id,$dfine_bgy_id,$dfine_str_id,$dfine_indgp_id,$dfine_opt_id,$dfine_unt_id,$dfine_side_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator 
				SET dfine_goal='$dfine_goal' ,dfine_ind_id='$dfine_ind_id' ,dfine_bgy_id='$dfine_bgy_id' ,dfine_str_id='$dfine_str_id' ,dfine_indgp_id='$dfine_indgp_id' ,dfine_opt_id='$dfine_opt_id' ,dfine_unt_id='$dfine_unt_id' ,dfine_side_id='$dfine_side_id'
				WHERE dfine_id='$dfine_id'";
		$this->db_KPIMS->query($sql);
	}

	function update_status($dfine_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator 
				SET dfine_status=0 WHERE dfine_id='$dfine_id'";
		$this->db_KPIMS->query($sql);
	}
	
	function update_status_action($status_action, $dfine_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator 
				SET dfine_status_action = '$status_action' WHERE dfine_id='$dfine_id'";
		$this->db_KPIMS->query($sql);
	}
	
	function update_status_assessment($status_assessment, $dfine_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator 
				SET dfine_status_assessment = '$status_assessment' ,dfine_status_action = 2 WHERE dfine_id='$dfine_id'";
		$this->db_KPIMS->query($sql);
	}
	
}//End Class Da_test
?>