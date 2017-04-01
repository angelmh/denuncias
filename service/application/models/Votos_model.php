<?php 

class Votos_model extends CI_Model
{
	public function get_voto_reporte_usuario($id_reporte,$id_usuario)
	{
		$query = $this->db->query("SELECT * FROM votos WHERE (id_usuario = ".$id_usuario.")
									AND (id_reporte =".$id_reporte.")"
            						);
		if ($query->num_rows() == 1) 
		{
			return $query->row_array();
		}
		return NULL;
	}

	public function actualizar_voto($id)
	{
		$this->db->set('cantidad', 1)
				 ->where('id',$id)
                 ->update('votos');

		if ( $this->db->affected_rows() === 1 ) 
		{
			return $this->db->insert_id();
		}
		return null;
	}

	public function get_cantidad_votos_reporte($id_reporte)
	{
		$query = $this->db->query("SELECT SUM( cantidad ) AS total FROM votos WHERE  id_reporte =".$id_reporte.""
            						);
		if ($query->num_rows() == 1) 
		{
			return $query->row_array();
		}
		return NULL;	
	}

	public function get_reportes_por_votos()
	{
		$query = $this->db->query("SELECT r.id, SUM( v.cantidad ) AS total,
								u.name ,e.estatus, c.categoria, r.descripcion,i.src, d.latitud, d.longitud, d.cp,d.calle_avenida,d.numero,d.colonia, r.fecha
								FROM reportes r, votos v,direcciones_reporte d, estatus_reportes e, categorias_reportes c, usuarios u, imagenes i
								WHERE (v.id_reporte = r.id)
								AND (r.id_estatus = e.id)
								AND (r.id_direccion = d.id)
								AND (r.id_imagen = i.id)
								AND (r.id_usuario = u.id)
								AND (r.id_categoria_rep = c.id)
								GROUP BY v.id_reporte
								ORDER BY  `total` DESC 
								");

			if ($query->num_rows() >0) 
			{
				return $query->result_array();
			}
			return NULL;	
	}

}