<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		redirect('');
	}

	public function login()
	{
		$data['css'] = array('general/main');

		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run() !== false) {
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));
			$this->load->model('user_model');
			$result = $this->user_model->auth($username, $password);
			if (is_array($result) && count($result) > 0) {
				$this->session->set_userdata($result[0]);
				redirect('home');
			} else {
				echo 'Not validated';
			}
		}

		$this->load->view('general/head', $data);
		$this->load->view('general/header');
		$this->load->view('user/login');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}
}