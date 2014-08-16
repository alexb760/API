<?php

class Estado_grupo extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Estado_grupo/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('estado_grupo');

    $crud->set_subject('Estado de Grupos');

    $crud->set_language('spanish');

    $crud->required_fields(
      'estado_id',
      'grupo_id',
      'fecha_estado');

    $crud->columns(
      'estado_id',
      'grupo_id',
      'observacion',
      'fecha_estado'
    );

    $crud->add_fields(
      'estado_id',
      'grupo_id',
      'observacion');

    $crud->display_as('estado_id','Estado')
         ->display_as('grupo_id','Grupo');

    $crud->set_Relation('estado_id','estado','descripcion');
    $crud->set_Relation('grupo_id','grupo','nombre_grupo');


    $output = $crud->render();

    $this->load->view('estado_grupo_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>