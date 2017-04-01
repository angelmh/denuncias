<?php 

class Usuarios_model extends CI_Model
{

	public function get_usuarios( $id= NULL)
	{
		if ( ! is_null($id) ) 
		{
			$query = $this->db->select("*")->from("usuarios")->where("id",$id)->get();
			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			return NULL;
		}

		$query = $this->db->select("*")->from("usuarios")->get();
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
			$query = $this->db->select("id,user,name")->from("usuarios")->where("user",$correo)->get();
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
		$query = $this->db->select("*")->from("usuarios")->where("user",$user)->get();
		if ($query->num_rows() == 1) 
		{
			return $query->row_array();
		}
		return FALSE;
	}
	//usuarios
	public function save($data)
	{
		$this->load->model('Usuarios_model');
		$user = $this->Usuarios_model->is_registrado($data['user']);
	
		
		if ($user == FALSE) 
		{
			//No se encuentra registrado, lo registramos
			$this->db->insert('usuarios',$data);	
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
		$this->load->model('Usuarios_model');
		//guardo el usuario 	
	 	$id_user = $this->Usuarios_model->save($data);	
	 	if ($id_user != false) 
	 	{
		 	//actualizo el estatus porque se registro con una cuenta externa
			$this->Usuarios_model->update_estatus( $id_user, false );
			$password = $this->Usuarios_model->generar_password_aleatorio();
			$this->Usuarios_model->update_password( $id_user, $password);
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

	public function save_ciudadano($data)
	{
		$this->db->insert('usuario_ciudadano',$data);	
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
	}

	public function save_trabajador($data)
	{
		$this->db->insert('usuario_trabajador',$data);	
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
	}

	public function update($id, $data)
	{
		
		$this->db->where('id', $id )->update('usuarios',$data);


		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function update_user($id, $user)
	{
		$this->db->set('user', $user)->where('id',$id)->update('usuarios');

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
                 ->update('usuarios');

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
                 ->update('usuarios');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function delete($id)
	{	
		$this->db->where("id",$id)->delete("usuarios");
		
		if ($this->db->affected_rows() === 1) 
		{
				return true;
		}
		return null;
	}

	public function generar_password_aleatorio()
	{
		return "password_aleatorio";
	}
}