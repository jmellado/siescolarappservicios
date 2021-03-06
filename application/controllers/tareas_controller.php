<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tareas_controller extends CI_Controller {


	public function __construct(){

		parent::__construct();
		$this->load->model('tareas_model');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, Content-Type");

		//Esto nos permite recuperar los datos del formulario
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}


	public function index(){

		$id_persona = $this->input->post('id_persona');
		$tareas = $this->tareas_model->buscar_tarea($id_persona);

		echo json_encode($tareas);

	}


	public function detalle_tarea(){

		$id_notificacion = $this->input->post('id_notificacion');
		$tareas = $this->tareas_model->detalle_tarea($id_notificacion);

		echo json_encode($tareas);

	}



}