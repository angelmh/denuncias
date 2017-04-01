<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	
	public function index()
	{
		return redirect('sesion');	
	}

	public function loginFb()
	{
		if( isset($_POST['id']) && isset($_POST['user']) && isset($_POST['name'])  )
		{
			$id =  $_POST['id'];
			$user = $_POST['user'];
			$name = $_POST['name'];

			$this->session->set_userdata('usuario', $id );
			$this->session->set_flashdata('nombre', $user );
			$msj = "Se realizo correctamente";
			$arr[] = array( 'E' => $msj );
			echo ''.json_encode($arr).''; 
		
		}
		else 
		{
			$msj = "NOOOOOOOOOOO";
			$arr[] = array( 'E' => $msj );
			echo ''.json_encode($arr).''; 	
		
		}

	}

	public function login()
	{
		$data = array(
					 'user' => $this->input->post('user'),
					 'password'=> $this->input->post('password') 
					 );
		

		if( !is_null($data['user']) && !is_null($data['password']) ) 
		{
			$this->load->model('Auth_model');
			$data = $this->Auth_model->login($data);
			
			if ( $data['response'] == "1") 
			{
				
				//CREAR SESSION
				$this->session->set_userdata('usuario', $data['data']['id'] );
				$this->session->set_flashdata('nombre', $data['data']['name'] );
				return redirect('reportes');
			}
			else 
			{
				
				$data = array( 'incorrecto' => "Correo o contraseña incorrecta" );
				
				$this->load->view('header');
				$this->load->view('iniciar_sesion',$data);
				$this->load-> view('footer');
			}

		}	
		
		//return redirect('sesion');
	}

	public function logout()
	{
		if ( !is_null($this->session->userdata('usuario')) )
		{	
 			$this->session->sess_destroy();
 	    	return redirect('reportes');
		}
		else
		{
			return redirect('reportes');
		}	
	}

}
