<?php class Audits_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function auth( $username, $password ) {
		$this->db->select( 'name, username' );
		$this->db->where( 'username', $username );
		$this->db->where( 'password', $password );
		return $this->db->get( 'users' )->result();
	}

	function headquarters() {
		$this->db->select( 'name, id_hq' );
		return $this->db->get( 'headquarters' )->result();
	}

	function buildings( $headquarter ) {
		$this->db->select( 'name, id_building' );
		$this->db->where( 'headquarter', $headquarter );
		return $this->db->get( 'buildings' )->result();
	}

	function rooms( $building ) {
		$this->db->select( 'name, floor, id_room' );
		$this->db->where( 'building', $building );
		return $this->db->get( 'rooms' )->result();
	}

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

	function assets( $room ) {
		$this->db->select( '*' );
		$this->db->where( 'room', $room );
		return $this->db->get( 'assets' )->result();
	}

	function audit_assets( $audit ) {
		$this->db->select( '*' );
		$this->db->where( 'audit', $audit );
		$this->db->join( 'assets', 'assets.id_asset = audit_assets.asset', 'inner');
		return $this->db->get( 'audit_assets' )->result();
	}

	function audit_insert( $audit ) {
		$this->db->insert('audits', $audit);
		return $this->db->insert_id();
	}

	function audit_update( $audit, $data ) {
		$this->db->where( 'id_audit', $audit );
		$this->db->update( 'audit', $data );
	}

	function audit_delete( $audit ) {
		$this->db->where( 'id_audit', $audit );
		$this->db->delete( 'audits' );
	}

	function audit_asset_insert( $audit_asset ) {
		$this->db->insert('audit_assets', $audit_asset );
		return $this->db->insert_id();
	}

	function audit_asset_update($audit_asset) {
		$this->db->where('audit', $audit_asset['audit']);
		$this->db->where('asset', $audit_asset['asset']);
		$this->db->update('audit_assets', $audit_asset );
	}
}