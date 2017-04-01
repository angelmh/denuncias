<?php 

class ModelReportes extends CI_Model
{
	public function get_voto_reporte_usuario($id_reporte,$id_usuario)
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/votos/reporte/'.$id_reporte.'/'.$id_usuario;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}
	
	public function get_cantidad_votos_reporte($id_reporte)
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/votos/cantidad/'.$id_reporte;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function actualizar_voto($data)
	{	//PUT
	    //next eample will change status of specific conversation to resolve
		$service_url = 'http://localhost/service/index.php/votos/actualizarvoto';
		$ch = curl_init($service_url);
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

		$data = array(
    				'voto' => $data['voto']
    				);
				
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		$response = curl_exec($ch);
		if ($response === false) {
		    $info = curl_getinfo($ch);
		    curl_close($ch);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($ch);
		$decoded = json_decode($response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
		
		return $decoded;
	} 

	public function cancelar_voto($data)
	{	//PUT
	    //next eample will change status of specific conversation to resolve
		$service_url = 'http://localhost/service/index.php/reportes/cancelarvoto';
		$ch = curl_init($service_url);
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

		$data = array(
    				'voto' => $data['voto']
    				);
				
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		$response = curl_exec($ch);
		if ($response === false) {
		    $info = curl_getinfo($ch);
		    curl_close($ch);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($ch);
		$decoded = json_decode($response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
		
		return $decoded;
	} 

	public function votar($data)
	{	
		//POST
		$service_url = 'http://localhost/service/index.php/reportes/votar';
		$curl = curl_init($service_url);
		$curl_post_data = array(
		        				'reporte' => $data['reporte'],
		        				'usuario' => $data['usuario'],
		       					);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}

		curl_close($curl);
		$decoded = json_decode($curl_response,true);


		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}

		return $decoded;
	}	

	public function get_reporte_por_categoria($id_categoria)
	{
		//POST
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/reportescategoria/'.$id_categoria;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	
	}

	public function get_direcciones_colonias()
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/colonias';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	
	}
	
	public function get_direcciones_calles()
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/calles';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	
	}

	public function get_reportes()
	{
	
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function get_categorias()
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/categorias';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function get_reporte($id)
	{
	
		//next example will recieve all messages for specific conversation


		$service_url = 'http://localhost/service/index.php/reportes/find/'.$id;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function estatus($id)
	{
	
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/estado/'.$id;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function get_reporte_por_avenidas($avenida)
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/direccion/calle/'.$avenida;
		
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}

	public function get_reporte_por_colonias($colonia)
	{
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/reportes/direccion/colonia/'.$colonia;
		
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occured: ' . $decoded->response->errormessage);
		}
	
		return $decoded;
	}
}