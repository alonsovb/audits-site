<?php class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function auth( $username, $password ) {
		$this->db->select( 'name, username' );
		$this->db->where( 'username', $username );
		$this->db->where( 'password', $password );
		return $this->db->get( 'users' )->result();
	}
}