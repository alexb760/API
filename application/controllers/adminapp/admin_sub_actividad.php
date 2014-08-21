<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Sub_Actividad extends CI_Controller
{
    private $id_subActividad;
  function __construct()
    {
		parent::__construct();
		$this->load->model('dai/actividad_model');
        $this->load->model('dai/sub_actividad_model');
        $this->load->model('dai/grupo_model');

		if (!$this->session->userdata('is_logged_in')) {
			redirect('index.php/main/index');
		}
	}

    public function index()
    {
    	$manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        $config['per_page'] = 7;
        $config['base_url'] = base_url().'index.php/adminapp/admin_sub_actividad/index/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config["uri_segment"] = 4;
    
        $page = $this->uri->segment(4);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        //echo $limit_end;
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type; 


        if($manufacture_id !== false && $search_string !== false && $order !== false || $this->uri->segment(2) == true){ 
            if($manufacture_id !== 0){
                $filter_session_data['manufacture_selected'] = $manufacture_id;
            }else{
                $manufacture_id = $this->session->userdata('manufacture_selected');
            }
            $data['manufacture_selected'] = $manufacture_id;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            $data['manufactures'] = null;//$this->manufacturers_model->get_manufacturers();

            $data['count_products']= $this->sub_actividad_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                $data['products'] = $this->sub_actividad_model->get_all_sub($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                $data['products'] = $this->sub_actividad_model->get_all_sub($search_string, '', $order_type, $config['per_page'],$limit_end);           
                // $data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }else{
                if($order){
                  $data['products'] = $this->sub_actividad_model->get_all_sub('', $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                 $data['products'] = $this->sub_actividad_model->get_all_sub('', '', $order_type, $config['per_page'],$limit_end);        
                //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products']= $this->actividad_model->count_();
            $data['products'] = $this->sub_actividad_model->get_all_sub('', '', $order_type, $config['per_page'],$limit_end);

            $config['total_rows'] = $data['count_products'];
        }

        $this->pagination->initialize($config);   

        $data['main_content'] = 'admin/sub_actividad/list';
        $this->load->view('includes/template', $data); 
    }

 public function add()
    {
        $var = null;
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('grupo','grupo','required');
            $this->form_validation->set_rules('actividad', 'actividad', 'trim|required');
            $this->form_validation->set_rules('descripcion', 'nombre', 'trim|required');
            $this->form_validation->set_rules('fecha_inicio', 'fecha inicio', 'required');
            $this->form_validation->set_rules('fecha_fin','fecha fin','required');

            if($this->input->post('observacion') !== NULL){
                $this->form_validation->set_rules('observacion','observacion','required');
            }

            $actividad = $this->input->post('actividad');
            $fechaI = $this->input->post('fecha_inicio');
            $fechaF = $this->input->post('fecha_fin');

            if($actividad !== "" && $fechaI !== "" && $fechaF !== ""){
                $this->form_validation->set_rules('fecha_fin','fecha fin','callback_FechaActividad');
            }
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                echo 'entro';
                $data_to_store = array(
                    'descripcion' => $this->input->post('descripcion'),
                    'fecha_inicio' => $this->input->post('fecha_inicio'),
                    'fecha_fin' => $this->input->post('fecha_fin'),
                    'observacion' => $this->input->post('observacion'),
                    'actividad_id' => $this->input->post('actividad'),
                    'realizada' => 1 //indicando que no esta realizada 
                );

                //$idSub = 3;
                $idSub = $this->sub_actividad_model->add($data_to_store);
                if($idSub !== 0){
                    $this->session->set_flashdata('flash_message', 'add'); 
                }else{
                    $this->session->set_flashdata('flash_message', 'Noadd');
                }
                redirect('index.php/adminapp/admin_sub_actividad/add/?ael='.base64_encode($idSub));
            }else{
                $var = $this->input->post('grupo');
                if($var === ''){
                    $data['grupoV'] = 0;
                    $data['actividadV'] = 0;
                }else{
                    $data['grupoV'] = $var;
                    $data['actividadV'] = $this->input->post('actividad');
                }
            }
        }
         $idActividad = $this->menu(FALSE);

        if($idActividad > 0 ){
            $userLogin = $this->session->userdata('user_name');
            $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);
            $data['actividad'] = $this->actividad_model->getxID($idActividad);
            $data['product'] = $this->sub_actividad_model->get_by_id_sub($idActividad);
            $data['url'] = "index.php/adminapp/admin_sub_actividad/add/?ael=".base64_encode($idActividad);
            $data['grupoV'] = 0;
            $data['actividadV'] = 0;
        }else{
            if($var === null){
                $data['grupoV'] = 0;
                $data['actividadV'] = 0;
            }else{
                $data['actividad'] = $this->actividad_model->get_byId_grupo($var); 
            }
            $userLogin = $this->session->userdata('user_name');
            $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);
            $data['url'] = "index.php/adminapp/admin_sub_actividad/add";
            $data['product'] = NULL;
        }
        
        $data['manufactures'] = null; 
        $data['main_content'] = 'admin/sub_actividad/add';
        $this->load->view('includes/template', $data);

    }

    public function update()
    {
        $var = null;
        $realizada = null;
        
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('actividad', 'Actividad', 'required');
            $this->form_validation->set_rules('descripcion', 'Nombre', 'required');
            $this->form_validation->set_rules('fecha_inicio', 'Fecha Inicio', 'required');
            $this->form_validation->set_rules('fecha_fin','fecha fin','callback_FechaActividad');

            if($this->input->post('observacion') !== NULL){
                $this->form_validation->set_rules('observacion','observacion','required');
            }

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">
                <a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                if($this->input->post('realizada')){
                    $realizada = 1;
                }else{
                    $realizada = 0;
                }

                $data_to_store = array(
                    'descripcion' => $this->input->post('descripcion'),
                    'fecha_inicio' => $this->input->post('fecha_inicio'),
                    'fecha_fin' => $this->input->post('fecha_fin'),
                    'observacion' => $this->input->post('observacion'),
                    'actividad_id' => $this->input->post('actividad'),
                    'realizada' => $realizada
                );

                $idSub = $this->session->flashdata('idSub');
                $this->session->set_flashdata('idSub',$idSub);
                if($this->sub_actividad_model->update($idSub, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }

                redirect('index.php/adminapp/admin_sub_actividad/update/?ael='.$_GET['ael']);
            }else{
                $var = $this->input->post('actividad');
                if($this->input->post('realizada')){
                    $realizada = 1;
                }else{
                    $realizada = 0;
                }

                $idSub = $this->session->flashdata('idSub');
                $this->session->set_flashdata('idSub',$idSub);
            }
        }
            $id = $this->menu(FALSE);
            
            if($id !== NULL){
                
                $idSub = $this->session->flashdata('idSub');
                if($idSub !== NULL){
                    $this->session->set_flashdata('idSub', $idSub);
                }
                $this->session->set_flashdata('idSub', $id);
                
                $data['product'] = $this->sub_actividad_model->get_by_id_sub($id);
                $data['actividad'] = NULL;
                $data['realizada'] = NULL;
            }else{
                $data['product'] = NULL;
                $data['realizada'] = $realizada;
                $data['actividad'] = $this->actividad_model->getxID($var);
            }

            $data['url'] =$_GET['ael']; 
            $data['main_content'] = 'admin/sub_actividad/edit';
            $this->load->view('includes/template', $data); 
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->products_model->delete_product($id);
        redirect('admin/products');
    }

    public function menu($bandera){
        if($bandera){
            $this->id_subActividad = $_GET['ael'];
            return base64_encode($this->id_subActividad);
        }else{
            if($this->input->server('REQUEST_METHOD') === 'GET' && isset($_GET['ael'])){
                $this->id_subActividad = $_GET['ael'];
                return base64_decode($this->id_subActividad);
            }
        }
    }

    public function FechaActividad(){

        $idActividad = $this->input->post('actividad');
        $fechaIS = $this->input->post('fecha_inicio');
        $fechaFS = $this->input->post('fecha_fin');

        if(strtotime($fechaFS) < strtotime($fechaIS)){
            $this->form_validation->set_message('FechaActividad','Fecha fin debe ser mayor a la inicial.');
            return FALSE;
        }else{
            $data['actividad'] = $this->actividad_model->getxID($idActividad);

            $fechaIA = $data['actividad'][0]['fecha_inicio'];
            $fechaFA = $data['actividad'][0]['fecha_fin'];

            $dateI = new DateTime($fechaIA);
            $dateF = new DateTime($fechaFA);
        
            if(strtotime($fechaIS) > strtotime($fechaFA) || strtotime($fechaFS) < strtotime($fechaIA)){
                $this->form_validation->set_message('FechaActividad','las fechas deben estar en el rango de la actividad. Inicio: '
                                                .$dateI->format('d/m/Y').' Fin: '.$dateF->format('d/m/Y'));
                return FALSE;
            }else if(strtotime($fechaIS) < strtotime($fechaIA) || strtotime($fechaFS) > strtotime($fechaFA)){
                $this->form_validation->set_message('FechaActividad','las fechas deben estar en el rango de la actividad. Inicio: '
                                                .$dateI->format('d/m/Y').' - Fin: '.$dateF->format('d/m/Y'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function buscarActividad($grupo = ''){
        $data['actividad'] = $this->actividad_model->get_byId_grupo($grupo);
        return $data['actividad'];
    }

    public function addActividad(){
        $html = null;
        
        if(isset($_POST['grupo'])){

            if($_POST['grupo'] === 0){
                echo 'entro';
                $html = "<option value=''>Seleccione </option>";
            }else{
                $actividad = $this->buscarActividad($_POST['grupo']);
                $html = "<option value=''>Seleccione </option>";
                foreach ($actividad as $key => $value) {
                    $html .= "<option value='".$value['IdActividad']."'>".$value['Actividad']."</option>";
                }
            }

            $respuesta = array("html" => $html);
            echo json_encode($respuesta);
        }
    }
}
?>