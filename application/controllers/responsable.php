<?php

class Responsable extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Responsable/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('responsable');

    $crud->set_subject('Responsable');

    $crud->set_language('spanish');

    $crud->required_fields(
      'actividad_id',
      'integrante_id',
      'duracion');

    $crud->columns(
      'id',
      'actividad_id',
      'integrante_id',
      'duracion');

    $crud->set_rules('duracion','Duracion','numeric');

    $crud->display_as('actividad_id','Actividad')
         ->display_as('integrante_id','Integrante');

     $crud->set_Relation('actividad_id','actividad','descripcion')
          ->set_Relation('integrante_id','integrante','usuario_id');    

    $output = $crud->render();

    $this->load->view('responsable_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>