<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Este controlador se encarga de devolver información en objetos JSON.
 * Es usada en el sitio al hacer llamadas AJAX
 */
class Data extends CI_Controller {

	/**
	 * Cargar el modelo de auditorías
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('audits_model');
	}

	/**
	 * Obtener las sedes
	 * @return Array Sedes en la base de datos
	 */
	public function headquarters()
	{
		$result = $this->audits_model->headquarters();
		echo json_encode($result);
	}

	/**
	 * Obtiene los edificios de una sede
	 * @param  int $headquarter Índice de la sede
	 * @return Array Lista de edificios para la sede indicada
	 */
	public function buildings($headquarter)
	{
		$result = $this->audits_model->buildings($headquarter);
		echo json_encode($result);
	}

	/**
	 * Obtiene las salas de un edificio
	 * @param  int $building Índice del edificio
	 * @return Array Lista de salas de un edificio
	 */
	public function rooms($building)
	{
		$result = $this->audits_model->rooms($building);
		echo json_encode($result);
	}
}