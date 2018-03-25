<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eventos_controller extends CI_Controller {


	public function __construct(){

		parent::__construct();
		$this->load->model('eventos_model');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, Content-Type");

		//Esto nos permite recuperar los datos del formulario
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}


	public function index(){

		$id_persona = $this->input->post('id_persona');
		$eventos = $this->eventos_model->buscar_evento($id_persona);

		echo json_encode($eventos);

	}


	public function detalle_evento(){

		$id_notificacion = $this->input->post('id_notificacion');
		$eventos = $this->eventos_model->detalle_evento($id_notificacion);

		echo json_encode($eventos);

	}



}