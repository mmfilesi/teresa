<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_options extends CI_Model {

	function __construct(){

		parent::__construct();

	}
	
/*================================================================
	Generales
=================================================================*/

	public function getOpciones() {

		$query = $this->db->get('ter_options');

		return $query->result_array();
	}

/*	public function updateOptions($data) {
		$this->db->update('ter_options');
	} */

/*================================================================
	Imágenes
=================================================================*/

	public function getMaxImg() {

		$this->db->where('key', 'img_main_width');
		$this->db->or_where('key', 'img_main_height');

		$query = $this->db->get('ter_options');
		
		return $query->result_array();
	}

	public function getMaxThumb() {

		$this->db->where('key', 'thumb_width');
		$this->db->or_where('key', 'thumb_height');

		$query = $this->db->get('ter_options');
		
		return $query->result_array();

	}

	public function updateDefaultSizeImg($maxWidth, $maxHeight, $maxWidthThumb, $maxHeightThumb) {
		
		$arrayIds = array( 1 => $maxWidthThumb, 2 => $maxHeightThumb, 3 => $maxWidth, 4 => $maxHeight,);

		foreach ( $arrayIds as $clave => $valor ) {
			$data = array('value' => $valor );
			$this->db->where('id', $clave);
			$this->db->update('ter_options', $data);
		}
		
		 
	}



}