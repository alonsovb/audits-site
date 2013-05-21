<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('user') === false) {
			$data['title'] = 'Audits';
			$data['js']    = array();
			$data['css']   = array();

			$this->load->view('general/head', $data);
			$this->load->view('general/header');
		} else {
			$data['title'] = 'Audits';
			$data['js']    = array();
			$data['css']   = array();

			// $data['username'] = $this->session->userdata('usuario')->name;
			
			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);
		}
		$this->load->view('general/footer');
	}
}
