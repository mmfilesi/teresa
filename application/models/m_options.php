<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_options extends CI_Model {

	function __construct(){

		parent::__construct();

	}
	
/*================================================================
	Opciones
=================================================================*/

	public function getOptions($options) {

		$query = $this->db->get('ter_options');

		return $query->result_array();
	}

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

}