<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';



class Usuarios extends REST_Controller{

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
		$this->load->model('Usuarios_model');
	}
	
	//Devuelve todos los usuarios
	public function index_get()
	{
		$users = $this->Usuarios_model->get_usuarios();

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
		$user = $this->Usuarios_model->get_usuarios($id);
		if (! is_null($user) ) 
		{
			
			$this->response( array('response' => $user),200);
		}
		else
		{
			$this->response( array('error' => 'No se encuentra' ),404 );
		}

	}


	// Guardar Miembros del sistema
	public function index_post()
	{
		
		$data = array(
					'id_rol'   		 => $this->post('id_rol'),
					'id_cuenta'   	 => $this->post('id_cuenta'),
					'name'			 => $this->post('name'),
					'user'   		 => $this->post('user'),
					'password' 		 => $this->post('password'),
					'estatus' 		 => 1
				);

				

		if ( !is_null($data['id_rol'])  && !is_null($data['id_cuenta']) && !is_null($data['name']) && !is_null($data['user']) && !is_null($data['password']) ) 
		{
				
				if( $data['id_cuenta'] == "1" )
				{
						// proceso de guardar en cuenta por default
						$data['id_rol'] = 2;
						$data['id_cuenta'] = 1;

						$id_usuario = $this->Usuarios_model->save( $data );

						if (!is_null( $this->post('id_dpto') ) ) 
						{
							// registrar trabajador
							$id_dpto = $this->post('id_dpto'); 
							$data2 = array( 'id_usuario' => $id_usuario,
											'id_dpto'	=> $id_dpto
										);
							
							if (!is_null($id_usuario) ) 
							{
								if ($id_usuario != false) {
									$trabajador = $this->Usuarios_model->save_trabajador( $data2 );
									$this->response( array('response' => "1",'user'=>$id_usuario, 'trabajador'=> $trabajador, 'name'=>$data['name'] ),200);
								}
								else
								{
									$this->response( array('response' => "2",'user'=> $data['user'],'msj'=> "Usuario registrado"),200);	
								}

							}
							else
							{
								$this->response( array('error' => '0' ),400 );
							}
							

						}
						else
						{
							$data2 = array( 'id_usuario' => $id_usuario
										   );
							if (! is_null($id_usuario) ) 
							{
								if ($id_usuario != false) {
									$trabajador = $this->Usuarios_model->save_ciudadano( $data2 );
									$this->response( array('response' => "1",'user'=>$id_usuario, 'name'=>$data['name']),200);
								}
								else
								{
									$this->response( array('response' => "2",'user'=> $data['user'],'msj'=> "Usuario registrado"),200);	
								}
							}
							else
							{
								$this->response( array('error' => '0' ),400 );
							}
						}
				}
				else
				{
						if( $data['id_cuenta'] != "1" )
						{
								// proceso de guardar en cuenta externa
								$data['id_rol'] = 2;
								$data['id_cuenta'] = 2; // solo por Fb
								$id_usuario = $this->Usuarios_model->save_externos( $data );

								if (!is_null( $this->post('id_dpto') ) ) 
								{
										// registrar trabajador
										$id_dpto = $this->post('id_dpto'); 
										$data2 = array( 'id_usuario' => $id_usuario,
														'id_dpto'	=> $id_dpto
													);
										
										if (!is_null($id_usuario) ) 
										{
											if ($id_usuario != false) {
												$trabajador = $this->Usuarios_model->save_trabajador( $data2 );
												$this->response( array('response' => "1",'user'=>$id_usuario, 'trabajador'=> $trabajador, 'name'=>$data['name'] ),200);
											}
											else
											{
												$this->response( array('response' => "2",'user'=> $data['user'],'msj'=> "Usuario registrado"),200);	
											}

										}
										else
										{
											$this->response( array('error' => '0' ),400 );
										}
									

								}
								else
								{
									
										$data2 = array( 'id_usuario' => $id_usuario
													   );
										if (! is_null($id_usuario) ) 
										{
											if ($id_usuario != false) {
												$trabajador = $this->Usuarios_model->save_ciudadano( $data2 );
												$this->response( array('response' => "1",'user'=>$id_usuario, 'name'=>$data['name']),200);
											}
											else
											{
												$this->response( array('response' => "2",'user'=> $data['user'],'msj'=> "Usuario registrado"),200);	
											}
										}
										else
										{
											$this->response( array('error' => '0' ),400 );
										}
								}
						}
						else
						{
							$this->response( array('error' => 0 ),404 );		
						}
				}
		}
		else
		{
			$this->response( array('error' => 0 ),404 );
		}
	}
	

	//Actualiza usuario, todos los campos o uno en especifico.
	// x-www-form-urlencoded
	public function index_put($id)
	{
			if ( !$id) 
			{
					$this->response(NULL, 400);
			}

			$data = array(
						'user' => 	$this->put('user'),
						'password'=> $this->put('password'),
						'estatus'=> $this->put('estatus'),
						'registrado_por' => $this->post('registrado_por'),
						'name'			 => $this->post('name')
			 			);

			if ( is_null( $data['password'] ) && is_null( $data['estatus'] ) && is_null( $data['registrado_por'] ) && is_null( $data['name'] )  ) 
			{
	
				$update = $this->Usuarios_model->update_user( 	$id , 	$this->put('user') );
				if (! is_null($update) ) 
				{
					$this->response( array('response' => "Usuario actualizado"),200);
				}
				else
				{
					$this->response( array('error' => 'Ha ocurrido un error'),400 );
				}
			
			}
			else if( is_null($data['user']) && is_null( $data['estatus'] ) && is_null( $data['registrado_por'] ) && is_null($data['name']) )
			{
				$update = $this->Usuarios_model->update_password($id, $this->put('password') );	
				if (! is_null($update) ) 
				{
					$this->response( array('response' => "Usuario actualizado"),200);
				}
				else
				{
					$this->response( array('error' => 'Ha ocurrido un error'),400 );
				}
			}
			else if( is_null( $data['user'] ) && is_null( $data['password'] ) && is_null( $data['registrado_por'] ) && is_null($data['name']) )
			{
				$update = $this->Usuarios_model->update_estatus($id, $this->put('estatus') );
				if (! is_null($update) ) 
				{
					$this->response( array('response' => "Usuario actualizado"),200);
				}
				else
				{
					$this->response( array('error' => 'Ha ocurrido un error'),400 );
				}
			}
			
			$update = $this->Usuarios_model->update($id, $data );
			if (! is_null($update) ) 
			{
				$this->response( array('response' => "Usuario actualizado"),200);
			}
			else
			{
				$this->response( array('error' => 'Ha ocurrido un error'),400 );
			}
	}

	//Elimina usuario
	public function index_delete($id)
	{
		if (!$id) 
		{
			$this->response(NULL,400);
		}
		$delete = $this->Usuarios_model->delete($id);

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