<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Audits';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'general/data', 'audit/add');
		$data['css']   = array('libs/jqueryui', 'general/main', 'general/form');

		if ($this->session->userdata('username') === false) {
			redirect('user/login');
		} else {
			$data['username'] = $this->session->userdata('name');

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);

			$this->load->view('home/home', $data);
			$this->load->view('audit/add');
		}
		$this->load->view('general/footer');
	}
}
