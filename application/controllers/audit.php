<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta clase se encarga de manejar las auditorías, desde mostrar el historial,
 * ver una auditoría específica (con cada uno de sus activos), así como de 
 * agregar nuevas auditorías, actualizarlas y eliminarlas.
 */
class Audit extends CI_Controller {

	/**
	 * Redirigir al historial
	 */
	public function index() {
		redirect('audit/history');
	}

	/**
	 * Muestra un historial de auditorías
	 */
	public function history() {
		// Si la sesión no existe, redirigir al login.
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->load->model('audits_model');
		$data['username'] = $this->session->userdata('name');

		$data['title'] = 'Historial';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'audit/history');
		$data['css']   = array('libs/jqueryui', 'general/main', 'audit/history');
		
		// Obtener auditorías
		$audits = $this->audits_model->audits();
		// Modificar formato de fecha para ser más legible
		foreach ($audits as $audit) {
			$date = date_parse($audit->date);
			$audit->date = $date['day']."/".$date['month']."/".$date['year'];
		}
		$data['audits'] = $audits;
		$data['view_url'] = base_url('audit/view');
		$data['delete_url'] = base_url('audit/delete');

		$this->load->view('general/head', $data);
		$this->load->view('general/header', $data);
		$this->parser->parse('audit/history', $data);
		$this->load->view('general/footer');
	}

	public function view($id_audit)
	{
		// Si la sesión no existe, redirigir al login.
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
		}
		$this->load->model('audits_model');

		$data['title'] = 'Ver auditoría';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'audit/view');
		$data['css']   = array('libs/jqueryui', 'general/main', 'audit/view');

		$data['username'] = $this->session->userdata('name');

		// Obtener la auditoría mostrada
		$audit = $this->audits_model->audit($id_audit);
		$data['audit'] = $audit;

		$audit_assets = $this->audits_model->audit_assets($id_audit);
		// Convertir los valores booleanos en texto para ser mostrados
		// en inputs
		foreach ($audit_assets as $audit_asset) {
			$audit_asset->present = ($audit_asset->present) ? 'checked' : '';
			$audit_asset->state = ($audit_asset->state) ? 'checked' : '';
		}
		$data['audit_assets'] = $audit_assets;
		$data['history_url'] = base_url('audit/history');
		$data['ajax_url'] = base_url('audit/update');
		$data['delete_url'] = base_url('audit/delete');
		$data['disabled'] = ($audit[0]->completed == 1) ? 'disabled' : '';
		
		$this->load->view('general/head', $data);
		$this->load->view('general/header', $data);
		$this->parser->parse('audit/view', $data);
		$this->load->view('general/footer');
	}

	public function add() {
		// Si la sesión no existe, redirigir al login.
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->form_validation->set_rules('room', 'room', 'required');

		if ($this->form_validation->run() === false) {
			// En caso de no validar, mostrar view para agregar una nueva auditoría
			$data['title']    = 'Agregar auditoría';
			$data['js']       = array('libs/jquery', 'libs/jqueryui', 'general/data', 'audit/add');
			$data['css']      = array('libs/jqueryui', 'general/main', 'general/form');
			$data['username'] = $this->session->userdata('name');
			$data['base_url'] = base_url('');
			$data['add_url'] = base_url('audit/add');

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);
			$this->parser->parse('audit/add', $data);
			$this->load->view('general/footer');
		} else {
			// Al agregar una nueva auditoría, convertir los valores recibidos
			$room = $this->input->post('room');
			$this->load->model('audits_model');
			// Agregar una nueva auditoría con la sala seleccionada y con el comentario
			// en blanco (por defecto)
			$audit = array('room' => $room,
				'comment' => '');
			// Insertar en la base de datos
			$audit = $this->audits_model->audit_insert($audit);
			// Insertar cada activo que tiene la sala en la auditoría
			$assets = $this->audits_model->assets($room);
			foreach ($assets as $asset) {
				$audit_asset->audit = $audit;
				$audit_asset->asset = $asset->id_asset;
				$audit_asset->present = 1;
				$audit_asset->state = 1;
				$audit_asset->rating = 10;
				$audit_asset->comment = '';
				$this->audits_model->audit_asset_insert($audit_asset);
			}
			// Al insertar, redirigir a la vista de auditoría
			redirect('audit/view/'.$audit);
		}
	}

	public function update($tipo) {
		// Si la sesión no existe, redirigir al login.
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->load->model('audits_model');
		// Dos tipos de actualizar: asset y audit.
		if ($tipo === 'asset') {
			// Obtener el activo y la auditoría
			$asset_id = $this->input->post('asset');
			$audit_id = $this->input->post('audit');
			// Obtener datos del activo
			$asset = new stdClass();
			$asset->rating 	= intval($this->input->post('rating'));

			// Procesar valores booleanos
			$asset->present = $this->input->post('present');
			if ($asset->present == 'true') {
				$asset->present = 1;
			} else {
				$asset->present = 0;
			}
			$asset->state 	= $this->input->post('state');
			if ($asset->state == 'true') {
				$asset->state = 1;
			} else {
				$asset->state = 0;
			}
			$asset->comment = $this->input->post('comment');

			// Actualizar en la base de datos
			$this->audits_model->audit_asset_update($audit_id, $asset_id, $asset);
		} else if ($tipo === 'audit') {
			// Actualizar una auditoría
			// Obtener el ID de auditoría
			$audit_id = $this->input->post('audit_id');
			$audit = new stdClass();
			$audit->comment 	= $this->input->post('comment');
			$audit->completed 	= $this->input->post('completed');
			// Actualizar en la base de datos
			$this->audits_model->audit_update($audit_id, $audit);
		}
	}

	public function delete() {
		// Si la sesión no existe, redirigir al login.
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->load->model('audits_model');
		// Obtener ID de la auditoría
		$audit_id = $this->input->post('audit_id');
		// Eliminar en la base de datos
		$this->audits_model->audit_delete($audit_id);
		echo 'true';
	}
}