<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_imagenes extends CI_Model {

	function __construct(){

		parent::__construct();

	}
	
/*================================================================
	Álbums
=================================================================*/

	public function getAlbums() {

		$this->db->order_by('orden');
		$this->db->order_by('indexacion');
		$query = $this->db->get('ter_albums');
		return $query->result_array();

	}

	public function insertAlbum($albumNombre, $albumFecha, $albumLugar, $albumDescripcion, $imagenDestacada) {

		$albumNombre 		= addslashes( strip_tags( $albumNombre ) );
		$albumFecha	 		= strip_tags( $albumFecha );
		$albumLugar 		= addslashes( strip_tags( $albumLugar ) );			
		$albumDescripcion 	= addslashes( strip_tags( $albumDescripcion ) ); 

		$data = array(
					   'nombre' 			=> $albumNombre,
					   'fecha' 				=> $albumFecha,
					   'lugar' 				=> $albumLugar,
					   'descripcion' 		=> $albumDescripcion,
					   'imagen_destacada'	=> $imagenDestacada,
					   'orden' 				=> 1
					);

		$query 	 = $this->db->insert('ter_albums', $data);
		$idAlbum = $this->db->insert_id(); 
		return $idAlbum;

	} //#insertAlbum

	public function getAlbum($idAlbum) {

		$this->db->where('id', $idAlbum);
		$query = $this->db->get('ter_albums');

		return $query->row_array();

	} //#getAlbum

	public function updateAlbum($idAlbum, $albumNombre, $albumFecha, $albumLugar, $albumDescripcion, $imagenDestacada) {

		if ( is_numeric($idAlbum) ) {

			$albumNombre 		= addslashes( strip_tags( $albumNombre ) );
			$albumFecha 		= addslashes( strip_tags( $albumFecha ) );		
			$albumLugar 		= addslashes( strip_tags( $albumLugar ) );
			$albumDescripcion 	= addslashes( $albumDescripcion );
			$imagenDestacada 	= addslashes( strip_tags( $imagenDestacada ) );
			
			$data = array(
	               'nombre' 			=> $albumNombre,
	               'fecha' 				=> $albumFecha,
	               'lugar' 				=> $albumLugar,
	               'descripcion' 		=> $albumDescripcion,
	               'imagen_destacada' 	=> $imagenDestacada,
	            );

			$this->db->where('id', $idAlbum);
			$this->db->update('ter_albums', $data);

		} else {
			die("Error en el envío del formulario");
		}

	} //#updateAlbum

	public function deleteAlbum($idAlbum) {		
		if ( is_numeric($idAlbum) ) {
			$this->db->where('id', $idAlbum);
			$this->db->delete('ter_albums');
		} else {
			die("Error en el envío del formulario");
		}
	}

	public function updateOrdenAlbums($clave, $contador) {
		$data = array( 'orden' => $contador );
		$this->db->where('id', $clave);
		$this->db->update('ter_albums', $data);
	}

	public function deleteAlbumCategorias($idAlbum) {
		if ( is_numeric($idAlbum) ) {
			$this->db->where('id_album', $idAlbum);
			$this->db->delete('ter_categorias_on_albums');
		} else {
			die("Error en el envío del formulario");
		}

	}

	public function deleteAlbumImagenes($idAlbum) {
		if ( is_numeric($idAlbum) ) {
			$this->db->where('id_album', $idAlbum);
			$this->db->delete('ter_imagenes_on_albums');
		} else {
			die("Error en el envío del formulario");
		}

	}

	/* OJO: ESTA ESTÁ MAL, SON TAGS */

	public function getImagenesAlbums($idAlbum) {
		
		$query = $this->db->query("SELECT  `ter_tags`.`value` FROM  `ter_tags` 
									INNER JOIN  `ter_tags_on_albums` ON  `ter_tags_on_albums`.`id_tag` =  `ter_tags`.`id` 
									WHERE  `ter_tags_on_albums`.`id_album` = ".$idAlbum);

		return $query->result_array();
	}

	public function getLastOrdenImagen($imagenAlbum) {

		if ( is_numeric($imagenAlbum) ) {

			$this->db->order_by("orden", "desc");
			$this->db->limit(1);
			$this->db->where('id_album', $imagenAlbum);
			$query = $this->db->get('ter_imagenes_on_albums');

			$temporal = $query->row_array();

			return $temporal['orden'];
		
		} else {			
			die("Error en el envío del formulario");
		}
	}

	public function insertImagenOnAlbum($idAlbum, $idImagen, $orden) {

		if ( is_numeric($idAlbum) && is_numeric($idImagen) && is_numeric($orden) ) {

			$data = array(
					   'id_album' 	 => $idAlbum,
					   'id_imagen' 	 => $idImagen,
					   'orden' 		 => $orden
					);

		$query = $this->db->insert('ter_imagenes_on_albums', $data);

		} else {			
			die("Error en el envío del formulario");
		}
		

	}

/*================================================================
	Imágenes
=================================================================*/

	public function insertImagen($imagenNombre, $imagenFecha, $imagenLugar, $imagenDescripcion, $imagenRuta) {

		if ( strlen($imagenNombre) > 249 OR strlen($imagenNombre) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenNombre = addslashes( strip_tags($imagenNombre) );
		}

		if ( strlen($imagenFecha) > 12 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenFecha = addslashes( strip_tags($imagenFecha) );
		}

		if ( strlen($imagenLugar) > 249 OR strlen($imagenLugar) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenLugar = addslashes( strip_tags($imagenLugar) );
		}		
		
		$imagenDescripcion = addslashes( $imagenDescripcion );

		if ( strlen($imagenRuta) > 249 OR strlen($imagenRuta) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenRuta = addslashes( strip_tags($imagenRuta) );
		}

		$data = array(
					   'nombre' 	 => $imagenNombre,
					   'fecha' 		 => $imagenFecha,
					   'lugar' 		 => $imagenLugar,
					   'descripcion' => $imagenDescripcion,
					   'ruta' 		 => $imagenRuta
					);

		$query = $this->db->insert('ter_imagenes', $data);

		$idImagen = $this->db->insert_id(); 
		return $idImagen;
		
	} #insertImagen
			
	public function updateImagen($idImagen, $imagenNombre, $imagenFecha, $imagenLugar, $imagenDescripcion, $imagenRuta) {

		if ( !is_numeric($idImagen) ) {
			die("Error en el envío del formulario");
		}

		if ( strlen($imagenNombre) > 249 OR strlen($imagenNombre) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenNombre = addslashes( strip_tags($imagenNombre) );
		}

		if ( strlen($imagenFecha) > 12 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenFecha = addslashes( strip_tags($imagenFecha) );
		}

		if ( strlen($imagenLugar) > 249 OR strlen($imagenLugar) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenLugar = addslashes( strip_tags($imagenLugar) );
		}		
		
		$imagenDescripcion = addslashes( $imagenDescripcion );

		if ( strlen($imagenRuta) > 249 OR strlen($imagenRuta) == 0 ) {
			die("Error en el envío del formulario");
		} else {
			$imagenRuta = addslashes( strip_tags($imagenRuta) );
		}

		$data = array(
			   'nombre' 	 => $imagenNombre,
			   'fecha' 		 => $imagenFecha,
			   'lugar' 		 => $imagenLugar,
			   'descripcion' => $imagenDescripcion,
			   'ruta' 		 => $imagenRuta
			);

		$this->db->where('id', $idImagen);
		$this->db->update('ter_imagenes', $data);

	}

	public function getImagenes() {		
		$query = $this->db->get('ter_imagenes');
		return $query->result_array();
	}

	public function getImagen($idImagen) {

		if ( !is_numeric($idImagen) ) {
			die("Error en el envío del formulario");
		} else {
			$this->db->where('id', $idImagen);
			$query = $this->db->get('ter_imagenes');
			return $query->row_array();
		}

	}

	public function deleteImagen($idImagen) {

		if ( !is_numeric($idImagen) ) {
			die("Error en el envío del formulario");
		} else {
			$this->db->where('id', $idImagen);
			$query = $this->db->delete('ter_imagenes');
		}

	}

	public function getAlbumsToImagen($idImagen) {
		$this->db->where('id_imagen', $idImagen);
		$query = $this->db->get('ter_imagenes_on_albums');
		return $query->result_array();
	}

	public function deleteAlbumToImagen($idImagen) {
		$this->db->where('id_imagen', $idImagen);
		$query = $this->db->delete('ter_imagenes_on_albums');
	}

	public function deleteImagenTags($idImagen) {

		if ( !is_numeric($idImagen) ) {
			die("Error en el envío del formulario");
		} else {		
			$this->db->where('id_imagen', $idImagen);
			$query = $this->db->delete('ter_tags_on_imagenes');
		}
		
	}



/*================================================================
	Categorías
=================================================================*/

	public function getCategorias() {

		$this->db->order_by('value', 'asc');
		$query = $this->db->get('ter_categorias');

		return $query->result_array();

	} //#getCategorias

	public function insertCategoria($value) {

		$data = array('value' => $value );
		$query = $this->db->insert('ter_categorias', $data);

		$idCategoria = $this->db->insert_id(); 
		return $idCategoria;

	} //#insertCategoria

	public function getCategoriaToAlbum($idAlbum) {

		$this->db->where('id_album', $idAlbum);
		$query = $this->db->get('ter_categorias_on_albums');
		return $query->result_array();

	} //#getCategoriaToAlbum

	public function insertCategoriaToAlbum($idAlbum, $idCategoria) {

		if ( !is_numeric($idAlbum) OR !is_numeric($idCategoria) ) {
			die("Error en el envío del formulario");
		} else {
			$data = array( 'id_album' => $idAlbum, 'id_categoria' => $idCategoria );
			$query = $this->db->insert('ter_categorias_on_albums', $data);
		}		

	} //#insertCategoriaToAlbum 

	public function deleteCategoriaToAlbum($idAlbum) {

		$this->db->where('id_album', $idAlbum);
		$query = $this->db->delete('ter_categorias_on_albums');

	} //#deleteCategoriaToAlbum

/*================================================================
	Tags
=================================================================*/

	public function getTagByValue($value) {

		$this->db->where('value', $value);
		$query = $this->db->get('ter_tags');

		return $query->row_array();

	} //#getTagByValue


	public function insertTag($value) {

		$value = addslashes( strip_tags($value) );

		$data = array('value' => $value );
		$query = $this->db->insert('ter_tags', $data);

		$idTag = $this->db->insert_id(); 
		return $idTag;

	} //#insertTag


	public function getTagsToImagen($idImagen) {
		
		$query = $this->db->query("SELECT  `ter_tags`.`value` FROM  `ter_tags` 
									INNER JOIN  `ter_tags_on_imagenes` ON  `ter_tags_on_imagenes`.`id_tag` =  `ter_tags`.`id` 
									WHERE  `ter_tags_on_imagenes`.`id_imagen` = ".$idImagen);

		return $query->result_array();

	} //#getTagsToImagen


	public function insertTagToImagen($idImagen, $idTag) {

		if ( !is_numeric($idImagen) OR !is_numeric($idTag) ) {
			die("Error en el envío del formulario");
		} else {
			$data = array('id_imagen' => $idImagen, 'id_tag' => $idTag );
			$query = $this->db->insert('ter_tags_on_imagenes', $data);
		}

	} //#insertTagToImagen


	public function deleteTagToImagen($idImagen) {

		if ( !is_numeric($idImagen) ) {
			die("Error en el envío del formulario");
		} else {
			$this->db->where('id_imagen', $idImagen);
			$this->db->delete('ter_tags_on_imagenes');
		}
	}


}