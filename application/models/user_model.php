<?php
/**
 * Modelo encargado de obtener datos de usuario
 */
class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Autentificar un usuario
	 * @param  String $username Nombre de usuario
	 * @param  String $password Contraseña
	 * @return Array            Datos del usuario si se autentificó
	 */
	function auth( $username, $password ) {
		$this->db->select( 'name, username' );
		$this->db->where( 'username', $username );
		$this->db->where( 'password', $password );
		return $this->db->get( 'users' )->result();
	}
}