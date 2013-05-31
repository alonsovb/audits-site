<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('audits_model');
	}


	public function headquarters()
	{
		$result = $this->audits_model->headquarters();
		echo json_encode($result);
	}

	public function buildings($headquarter)
	{
		$result = $this->audits_model->buildings($headquarter);
		echo json_encode($result);
	}

	public function rooms($building)
	{
		$result = $this->audits_model->rooms($building);
		echo json_encode($result);
	}
}