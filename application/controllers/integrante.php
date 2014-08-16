<?php

class Integrante extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Integrante/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('integrante');

    $crud->set_subject('Integrante');

    $crud->set_language('spanish');

    $crud->required_fields(
      'usuario_id',
      'grupo_id');

    $crud->columns(
      'id',
      'usuario_id',
      'grupo_id',
      'activo',
      'is_asesor',
      'facultad_id'
    );

    $crud->display_as('usuario_id','Usuario')
         ->display_as('grupo_id','Grupo')
         ->display_as('facultad_id','Facultad');

    $crud->set_Relation('usuario_id','usuario','apellido')
         ->set_Relation('grupo_id','grupo','nombre_grupo')
         ->set_Relation('facultad_id','facultad','nombre');


    $output = $crud->render();

    $this->load->view('integrante_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>