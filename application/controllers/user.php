<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador encargado del manejo de usuarios, tanto el Login
 * como el Logout
 */
class User extends CI_Controller {

	/**
	 * No hay raíz para este controlador, redirigir al inicio
	 */
	public function index()
	{
		redirect('');
	}

	/**
	 * Realizar el Login de un usuario
	 */
	public function login()
	{
		// Si ya hay una sesión activa, redirigir al inicio
		if ($this->session->userdata('username') !== false) {
			redirect('');
		}
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run() !== false) {
			
			// Obtener valores de usuario y contraseña
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));
			$this->load->model('user_model');
			
			// Autentificar con base de datos
			$result = $this->user_model->auth($username, $password);

			// Si se verifica correctamente, obtener los datos y
			// crear la sesión
			if (is_array($result) && count($result) > 0) {
				$this->session->set_userdata($result[0]);
				redirect('home');
			}
		}
		$data['css'] = array('general/main', 'general/form', 'libs/jqueryui');
		$data['js']  = array('libs/jquery', 'libs/jqueryui', 'user/login');
		$this->load->view('general/head', $data);
		$this->load->view('general/header');
		$this->load->view('user/login');
	}

	/**
	 * Cerrar la sesión activa
	 */
	public function logout()
	{
		// Destruir la sesión actual
		$this->session->sess_destroy();
		redirect('');
	}
}