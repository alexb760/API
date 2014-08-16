<?php

class Facultad extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Facultad/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('facultad');

    $crud->set_subject('Facultad');

    $crud->set_language('spanish');

    $crud->required_fields(
      'nombre',
      'director'
    );

    $crud->columns(
      'id',
      'nombre',
      'director'
    );

    $output = $crud->render();

    $this->load->view('facultad_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>