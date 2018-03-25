<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes_model extends CI_Model {


	public function buscar_mensaje($id_persona){

		$this->db->where("(rol_destinatario = 1 OR rol_destinatario = 3 OR rol_destinatario = 4)");
		$this->db->where('destinatario',$id_persona);
		$this->db->where('categoria_notificacion',"Mensajes");

		$this->db->order_by('fecha_envio', 'desc');

		$this->db->join('personas', 'notificaciones.remitente = personas.id_persona');

		$this->db->select('id_notificacion,codigo_notificacion,categoria_notificacion,remitente,titulo,tipo_notificacion,contenido,destinatario,rol_destinatario,fecha_envio,estado_lectura,personas.nombres,personas.apellido1,personas.apellido2');

		$query = $this->db->get('notificaciones');

		return $query->result();
		
	}


	public function detalle_mensaje($id_notificacion){

		$this->db->where('id_notificacion',$id_notificacion);

		$this->db->join('personas', 'notificaciones.remitente = personas.id_persona');

		$this->db->select('id_notificacion,codigo_notificacion,categoria_notificacion,remitente,titulo,tipo_notificacion,contenido,destinatario,rol_destinatario,fecha_envio,estado_lectura,personas.nombres,personas.apellido1,personas.apellido2');

		$query = $this->db->get('notificaciones');

		return $query->result();
		
	}




}