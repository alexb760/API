<?php

class Autoria extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Autoria/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('autoria');

    $crud->set_subject('Autoria');

    $crud->set_language('spanish');

    $crud->required_fields(
      'integrante_id',
      'producto_id');

    $crud->columns(
      'id',
      'integrante_id',
      'producto_id'
    );

    $crud->display_as('integrante_id','Integrante')
         ->display_as('producto_id','Producto');

    $crud->set_Relation('integrante_id','integrante','usuario_id')
         ->set_Relation('producto_id','producto','nombre');


    $output = $crud->render();

    $this->load->view('autoria_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>