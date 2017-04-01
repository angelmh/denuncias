<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';



class Ciudadano extends REST_Controller{

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
		$this->load->model('Ciudadano_model');
	}
	
	//Devuelve todos los usuarios
	public function index_get()
	{
		$users = $this->Ciudadano_model->get_usuarios();

		if (! is_null($users) ) {
			$this->response( array( 'response' => $users),200);
		}
		else
		{
			$this->response( array( 'error' => $users),404);
		}
	}

	//Encuentra un usuario especifico
	public function find_get($id)
	{
		if (!$id) 
		{
				$this->response(NULL,400);
		}
		$user = $this->Ciudadano_model->get_usuarios($id);
		if (! is_null($user) ) 
		{
			
			$this->response( array('response' => $user),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}

	}

	//Elimina usuario
	public function index_delete($id)
	{
		if (!$id) 
		{
			$this->response(NULL,400);
		}
		$delete = $this->Ciudadano_model->delete($id);

		if (! is_null($delete) ) 
		{
			$this->response( array('response' =>"Usuario eliminado" ),200 );
		}
		else
		{
			$this->response( array('response' => "Ha ocurrido un error" ),400 );
		}
	}
}