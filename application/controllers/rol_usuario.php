<?php

class Rol_Usuario extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Rol_Usuario/rolUsuario');
    }

    function rolUsuario()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('rol_usuario');

    $crud->set_subject('Roles');

    $crud->set_language('spanish');

    $crud->required_fields(
      'nombre'
    );

    $crud->columns(
      'id',
      'nombre'
    );

    $output = $crud->render();

    $this->load->view('rol_usuario_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>