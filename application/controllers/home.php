<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Audits';
		$data['js']    = array();
		$data['css']   = array('general/main');

		if ($this->session->userdata('username') === false) {
			$this->load->view('general/head', $data);
			$this->load->view('general/header');
		} else {
			$data['username'] = $this->session->userdata('name');
			
			$audit1['name'] = '123';
			$data['audits'] = array($audit1);

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);

			$this->parser->parse('home/audit_list', $data);
		}
		$this->load->view('general/footer');
	}
}
