<?php 

class Ciudadano_model extends CI_Model
{

	public function get_usuarios( $id= NULL)
	{
		if ( ! is_null($id) ) 
		{
			$query = $this->db->select("*")->from("usuario_ciudadano")->where("id",$id)->get();
			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			return NULL;
		}

		$query = $this->db->select("*")->from("usuario_ciudadano")->get();
			if ( $query->num_rows() > 0 ) 
			{
				return $query->result_array();
			}
			return null;
	}
  	
  	public function get_usuario( $correo = NULL)
	{
		if ( ! is_null($correo) ) 
		{
			$query = $this->db->select("id,user,name")->from("usuario_ciudadano")->where("user",$correo)->get();
			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}
		return NULL;
	}

	public function is_registrado($user)
	{
		$query = $this->db->select("*")->from("usuario_ciudadano")->where("user",$user)->get();
		if ($query->num_rows() == 1) 
		{
			return $query->row_array();
		}
		return FALSE;
	}
	//usuarios
	public function save($data)
	{
		$this->load->model('Ciudadano_model');
		$user = $this->Ciudadano_model->is_registrado($data['user']);
	
		
		if ($user == FALSE) 
		{
			//No se encuentra registrado, lo registramos
			$this->db->insert('usuario_ciudadano',$data);	
			if ( $this->db->affected_rows() === 1 ) 
			{
				return $this->db->insert_id();
			}
		}
		else
		{
			//Esta registrado
			return false;	
		}

		return null;
	}


	public function save_externos($data)	
	{
		$this->load->model('Ciudadano_model');
		//guardo el usuario 	
	 	$id_user = $this->Ciudadano_model->save($data);	
	 	if ($id_user != false) 
	 	{
		 	//actualizo el estatus porque se registro con una cuenta externa
			$this->Ciudadano_model->update_estatus( $id_user, false );
			
			if ( $this->db->affected_rows() === 1 ) 
			{
				return $id_user;
			}

	 	}
	 	else
	 	{
	 		return false;
	 	}

		return null;
	}

	public function update($id, $data)
	{
		
		$this->db->where('id', $id )->update('usuario_ciudadano',$data);


		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function update_user($id, $user)
	{
		$this->db->set('user', $user)->where('id',$id)->update('usuario_ciudadano');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function update_password($id, $password)
	{
		$this->db->set('password', $password)
				 ->where('id',$id)
                 ->update('usuario_ciudadano');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function update_estatus($id, $estatus)
	{
		$this->db->set('estatus', $estatus)
				 ->where('id',$id)
                 ->update('usuario_ciudadano');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function delete($id)
	{	
		$this->db->where("id",$id)->delete("usuario_ciudadano");
		
		if ($this->db->affected_rows() === 1) 
		{
				return true;
		}
		return null;
	}

	function generar_password_aleatorio()
	{
		return "password";
	}
}