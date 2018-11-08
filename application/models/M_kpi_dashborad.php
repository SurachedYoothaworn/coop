 <?php
/*	
* Class M_kpi_dashborad	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-9-02
*/
include_once(dirname(__FILE__)."/Da_kpi_dashborad.php");
class M_kpi_dashborad extends Da_kpi_dashborad {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_indicator_faile($chk_type,$bgy_id,$val_wait){
		$where_bgy = "";
		$where_dfine_str_id = "";
		
		if($chk_type == 1){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_str_id = '$val_wait'";
			}
		}else if($chk_type == 2){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_indgp_id = '$val_wait'";
			}
		}
		
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id
				WHERE dfine_status_assessment = 1 AND dfine_status != 0
					".$where_bgy."
					".$where_dfine_str_id."";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_faile
	
	function get_indicator_pass($chk_type,$bgy_id,$val_wait){
		$where_bgy = "";
		$where_dfine_str_id = "";
		if($chk_type == 1){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_str_id = '$val_wait'";
			}
		}else if($chk_type == 2){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_indgp_id = '$val_wait'";
			}
		}
		
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id
				WHERE dfine_status_assessment = 2 AND dfine_status != 0
					".$where_bgy."
					".$where_dfine_str_id."";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_pass
	
	function get_indicator_notprocessed($chk_type,$bgy_id,$val_wait){
		$where_bgy = "";
		$where_dfine_str_id = "";
		if($chk_type == 1){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_str_id = '$val_wait'";
			}
		}else if($chk_type == 2){
			if($bgy_id > 0){
				$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
			}
			if($val_wait > 0){
				$where_dfine_str_id = "AND dfine_indgp_id = '$val_wait'";
			}
		}
		
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id
				WHERE dfine_status_assessment = 0 AND dfine_status != 0
					".$where_bgy."
					".$where_dfine_str_id."";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_notprocessed
} //End class
?>