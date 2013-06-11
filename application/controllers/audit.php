<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit extends CI_Controller {

	public function index() {
		redirect('audit/history');
	}

	public function history() {
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->load->model('audits_model');
		$data['username'] = $this->session->userdata('name');

		$data['title'] = 'Historial';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'audit/history');
		$data['css']   = array('libs/jqueryui', 'general/main', 'audit/history');
		
		$audits = $this->audits_model->audits();
		foreach ($audits as $audit) {
			$date = date_parse($audit->date);
			$audit->date = $date['day']."/".$date['month']."/".$date['year'];
		}
		$data['audits'] = $audits;
		$data['view_url'] = base_url('audit/view');

		$this->load->view('general/head', $data);
		$this->load->view('general/header', $data);
		$this->parser->parse('audit/history', $data);
		$this->load->view('general/footer');
	}

	public function view($id_audit)
	{
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
		}
		$this->load->model('audits_model');

		$data['title'] = 'Ver auditoría';
		$data['js']    = array('libs/jquery', 'libs/jqueryui', 'audit/view');
		$data['css']   = array('libs/jqueryui', 'general/main', 'audit/view');

		$data['username'] = $this->session->userdata('name');

		$data['audit'] = $this->audits_model->audit($id_audit);

		$audit_assets = $this->audits_model->audit_assets($id_audit);
		foreach ($audit_assets as $audit_asset) {
			$audit_asset->present = ($audit_asset->present) ? 'checked' : '';
			$audit_asset->state = ($audit_asset->state) ? 'checked' : '';
		}
		$data['audit_assets'] = $audit_assets;
		$data['history_url'] = base_url('audit/history');
		$data['ajax_url'] = base_url('audit/update');
		
		$this->load->view('general/head', $data);
		$this->load->view('general/header', $data);
		$this->parser->parse('audit/view', $data);
		$this->load->view('general/footer');
	}

	public function add() {
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
			return;
		}
		$this->form_validation->set_rules('room', 'room', 'required');

		if ($this->form_validation->run() === false) {
			
			$data['title']    = 'Agregar auditoría';
			$data['js']       = array('libs/jquery', 'libs/jqueryui', 'general/data', 'audit/add');
			$data['css']      = array('libs/jqueryui', 'general/main', 'general/form');
			$data['username'] = $this->session->userdata('name');

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);
			$this->load->view('audit/add');
			$this->load->view('general/footer');
		} else {
			$room = $this->input->post('room');
			$this->load->model('audits_model');
			$audit = array('room' => $room,
				'comment' => '');
			$audit = $this->audits_model->audit_insert($audit);
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
			redirect('audit/view/'.$audit);
		}
	}

	public function update($tipo) {
		$this->load->model('audits_model');
		if ($tipo === 'asset') {
			$asset_id = $this->input->post('asset');
			$audit_id = $this->input->post('audit');
			$asset = new stdClass();
			$asset->rating 	= intval($this->input->post('rating'));
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

			$this->audits_model->audit_asset_update($audit_id, $asset_id, $asset);
		} else if ($tipo === 'audit') {
			$audit_id = $this->input->post('audit_id');
			$audit = new stdClass();
			$audit->comment 	= $this->input->post('comment');
			$audit->completed 	= $this->input->post('completed');
			$this->audits_model->audit_update($audit_id, $audit);
		}
	}
}