<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acudidos_model extends CI_Model {


	public function buscar_acudido($id_persona){

		$ano_lectivo = $this->acudidos_model->obtener_anio_actual();

		$this->db->where('matriculas.ano_lectivo',$ano_lectivo);
		$this->db->where('matriculas.id_acudiente',$id_persona);

		$this->db->order_by('personas.apellido1', 'asc');
		$this->db->order_by('personas.apellido2', 'asc');
		$this->db->order_by('personas.nombres', 'asc');

		$this->db->join('personas', 'matriculas.id_estudiante = personas.id_persona');
		$this->db->join('cursos', 'matriculas.id_curso = cursos.id_curso');
		$this->db->join('grados', 'cursos.id_grado = grados.id_grado');
		$this->db->join('grupos', 'cursos.id_grupo = grupos.id_grupo');
		$this->db->join('salones', 'cursos.id_salon = salones.id_salon');

		$this->db->select('matriculas.id_acudiente,matriculas.id_estudiante,matriculas.id_curso,matriculas.jornada,personas.nombres,personas.apellido1,personas.apellido2,grados.nombre_grado,grupos.nombre_grupo,salones.nombre_salon');

		$query = $this->db->get('matriculas');

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