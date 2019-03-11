 <?php
/*	
* Class M_kpi_report_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-9-02
*/
include_once(dirname(__FILE__)."/Da_kpi_report_indicator.php");
class M_kpi_report_indicator extends Da_kpi_report_indicator {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_all(){
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				WHERE dfine.dfine_status != 0 AND dfine.dfine_status_assessment !=0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_all
	
	function get_search_by_id($bgy_id,$indgp_id,$resm_ps_id,$ptm_id){
		$select = "";
		$join_main = "";
		$join_sub = "";
		$where_bgy = "";
		$where_indgp = "";
		$where_resm = "";
		if($bgy_id > 0){
			$where_bgy = "AND bgy.bgy_id='$bgy_id'";
		}
		if($indgp_id > 0){
			$where_indgp = "AND indgp.indgp_id='$indgp_id'";
		}
		
		if($ptm_id == 1){
			if($resm_ps_id > 0){
				$select = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status,dfine.dfine_status_action,dfine.dfine_status_assessment,dfine.dfine_follow_status, resm.resm_id, resm.resm_ps_id,resm.resm_name";
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id";
				$where_resm = "AND resm.resm_ps_id='$resm_ps_id'";
			}
		}else if($ptm_id == 2){
			if($resm_ps_id > 0){
				$select = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status,dfine.dfine_status_action,dfine.dfine_status_assessment,dfine.dfine_follow_status, resm.resm_id, resm.resm_ps_id,resm.resm_name";
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id";
				$join_sub = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id";
				$where_resm = "AND ress.ress_ps_id='$resm_ps_id'";
			}
		}else if($ptm_id == 0){
			$select = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status,dfine.dfine_status_action,dfine.dfine_status_assessment,dfine.dfine_follow_status";
		}
		
		$sql = 	$select." FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				".$join_main."
				".$join_sub."
				WHERE dfine.dfine_status != 0 
					".$where_bgy."
					".$where_indgp."
					".$where_resm." 
				ORDER BY bgy.bgy_id,dfine.dfine_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_search_by_id
	
	function get_search_by_bgy_id($bgy_id){
		$where_bgy = "";
		if($bgy_id > 0){
			$where_bgy = "AND bgy.bgy_id='$bgy_id'";
		}
		
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status,dfine.dfine_status_action,dfine.dfine_status_assessment,dfine.dfine_follow_status
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				WHERE dfine.dfine_status != 0 
					".$where_bgy." 
				ORDER BY bgy.bgy_id,dfine.dfine_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_search_by_bgy_id
	
	function get_search_export($bgy_id,$indgp_id,$resm_ps_id,$ptm_id){
		$where_bgy = "";
		$where_indgp = "";
		$where_resm = "";
		if($bgy_id > 0){
			$where_bgy = "AND bgy.bgy_id='$bgy_id'";
		}
		if($indgp_id > 0){
			$where_indgp = "AND indgp.indgp_id='$indgp_id'";
		}
		
		if($ptm_id == 1){
			if($resm_ps_id > 0){
				$where_resm = "AND resm.resm_ps_id='$resm_ps_id'";
			}
		}else if($ptm_id == 2){
			if($resm_ps_id > 0){
				$where_resm = "AND ress.ress_ps_id='$resm_ps_id'";
			}
		}
		
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id
				WHERE dfine.dfine_status != 0
					".$where_bgy."
					".$where_indgp."
					".$where_resm." 
				ORDER BY bgy.bgy_id,dfine.dfine_id ASC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_search_export
	
	function get_indicator_faile($bgy_id,$indgp_id,$resm_id,$ptm_id){
		$where_bgy = "";
		$where_indgp = "";
		$where_resm = "";
		$join_main = "";
		$join_sub = "";
		if($bgy_id > 0){
			$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
		}
		if($indgp_id > 0){
			$where_indgp = "AND dfine_indgp_id = '$indgp_id'";
		}
		
		if($ptm_id == 1){
			if($resm_id > 0){
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$where_resm = "AND resm.resm_ps_id='$resm_id'";
			}
		}else if($ptm_id == 2){
			if($resm_id > 0){
				$join_sub = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id";
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$where_resm = "AND ress.ress_ps_id='$resm_id'";
			}
		}
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				".$join_main."
				".$join_sub."
				WHERE dfine_status_assessment = 1 AND dfine_status != 0
					".$where_bgy."
					".$where_indgp."
					".$where_resm." ";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_faile
	
	function get_indicator_pass($bgy_id,$indgp_id,$resm_id,$ptm_id){
		$where_bgy = "";
		$where_indgp = "";
		$where_resm = "";
		$join_main = "";
		$join_sub = "";
		if($bgy_id > 0){
			$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
		}
		if($indgp_id > 0){
			$where_indgp = "AND dfine_indgp_id = '$indgp_id'";
		}
		
		if($ptm_id == 1){
			if($resm_id > 0){
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$where_resm = "AND resm.resm_ps_id='$resm_id'";
			}
		}else if($ptm_id == 2){
			if($resm_id > 0){
				$join_sub = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id";
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$where_resm = "AND ress.ress_ps_id='$resm_id'";
			}
		}
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				".$join_main."
				".$join_sub."
				WHERE dfine_status_assessment = 2 AND dfine_status != 0
					".$where_bgy."
					".$where_indgp."
					".$where_resm." ";
		$query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_pass
	
	function get_indicator_notprocessed($bgy_id,$indgp_id,$resm_id,$ptm_id){
		$where_bgy = "";
		$where_indgp = "";
		$where_resm = "";
		$join_main = "";
		$join_sub = "";
		if($bgy_id > 0){
			$where_bgy = "AND dfine_bgy_id = '$bgy_id'";
		}
		if($indgp_id > 0){
			$where_indgp = "AND dfine_indgp_id = '$indgp_id'";
		}
		
		if($ptm_id == 1){
			if($resm_id > 0){
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$where_resm = "AND resm.resm_ps_id='$resm_id'";
			}
		}else if($ptm_id == 2){
			if($resm_id > 0){
				$join_main = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON dfine_id = resm.resm_dfine_id";
				$join_sub = "LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_sub as ress ON ress.ress_resm_id = resm.resm_id";
				$where_resm = "AND ress.ress_ps_id='$resm_id'";
			}
		}
		$sql = "SELECT COUNT(dfine_status_assessment) as dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				".$join_main."
				".$join_sub."
				WHERE dfine_status_assessment = 0 AND dfine_status != 0
					".$where_bgy."
					".$where_indgp."
					".$where_resm." ";
		$query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_indicator_notprocessed
	
	function get_name_indicator_by_status_assessment($bgy_id,$status_assessment){
		$where_bgy = "";
		$where_status_assessment = "";
		if($bgy_id > 0){
			$where_bgy = "AND bgy.bgy_id='$bgy_id'";
		}
		if($status_assessment == 2){
			$where_status_assessment = "AND dfine.dfine_status_assessment='$status_assessment'";
		}else if($status_assessment == 1){
			$where_status_assessment = "AND dfine.dfine_status_assessment='$status_assessment'";
		}else if($status_assessment == 0){
			$where_status_assessment = "AND dfine.dfine_status_assessment='$status_assessment'";
		}

		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				WHERE dfine.dfine_status != 0 
					".$where_bgy."
					".$where_status_assessment."
				ORDER BY str.str_name ASC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_name_indicator_by_status_assessment
	
	function get_report_indicator_by_id($dfine_id){
		$where_dfine_id = "";
		if($dfine_id > 0){
			$where_dfine_id = "AND dfine.dfine_id='$dfine_id'";
		}
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				WHERE dfine.dfine_status != 0 
					".$where_dfine_id." 
				ORDER BY bgy.bgy_id,dfine.dfine_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_report_indicator_by_id
	
	function get_report_indicator_by_follow_status($bgy_id){
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				WHERE dfine.dfine_follow_status = 1 AND dfine.dfine_bgy_id = '$bgy_id'
				";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_report_indicator_by_follow_status
	
	function get_ind_result_by_id($dfine_id){
		$sql = "SELECT *
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result 
				WHERE indrs_dfind_id = '$dfine_id'";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_ind_result_by_id
} //End fn 
?>