<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *s
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
		if(!is_null( $this->session->userdata('usuario') ) )
		{
		 

			$id = $this->session->userdata('usuario');
		 	$this->load->model('Auth_model');
			$data = $this->Auth_model->get_usuario($id);
			
			$this->load->model('ModelReportes');
			$data2 = $this->ModelReportes->get_reportes();
			
			$data2['colonias'] = $this->ModelReportes->get_direcciones_colonias();
			$data2['calles']= $this->ModelReportes->get_direcciones_calles();
			$data2['categorias']= $this->ModelReportes->get_categorias();
	

			$this->load-> view('header',$data);
			$this->load->view('reportes',$data2);
			$this->load-> view('footer');

		}  
		else
		{
			$this->load->model('ModelReportes');
			$data2 = $this->ModelReportes->get_reportes();
			$data2['colonias']= $this->ModelReportes->get_direcciones_colonias();
			$data2['calles']= $this->ModelReportes->get_direcciones_calles();
			$data2['categorias']= $this->ModelReportes->get_categorias();
			
		
			
			$this->load-> view('header');
			$this->load->view('reportes',$data2);
			$this->load-> view('footer');	
			
		}
	}

	public function reportar()
	{
		 if( !is_null($this->session->userdata('usuario')) )
		 { 
		 	$id = $this->session->userdata('usuario');
		 	$this->load->model('Auth_model');
			$data = $this->Auth_model->get_usuario($id);
			
			$this->load->model('ModelReportes');
			$categorias = $this->ModelReportes->get_categorias();
			
			
			$this->load-> view('header',$data);
			$this->load->view('new_reporte',$categorias);
			$this->load-> view('footer');
		 
		 } 
		 else
		 {
		 	
		 	 return redirect('reportes');
		 }
	}


	public function reporte($id)
	{
		if ( is_numeric($id) )
		{

			
			$data = array('id' => $id);
			// consultar el reporte 
			$this->load->model('ModelReportes');
			$data = $this->ModelReportes->get_reporte($id);
			
			
			if (!isset( $data['error'] )) 
			{
				$this->load-> view('header');
				$this->load->view('reporte',$data);
				$this->load-> view('footer');	
			}
			else
			{
				//No existe Reporte
				return redirect('reportes');
			}

		}
		else
		{
			//No existe Reporte
			return redirect('reportes');
		}
	}

	public function reporte_estatus()
	{
	    if (!is_null($this->input->post('b-estado'))) {
			
			if ( is_numeric($this->input->post('b-estado') ) )
			{
				$estado = $this->input->post('b-estado');
				$id = $estado;
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->estatus($id);
				echo ''.json_encode($data).''; 
			}
			
		}
		else
		{

		}

	}

	public function reporte_avenidas()
	{
	    if (!is_null($this->input->post('avenida'))) {
			
		
				$avenida =  $this->input->post('avenida');
				
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->get_reporte_por_avenidas($avenida);
				
				echo ''.json_encode($data).''; 
			
			
		}
		else
		{

		}

	}	
	
	public function reporte_colonias()
	{
	    if (!is_null($this->input->post('colonia'))) {
			
		
				$colonia =  $this->input->post('colonia');
				
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->get_reporte_por_colonias($colonia);
				
				echo ''.json_encode($data).''; 
		}
		else
		{

		}
	}

	public function reporte_categorias()
	{
	    if (!is_null($this->input->post('categoria'))) {
			
		
				$categoria =  $this->input->post('categoria');
				
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->get_reporte_por_categoria($categoria);
				
				echo ''.json_encode($data).''; 
		}
		else
		{

		}
	}

	public function votar()
	{
	    if ( !is_null($this->input->post('reporte')) && !is_null($this->input->post('usuario'))) 
	    {
				$data = array(
							'reporte' => $this->input->post('reporte'),
							'usuario' => $this->input->post('usuario') 
							);

				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->votar($data);
				
				echo ''.json_encode($data).''; 
		}
		else
		{

		}
	}

	public function cancelarvoto()
	{
	    if ( !is_null($this->input->post('voto')) ) 
	    {
				$data = array(
								'voto' => $this->input->post('voto')
							);
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->cancelar_voto($data);
				
				echo ''.json_encode($data).''; 
		}
		else
		{

		}
	}

	public function actualizarvoto()
	{
	    if ( !is_null($this->input->post('voto')) ) 
	    {
				$data = array(
								'voto' => $this->input->post('voto')
							);
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->actualizar_voto($data);
				
				echo ''.json_encode($data).''; 
		}
		else
		{

		}
	}

	public function votos()
	{
		if ( !is_null($this->input->post('reporte')) && !is_null($this->input->post('usuario')) ) 
	    {
				$id_reporte = $this->input->post('reporte');
				$id_usuario = $this->input->post('usuario');
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->get_voto_reporte_usuario($id_reporte,$id_usuario);
				echo ''.json_encode($data).''; 
		}
		else
		{
		}
	}

	public function cantidadvotos()
	{
		if ( !is_null($this->input->post('reporte')) ) 
	    {
				$id_reporte = $this->input->post('reporte');
				
				$this->load->model('ModelReportes');
				$data = $this->ModelReportes->get_cantidad_votos_reporte($id_reporte);
				echo ''.json_encode($data).''; 
		}
		else
		{
		}
	}
}
