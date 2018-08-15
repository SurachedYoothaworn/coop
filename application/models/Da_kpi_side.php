<?php
/*	
* Class Da_kpi_side	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/Kpims_model.php");
class Da_kpi_side extends Kpims_model {

    // public $ind_name;

	function __construct() {
		parent::__construct();
    }

    function insert(){
        $sql = "INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side(side_id,side_name,side_code,side_status) 
                VALUES ('',?,?,?)";
        $this->db_KPIMS->query($sql,array($this->side_name, $this->side_code, 1));
        // $this->last_insert_id = $this->db_KPIMS->insert_id();
    }

    function update($side_id, $side_name, $side_code){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side 
				SET side_name='$side_name', side_code='$side_code'
				WHERE side_id='$side_id'";
		$this->db_KPIMS->query($sql);
    }
    
    function update_status($side_id){
		$sql = "UPDATE ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side 
				SET side_status=0 WHERE side_id='$side_id'";
		$this->db_KPIMS->query($sql);
	}
	
}//End Class Da_kpi_side
?>