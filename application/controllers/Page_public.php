<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__)."\Non_Login_Controller.php");

class Page_public extends Non_Login_Controller {

	public function home()
	{
		$this->output('public_home');
	}
	
}
