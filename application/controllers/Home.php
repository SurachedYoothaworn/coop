<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("kpims_Controller.php");

class Home extends kpims_Controller {

	public function index()
	{
		$this->output('v_home');
	}
	
}