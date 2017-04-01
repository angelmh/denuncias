<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';



class Auth extends REST_Controller{

	public function __construct()
	{

		header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
	    $method = $_SERVER['REQUEST_METHOD'];
	    if($method == "OPTIONS") {
	        die();
	    }

		parent::__construct();
		$this->load->model('Auth_model');
	}
	
	//Encuentra un usuario especifico
	public function find_get($correo)
	{
		if (!$correo) 
		{
				$this->response(NULL,400);
		}
		$this->load->model('Usuarios_model');
		$user = urldecode($correo);
		$data = $this->Usuarios_model->get_usuario($user);
		

		if (! is_null($data) ) 
		{
			//No se encuentra registrado
			if ($data==false) 
			{
				$this->response( array('user' => $user,'find' => false,'data' => $data ),200);
			}
			else
			{
				$this->response( array('user' => $user,'find' => true,'data' => $data ),200);
			}			

		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}

	}


	public function index_post()
	{
		
		$data = array(
					'user'   		 => $this->post('user'),
					'password' 		 => $this->post('password'),
				);
		$check = $this->Auth_model->verificacion($data);
		
		

		if ( $check != false)  
		{
			//entrar al sistema
			if (!is_null($check) ) 
			{
				$this->response( array( 'response' => "1", 'data'=> $check ),200);
			}
			else
			{
				$this->response( array( 'error' => "Existe un error"),404);
			}

		}
		else
		{
			//Acceso denegado
			$this->response( array( 'response' => "0"),404);
		}

	}

}