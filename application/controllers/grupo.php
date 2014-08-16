<?php

class Grupo extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Grupo/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('grupo');

    $crud->set_subject('Grupo');

    $crud->set_language('spanish');

    $crud->required_fields(
      'proyecto_investigacion_id',
      'nombre_grupo',
      'sigla',
      'semillero',
      'grupo_id');

    $crud->columns(
      'id',
      'proyecto_investigacion_id',
      'nombre_grupo',
      'sigla',
      'semillero',
      'grupo_id');

    $crud->display_as('proyecto_investigacion_id','Proyecto Investigacion')
         ->display_as('grupo_id','Grupo');

     $crud->set_Relation('grupo_id','grupo','id');    

    $output = $crud->render();

    $this->load->view('grupo_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>