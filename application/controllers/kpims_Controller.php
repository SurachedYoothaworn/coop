<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__)."\Main_Controller.php");

class kpims_Controller extends Main_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->helper('function_helper');
		$this->load->helper('date_helper');
    }
	
	public function index()
	{
		echo "Access system is forbidden.";
		// $this->output('starter_view');
	}
	
	function head(){ 
		$this->load->view('template/head');
	}
	
	function topbar(){
		$this->load->view('template/header_login');
	}
	
	function menu_sidebar(){
		$this->load->view('template/menu_sidebar_login');
	}
	
	function footer(){
		$this->load->view('template/footer');
	}
	
	function javascript(){
		$this->load->view('template/javascript');
	}
	
	function checkUser()
	{
		if($this->session->userdata('us_id'))
			return true;
		else 
			return false;
	}
	
	function output($body='',$data='')
	{
		if($this->checkUser())
		{
			$this->head();
			$this->javascript();
			$this->topbar();
			$this->menu_sidebar();
			$this->load->view($body,$data);
			$this->footer();
			
		}
		else
		{
			$this->head();
			$this->javascript();
			$this->load->view('page_login');
		}
	}
	
}
  