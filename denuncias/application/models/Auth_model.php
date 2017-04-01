<?php 

class Auth_model extends CI_Model
{


	public function login($data)
	{
		
		$service_url = 'http://localhost/service/index.php/auth/';
		$curl = curl_init($service_url);
		$curl_post_data = array(
		        				'user'	   => $data['user'],
		        				'password' => $data['password'],
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



		//var_dump( $decoded );
		//print_r( $decoded->response );
		return $decoded;
	}

	public function registrar_usuario_normal($data)
	{
		
		$service_url = 'http://localhost/service/index.php/usuarios';
		$curl = curl_init($service_url);

		$curl_post_data = array(
								'id_rol' 		=> $data['id_rol'],
		        				'id_cuenta' 	=> $data['id_cuenta'],
		        				'ife'			=> $data['ife'],
		        				'ip'			=> $data['ip'],
		        				'name' 			=> $data['name'],
		        				'user' 			=> $data['user'],
		        				'password' 		=> $data['password']
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


	
		//print_r( $decoded->response );
		//var_dump($decoded);
		return $decoded;
	}
	
	public function registrar_usuario_trabajador($data)
	{
		
		$service_url = 'http://localhost/service/index.php/usuarios/';
		$curl = curl_init($service_url);

		$curl_post_data = array(
								'id_rol' 		=> $data['id_rol'],
		        				'id_cuenta' 	=> $data['id_cuenta'],
		        				'name' 			=>  $data['name'],
		        				'user' 			=> $data['user'],
		        				'password' 		=> $data['password'],
		        				'id_dpto'  		=> $data['id_categoria'],
		        			
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

	public function get_usuario($id)
	{
	
		//next example will recieve all messages for specific conversation
		$service_url = 'http://localhost/service/index.php/usuarios/'.$id;
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