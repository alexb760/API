<?php

class Actividad_Realizada extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Actividad_Realizada/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('actividad_realizada');

    $crud->set_subject('Actividades Realizadas');

    $crud->set_language('spanish');

    $crud->required_fields(
      'fecha_fin',
      'observacion',
      'responsable',
      'presupuesto_actividad_id',
      'ejecutada'
    );

    $crud->columns(
        'id',
      'fecha_fin',
      'observacion',
      'responsable',
      'presupuesto_actividad_id',
      'ejecutada'
    );

    $crud->set_Relation(
      'presupuesto_actividad_id',
      'presupuesto_actividad',
      'valor_gasto');

    $crud->display_as(
      'presupuesto_actividad_id',
      'Presupuesto');

    $output = $crud->render();

    $this->load->view('actividad_realizada_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>