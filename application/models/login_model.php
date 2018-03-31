<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	
	public function login_usuarios($username,$password){

		$this->db->select('id_usuario,usuarios.id_persona,roles.nombre_rol,username,acceso,personas.identificacion,personas.nombres,personas.apellido1,personas.apellido2');
		$this->db->from('usuarios');
		$this->db->join('roles', 'usuarios.id_rol = roles.id_rol');
		$this->db->join('personas', 'usuarios.id_persona = personas.id_persona');
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			
			return $query->row();
		}
		else{

			
			return false;
		}

	}


	//Actualiza El Token De Un Acudiente
	public function modificar_token($id_persona,$token){

		$usuarios = array('token' => $token);

		$this->db->where('id_persona',$id_persona);
		$this->db->where('id_rol',4);

		if ($this->db->update('usuarios', $usuarios))

			return true;
		else
			return false;
	}
}