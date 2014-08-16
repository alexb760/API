<?php

class Presupuesto_Actividad extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Presupuesto_Actividad/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('presupuesto_actividad');

    $crud->set_subject('Presupuesto de Actividad');

    $crud->set_language('spanish');

    $crud->required_fields(
      'presupuesto_id',
      'actividad_id',
      'valor_gasto');

    $crud->columns(
      'id',
      'presupuesto_id',
      'actividad_id',
      'valor_gasto');

    //$crud->field_type('valor_gasto','enum',array ( 'activo' , 'privado' , 'correo no deseado' , 'borrado' ));
    $crud->set_rules('valor_gasto','Valor','numeric');

    $crud->display_as('presupuesto_id','Presupuesto')  ->display_as('actividad_id','Actividad')
         ->display_as('valor_gasto','Gasto');

     $crud->set_Relation('presupuesto_id','presupuesto','valor')
          ->set_Relation('actividad_id','actividad','descripcion');    

    $output = $crud->render();

    $this->load->view('presupuesto_actividad_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>