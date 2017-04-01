<?php 

class Auth_model extends CI_Model
{

	public function verificacion($data)
	{
		

		if (!is_null($data) ) 
		{
			$query = $this->db->query("SELECT * FROM `usuarios` WHERE password='".$data['password']."' AND user='".$data['user']."'");
			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			return FALSE;
		}
		else
		{
			return NULL;
		}
	}

}