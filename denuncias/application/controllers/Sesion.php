<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Sesion extends CI_Controller {

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
	public function __construct(){
		parent::__construct();

	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('iniciar_sesion');
		$this->load-> view('footer');
	}

	//POST
	public function registrarusuario()
	{
		if ( !is_null($this->input->post('user')) && !is_null($this->input->post('password')) && !is_null($this->input->post('nombre')) && !is_null($this->input->post('ife')) ) 
		{
		
			$data = array(
							'id_rol' => 2,
							'id_cuenta' => 1,
							'ife' => $this->input->post('ife'),
							'ip' => $this->input->ip_address(),
							'name' => $this->input->post('nombre'),
							'user' => $this->input->post('user'),
							'password'=> $this->input->post('password')
						);

			$this->load->model('Auth_model');
			$data = $this->Auth_model->registrar_usuario_normal($data);
			
			$this->load->view('header');
			$this->load->view('iniciar_sesion',$data);
			$this->load-> view('footer');
		}
		else
		{
			return redirect('sesion');
		}
	}	

	//VIEW
	public function registrar_usuario()
	{
		$this->load->view('header');
		$this->load->view('registrar_usuario');
		$this->load-> view('footer');
	}

	//POST 
	public function registrartrabajador()
	{
		
		if ( !is_null($this->input->post('user')) && !is_null($this->input->post('password')) && !is_null($this->input->post('nombre')) && !is_null($this->input->post('categoria'))) 
		{
		
			
			$data = array(	'id_rol' => 2,
							'id_cuenta' => 1,
							'id_categoria' => $this->input->post('categoria'),
							'name' => $this->input->post('nombre'),
							'user' => $this->input->post('user'),
							'password'=> $this->input->post('password')
						);

			$this->load->model('Auth_model');
			$data = $this->Auth_model->registrar_usuario_trabajador($data);

			$this->load->view('header');
			$this->load->view('iniciar_sesion',$data);
			$this->load-> view('footer');	
		}
		else
		{
			return redirect('sesion');
		}
	}	

	//VIEW
	public function registrar_trabajador()
	{
		$this->load->model('ModelReportes');
		$categorias = $this->ModelReportes->get_categorias();
		
		$this->load->view('header');
		$this->load->view('registrar_trabajador',$categorias);
		$this->load-> view('footer');
	}
}
