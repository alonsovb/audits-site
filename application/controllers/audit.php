<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit extends CI_Controller {

	public function index() {
		redirect('audit/history');
	}

	public function history() {
		if ($this->session->userdata('username') === false) {
			redirect('user/login');
		} else {
			$this->load->model('audits_model');

			$data['username'] = $this->session->userdata('name');

			$data['title'] = 'Audits history';
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

			$this->parser->parse('home/audit_list', $data);
		}
		$this->load->view('general/footer');
	}

	public function view($id_audit)
	{
		$this->load->model('audits_model');
		$result = $this->audits_model->audit($id_audit);
		var_dump($result);
		$result = $this->audits_model->audit_assets($id_audit);
		var_dump($result);
	}

	public function add() {
		$this->form_validation->set_rules('room', 'room', 'required');

		if ($this->form_validation->run() === false) {
			
			$data['title']    = 'Agregar auditoría';
			$data['js']       = array('libs/jquery', 'general/data', 'audit/add');
			$data['css']      = array('general/main', 'general/form');
			$data['username'] = $this->session->userdata('name');

			$this->load->view('general/head', $data);
			$this->load->view('general/header', $data);
			$this->load->view('audit/add');
			$this->load->view('general/footer');
		} else {
			$room = $this->input->post('room');
			$this->load->model('audits_model');
			$audit = array('room' => $room,
				'date' => 'NOW()',
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
			// audit_insert (array)
			// audit_asset_insert
			redirect('audit/view/'.$audit);
		}
	}
}