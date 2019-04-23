<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asistencias_controller extends CI_Controller {


	public function __construct(){

		parent::__construct();
		$this->load->model('asistencias_model');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, Content-Type");

		//Esto nos permite recuperar los datos del formulario
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}


	public function asignaturas(){

		$id_estudiante = $this->input->post('id_estudiante');
		$asignaturas = $this->asistencias_model->buscar_asignatura($id_estudiante);

		echo json_encode($asignaturas);

	}


	public function asistencias(){

		$id_asignatura = $this->input->post('id_asignatura');
		$id_estudiante = $this->input->post('id_estudiante');
		$asistencias = $this->asistencias_model->buscar_asistencia($id_asignatura,$id_estudiante);

		echo json_encode($asistencias);

	}



}