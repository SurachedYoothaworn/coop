 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Manual extends kpims_Controller {

    public function __construct(){
        parent::__construct();
    }
	
	function index(){
		$this->output('v_manual');
	} //End fn index
} //End class
?>    
 