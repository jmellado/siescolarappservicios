<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asistencias_model extends CI_Model {


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


	public function buscar_asistencia($id_asignatura,$id_estudiante){

		$ano_lectivo = $this->asistencias_model->obtener_anio_actual();

		$this->db->where('asistencias.ano_lectivo',$ano_lectivo);
		$this->db->where('asistencias.id_asignatura',$id_asignatura);
		$this->db->where('asistencias.id_estudiante',$id_estudiante);

		$this->db->order_by('asistencias.fecha', 'desc');

		$this->db->join('personas', 'asistencias.id_estudiante = personas.id_persona');
		$this->db->join('cursos', 'asistencias.id_curso = cursos.id_curso');
		$this->db->join('grados', 'cursos.id_grado = grados.id_grado');
		$this->db->join('grupos', 'cursos.id_grupo = grupos.id_grupo');
		$this->db->join('asignaturas', 'asistencias.id_asignatura = asignaturas.id_asignatura');

		$this->db->select('asistencias.id_asistencia,asistencias.ano_lectivo,asistencias.id_profesor,asistencias.id_curso,asistencias.id_asignatura,asistencias.id_estudiante,asistencias.periodo,asistencias.fecha,asistencias.asistencia,asistencias.horas,asistencias.fecha_registro,grados.nombre_grado,grupos.nombre_grupo,cursos.jornada,personas.identificacion,personas.nombres,personas.apellido1,personas.apellido2,asignaturas.nombre_asignatura');

		$query = $this->db->get('asistencias');

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