<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__)."\Main_Controller.php");

class Non_Login_Controller extends Main_Controller {

	public function index()
	{
		echo "Access system is forbidden.";
		// $this->output('starter_view');
	}
	
	function head(){
		$this->load->view('template/head');
	}
	
	function topbar(){
		$this->load->view('template/header_non_login');
	}
	
	// function menu_sidebar(){
		// $this->load->view('template/menu_sidebar');
	// }
	
	function footer(){
		$this->load->view('template/footer');
	}
	
	function javascript(){
		$this->load->view('template/javascript');
	}
	
	function output($body='',$data='')
	{
			$this->head();
			$this->topbar();
			// $this->menu_sidebar();
			$this->load->view($body,$data);
			$this->footer();
			$this->javascript();
	}
	
}
