<?php

class Presupuesto extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
    }

    function index(){
        redirect('Presupuesto/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    $crud->set_theme('flexigrid');

    $crud->set_table('presupuesto');

    $crud->set_subject('Presupuesto');

    $crud->set_language('spanish');

    $crud->required_fields(
      'fechasistema',
      'fecha_inicio',
      'fecha_final',
      'valor',
      'autoriza',
      'grupo_id');

    $crud->columns(
      'id',
      'fechasistema',
      'fecha_inicio',
      'fecha_final',
      'valor',
      'autoriza',
      'grupo_id');

    $crud->set_rules('valor','Valor','numeric');

    $crud->display_as('grupo_id','Grupo')
         ->display_as('fechasistema','Fecha');
    //  ->display_as('actividad_id','Actividad')
      //   ->display_as('valor_gasto','Gasto');

     $crud->set_Relation('grupo_id','grupo','nombre_grupo');    

    $output = $crud->render();

    $this->load->view('presupuesto_view', $output);

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>