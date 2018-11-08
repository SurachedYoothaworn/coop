<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__)."\kpims_Controller.php");

class Login extends kpims_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->model('User_Login/M_kpi_user','us');
        $this->load->model('User_Login/M_kpi_userlog','uslog');
    }  
    
    public function index(){
        if($this->checkUser()){
            // $this->output('public_home');
			if($this->session->userdata('us_permission') == 1){ //Admin
				$this->session->set_userdata('menu_active',1);
				redirect('Dashborad');
			}else{
				redirect('Result_indicator');
			}
        }else{
            $this->login();
        }
		
    } //End fn index

    public function login(){
		$data['chk_login_failed'] = 0;
        $this->output('page_login',$data);
    } //End fn login

    public function checklogin(){
		 // $this->session->sess_destroy();
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$url = "http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_checkLogin.php/";
		$data = array("username" => $username, "password" => $password); 
		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_FAILONERROR, true); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
		$rs_services = json_decode(curl_exec($curl));
		
		
		$json = file_get_contents('http://med.buu.ac.th/scan-med/scanningPersonnel/API/api_getPerson.php');
		$rs_person = json_decode($json, TRUE);
		// $rs_services->data_result->us_name);

		if($rs_services->data_unit == 1){
            $this->session->set_userdata('us_id',$rs_services->data_result->us_id);
			if($rs_services->data_result->us_ref_ps_id == null || $rs_services->data_result->us_ref_ps_id == ""){
				$this->session->set_userdata('us_ps_id',0);
			}else{
				$this->session->set_userdata('us_ps_id',$rs_services->data_result->us_ref_ps_id);
			}
            $this->session->set_userdata('us_username',$rs_services->data_result->us_name);
			$this->session->set_userdata('us_ref_ug_id',$rs_services->data_result->us_ref_ug_id);
			$this->session->set_userdata('us_permission',$rs_services->data_result->us_ref_ug_id);
			foreach($rs_person['data_result'] as $row){
				if($rs_services->data_result->us_ref_ps_id == $row['ps_id']){
					$ps_name = $row['pf_title_th'].''.$row['ps_fname_th'].' '.$row['ps_lname_th'];
					$this->session->set_userdata('us_ps_name',$ps_name);
				}
			}
            $this->session->set_userdata('logged_in',TRUE);
            $this->uslog->login();
			
			echo json_encode(true);
			// redirect('Login', 'refresh');  
			// return true;
		}else{
			echo json_encode(false);
			// redirect('Login', 'refresh');  
			// return false;
		}   
    } //End fn checklogin

    public function logout(){
        $this->uslog->logout();
        // $this->session->unset_userdata('us_id');
        $this->session->sess_destroy();
        redirect('Login', 'refresh'); 
    } //End fn logout
	
}
