 <?php
/*	
* Class M_kpi_result_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-9-02
*/
include_once(dirname(__FILE__)."/Da_kpi_result_indicator.php");
class M_kpi_result_indicator extends Da_kpi_result_indicator {	
	
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
				WHERE dfine.dfine_status != 0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_all
	
	function get_by_id($dfine_id){
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment, resm.resm_id, resm.resm_ps_id,resm.resm_name,resm.resm_pt_name,resm.resm_dept
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."responsibility_main as resm ON resm.resm_dfine_id = dfine.dfine_id
				WHERE dfine_id = '$dfine_id' AND dfine.dfine_status != 0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    } //End fn get_by_id
	
	function get_by_ps_id($ps_id){
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
				WHERE resm.resm_ps_id = '$ps_id' AND dfine.dfine_status != 0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_by_ps_id
	
	function get_ress_by_ps_id($ps_id){
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
				WHERE ress.ress_ps_id = '$ps_id' AND dfine.dfine_status != 0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn get_by_ps_id
	
	function get_result_by_id($dfind_id){
		$sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_result
				WHERE indrs_dfind_id = '$dfind_id'";
		$query = $this->db_KPIMS->query($sql);
        return $query;
	} //End fn  
} //End class
?>