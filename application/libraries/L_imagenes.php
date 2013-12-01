<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class L_imagenes {
  	
  	public function __construct() {

        $this->instance =& get_instance();        
        $this->instance->load->model( 'm_imagenes', 'modImagenes' );        
  
  	} 


/* Sube cualquier tipo de imagen */
	
	public function uploadImagenes($rutaBase, $nombreImagen, $nombreInput) {

		if (!is_dir($rutaBase)) {
			mkdir($rutaBase, 0777, true);
			$directorioCreado = 1;
		} else {
			$directorioCreado = 0;
		}

		$CI =& get_instance();

		$CI->load->library('upload');

		$config =  array(
						'upload_path'	     	=> $rutaBase,
						'file_name'				=> $nombreImagen, 
						'allowed_types'   		=> "gif|jpg|png",
						'overwrite'       		=> TRUE,
						'max_size'        		=> "1000KB",
						'max_height'      		=> "1768",
						'max_width'       		=> "2024" 
						);

		$CI->upload->initialize($config);   

		if( $CI->upload->do_upload($nombreInput) ) {
			$envio = 1;						
		} else {
			$envio = 0;
		}

		return $envio;

	}

/* Genera una miniatura a partir de una imagen */

	public function generateThumbails($file) {

		$this->instance =& get_instance();        
        $this->instance->load->model( 'm_options', 'modOptions' );

		$options = $this->instance->modOptions->getMaxThumb();

		$width = $options[0]['value'];
		$height = $options[1]['value'];

		$CI =& get_instance();

		$CI->load->library('image_lib'); 

		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $file;
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio'] 	= FALSE;
		$config['width']	 		= $width;
		$config['height']	 		= $height;

		$CI->image_lib->initialize($config); 

		$CI->image_lib->resize();

	}

	public function resizeImageIfLong($file) {

		$this->instance =& get_instance();        
        $this->instance->load->model( 'm_options', 'modOptions' );

		$options = $this->instance->modOptions->getMaxImg();

		$maxWidth = $options[0]['value'];
		$maxHeight = $options[1]['value'];

		$imageData = getimagesize($file);
				
		if ( ($imageData[0] > $imageData[1]) && ($imageData[0] > $maxWidth) ) {
			$width = $maxWidth;
			$height = ($maxWidth / $imageData[0]) * $imageData[1];
			$this->resizeImage($file, $width, $height);
			
		} elseif ( ($imageData[0] < $imageData[1]) && ($imageData[1] > $maxHeight) ) {
			$height = $maxHeight;
			$width = ($maxHeight / $imageData[1]) * $imageData[0];
			$this->resizeImage($file, $width, $height);
		}

	}

/* Recorta una imagen */

	public function resizeImage($file, $width, $height) {

		$CI =& get_instance();

		$CI->load->library('image_lib'); 

		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $file;
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= FALSE;
		$config['width']	 		= $width;
		$config['height']	 		= $height;

		$CI->image_lib->initialize($config); 

		$CI->image_lib->resize();

	}		

/* Recibe una cadena en fecha española y devuelve el formato inglés */

	public function dateSpToUk($fecha) {

		$fecha = explode("-", $fecha);
		$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
		return $fecha; 
	}

/* Recibe una cadena en fecha inglesa y la devuelve en formato español */

	public function dateUkToSp($fecha) {
		
		$fecha = explode("-", $fecha);
		$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
		return $fecha; 
	} 

	/* Inserta un listado de etiquetas y los asocia con un álbum. 
		Pendiente: optimizar este proceso para no lanzar tantas queries */

	public function insertTagsAlbum($idAlbum, $arrayTags) {

		if ( count($arrayTags) > 0 && $arrayTags && $arrayTags != "") {

				foreach ( $arrayTags as $clave ) {
					// Comprobamos si existe
					$idTag = $this->instance->modImagenes->getTagByValue($clave);

					// Si no existe, insertamos
					if ( empty($idTag) ) {
						$idTag = $this->instance->modImagenes->insertTag($clave);
					} else {
						$idTag = $idTag['id'];
					}

					// Y ya vamos con el álbum
					$this->instance->modImagenes->insertTagToAlbum($idAlbum, $idTag);
				} 
		}
	} 

	/* Inserta un listado de etiquetas y los asocia con una imagen. 
		Pendiente: optimizar este proceso para no lanzar tantas queries */

	public function insertTagsImagen($idImagen, $arrayTags) {

		if ( count($arrayTags) > 0 && $arrayTags && $arrayTags != "") {

				foreach ( $arrayTags as $clave ) {

					$idTag = $this->instance->modImagenes->getTagByValue($clave);

					if ( empty($idTag) ) {
						$idTag = $this->instance->modImagenes->insertTag($clave);
					} else {
						$idTag = $idTag['id'];
					}

					$this->instance->modImagenes->insertTagToImagen($idImagen, $idTag);
				} 
		}
	} 



}