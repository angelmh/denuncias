<?php 

class Reportes_model extends CI_Model
{

	public function guardar_imagen($data)
	{
		$this->db->insert('imagenes',$data);	
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return NULL;	
	}

	public function get( $id= NULL)
	{
		if ( ! is_null($id) ) 
		{
			
			$query = $this->db->query("SELECT r.id, u.name ,e.estatus, c.categoria, r.descripcion,i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
			FROM reportes r, direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
			WHERE (r.id_estatus = e.id) 
			AND (r.id_direccion = d.id)
			AND (r.id_imagen = i.id)
			AND (r.id_usuario = u.id)
			AND (r.id_categoria_rep = c.id)  
            AND (r.id =".$id.")");

			

			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			return NULL;
		}

		$query = $this->db->query("SELECT r.id, u.name ,e.estatus, c.categoria, r.descripcion,i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
									FROM reportes r,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
									WHERE (r.id_estatus = e.id) 
									AND (r.id_direccion = d.id)
									AND (r.id_imagen = i.id)
									AND (r.id_usuario = u.id)
									AND (r.id_categoria_rep = c.id)
									ORDER BY `r`.`id` DESC");
		
	
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;
	}


	public function get_por_estado($id)
	{
		if ( ! is_null($id) ) 
		{
			$query = $this->db->query("SELECT r.id, u.name ,e.estatus, c.categoria, r.descripcion, i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
										FROM reportes r,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
										WHERE (r.id_estatus= e.id) 
										AND (r.id_direccion = d.id)
										AND (r.id_imagen = i.id)
										AND (r.id_usuario = u.id)
										AND (r.id_categoria_rep = c.id)
										AND (r.id_estatus=".$id.")
										ORDER BY `r`.`id` ASC");
			
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;
	}

	public function get_categorias()
	{

		$query = $this->db->select("*")->from("categorias_reportes")->get();
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;

	}

	public function get_categorias_sub($id)
	{
	    $query = $this->db->query("SELECT * FROM subcategoria WHERE id=".$id);
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;	
	}

	public function get_subcategorias()
	{
		$query = $this->db->query("SELECT * FROM subcategoria ORDER BY subcategoria");
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;

	}

	public function get_sub_categorias($id)
	{
		if ( ! is_null($id) ) 
		{
			$query = $this->db->query("SELECT * FROM subcategoria WHERE id_categoria=".$id);
			
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;

	}

	public function get_reporte_por_categoria($categoria)
	{
		if ( ! is_null($categoria) ) 
		{
			$query = $this->db->query("SELECT r.id, r.id_direccion, u.name ,e.estatus, c.categoria, r.descripcion, i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
										FROM reportes r,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
										WHERE (r.id_estatus= e.id) 
										AND (r.id_direccion = d.id)
										AND (r.id_imagen = i.id)
										AND (r.id_usuario = u.id)
										AND (r.id_categoria_rep = c.id)
										AND (r.id_categoria_rep=".$categoria.")");
	
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;
	}

	public function get_reporte_por_categoria_recientes($categoria)
	{
	
		if ( ! is_null($categoria) ) 
		{
			$query = $this->db->query("SELECT r.id, u.name, e.estatus, c.categoria, r.descripcion, i.src, d.latitud, d.longitud, d.cp, d.calle_avenida, d.numero, d.colonia, r.fecha
										FROM reportes r, direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
										WHERE (r.id_estatus = e.id)
										AND (r.id_direccion = d.id)
										AND (r.id_imagen = i.id)
										AND (r.id_usuario = u.id)
										AND (r.id_categoria_rep = c.id)
										AND (r.id_categoria_rep=".$categoria.")
										
										ORDER BY  `r`.`fecha` DESC 
										LIMIT 0 , 10
										");
	
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;	
	}

	public function get_reporte_por_colonia($colonia)
	{
		if ( ! is_null($colonia) ) 
		{
			$query = $this->db->query("SELECT r.id, r.id_direccion, u.name ,e.estatus, c.categoria, r.descripcion, i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
										FROM reportes r,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
										WHERE (r.id_estatus= e.id) 
										AND (r.id_direccion = d.id)
										AND (r.id_imagen = i.id)
										AND (r.id_usuario = u.id)
										AND (r.id_categoria_rep = c.id)
										AND (d.colonia='".$colonia."')");
	
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;
	}

	public function get_reporte_por_calle($calle)
	{
		if ( ! is_null($calle) ) 
		{
			$query = $this->db->query("SELECT r.id, r.id_direccion, u.name ,e.estatus, c.categoria, r.descripcion, i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
										FROM reportes r,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
										WHERE (r.id_estatus= e.id) 
										AND (r.id_direccion = d.id)
										AND (r.id_imagen = i.id)
										AND (r.id_usuario = u.id)
										AND (r.id_categoria_rep = c.id)
										AND (d.calle_avenida='".$calle."')");
	
			if ($query->num_rows() > 0) 
			{
				return $query->result_array();
			}
			return NULL;
		}

		return NULL;
	}


	public function get_direcciones_colonias()
	{
		$query = $this->db->query("SELECT DISTINCT colonia FROM `direcciones_reporte`");
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;		
	}
  	
  	public function get_direcciones_calle_avenida()
	{
		$query = $this->db->query("SELECT DISTINCT calle_avenida FROM `direcciones_reporte`");
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		return null;		
	}
	
	public function modificar_estatus_reporte($id,$id_estatus,$id_user)
	{
		$this->db->set('id_estatus', $id_estatus)
				->set('modificado_por', $id_user)
				 ->where('id',$id)
                 ->update('reportes');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function cancelar_voto($id)
	{
		$this->db->set('cantidad', 0)
				 ->where('id',$id)
                 ->update('votos');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function insertar_voto($data)
	{
		
		$this->db->insert('votos',$data);	
		
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function insertar_reporte($data)
	{
		
		$this->db->insert('reportes',$data);	
		
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function insertar_direccion($data)
	{
		
		$this->db->insert('direcciones_reporte',$data);	
		
		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function delete($id)
	{	
		$this->load->model('Reportes_model');
		$reporte = $this->Reportes_model->get_reportes( $id );

 		
 		$this->db->where("id_reporte",$id)->delete("votos");
		
		
		$this->db->where("id",$id)->delete("reportes");
		if ($this->db->affected_rows() === 1) 
		{
				$id_imagen = $reporte['id_imagen'];
				$this->db->where("id",$id_imagen)->delete("imagenes");
				$id_direccion = $reporte['id_direccion'];
				$this->db->where("id",$id_direccion)->delete("direcciones_reporte");
				return true;
		}
		return null;
	}

	public function get_reportes($id)
	{
		if ( ! is_null($id) ) 
		{
			
			$query = $this->db->query("SELECT * FROM reportes WHERE id=".$id);

			if ($query->num_rows() == 1) 
			{
				return $query->row_array();
			}
			return NULL;
		}

	}

}