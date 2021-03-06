<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

		function __construct(){

		parent::__construct();
			
		$this->load->library('L_imagenes', '', 'libImagenes');		
		
	}

	public function index() {

		$sidebar['selected'] = "main";
		$data['sidebar'] = $this->load->view('backend/common/sidebar',$sidebar, true);

		$this->load->view('backend/common/header');
		$this->load->view('backend/index', $data);
		$this->load->view('backend/common/footer');
	}

	/* Cosas pendientes 
		No perder el tag seleccionado de categorías.
		Cambiar proceso álbums
		Borrar categorías y tags cuando borre el álbum
		añadir footer personalizado
	*/

/* =========================================================
	Albums
============================================================ */

	public function albumes() {

		$sidebar['selected'] 	= "albumes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);
		$header['breadcrumb']	= "<a href='".base_url()."admin/albumes'>Álbumes</a>";

		$header['titular'] 		= "Álbumes";
		$data['todoAlbums']		= $this->modImagenes->getAlbums();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();
		
		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/albums', $data);
		$this->load->view('backend/common/footer', $footer);
		
	}


	public function addAlbum( $idAlbum ='add' ) {

		$sidebar['selected'] 	= "albumes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);

		if ( $idAlbum == 'add') {
			$header['titular'] 			 = "Crear un álbum";			
			$header['breadcrumb']		 = "<a href='".base_url()."admin/albumes'>Álbumes</a> <span class='separador'>&rsaquo;</span> Añadir un álbum";
			$data['accion'] 			 = "add";
		} else {
			$header['titular'] 			 = "Editar un álbum";
			$header['breadcrumb']		 = "<a href='".base_url()."admin/albumes'>Álbumes</a> <span class='separador'>&rsaquo;</span> Editar un álbum";
			$data['accion'] 			 = "edit";
			$data['todoAlbum'] 			 = $this->modImagenes->getAlbum($idAlbum);			
			$data['todoAlbum']['fecha']	 = $this->libImagenes->dateUkToSp($data['todoAlbum']['fecha']);
			$data['todoCategoriasAlbum'] = $this->modImagenes->getCategoriaToAlbum($idAlbum);
			$data['todoTagsAlbum'] 		 = $this->modImagenes->getTagsToAlbum($idAlbum);
		}

		$data['todoCategorias'] 		 = $this->modImagenes->getCategorias();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();

		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/addAlbums', $data);
		$this->load->view('backend/common/footer', $footer);
	}

	public function insertAlbum() {

		if (isset($_POST) && $_POST) {

			$albumNombre 		= addslashes( strip_tags($this->input->post('albumNombre') ) );
			$albumFecha 		= strip_tags( $this->input->post('albumFecha') );	
			$albumLugar 		= addslashes( strip_tags($this->input->post('albumLugar') ) );
			$albumGoogle 		= addslashes( strip_tags($this->input->post('albumGoogle') ) );
			$albumDescripcion 	= addslashes( $this->input->post('albumDescripcion') ); 
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

			if ( count($albumCategorias) > 0 && $albumCategorias != "" ) {
				foreach ( $albumCategorias as $clave ) {
					$this->modImagenes->insertCategoriaToAlbum($idAlbum, $clave);
				} 
			} 			
		
			if ( $albumTags AND $albumTags !=0 ) {
				$albumTags = explode(",", $albumTags );
				$this->libImagenes->insertTagsAlbum($idAlbum, $albumTags);
			}			
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

					// Miniatura
					$this->libImagenes->generateThumbails($rutaBase.$imagenDestacada);

					// Sacada la miniatura, redimensionamos la imagen si sobrepasa un ancho o alto máximo
					$this->libImagenes->resizeImageIfLong($rutaBase.$imagenDestacada);					

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
			$albumTags 				= addslashes( strip_tags($this->input->post('albumTags') ) );
			$listadoTags 			= $this->input->post('inputTags');
			$imagenDestacadaSubida 	= addslashes( strip_tags($this->input->post('imagenDestacadaSubida') ) );

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

						$this->libImagenes->generateThumbails($rutaBase.$imagenDestacada);

						$this->libImagenes->resizeImageIfLong($rutaBase.$imagenDestacada);	

					}

				}

			}


			$this->modImagenes->updateAlbum($idAlbum, $albumNombre, $albumFecha, $albumLugar, $albumGoogle, $albumDescripcion, $imagenDestacada);

			redirect ( 'admin/addAlbum/'.$idAlbum, 'location', 301 );	

		} // #if (isset($_POST) && $_POST)

	} //#updateAlbum

	public function deleteAlbum() {

		if (isset($_POST) && $_POST) {

			$idAlbum = addslashes( strip_tags($this->input->post('id') ) );
			$checkAlbum = $this->modImagenes->getAlbum($idAlbum);

			if ( is_numeric($idAlbum) AND !empty($checkAlbum) ) {
				
				$this->modImagenes->deleteAlbum($idAlbum);

				$ruta = './images/albums/'.$idAlbum;

				if ( is_dir($ruta) ) {
					$this->load->helper("file");
					delete_files($ruta, true);
					rmdir($ruta);
				}				

			} 

		}
		
	} //#deleteAlbum

	public function ordenarAlbumes() {
		$sidebar['selected'] 	= "ordenarAlbumes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);
		$header['breadcrumb']	= "<a href='".base_url()."admin/albumes'>Álbumes</a> <span class='separador'>&rsaquo;</span> Ordenar";

		$header['titular'] 		= "Ordenar álbumes";
		$data['todoAlbums']		= $this->modImagenes->getAlbums();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();
		
		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/albumsOrdenar', $data);
		$this->load->view('backend/common/footer', $footer);
	}

	public function ordenarAlbumsUpdate() {

		if (isset($_POST) && $_POST) {

			$ordenAlbums = $this->input->post('ordenAlbums');
			$ordenAlbums = explode(",", $ordenAlbums);
			$contador = 1;
			foreach ($ordenAlbums as $clave) {
				$idAlbum = str_replace('js-capsula_', '', $clave);
				$this->modImagenes->updateOrdenAlbums($idAlbum, $contador);
				$contador++;
			}

		}

	}

/* =========================================================
	Imágenes
============================================================ */

	public function imagenes() {

		$sidebar['selected'] 	= "imagenes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);
		$header['breadcrumb']	= "<a href='".base_url()."admin/imagenes'>Imágenes</a>";

		$header['titular'] 		= "Imágenes";
		$data['todoImagenes']	= $this->modImagenes->getImagenes();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();
		
		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/imagenes', $data);
		$this->load->view('backend/common/footer', $footer);
		
	}


	public function addImagen( $idImagen ='add' ) {

		$sidebar['selected'] 	= "imagenes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);

		if ( $idImagen == 'add') {
			$header['titular'] 			 = "Subir imágenes";			
			$header['breadcrumb']		 = "<a href='".base_url()."admin/imagenes'>Imágenes</a> <span class='separador'>&rsaquo;</span> Subir una imagen";
			$data['accion'] 			 = "add";
		} else {
			$header['titular'] 			 = "Editar una imagen";
			$header['breadcrumb']		 = "<a href='".base_url()."admin/imagenes'>Imágenes</a> <span class='separador'>&rsaquo;</span> Editar una imagen";
			$data['accion'] 			 = "edit";
			$data['todoImagen'] 		 = $this->modImagenes->getImagen($idImagen);			
			$data['todoImagen']['fecha'] = $this->libImagenes->dateUkToSp($data['todoImagen']['fecha']);			
			$data['todoTagsImagen'] 	 = $this->modImagenes->getTagsToImagen($idImagen);
		}

		$data['todoAlbums']		= $this->modImagenes->getAlbums();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();

		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/addImagen', $data);
		$this->load->view('backend/common/footer', $footer);
	}

	public function insertImagen() {

		if (isset($_POST) && $_POST) {

			$imagenNombre 		= $this->input->post('imagenNombre');
			$imagenFecha 		= $this->input->post('imagenFecha');	
			$imagenLugar 		= $this->input->post('imagenLugar');			
			$imagenDescripcion 	= $this->input->post('imagenDescripcion');
			$imagenAlbum 		= $this->input->post('imagenAlbum'); 
						
			$imagenTags 		= $this->input->post('imagenTags');
			$listadoTags 		= $this->input->post('inputTags');

			if ( $imagenNombre == "" ) {
				$imagenNombre = "Sin título";
			} 

			if ( $imagenFecha != "" ) {
				$imagenFecha = $this->libImagenes->dateSpToUk($imagenFecha);
			}

			if ( $imagenLugar == "" ) {
				$imagenLugar = "-";
			}

			$imagenRuta = "pendiente";

			$idImagen = $this->modImagenes->insertImagen($imagenNombre, $imagenFecha, $imagenLugar, $imagenDescripcion, $imagenRuta, $imagenAlbum);

			if ( $imagenTags AND $imagenTags !=0 ) {
				$imagenTags = explode(",", $imagenTags );
				$this->libImagenes->insertTagsImagen($idImagen, $imagenTags);
			}			
			$this->libImagenes->insertTagsImagen($idImagen, $listadoTags);

			$month 			= date('m');
			$year 			= date('Y');
			$nombreImagen 	= time();

			$rutaBase = 'images/images/'.$year.'/'.$month.'/';

			if ( isset($_FILES['imagenRuta']['tmp_name']) ) {

				$nombreInput = 'imagenRuta';		

				$envio = $this->libImagenes->uploadImagenes($rutaBase, $nombreImagen, $nombreInput);

				if ( $envio == 1 ) {
					$extensionImagen = $_FILES['imagenRuta']['name'];
					$arrayTemporal = explode(".", $extensionImagen);
					$extensionImagen = end($arrayTemporal);

					$imagenRuta = $nombreImagen.".".$extensionImagen;

					$this->libImagenes->generateThumbails($rutaBase.$imagenRuta);

					$this->libImagenes->resizeImageIfLong($rutaBase.$imagenRuta);

					$imagenRuta = $year.'/'.$month.'/'.$nombreImagen.".".$extensionImagen;					

					$this->modImagenes->updateImagen($idImagen, $imagenNombre, $imagenFecha, $imagenLugar, $imagenDescripcion, $imagenRuta, $imagenAlbum);

				} 

			} // #if ( isset($_FILES['imagenDestacada']['tmp_name']) )	
		
			redirect ( 'admin/addImagen/'.$idImagen, 'location', 301 );	

		} // #if (isset($_POST) && $_POST)

	} //#insertImagen

	public function updateImagen() {

		if (isset($_POST) && $_POST) {

			$imagenNombre 		= $this->input->post('imagenNombre');
			$imagenFecha 		= $this->input->post('imagenFecha');	
			$imagenLugar 		= $this->input->post('imagenLugar');			
			$imagenDescripcion 	= $this->input->post('imagenDescripcion');
			$imagenAlbum 		= $this->input->post('imagenAlbum');
			$imagenRuta 		= $this->input->post('imagenRuta');
			$idImagen 			= $this->input->post('idImagen');    
						
			$imagenTags 		= $this->input->post('imagenTags');
			$listadoTags 		= $this->input->post('inputTags');

			if ( $imagenNombre == "" ) {
				$imagenNombre = "Sin título";
			} 

			if ( $imagenFecha != "" ) {
				$imagenFecha = $this->libImagenes->dateSpToUk($imagenFecha);
			}

			if ( $imagenLugar == "" ) {
				$imagenLugar = "-";
			}

			$this->modImagenes->deleteTagToImagen($idImagen);

			if ( $imagenTags AND $imagenTags !=0 ) {
				$imagenTags = explode(",", $imagenTags );
				$this->libImagenes->insertTagsImagen($idImagen, $imagenTags);
			}			
			$this->libImagenes->insertTagsImagen($idImagen, $listadoTags);


			$this->modImagenes->updateImagen($idImagen, $imagenNombre, $imagenFecha, $imagenLugar, $imagenDescripcion, $imagenRuta, $imagenAlbum);

		
			redirect ( 'admin/addImagen/'.$idImagen, 'location', 301 );	

		} // #if (isset($_POST) && $_POST)

	} //#insertImagen

	public function deleteImagen() {

		if (isset($_POST) && $_POST) {

			$idImagen = $this->input->post('idImagen');

			if ( !is_numeric($idImagen) ) {
				die("Error en el envío del formulario");
			}

			$todoImagen = $this->modImagenes->getImagen($idImagen);
		
			$this->modImagenes->deleteImagen($idImagen);

			$this->modImagenes->deleteImagenTags($idImagen);

			$ruta = './images/images/'.$todoImagen['ruta'];

			if ( is_file($ruta) ) {
				unlink($ruta);
			}

		}

		redirect ( 'admin/imagenes', 'location', 301 );	

	}


/*================================================================
	Categorías
=================================================================*/


	public function insertCategoria() {
		
		if (isset($_POST) && $_POST) {

			$value = addslashes( strip_tags($this->input->post('value') ) );

			if ( $value != "" ) {

				$idCategoria = $this->modImagenes->insertCategoria($value);

					/* De momento, en tanto que apenas hay que pintar un convo de checkoptions con esto,
					devuelvo el ajax directamente. Si más adelante se complica, preparar una vista ex-profeso */

				$cadena = "<input type='checkbox' name='albumCategorias[".$idCategoria."]' value='".$idCategoria."' class='azul_0777eb'  checked  />".$value."<br />";
			
				echo $cadena;
			}

		}

	} //#insertCategoria


/* =========================================================
	Opciones
============================================================ */

	public function ajustes() {

		$this->load->model( 'm_options', 'modOptions' );		

		$sidebar['selected'] 	= "ajustes";
		$header['sidebar'] 		= $this->load->view('backend/common/sidebar',$sidebar, true);
		$header['breadcrumb']	= "<a href='".base_url()."admin/ajustes'>Ajustes</a>";

		$header['titular'] 		= "Ajustes";

		$data['todoOpciones'] 	= $this->modOptions->getOpciones();

		$footer['tiempo'] 		= $this->benchmark->elapsed_time();
		$footer['memoria'] 		= $this->benchmark->memory_usage();
		
		$this->load->view('backend/common/header', $header);
		$this->load->view('backend/opciones', $data);
		$this->load->view('backend/common/footer', $footer); 

	} //#opciones

	public function optionsUpdateImg() {

		if (isset($_POST) && $_POST) {

			$this->load->model( 'm_options', 'modOptions' );

			$maxWidth 		= addslashes( strip_tags($this->input->post('maxWidth') ) );
			$maxHeight 		= addslashes( strip_tags($this->input->post('maxHeight') ) );
			$maxWidthThumb 	= addslashes( strip_tags($this->input->post('maxWidthThumb') ) );
			$maxHeightThumb = addslashes( strip_tags($this->input->post('maxHeightThumb') ) );

			$data = array( 	'thumb_width'		=> $maxWidthThumb,
							'thumb_height'		=> $maxHeightThumb,
							'img_main_width'	=> $maxWidth,
							'img_main_height'	=> $maxHeight
						);

			$this->modOptions->updateOptions($data);

		}

	} // #optionsUpdateImg

	public function getDefaultSizeImg() {

		$this->config->load('options');

		$maxSizes 		= $this->config->item('image_max_sizes');
		$maxThumbails 	= $this->config->item('image_max_thumbails');
		/* Aunque se podría enviar todo en un array directamente, prefiero desglosarlo
		por escalabilidad */
		$maxWidth 		= $maxSizes[0];
		$maxHeight 		= $maxSizes[1];
		$maxWidthThumb 	= $maxThumbails[0];
		$maxHeightThumb = $maxThumbails[1];
		$arraySizes 	= array($maxWidth, $maxHeight, $maxWidthThumb, $maxHeightThumb);
		echo json_encode( $arraySizes ); 

	} // #getDefaultSizeImg

	public function updateDefaultSizeImg() {

		$this->load->model( 'm_options', 'modOptions' );

		if (isset($_POST) && $_POST) {

			$maxWidth 		= intval( $this->input->post('maxWidth') );
			$maxHeight 		= intval( $this->input->post('maxHeight') );
			$maxWidthThumb 	= intval( $this->input->post('maxWidthThumb') );
			$maxHeightThumb = intval( $this->input->post('maxHeightThumb') );
			
			$this->modOptions->updateDefaultSizeImg($maxWidth, $maxHeight, $maxWidthThumb, $maxHeightThumb);

		}

	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */