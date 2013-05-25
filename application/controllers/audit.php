<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit extends CI_Controller {

	public function index()
	{
	}

	public function view($id_audit)
	{
		$this->load->model('audits_model');
		$result = $this->audits_model->audit($id_audit);
		var_dump($result);
		$result = $this->audits_model->audit_assets($id_audit);
		var_dump($result);
	}

	public function add($date) {

	}
}