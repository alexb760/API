<?php

class Sub_actividad extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Sub_actividad/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('sub_actividad');

    $crud->set_subject('Sub Actividades');

    $crud->set_language('spanish');

    $crud->required_fields(
      'descripcion',
      'fecha_inicio',
      'fecha_fin',
      'observacion',
      'actividad_id'
    );

    $crud->columns(
        'id',
      'descripcion',
      'fecha_inicio',
      'fecha_fin',
      'observacion',
      'actividad_id'
    );

    $crud->set_Relation(
      'actividad_id',
      'actividad',
      'descripcion');

    $crud->display_as('actividad_id','Actividad');

    $output = $crud->render();

    $this->load->view('sub_actividad_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>