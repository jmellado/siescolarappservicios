<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes_controller extends CI_Controller {


	public function __construct(){

		parent::__construct();
		$this->load->model('mensajes_model');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, Content-Type");

		//Esto nos permite recuperar los datos del formulario
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}


	public function index(){

		$id_persona = $this->input->post('id_persona');
		$mensajes = $this->mensajes_model->buscar_mensaje($id_persona);

		echo json_encode($mensajes);

	}


	public function detalle_mensaje(){

		$id_notificacion = $this->input->post('id_notificacion');
		$mensajes = $this->mensajes_model->detalle_mensaje($id_notificacion);

		echo json_encode($mensajes);

	}



}