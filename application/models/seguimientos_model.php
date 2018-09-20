<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguimientos_model extends CI_Model {


	public function buscar_seguimiento($id_persona){

		$ano_lectivo = $this->seguimientos_model->obtener_anio_actual();

		$acudidos = $this->seguimientos_model->obtener_acudidos($id_persona,$ano_lectivo);

		$listaSeguimientos = array();

		for ($i=0; $i < count($acudidos); $i++) {

			$id_estudiante = $acudidos[$i]['id_estudiante'];

			$this->db->where('seguimientos_disciplinarios.ano_lectivo',$ano_lectivo);
			$this->db->where('seguimientos_disciplinarios.id_estudiante',$id_estudiante);

			$this->db->order_by('seguimientos_disciplinarios.fecha_registro', 'desc');

			$this->db->join('personas as est', 'seguimientos_disciplinarios.id_estudiante = est.id_persona');
			$this->db->join('personas as pf', 'seguimientos_disciplinarios.id_profesor = pf.id_persona');
			$this->db->join('asignaturas', 'seguimientos_disciplinarios.id_asignatura = asignaturas.id_asignatura');
			$this->db->join('tipos_causales', 'seguimientos_disciplinarios.id_tipo_causal = tipos_causales.id_tipo_causal');
			$this->db->join('causales', 'seguimientos_disciplinarios.id_causal = causales.id_causal');

			$this->db->select('seguimientos_disciplinarios.id_seguimiento,seguimientos_disciplinarios.id_curso,seguimientos_disciplinarios.id_asignatura,seguimientos_disciplinarios.id_estudiante,seguimientos_disciplinarios.id_tipo_causal,seguimientos_disciplinarios.id_causal,seguimientos_disciplinarios.descripcion_situacion,seguimientos_disciplinarios.fecha_causal,seguimientos_disciplinarios.id_accion_pedagogica,seguimientos_disciplinarios.descripcion_accion_pedagogica,seguimientos_disciplinarios.compromiso_estudiante,seguimientos_disciplinarios.observaciones,seguimientos_disciplinarios.estado_seguimiento,seguimientos_disciplinarios.fecha_registro,asignaturas.nombre_asignatura,est.nombres as nombresest,est.apellido1 as apellido1est,est.apellido2 as apellido2est,tipos_causales.tipo_causal,causales.causal,pf.nombres as nombrespf,pf.apellido1 as apellido1pf,pf.apellido2 as apellido2pf');

			$query = $this->db->get('seguimientos_disciplinarios');
			$seguimientos = $query->result_array();

			for ($j=0; $j < count($seguimientos); $j++) { 
				
				$listaSeguimientos[] = $seguimientos[$j];
			}


		}

		return $listaSeguimientos;
		
	}


	public function detalle_seguimiento($id_seguimiento){

		$this->db->where('seguimientos_disciplinarios.id_seguimiento',$id_seguimiento);

		$this->db->join('personas as est', 'seguimientos_disciplinarios.id_estudiante = est.id_persona');
		$this->db->join('personas as pf', 'seguimientos_disciplinarios.id_profesor = pf.id_persona');
		$this->db->join('cursos', 'seguimientos_disciplinarios.id_curso = cursos.id_curso');
		$this->db->join('asignaturas', 'seguimientos_disciplinarios.id_asignatura = asignaturas.id_asignatura');
		$this->db->join('tipos_causales', 'seguimientos_disciplinarios.id_tipo_causal = tipos_causales.id_tipo_causal');
		$this->db->join('causales', 'seguimientos_disciplinarios.id_causal = causales.id_causal');
		$this->db->join('acciones_pedagogicas', 'seguimientos_disciplinarios.id_accion_pedagogica = acciones_pedagogicas.id_accion_pedagogica');
		$this->db->join('grados', 'cursos.id_grado = grados.id_grado');
		$this->db->join('grupos', 'cursos.id_grupo = grupos.id_grupo');

		$this->db->select('seguimientos_disciplinarios.id_seguimiento,seguimientos_disciplinarios.id_curso,seguimientos_disciplinarios.id_asignatura,seguimientos_disciplinarios.id_estudiante,seguimientos_disciplinarios.id_tipo_causal,seguimientos_disciplinarios.id_causal,seguimientos_disciplinarios.descripcion_situacion,seguimientos_disciplinarios.fecha_causal,seguimientos_disciplinarios.id_accion_pedagogica,seguimientos_disciplinarios.descripcion_accion_pedagogica,seguimientos_disciplinarios.compromiso_estudiante,IF(seguimientos_disciplinarios.observaciones = "","Ninguna", seguimientos_disciplinarios.observaciones) as observaciones,seguimientos_disciplinarios.estado_seguimiento,seguimientos_disciplinarios.fecha_registro,grados.nombre_grado,grupos.nombre_grupo,cursos.jornada,asignaturas.nombre_asignatura,est.nombres as nombresest,est.apellido1 as apellido1est,est.apellido2 as apellido2est,tipos_causales.tipo_causal,causales.causal,acciones_pedagogicas.accion_pedagogica,pf.nombres as nombrespf,pf.apellido1 as apellido1pf,pf.apellido2 as apellido2pf',false);

		$query = $this->db->get('seguimientos_disciplinarios');

		return $query->result();
		
	}


	public function obtener_acudidos($id_persona,$ano_lectivo){

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

		return $query->result_array();
		
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