<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {

	public function index() {

		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}
}

/* End of file gallery.php */
/* Location: ./application/controllers/gallery.php */