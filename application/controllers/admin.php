<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

		function __construct(){

		parent::__construct();

			
		$this->load->library('L_imagenes', '', 'libImagenes');

		//$this->load->model( 'm_imagenes', 'modImagenes' );
		
	}

	public function index() {

		$sidebar['selected'] = "main";
		$data['sidebar'] = $this->load->view('backend/common/sidebar',$sidebar, true);

		$this->load->view('backend/common/header');
		$this->load->view('backend/index', $data);
		$this->load->view('backend/common/footer');
	}

/* =========================================================
	Albums
============================================================ */

		public function albums() {

		$sidebar['selected'] 	= "albums";
		$data['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);

		$data['titular'] 		= "Albums";
		$data['todoAlbums']		= $this->modImagenes->getAlbums();

		$this->load->view('backend/common/header');
		$this->load->view('backend/albums', $data);
		$this->load->view('backend/common/footer');
		
	}


	public function addAlbum( $idAlbum ='add' ) {

		$sidebar['selected'] 	= "albums";
		$data['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);

		if ( $idAlbum == 'add') {
			$data['titular'] 			 = "Crear un álbum";
			$data['accion'] 			 = "add";
		} else {
			$data['titular'] 			 = "Editar un álbum";
			$data['accion'] 			 = "edit";
			$data['todoAlbum'] 			 = $this->modImagenes->getAlbum($idAlbum);			
			$data['todoAlbum']['fecha']	 = $this->libImagenes->dateUkToSp($data['todoAlbum']['fecha']);
			$data['todoCategoriasAlbum'] = $this->modImagenes->getCategoriaToAlbum($idAlbum);
			$data['todoTagsAlbum'] 		 = $this->modImagenes->getTagsToAlbum($idAlbum);
		}

		$data['todoCategorias'] 		 = $this->modImagenes->getCategorias();

		$this->load->view('backend/common/header');
		$this->load->view('backend/addAlbums', $data);
		$this->load->view('backend/common/footer');
	}

	public function insertAlbum() {

		if (isset($_POST) && $_POST) {

			$albumNombre 		= addslashes( strip_tags($this->input->post('albumNombre') ) );
			$albumFecha 		= strip_tags( $this->input->post('albumFecha') );	
			$albumLugar 		= addslashes( strip_tags($this->input->post('albumLugar') ) );
			$albumGoogle 		= addslashes( strip_tags($this->input->post('albumGoogle') ) );
			$albumDescripcion 	= addslashes( $this->input->post('albumDescripcion') ); // ESPECIFICAR AQUÍ LAS QUE DEJE
			$albumCategorias	= $this->input->post('albumCategorias');
			
			/* Recogemos dos fuentes de los tags por si no le dieron al botón añadir */
			$albumTags 			= addslashes( strip_tags($this->input->post('albumTags') ) );
			$listadoTags 		= $this->input->post('inputTags');

			if ( $albumNombre == "" ) {
				$albumNombre = "Sin título";
			} 

			if ( $albumFecha != "" ) {
				$albumFecha = $this->libImagenes->dateSpToUk($albumFecha);
			}

			if ( $albumLugar == "" ) {
				$albumLugar = "-";
			}

			if ( $albumGoogle != 1 ) {
				$albumGoogle = 0;
			}

			$imagenDestacada = "pendiente";

			$idAlbum = $this->modImagenes->insertAlbum($albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada);

			if ( count($albumCategorias) > 0 ) {
				foreach ( $albumCategorias as $clave ) {
					$this->modImagenes->insertCategoriaToAlbum($idAlbum, $clave);
				} 
			} 			
		
			$albumTags = explode(",", $albumTags );
			$this->libImagenes->insertTagsAlbum($idAlbum, $albumTags);			
			$this->libImagenes->insertTagsAlbum($idAlbum, $listadoTags);


			$rutaBase = 'images/albums/'.$idAlbum.'/';

			if ( isset($_FILES['imagenDestacada']['tmp_name']) ) {

				$nombreImagen = "imagenDestacada_".$idAlbum;
				$nombreInput = "imagenDestacada";		

				$envio = $this->libImagenes->uploadImagenes($rutaBase, $nombreImagen, $nombreInput);

				if ( $envio == 1 ) {
					$extensionImagen = $_FILES['imagenDestacada']['name'];
					$arrayTemporal = explode(".", $extensionImagen);
					$extensionImagen = end($arrayTemporal);

					$imagenDestacada = $nombreImagen.".".$extensionImagen;

					$this->modImagenes->updateAlbum($idAlbum, $albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada);

				} 

			} // #if ( isset($_FILES['imagenDestacada']['tmp_name']) )	
		
		redirect ( 'admin/addAlbum/'.$idAlbum, 'location', 301 );	

		} // #if (isset($_POST) && $_POST)

	} //#insertAlbum

	public function updateAlbum() {

		if (isset($_POST) && $_POST) {

			
			$idAlbum				= addslashes( strip_tags($this->input->post('idAlbum') ) );
			$albumNombre 			= addslashes( strip_tags($this->input->post('albumNombre') ) );
			$albumFecha 			= strip_tags( $this->input->post('albumFecha') );		
			$albumLugar 			= addslashes( strip_tags($this->input->post('albumLugar') ) );
			$albumGoogle 			= addslashes( strip_tags($this->input->post('albumGoogle') ) );
			$albumDescripcion 		= addslashes( $this->input->post('albumDescripcion') );
			$albumCategorias		= $this->input->post('albumCategorias');
			$albumTags 			= addslashes( strip_tags($this->input->post('albumTags') ) );
			$listadoTags 		= $this->input->post('inputTags');
			$imagenDestacadaSubida = addslashes( strip_tags($this->input->post('imagenDestacadaSubida') ) );

			if ( $albumNombre == "" ) {
				$albumNombre = "Sin título";
			} 

			if ( $albumFecha != "" ) {				
				$albumFecha = $this->libImagenes->dateSpToUk($albumFecha);
			}
			
			if ( $albumLugar == "" ) {
				$albumLugar = "-";
			}

			if ( $albumGoogle != 1 ) {
				$albumGoogle = 0;
			}

			if ( count($albumCategorias) > 0 ) {
				// Borramos todas las posibles de este álbum
				$this->modImagenes->deleteCategoriaToAlbum($idAlbum);
				// Reinsertamos
				foreach ( $albumCategorias as $clave ) {
					$this->modImagenes->insertCategoriaToAlbum($idAlbum, $clave);
				} 
			} 

			// Ídem con los tags: Primero, los borramos
			$this->modImagenes->deleteTagToAlbum($idAlbum);
			// y ya con el resto
			if ( $albumTags != "" ) {
				$albumTags = explode(",", $albumTags );
				$this->libImagenes->insertTagsAlbum($idAlbum, $albumTags);
			}
			if ( count( $listadoTags) > 0 ) {			
				$this->libImagenes->insertTagsAlbum($idAlbum, $listadoTags);			
			}
			/* Si no existe ya alguna imagen, ponemos en marcha el proceso */

			if ( isset($imagenDestacadaSubida) AND $imagenDestacadaSubida != "" ) {

				$imagenDestacada = $imagenDestacadaSubida;

			} else {

				$imagenDestacada = "pendiente";

				$rutaBase = 'images/albums/'.$idAlbum.'/';

				if ( isset($_FILES['imagenDestacada']['tmp_name']) ) {

					$nombreImagen = "imagenDestacada_".$idAlbum;
					$nombreInput = "imagenDestacada";		

					$envio = $this->libImagenes->uploadImagenes($rutaBase, $nombreImagen, $nombreInput);

					if ( $envio == 1 ) {
						$extensionImagen = $_FILES['imagenDestacada']['name'];
						$arrayTemporal = explode(".", $extensionImagen);
						$extensionImagen = end($arrayTemporal);

						$imagenDestacada = $nombreImagen.".".$extensionImagen;

					}

				}

			}


			$this->modImagenes->updateAlbum($idAlbum, $albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada);

			redirect ( 'admin/addAlbum/'.$idAlbum, 'location', 301 );	

		} // #if (isset($_POST) && $_POST)

	} //#updateAlbum

	public function insertCategoria() {
		
		if (isset($_POST) && $_POST) {

			$value = addslashes( strip_tags($this->input->post('value') ) );

			if ( $value != "" ) {
				$this->modImagenes->insertCategoria($value);
			}

		}

		/* De momento, en tanto que apenas hay que pintar un convo de checkoptions con esto,
		devuelvo el ajax directamente. Si más adelante se complica, preparar una vista ex-profeso */

		$todoCategorias = $this->modImagenes->getCategorias();

		foreach ( $todoCategorias as $clave ) {
			echo "<input type='checkbox' name='".$clave['id']."' value='".$clave['id']."' class='azul_0777eb'>".$clave['value']."<br />";
		}

	} //#insertCategoria


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */