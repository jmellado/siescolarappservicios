<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes_model extends CI_Model {


	public function buscar_mensaje($id_persona){

		$this->db->where("(rol_destinatario = 1 OR rol_destinatario = 3 OR rol_destinatario = 4)");
		$this->db->where('destinatario',$id_persona);
		$this->db->where('categoria_notificacion',"Mensajes");

		$this->db->order_by('fecha_envio', 'desc');

		$this->db->join('personas as pf', 'notificaciones.remitente = pf.id_persona');
		$this->db->join('personas as est', 'notificaciones.id_estudiante = est.id_persona');

		$this->db->select('id_notificacion,codigo_notificacion,categoria_notificacion,remitente,titulo,tipo_notificacion,contenido,destinatario,rol_destinatario,id_estudiante,fecha_envio,estado_lectura,pf.nombres,pf.apellido1,pf.apellido2,est.nombres as nombresest,est.apellido1 as apellido1est,est.apellido2 as apellido2est');

		$query = $this->db->get('notificaciones');

		return $query->result();
		
	}


	public function detalle_mensaje($id_notificacion){

		$this->db->where('id_notificacion',$id_notificacion);

		$this->db->join('personas as pf', 'notificaciones.remitente = pf.id_persona');
		$this->db->join('personas as est', 'notificaciones.id_estudiante = est.id_persona');

		$this->db->select('id_notificacion,codigo_notificacion,categoria_notificacion,remitente,titulo,tipo_notificacion,contenido,destinatario,rol_destinatario,id_estudiante,fecha_envio,estado_lectura,pf.nombres,pf.apellido1,pf.apellido2,est.nombres as nombresest,est.apellido1 as apellido1est,est.apellido2 as apellido2est');

		$query = $this->db->get('notificaciones');

		return $query->result();
		
	}


	public function actualizar_estado_lectura($id_notificacion){

		$notificaciones = array('estado_lectura' => '1');

		$this->db->where('id_notificacion',$id_notificacion);

		if ($this->db->update('notificaciones', $notificaciones))

			return true;
		else
			return false;

	}




}