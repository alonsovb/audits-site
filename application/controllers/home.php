<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador encargado de mostrar la página inicial del sitio
 */
class Home extends CI_Controller {

	/**
	 * Muestra la página de inicio, incluyendo el módulo de insertar
	 * auditoría
	 */
	public function index()
	{
		$data['title'] = 'Audits';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'general/data', 'audit/add');
		$data['css']   = array('libs/jqueryui', 'general/main', 'general/form');

		if ($this->session->userdata('username') === false) {
			// Si no hay una sesión activa, redirigir al Login
			redirect('user/login');
		} else {
			$data['username'] = $this->session->userdata('name');

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);
			// View de inicio con link al historial
			$this->load->view('home/home', $data);
			// View de insersión de auditoría
			$data['base_url'] = base_url('');
			$data['add_url'] = base_url('audit/add');
			$this->parser->parse('audit/add', $data);
		}
		$this->load->view('general/footer');
	}
}
