<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {


	public function __construct(){

		parent::__construct();
		$this->load->model('login_model');
		$this->load->database('default');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, Content-Type");

		//Esto nos permite recuperar los datos del formulario
		//$res_json = file_get_contents("php://input");
		//$_POST = json_decode($res_json, true);
	}


	public function login_user(){

		$username = $this->input->post('username'); 
		$password = sha1($this->input->post('password')); 
		$check_user = $this->login_model->login_usuarios($username,$password);

		if ($check_user == true){

			$data = array(
                'logueado' 		=> 		TRUE,
                'id_usuario' 	=> 		$check_user->id_usuario,
                'id_persona'	=>		$check_user->id_persona,
                'rol'			=>		$check_user->nombre_rol,
                'username' 		=> 		$check_user->username,
                'acceso' 		=> 		$check_user->acceso,
                'identificacion'=> 		$check_user->identificacion,
                'nombres' 		=> 		$check_user->nombres,
                'apellido1' 	=> 		$check_user->apellido1,
                'apellido2' 	=> 		$check_user->apellido2
        	);	

			//$this->session->set_userdata($data);

			echo json_encode($data);		

		}
		else{

			echo "usuarionoexiste";
		}

	}


	public function registrar_token(){

		$id_persona = $this->input->post('id_persona');
		$token = $this->input->post('token');

		$respuesta = $this->login_model->modificar_token($id_persona,$token);

		if($respuesta==true){

			echo "tokenguardado";
		}
		else{

			echo "tokennoguardado";
		}

	}


}