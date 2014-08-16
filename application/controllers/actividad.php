<?php

class Actividad extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Actividad/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('actividad');

    $crud->set_subject('Actividad');

    $crud->set_language('spanish');

    $crud->required_fields(
      'descripcion',
      'fecha_inicio',
      'fecha_fin',
      'observacion',
      'grupo_id');

    $crud->columns(
      'id',
      'descripcion',
      'fecha_inicio',
      'fecha_fin',
      'observacion',
      'grupo_id'
    );

    $crud->display_as('grupo_id','Grupo');

    $crud->set_Relation('grupo_id','grupo','nombre_grupo');

    $output = $crud->render();

    $this->load->view('actividad_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>