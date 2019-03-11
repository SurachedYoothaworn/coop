<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Routes_menu extends kpims_Controller {

    public function __construct(){
        parent::__construct();
		$this->session->set_userdata('menu_tree_active',0);
    }
	
	function link_page($id=""){
		if($id == 1){
			$this->session->set_userdata('menu_active',1);
			redirect('Dashborad');
		}
		if($id == 2){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',2);
			redirect('Manage_indicator');
		}
		if($id == 3){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',3);
			redirect('Manage_strategy');
		}
		if($id == 4){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',4);
			redirect('Manage_indicator_group');
		}
		if($id == 5){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',5);
			redirect('Manage_side');
		}
		if($id == 6){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',6);
			redirect('Manage_budget_year');
		}
		if($id == 7){
			$this->session->set_userdata('menu_tree_active',2);
			$this->session->set_userdata('menu_active',7);
			redirect('Manage_unit');
		}
		if($id == 8){
			$this->session->set_userdata('menu_active',8);
			redirect('Define_indicator');
		}
		if($id == 9){
			$this->session->set_userdata('menu_active',9);
			redirect('Result_indicator');
		}
		if($id == 10){
			$this->session->set_userdata('menu_active',10);
			redirect('Report_indicator');
		}
		if($id == 11){
			$this->session->set_userdata('menu_active',11);
			redirect('Manual');
		}
		if($id == 12){
			$this->session->set_userdata('menu_active',12);
			redirect('Follow_result');
		}
	} //End fn link_page
} //End class
?>    
 