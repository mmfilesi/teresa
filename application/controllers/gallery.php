<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {

		function __construct(){

		parent::__construct();
		
	}

	public function index() {

		$this->load->view('frontend/header');
		$this->load->view('frontend/index');
		$this->load->view('frontend/footer');
	}
}

/* End of file gallery.php */
/* Location: ./application/controllers/gallery.php */