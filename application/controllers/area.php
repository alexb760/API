<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Area extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
		$this->load->helpers(array('url','form'));
		$this->load->library(array('form_validation'));
		$this->load->model('area_model');

	}

	function index(){
		$this->load->view('area_view');
	}

	function insertar(){
		$area =  array('area' => $this->input->post('area'),
						'descripcion' => $this->input->post('descripcion'), 
						'fecha_sistema' => date('Y-m-d H:m:s'));
		if($this->area_model->insertar_area($area))
			echo 'Insertado';
		else
			echo ':(';
	}


}


?>