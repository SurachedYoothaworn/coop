<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__)."\kpims_Controller.php");

class Authen extends kpims_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->model('User_Login/M_kpi_user','us');
        $this->load->model('User_Login/M_kpi_userlog','uslog');
       
    }  
    
    public function index(){
		// print_r($this->session->userdata('us_id'));die;
        // $this->session->unset_userdata('us_id');
        if($this->checkUser()){
            // $this->output('public_home');
			if($this->session->userdata('us_permission') == 1){
				redirect('Home');
			}else{
				redirect('Result_indicator');
			}
			// print_r($this->session->userdata('us_id'));die;
        }else{
            $this->login();
			// print_r($this->session->userdata('us_id'));die;
        }
		
    }

    public function login(){
        $this->output('page_login');
    }

    public function checklogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
        $user = $this->us->check_login($username, $password);
        if(!$user){
            $chk_user = $this->us->check_user($username);
            if(!$chk_user){ 
                //chack no user
                $this->uslog->login_failed();
            }else{ 
                //check pass failed 
                // pre($chk_user->result());die;
                $chk_usr = $chk_user->row_array();
                $this->uslog->login_wrongpass($chk_usr['us_id']);
            }
        }else{ 
            // login pass
            $usr = $user->row_array();
            $this->session->set_userdata('us_id',$usr['us_id']);
            $this->session->set_userdata('us_username',$usr['us_username']);
			$this->session->set_userdata('us_permission',$usr['us_permission']);
            $this->session->set_userdata('logged_in',TRUE);
            $this->uslog->login();
        }
        // pre($this->check_user()); die;
        redirect('Authen', 'refresh');       
    }

    public function logout(){
        $this->uslog->logout();
        // $this->session->unset_userdata('us_id');
        $this->session->sess_destroy();
        redirect('Authen', 'refresh'); 
    }
	
}
