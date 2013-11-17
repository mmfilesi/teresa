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
		$this->db->order_by('id');
		$query = $this->db->get('ter_albums');
		return $query->result_array();
	}

	public function insertAlbum($albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada) {

		$data = array(
					   'nombre' => $albumNombre,
					   'fecha' => $albumFecha,
					   'lugar' => $albumLugar,
					   'google_maps' => $albumGoogle,
					   'descripcion' => $albumDescripcion,
					   'imagen_destacada' => $imagenDestacada,
					   'orden' => 1
					);

		$query = $this->db->insert('ter_albums', $data);

		$idAlbum = $this->db->insert_id(); 
		return $idAlbum;

	} //#insertAlbum

	public function getAlbum($idAlbum) {

		$this->db->where('id', $idAlbum);
		$query = $this->db->get('ter_albums');

		return $query->row_array();

	} //#getAlbum

	public function updateAlbum($idAlbum, $albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada) {
		
		$data = array(
               'nombre' 			=> $albumNombre,
               'fecha' 				=> $albumFecha,
               'lugar' 				=> $albumLugar,
               'google_maps' 		=> $albumGoogle,
               'descripcion' 		=> $albumDescripcion,
               'imagen_destacada' 	=> $imagenDestacada,
            );

		$this->db->where('id', $idAlbum);
		$this->db->update('ter_albums', $data);
		//$sql = $this->db->last_query();
		//die($sql);

	} //#updateAlbum

	public function deleteAlbum($idAlbum) {
		
		$this->db->where('id', $idAlbum);
		$this->db->delete('ter_albums');

	}

	public function deleteAlbumCategorias($idAlbum) {
		
		$this->db->where('id_album', $idAlbum);
		$this->db->delete('ter_categorias_on_albums');

	}

	public function deleteAlbumTags($idAlbum) {
		
		$this->db->where('id_album', $idAlbum);
		$this->db->delete('ter_tags_on_albums');

	}

	public function deleteAlbumImagenes($idAlbum) {
		
		$this->db->where('id_album', $idAlbum);
		$this->db->delete('ter_imagenes_on_albums');

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

		$data = array( 'id_album' => $idAlbum, 'id_categoria' => $idCategoria );
		$query = $this->db->insert('ter_categorias_on_albums', $data);

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

	public function getTagsToAlbum($idAlbum) {
		$query = $this->db->query("SELECT  `ter_tags`.`value` FROM  `ter_tags` 
									INNER JOIN  `ter_tags_on_albums` ON  `ter_tags_on_albums`.`id_tag` =  `ter_tags`.`id` 
									WHERE  `ter_tags_on_albums`.`id_album` = ".$idAlbum);

		return $query->result_array();

	} //#getTagsToAlbum

	public function insertTag($value) {

		$data = array('value' => $value );
		$query = $this->db->insert('ter_tags', $data);

		$idTag = $this->db->insert_id(); 
		return $idTag;

	} //#insertTag

	public function insertTagToAlbum($idAlbum, $idTag) {

		$data = array('id_album' => $idAlbum, 'id_tag' => $idTag );
		$query = $this->db->insert('ter_tags_on_albums', $data);

	} //#insertTagToAlbum


	public function deleteTagToAlbum($idAlbum) {

		$this->db->where('id_album', $idAlbum);
		$this->db->delete('ter_tags_on_albums');

	} //#insertTagToAlbum

}