<?php

class Consulta extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_crud');

        $this->load->helper('url');
        //$this->load->model('consulta_model');
    }

    function index(){
        redirect('Consulta/listar');
    }

    function listar()
  {
    try{

    $crud = new grocery_CRUD();

    /*$crud->set_theme('flexigrid');

    $crud->set_table('actividad');

    $crud->set_subject('Actividad');

    $crud->set_language('spanish');
*/
    $this->load->model('consulta_model');
    $activi = $this->consulta_model->Actividades();
    $activiR = $this->consulta_model->ActividadRealizada();

    //print_r($activi);

    //print_r($activiR);

    $operacion['resultado'] = $activiR/$activi*100;
    print_r($activiR.'%');
    //print_r($operacion.'%');

    $dat['tit']="Hola";

    //$this->load->view('actividad_view', $output);

    $this->load->view('consulta_view',$operacion);
    //$this->load->view('prueba');

    }catch(Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}
?>