<?php

class Linea_Investigacion extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Linea_Investigacion/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('linea_investigacion');

    $crud->set_subject('Linea Investigaciòn');

    $crud->set_language('spanish');

    $crud->required_fields(
      'tema',
      'descripcion',
      'area_id'
    );

    $crud->columns(
      'id',
      'tema',
      'descripcion',
      'fecha_sistema',
      'area_id'
    );

    $crud->add_fields(
      'tema',
      'descripcion',
      'area_id');

    $crud->display_as('area_id','Area')->display_as('fecha_sistema','Fecha');

    $output = $crud->render();

    $this->load->view('linea_investigacion_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>