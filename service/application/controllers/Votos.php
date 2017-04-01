<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';



class Votos extends REST_Controller{

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
		$this->load->model('Votos_model');
	}
	
	public function index_get()
	{
		$reportes = $this->Votos_model->get_reportes_por_votos();

		if (! is_null($reportes) ) {
			$this->response( array( 'response' => $reportes),200);
		}
		else
		{
			$this->response( array( 'error' => $reportes),404);
		}
	}

	public function cantidad_get($id_reporte)
	{
		if (!$id_reporte) 
		{
				$this->response(NULL,400);
		}
		
		$cantidad = $this->Votos_model->get_cantidad_votos_reporte($id_reporte);
		if (! is_null($cantidad) ) 
		{
			$this->response( array('cantidad' => $cantidad),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}
	}

	public function reporte_get($id_reporte,$id_usuario)
	{
		
			$voto = $this->Votos_model->get_voto_reporte_usuario($id_reporte,$id_usuario);
			if (!is_null($voto) ) 
			{
				$this->response( array('is_true' => true, 'voto'=> $voto),200);
			}
			else
			{
				$this->response( array('is_true' => false ), 202 );
			}
		
			$this->response(NULL,400);	
			
	}

	public function actualizarvoto_put()
	{
		
		$id = $this->put('voto');
		$voto = $this->Votos_model->actualizar_voto($id);
		if (! is_null($voto) ) 
		{
				$this->response( array('response' => $id ),200);
		}
		else
		{
				$this->response( array('response' => '0' ),404 );
		}

	}
	


}