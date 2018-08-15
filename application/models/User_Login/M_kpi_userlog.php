<?php
/*	
* Class M_kpiuser	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-09
*/
include_once(dirname(__FILE__)."/Da_kpi_userlog.php");
// include_once("Kpims_model.php");
class M_kpi_userlog extends Da_kpi_userlog {	
	
	function __construct() {
		parent::__construct();
		
	}
	
	function check_login($id, $passwd){
        $sql = "SELECT * FROM ".$this->db_kpims.".".$this->config->item("kpims_prefix")."user 
				WHERE us_username='$id' and us_password='$passwd' and us_active = 1";
        $query = $this->db_KPIMS->query($sql);

        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
	}//End fn check_login
	
}
?>