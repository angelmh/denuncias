<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';



class Reportes extends REST_Controller{

	public function __construct()
	{

		header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	    $method = $_SERVER['REQUEST_METHOD'];
	    if($method == "OPTIONS") {
	        die();
	    }

		parent::__construct();
		$this->load->model('Reportes_model');
	}
	
	public function index_get()
	{
		$users = $this->Reportes_model->get();

		if (! is_null($users) ) {
			$this->response( array( 'response' => $users),200);
		}
		else
		{
			$this->response( array( 'error' => $users),404);
		}
	}

	public function find_get($id)
	{
		if (!$id) 
		{
				$this->response(NULL,400);
		}
		$user = $this->Reportes_model->get($id);
		if (! is_null($user) ) 
		{
			$this->response( array('response' => $user),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}
	}

	public function estado_get($id)
	{
		if (!$id) 
		{
				$this->response(NULL,400);
		}
		
		$reporte = $this->Reportes_model->get_por_estado($id);

		if (! is_null($reporte) ) 
		{
			$this->response( array('response' => $reporte),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}
	}

	public function direccion_get($parametro,$valor)
	{
		$parametro= urldecode($parametro);
		$valor = urldecode($valor);	
		if ($parametro=="calle") 
		{
			$reporte = $this->Reportes_model->get_reporte_por_calle($valor);
			if (! is_null($reporte) ) 
			{
				$this->response( array('response' => $reporte),200);
			}
			else
			{
				$this->response( array('error' => 'No se encuentra' ),404 );
			}
		}
		else if($parametro=="colonia")
		{
			$reporte = $this->Reportes_model->get_reporte_por_colonia($valor);
			if (! is_null($reporte) ) 
			{
				$this->response( array('response' => $reporte),200);
			}
			else
			{
				$this->response( array('error' => 'No se encuentra' ),404 );
			}
		}
		else
		{
			$this->response(NULL,400);	
		}		
	}

	public function colonias_get()
	{
		$direcciones = $this->Reportes_model->get_direcciones_colonias();

		if (! is_null($direcciones) ) {
			$this->response( array( 'colonias' => $direcciones),200);
		}
		else
		{
			$this->response( array( 'colonias' => 0),404);
		}
	}

	public function calles_get()
	{
		$direcciones = $this->Reportes_model->get_direcciones_calle_avenida();

		if (! is_null($direcciones) ) {
			$this->response( array( 'calles' => $direcciones),200);
		}
		else
		{
			$this->response( array( 'calles' => 0),404);
		}
	}

	public function categorias_get()
	{
		$categorias = $this->Reportes_model->get_categorias();

		if (! is_null($categorias) ) {
			$this->response( array( 'response' => $categorias),200);
		}
		else
		{
			$this->response( array( 'response' => 0),404);
		}
	}
	
	public function categoria_sub_get($id)
	{
		if (!$id) 
		{
				$this->response(NULL,400);
		}
		
		$reporte = $this->Reportes_model->get_categorias_sub($id);

		if (! is_null($reporte) ) 
		{
			$this->response( array('response' => $reporte),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}
	}

	public function subcategorias_get()
	{
		$subcategorias = $this->Reportes_model->get_subcategorias();

		if (! is_null($subcategorias) ) {
			$this->response( array( 'response' => $subcategorias),200);
		}
		else
		{
			$this->response( array( 'response' => 0),404);
		}
	}
	
	public function sub_categorias_get($id)
	{
		if (!$id) 
		{
				$this->response(NULL,400);
		}
		
		$reporte = $this->Reportes_model->get_sub_categorias($id);

		if (! is_null($reporte) ) 
		{
			$this->response( array('response' => $reporte),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}
	}

	public function reportescategoria_get($categoria)
	{
		$reportes = $this->Reportes_model->get_reporte_por_categoria($categoria);

		if (! is_null($reportes) ) {
			$this->response( array( 'response' => $reportes),200);
		}
		else
		{
			$this->response( array( 'response' => 0),404);
		}
	}

	public function reportescategoriarecientes_get($categoria)
	{
		$reportes = $this->Reportes_model->get_reporte_por_categoria_recientes($categoria);

		if (! is_null($reportes) ) {
			$this->response( array( 'response' => $reportes),200);
		}
		else
		{
			$this->response( array( 'response' => 0),404);
		}
	}

	public function imagen_post()
	{
	
		$file = $_FILES;
		if ( isset( $file['file']['name'] ) ) 
		{
			$file = $_FILES['file'];
			$nombre = $file['name'];
			$tipo = $file['type'];
			$ruta_provisional = $file['tmp_name'];
			
			if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo !='image/gif') 
			{
				
			$this->response( array('response' => "0" ),200 );
			}
			else
			{
				
				
				$dataImagen = $_FILES;
				$nombreImagen = $dataImagen['file']['name']; 
				$folder = "data/img/";
				$nombreImagen = $dataImagen['file']['name']; 
				$tmpImagen = $dataImagen['file']['tmp_name']; 
				$arch = move_uploaded_file( $tmpImagen, $folder.'/'.$nombreImagen );
				
				$data = array('src' => "http://localhost/service/".$folder.$nombreImagen );
				$this->load->model('Reportes_model');
				$id = $this->Reportes_model->guardar_imagen($data);
				
				if (! is_null($id) ) 
				{
					$this->response( array('response' => $id),200);
				}
				else
				{
					$this->response( array('response' => -1 ),200 );
				}

			}
		
		}
		else
		{
			$this->response( array('response' => 0 ),404 );
		}
	}

	
	public function reporte_post()
	{
		
		$this->load->model('Reportes_model');
		
		$direccion = array(
						'latitud' 		=> $this->post('latitud'), 
						'longitud' 		=> $this->post('longitud'),
						'descripcion' 	=> $this->post('direccion'),
						'cp' 			=> $this->post('cp'),
						'calle_avenida' => trim( ucwords(mb_strtolower( $this->post('calle_avenida') )) ),
						'numero' 		=> $this->post('numero'),
						'colonia' 		=> trim( ucwords(mb_strtolower( $this->post('colonia') )) )
					);

		$id_direccion = $this->Reportes_model->insertar_direccion($direccion);
		
		if (! is_null($id_direccion) ) 
		{
				$data = array(
							'id_usuario'   			=> $this->post('usuario'),
							'id_estatus'    		=> 1,
							'id_categoria_rep' 		=> $this->post('categoria'),
							'id_subcategoria_rep'	=> $this->post('subcategoria'),
							'id_direccion' 			=> $id_direccion,
							'id_imagen'    			=> $this->post('imagen'),
							'descripcion'  			=> trim( ucwords(mb_strtolower( $this->post('descripcion') )) ),
						);
				

				$reporte = $this->Reportes_model->insertar_reporte($data);
				$data = array( 'id_reporte' => $reporte,
				   				'id_usuario'=>1,
				   				'cantidad'=>0
							);
				$votoautomatico = $this->Reportes_model->insertar_voto($data);
				if (! is_null($reporte) ) 
				{
					$this->response( array('response' => $reporte),200);
				}
				else
				{
					$this->response( array('response' => '0' ),404 );
				}
		}
		else
		{
			$this->response( array('response' => '0' ),404 );
		}
	}

	public function votar_post()
	{
		$data = array(
						'id_reporte' 	=> $this->post('reporte'),
						'id_usuario' 	=> $this->post('usuario'),
						'cantidad'   	=> 1
					 );

		$voto = $this->Reportes_model->insertar_voto($data);
		if (! is_null($voto) ) 
		{
				$this->response( array('response' => $voto),200);
		}
		else
		{
				$this->response( array('response' => '0' ),404 );
		}

	}

	public function cancelarvoto_put()
	{
		
		$id = $this->put('voto');
		$voto = $this->Reportes_model->cancelar_voto($id);
		if (! is_null($voto) ) 
		{
				$this->response( array('response' => $id ),200);
		}
		else
		{
				$this->response( array('response' => '0' ),404 );
		}

	}

	public function modificarestatus_put()
	{
		$id = $this->put('id');
		$id_estatus = $this->put('id_estatus');
		$id_user  = $this->put('id_user');
		$reporte = $this->Reportes_model->modificar_estatus_reporte($id, $id_estatus, $id_user);
		if (! is_null($reporte) ) 
		{
				$this->response( array('response' => $id ),200);
		}
		else
		{
				$this->response( array('response' => '0' ),404 );
		}
	}

	public function index_delete($id)
	{
		if (!$id) 
		{
			$this->response(NULL,400);
		}
		$delete = $this->Reportes_model->delete($id);

		if (! is_null($delete) ) 
		{
			$this->response( array('response' =>"Reporte eliminado" ),200 );
		}
		else
		{
			$this->response( array('response' => "Ha ocurrido un error" ),400 );
		}
	}
}