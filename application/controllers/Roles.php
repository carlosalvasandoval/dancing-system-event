<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}
	}

	public function index()
	{
		$this->get_template("roles/index");
	}

	public function grid()
	{
		echo $this->ion_auth->grid_roles();
	}
}
