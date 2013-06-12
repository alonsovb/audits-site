<?php
/**
 * Modelo para el manejo de auditorías
 */
class Audits_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Autentificar un usuario
	 * @param  String $username Nombre de usuario
	 * @param  String $password Contraseña
	 * @return Array            Arreglo con los datos del usuario encontrado
	 */
	function auth( $username, $password ) {
		$this->db->select( 'name, username' );
		$this->db->where( 'username', $username );
		$this->db->where( 'password', $password );
		return $this->db->get( 'users' )->result();
	}

	/**
	 * Obtiene la lista de sedes
	 * @return Array Lista de sedes
	 */
	function headquarters() {
		$this->db->select( 'name, id_hq' );
		return $this->db->get( 'headquarters' )->result();
	}

	/**
	 * Obtiene lista de edificios de una sede
	 * @param  int $headquarter Sede
	 * @return Array            Lista de edificios de la sede
	 */
	function buildings( $headquarter ) {
		$this->db->select( 'name, id_building' );
		$this->db->where( 'headquarter', $headquarter );
		return $this->db->get( 'buildings' )->result();
	}

	/**
	 * Obtiene la lista de salas de un edificio
	 * @param  int $building Edificio
	 * @return Array         Lista de salas del edificio
	 */
	function rooms( $building ) {
		$this->db->select( 'name, floor, id_room' );
		$this->db->where( 'building', $building );
		return $this->db->get( 'rooms' )->result();
	}

	/**
	 * Obtiene una auditoría
	 * @param  int $id_audit Índice de auditoría
	 * @return Array         Datos de la auditoría
	 */
	function audit($id_audit) {
		$this->db->select( 'rooms.name as room_name, buildings.name as building_name,
			headquarters.name as hq_name, id_audit, comment, floor as room_floor,
			completed, date' );
		$this->db->from( 'audits' );
		$this->db->join('rooms', 'rooms.id_room = audits.room', 'inner');
		$this->db->join('buildings', 'rooms.building = buildings.id_building', 'inner');
		$this->db->join('headquarters', 'buildings.headquarter = headquarters.id_hq', 'inner');
		$this->db->where( 'id_audit', $id_audit );
		return $this->db->get()->result();
	}

	/**
	 * Obtiene la lista de auditorías
	 * @return Array Lista de auditorías
	 */
	function audits() {
		$this->db->select( 'rooms.name as room_name, buildings.name as building_name,
			headquarters.name as hq_name, id_audit, comment, floor as room_floor,
			completed, date' );
		$this->db->from( 'audits' );
		$this->db->join('rooms', 'rooms.id_room = audits.room', 'inner');
		$this->db->join('buildings', 'rooms.building = buildings.id_building', 'inner');
		$this->db->join('headquarters', 'buildings.headquarter = headquarters.id_hq', 'inner');
		return $this->db->get()->result();
	}

	/**
	 * Obtiene la lista de activos de un salón
	 * @param  int $room Salón
	 * @return Array     Lista de activos
	 */
	function assets( $room ) {
		$this->db->select( '*' );
		$this->db->where( 'room', $room );
		return $this->db->get( 'assets' )->result();
	}

	/**
	 * Lista de activos de una auditoría
	 * @param  int $audit Auditoría
	 * @return Array      Lista de activos
	 */
	function audit_assets( $audit ) {
		$this->db->select( '*' );
		$this->db->where( 'audit', $audit );
		$this->db->join( 'assets', 'assets.id_asset = audit_assets.asset', 'inner');
		return $this->db->get( 'audit_assets' )->result();
	}

	/**
	 * Inserta una auditoría
	 * @param  Object $audit Datos de la auditoría
	 * @return int           Índice de la auditoría nueva
	 */
	function audit_insert( $audit ) {
		$this->db->insert('audits', $audit);
		return $this->db->insert_id();
	}

	/**
	 * Actualiza una auditoría
	 * @param  int $audit Índice de la auditoría
	 * @param  Object $data  Nuevos datos
	 */
	function audit_update( $audit, $data ) {
		$this->db->where( 'id_audit', $audit );
		$this->db->update( 'audits', $data );
	}

	/**
	 * Eliminar una auditoría
	 * @param  int $audit Auditoría
	 */
	function audit_delete( $audit ) {
		$this->db->where( 'id_audit', $audit );
		$this->db->delete( 'audits' );
	}

	/**
	 * Insertar un activo en auditoría
	 * @param  Object $audit_asset Datos del activo
	 * @return int                 Índice del activo
	 */
	function audit_asset_insert( $audit_asset ) {
		$this->db->insert('audit_assets', $audit_asset );
		return $this->db->insert_id();
	}

	/**
	 * Actualizar un activo en auditoría
	 * @param  int $audit_id    Índice de la auditoría
	 * @param  int $asset_id    Índice del activo
	 * @param  Object $audit_asset Datos del activo
	 */
	function audit_asset_update($audit_id, $asset_id, $audit_asset) {
		$this->db->where('audit', $audit_id);
		$this->db->where('asset', $asset_id);
		$this->db->update('audit_assets', $audit_asset );
	}
}