  <?php
/*	
* Class Da_test	
* @author Surached Yoothaworn 58160156 
* @Create Date 2561-8-08
*/
include_once(dirname(__FILE__)."/../Kpims_model.php");
class Da_kpi_userlog extends Kpims_model {

	public $LogAction;

	function __construct() {
		parent::__construct();
	}

	function login(){
		$sql = " INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."userlog(uslog_id,uslog_time,uslog_usId,uslog_action) VALUES ('',CURRENT_TIMESTAMP,?,?)";
		$this->LogAction = "เข้าสู่ระบบ สำเร็จ";
		$this->db_KPIMS->query($sql,array($this->session->userdata('us_id'), $this->LogAction));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	}

	function logout(){
		$sql = " INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."userlog (uslog_id,uslog_time,uslog_usId,uslog_action) VALUES ('',CURRENT_TIMESTAMP,?,?)";
		$this->LogAction = "ออกจากระบบ สำเร็จ";
		$this->db_KPIMS->query($sql,array($this->session->userdata('us_id'), $this->LogAction));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	}

	function login_wrongpass($us_id){
		$sql = " INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."userlog (uslog_id,uslog_time,uslog_usId,uslog_action) VALUES ('',CURRENT_TIMESTAMP,?,?)";
		$this->LogAction = "ไม่สามารถเข้าสู่ระบบได้ รหัสผ่านผิด";
		$this->db_KPIMS->query($sql,array($us_id, $this->LogAction));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	}

	function login_failed(){
		$sql = " INSERT INTO ".$this->db_kpims.".".$this->config->item("kpims_prefix")."userlog (uslog_id,uslog_time,uslog_usId,uslog_action) VALUES ('',CURRENT_TIMESTAMP,?,?)";
		$this->LogAction = "ไม่สามารถเข้าสู่ระบบได้ ไม่มีผู้ใช้นี้";
		$this->db_KPIMS->query($sql,array(0, $this->LogAction));
		$this->last_insert_id = $this->db_KPIMS->insert_id();
	}
	
}//End Class Da_test
?>