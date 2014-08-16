<?php

class Producto extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Producto/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('producto');

    $crud->set_subject('Producto');

    $crud->set_language('spanish');

    $crud->required_fields(
      'nombre',
      'descripcion',
      'ruta',
      'tipo_producto_id',
      'grupo_id');

    $crud->columns(
      'id',
      'nombre',
      'descripcion',
      'ruta',
      'tipo_producto_id',
      'grupo_id'
    );

    $crud->display_as('tipo_producto_id','Tipo Producto')
         ->display_as('grupo_id','Grupo');

    $crud->set_Relation('tipo_producto_id','tipo_producto','descripcion')
         ->set_Relation('grupo_id','grupo','nombre_grupo');

    $output = $crud->render();

    $this->load->view('producto_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>