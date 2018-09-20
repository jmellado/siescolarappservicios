<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notas_model extends CI_Model {


	public function buscar_asignatura($id_estudiante){

		$ano_lectivo = $this->notas_model->obtener_anio_actual();

		$this->db->where('matriculas.ano_lectivo',$ano_lectivo);
		$this->db->where('matriculas.id_estudiante',$id_estudiante);
		$this->db->where('notas.ano_lectivo',$ano_lectivo);
		$this->db->where('notas.id_estudiante',$id_estudiante);

		$this->db->order_by('asignaturas.nombre_asignatura', 'asc');

		$this->db->join('notas', 'matriculas.id_estudiante = notas.id_estudiante');
		$this->db->join('asignaturas', 'notas.id_asignatura = asignaturas.id_asignatura');

		$this->db->select('matriculas.id_estudiante,notas.id_asignatura,asignaturas.nombre_asignatura');

		$query = $this->db->get('matriculas');

		return $query->result();
		
	}


	public function buscar_actividad($id_asignatura,$id_estudiante){

		$ano_lectivo = $this->notas_model->obtener_anio_actual();

		$this->db->where('actividades.ano_lectivo',$ano_lectivo);
		$this->db->where('actividades.id_asignatura',$id_asignatura);
		$this->db->where('notas_actividades.id_estudiante',$id_estudiante);

		$this->db->order_by('notas_actividades.fecha_registro', 'desc');

		$this->db->join('notas_actividades', 'actividades.id_actividad = notas_actividades.id_actividad');
		$this->db->join('asignaturas', 'actividades.id_asignatura = asignaturas.id_asignatura');

		$this->db->select('actividades.id_actividad,actividades.descripcion_actividad,actividades.id_asignatura,asignaturas.nombre_asignatura,actividades.periodo,IFNULL(notas_actividades.nota,"Sin Nota") as nota,notas_actividades.fecha_registro',false);

		$query = $this->db->get('actividades');

		return $query->result();
		
	}


	public function obtener_anio_actual(){

		$this->db->where('estado_ano_lectivo','Activo');
		$query = $this->db->get('anos_lectivos');

		if ($query->num_rows() > 0) {

			$row = $query->result_array();
			$id_ano_lectivo = $row[0]['id_ano_lectivo'];

			return $id_ano_lectivo;
		}
		else{
			return false;
		}

	}




}