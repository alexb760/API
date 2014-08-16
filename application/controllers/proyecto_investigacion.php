<?php

class Proyecto_Investigacion extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Proyecto_Investigacion/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('proyecto_investigacion');

    $crud->set_subject('Proyecto Investigación');

    $crud->set_language('spanish');

    $crud->required_fields(
      'nombre_pro',
      'descripcion',
      'sigla',
      'objetivo',
      'fecha_creacion',
      'fecha_caducado',
      'linea_investigacion_id');

    $crud->columns(
      'id',
      'nombre_pro',
      'descripcion',
      'sigla',
      'objetivo',
      'fecha_creacion',
      'fecha_caducado',
      'linea_investigacion_id');

    $crud->display_as('nombre_pro','Nombre')
         ->display_as('linea_investigacion_id','Linea Investigación');

     $crud->set_Relation('linea_investigacion_id','linea_investigacion','tema');    

    $output = $crud->render();

    $this->load->view('proyecto_investigacion_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>