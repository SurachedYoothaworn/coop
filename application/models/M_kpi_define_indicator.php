 <?php
/*	
* Class M_kpi_define_indicator	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_define_indicator.php");
class M_kpi_define_indicator extends Da_kpi_define_indicator {	
	
	function __construct() {
		parent::__construct();
		
	}

    function get_all(){
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				WHERE dfine.dfine_status != 0 ORDER BY bgy.bgy_id  , dfine.dfine_ind_id DESC";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }
	
	function get_by_id($dfine_id){
		$sql = "SELECT dfine.dfine_id,ind.ind_name,ind.ind_description,bgy.bgy_name,str.str_name,indgp.indgp_name,opt.opt_name,opt.opt_symbol,dfine.dfine_goal,unt.unt_name,side.side_name ,ind.ind_id,bgy.bgy_id,str.str_id,indgp.indgp_id,opt.opt_id,unt.unt_id,side.side_id,dfine.dfine_status_action,dfine.dfine_status_assessment
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator as dfine
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator as ind ON dfine.dfine_ind_id = ind.ind_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year as bgy ON dfine.dfine_bgy_id = bgy.bgy_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy as str ON dfine.dfine_str_id = str.str_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group as indgp ON dfine.dfine_indgp_id = indgp.indgp_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit as unt ON dfine.dfine_unt_id = unt.unt_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side as side ON side.side_id = dfine.dfine_side_id
				LEFT JOIN ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator as opt ON opt.opt_id = dfine.dfine_opt_id
				WHERE dfine_id = '$dfine_id' AND dfine.dfine_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
    }
	
	// function get_indicator(){
		// $sql = "SELECT *
				// FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator
				// WHERE ind_status != 0";
        // $query = $this->db_KPIMS->query($sql);
        // return $query;
	// }
	
	function get_indicator($bgy_id){
		$sql = "SELECT ind_id, ind_name
				FROM kpi_indicator 
				WHERE ind_id NOT IN
					(SELECT dfine_ind_id 
					FROM kpi_indicator 
					LEFT JOIN kpi_define_indicator ON ind_id = dfine_ind_id
					WHERE dfine_bgy_id = '$bgy_id' AND dfine_status = 1)";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_indicator_edit($ind_id, $bgy_id){
		$sql = "SELECT ind_id, ind_name
				FROM kpi_indicator 
				WHERE ind_id NOT IN
					(SELECT dfine_ind_id 
					FROM kpi_indicator 
					LEFT JOIN kpi_define_indicator ON ind_id = dfine_ind_id
					WHERE dfine_bgy_id = '$bgy_id' AND dfine_status = 1)
				OR ind_id = '$ind_id'";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	// function get_indicator_by_ind_id($bgy_id, $ind_id){
		// $sql = "SELECT ind_id, ind_name
				// FROM kpi_indicator 
				// WHERE ind_id NOT IN
					// (SELECT dfine_ind_id 
					// FROM kpi_indicator 
					// LEFT JOIN kpi_define_indicator ON ind_id = dfine_ind_id
					// WHERE dfine_bgy_id = '$bgy_id' AND ind_id = '$ind_id' )";
        // $query = $this->db_KPIMS->query($sql);
        // return $query;
	// }
	
	function get_indicator_use_by_bgy(){
		$sql = "SELECT ind_id, ind_name, dfine_id,dfine_ind_id ,dfine_bgy_id , dfine_status
				FROM kpi_indicator 
				LEFT JOIN kpi_define_indicator ON ind_id = dfine_ind_id
				WHERE dfine_bgy_id = 2";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_budget_year(){
		$sql = "SELECT bgy_id, bgy_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."budget_year
				WHERE bgy_status != 0 ORDER BY bgy_id DESC ";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_side(){
		$sql = "SELECT side_id, side_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."side
				WHERE side_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_strategy(){
		$sql = "SELECT str_id, str_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."strategy
				WHERE str_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_indicator_group(){
		$sql = "SELECT indgp_id, indgp_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."indicator_group
				WHERE indgp_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_unit(){
		$sql = "SELECT unt_id, unt_name
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."unit
				WHERE unt_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_operator(){
		$sql = "SELECT opt_id, opt_name, opt_symbol
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."operator";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_ind_id(){
		$sql = "SELECT dfine_ind_id
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator
				WHERE dfine_status != 0";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}
	
	function get_follow_status_by_dfine_id($dfine_id){
		$sql = "SELECT dfine_follow_status
				FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."define_indicator 
				WHERE dfine_id = '$dfine_id'";
        $query = $this->db_KPIMS->query($sql);
        return $query;
	}

   
}
?>