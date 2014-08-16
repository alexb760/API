<?php

class Tipo_Producto extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Tipo_Producto/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('tipo_producto');

    $crud->set_subject('Tipo Producto');

    $crud->set_language('spanish');

    $crud->required_fields(
      'descripcion');

    $crud->columns(
      'id',
      'descripcion');

    $output = $crud->render();

    $this->load->view('tipo_producto_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>