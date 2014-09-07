<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Actividad_Realizada extends CI_Controller
{

    var $permiso;
    var $per_controlador;
    var $id_menu;

  function __construct()
    {
		parent::__construct();
        $this->load->model('dai/actividad_model');
		$this->load->model('dai/actividad_realizada_model');
        $this->load->model('dai/integrante_model');
        $this->load->model('dai/sub_actividad_model');
        $this->load->model('dai/grupo_model');
        session_start();

		if (!$this->session->userdata('is_logged_in')) {
			redirect('index.php/main/index');
		}
	}

    private function instancia($key){
        $instancia  = array();
        $instancia['user_rol']      = $this->session->userdata('user_rol') ;
        $instancia['user_rol_id']   = $this->session->userdata('user_rol_id');
        $instancia['id_user']       = $this->session->userdata('id_user');    
        $instancia['controlador']   = $this->router->fetch_class();
        if (!is_null($key)) {
            $instancia[$key['1']] =  $this->router->fetch_method();
        }
        return  $instancia ;
    }

    public function index()
    {
        $this->per_controlador = $this->menus->get_permisos_controlador($this->instancia(null));
        $data;

        if ($this->per_controlador === null && $this->per_controlador['controlador'] != $this->router->fetch_class()){

            $p_error['header'] = 'Acceso No autorizado';
            $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
            $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->menus->errors($p_error);

        }else{
            $data['permiso'] =  $this->menus->permisos_funciones($this->per_controlador['permiso']);

    	$manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        $config['per_page'] = 7;
        $config['base_url'] = base_url().'index.php/adminapp/admin_actividad_realizada/index/';
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
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
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

            $data['count_products']= $this->actividad_realizada_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                $data['products'] = $this->actividad_realizada_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                $data['products'] = $this->actividad_realizada_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                // $data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }else{
                if($order){
                  $data['products'] = $this->actividad_realizada_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                 $data['products'] = $this->actividad_realizada_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
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
            $data['count_products']= $this->actividad_realizada_model->count_();
            $data['products'] = $this->actividad_realizada_model->get_all('', '', $order_type, $config['per_page'],$limit_end);

            $config['total_rows'] = $data['count_products'];
        }
        $Actividades = $this->actividad_model->count_();
        $ActividadR = $this->actividad_realizada_model->count_();
        $data['ActividadesR'] = round($ActividadR / $Actividades * 100, 2); 
        $data['realizadas'] = $ActividadR;
        $data['activas'] = $Actividades;
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));

        $this->pagination->initialize($config);
            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $data['submenu'] = $this->menus->render_submenu();
            $data['id_menu'] =  $this->id_menu;    

        $data['main_content'] = 'admin/actividad_realizada/list';
        $this->load->view('includes/template', $data); 
    }
    }

    public function add()
    {
        try{
            $var = null;
            $tmp['1'] = 'funcion';
            if ($this->menus->permiso_funcion($this->instancia($tmp))){
                $idSub = null;
                $actividad = null;

                if ($this->input->server('REQUEST_METHOD') === 'POST')
                {
                    $this->form_validation->set_rules('grupo','grupo','required');
                    $this->form_validation->set_rules('actividad', 'actividad', 'required');
                    $this->form_validation->set_rules('fecha_fin','fecha fin','callback_FechaActividad');

                    if($this->input->post('observacion') !== NULL){
                        $this->form_validation->set_rules('observacion','observacion','required');
                    } 

                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

                    $actividad = $this->input->post('actividad');
                    $idGrupo = $this->input->post('grupo');

                    if ($this->form_validation->run())
                    {
                        $data['responsable'] = $this->integrante_model->get_by_id_actividad($actividad);
                        $IdResponsable = $data['responsable'][0]['Integrante'];

                        $data_to_store = array(
                            'fecha_fin' => $this->input->post('fecha_fin'),
                            'observacion' => $this->input->post('observacion'),
                            'responsable' => $IdResponsable,
                            'ejecutada' => 0,
                            'actividad_id' => $actividad,
                        );

                        $idGrupo = $this->input->post('grupo');
                        $idSub = 0;
                        
                        if($this->sub_actividad_model->subActividadRealizadas($data_to_store['actividad_id'], $idGrupo) == 0){
                            $idSub = $this->actividad_realizada_model->add($data_to_store);
                            if($idSub > 0){
                                $this->actividad_model->updateEstado($actividad);
                                $this->session->set_flashdata('flash_message', 'add');
                            }else{
                                $this->session->set_flashdata('flash_message', 'not_add');
                            } 
                        }else{
                            $this->session->set_flashdata('flash_message', 'not_sub'); 
                        }

                        if($idSub > 0){
                            $this->session->set_flashdata('idActividad',$idSub);
                            redirect('index.php/adminapp/admin_actividad_realizada/add');
                        }else{
                            redirect('index.php/adminapp/admin_actividad_realizada/add');
                        }
                    }else{
                        $var = $idGrupo;
                        $data['actividadV'] = $actividad;
                        $data['grupoV'] = $idGrupo;
                    }
                }
                    $userLogin = $this->session->userdata('user_name');
                    $id = $this->session->flashdata('idActividad');

                    if($id != NULL){
                        $data['product'] = $this->actividad_realizada_model->get_ByID_Edit($id);
                        $data['actividadV'] = NULL;
                        $data['grupoV'] = NULL;
                    }else{
                        $data['product'] = NULL;
                        $data['actividad'] = NULL;

                        if($var !== NULL){
                            $data['actividad'] = $this->actividad_realizada_model->get_ActividadSinRealizar($var);
                        }else{
                            $data['product'] = NULL;
                            $data['actividad'] = NULL;
                            $data['actividadV'] = NULL;
                            $data['grupoV'] = NULL;
                        }   
                    }
                    $data['idactividad'] = $id;
                    $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);

                    $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
                    $data['op_submenu'] = $this->menus->render_submenu();
                    $data['id_menu'] = $this->id_menu;
                    $data['options_rol'] = $this->usuario_model->get_rol_option(
                                                                $this->session->userdata('user_rol_id'),
                                                                $this->session->userdata('user_rol'));
                    $data['controlador'] = $this->router->fetch_method();
         
                    $data['manufactures'] = null; 
                    $data['main_content'] = 'admin/actividad_realizada/add';
                    $this->load->view('includes/template', $data); 
            }else{
                $p_error['header'] = 'Acceso No autorizado';
                $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
                $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
                $this->menus->errors($p_error);   
            } 
        }catch(Exception $e){
            show_error($e->getMessage().'---'.$e->getTraceAsString());
        }
<<<<<<< HEAD
        $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);
         
        $data['manufactures'] = null; 
        $data['main_content'] = 'admin/actividad_realizada/add';
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
        $this->load->view('includes/template', $data);  
=======
>>>>>>> origin/master
    }

    public function update()
    {
        try{
            $id = $this->uri->segment(4);
            $var = null;
            $res = null;

            if ($this->input->server('REQUEST_METHOD') === 'POST')
            {
                $this->form_validation->set_rules('actividad', 'actividad', 'required');
                $this->form_validation->set_rules('fecha_fin','fecha fin','callback_FechaActividad');

                if($this->input->post('observacion') !== NULL){
                    $this->form_validation->set_rules('observacion','observacion','required');
                }

                $this->form_validation->set_rules('responsable', 'responsable', 'required');

                $this->form_validation->set_error_delimiters('<div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">&times;</a>
                    <strong>', '</strong></div>');
            
                if ($this->form_validation->run())
                {
                    $data_to_store = array(
                        'fecha_fin' => $this->input->post('fecha_fin'),
                        'observacion' => $this->input->post('observacion'),
                        'responsable' => $this->input->post('responsable'),
                        'actividad_id' => $this->input->post('actividad'),
                        'ejecutada' => 0
                    );

                    $IdResponsable = $_SESSION['IdResponsable'];
                    //$IdResponsable = $this->session->flashdata('responsable');
                    echo $idIntegrante = $data_to_store['responsable'];

                    if($this->actividad_realizada_model->update($id, $data_to_store) == TRUE){
                        if($this->integrante_model->updateResponsable($IdResponsable, $idIntegrante) == TRUE){
                           $this->session->set_flashdata('flash_message', 'updated'); 
                       }else{
                        $this->session->set_flashdata('flash_message', 'not_updated');
                       }
                       $this->session->set_flashdata('flash_message', 'updated'); 
                    }else{
                        $this->session->set_flashdata('flash_message', 'not_updated');
                    }
                
                    redirect('index.php/adminapp/admin_actividad_realizada/update/'.$id);
                }else{
                    $var = $this->input->post('actividad');
                    $res = $this->input->post('responsable');
                    $data['actividadV'] = $var;
                    $data['responsableV'] = $this->input->post('responsable');
                }
            }
                //$id = $this->menu(FALSE);
            if($var === NULL){
                if($id !== NULL){
                    $data['product'] = $this->actividad_realizada_model->get_ByID_Edit($id); 
                    $data['integrantes'] = $this->integrante_model->get_by_id_grupo($data['product'][0]['idGrupo']);
                    $data['actividades'] = $this->actividad_realizada_model->get_ActividadSinRealizar($data['product'][0]['idGrupo']);
                    $data['url'] = 'index.php/adminapp/admin_actividad_realizada/update/'.$id;

                    $_SESSION['IdResponsable'] = $data['product'][0]['IdResponsable'];
                    $_SESSION['IdGrupo'] = $data['product'][0]['idGrupo'];
                    $data['actividadV'] = NULL;
                    $data['responsableV'] = NULL;
                }
            }else{
                if($var !== NULL){
                    $data['product'] = NULL;
                    $idGrupo = $_SESSION['IdGrupo'];
                    $data['actividades'] = $this->actividad_model->get_byId_grupo($idGrupo);
                    $data['integrantes'] = $this->integrante_model->get_by_id_grupo($idGrupo);
                }else{
                    $data['product'] = NULL;
                    $data['actividadV'] = NULL;
                    $data['responsableV'] = NULL;
                }
                
                $data['url'] = 'index.php/adminapp/admin_actividad_realizada/update/'.$id;
            }
<<<<<<< HEAD
            $data['main_content'] = 'admin/actividad_realizada/edit';
            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->load->view('includes/template', $data);
    }
=======
                $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
                $data['op_submenu'] = $this->menus->render_submenu();
                $data['options_rol'] = $this->usuario_model->get_rol_option(
                                                                $this->session->userdata('user_rol_id'),
                                                                $this->session->userdata('user_rol'));
                $data['main_content'] = 'admin/actividad_realizada/edit';
                $this->load->view('includes/template', $data);

            }catch(Exception $e){
                show_error($e->getMessage().'---'.$e->getTraceAsString());
            }
        }
>>>>>>> origin/master

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->actividad_realizada_model->delete($id);
        
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('index.php/adminapp/admin_actividad_realizada');
    }


    public function menu($bandera){
        if($bandera){
            $this->id_actividad = $_GET['ael'];
            return base64_encode($this->id_actividad);
        }else{
            if($this->input->server('REQUEST_METHOD') === 'GET' && isset($_GET['ael'])){
                $this->id_actividad = $_GET['ael'];
                return base64_decode($this->id_actividad);
            }
        }
    }

    public function FechaActividad(){

        $idActividad = $this->input->post('actividad');
        $fechaFAR = $this->input->post('fecha_fin');

        if($fechaFAR === NULL || $fechaFAR === ""){
            $this->form_validation->set_message('FechaActividad','The fecha fin field is required.');
            return FALSE;
        }else{
            $data['actividad'] = $this->actividad_model->getxID($idActividad);

            $fechaFA = $data['actividad'][0]['fecha_fin'];
            $fechaHoy = date("d/m/Y");

            $dateF = new DateTime($fechaFA);
        
            if(strtotime($fechaFAR) < strtotime($fechaFA)){
                $this->form_validation->set_message('FechaActividad','La fecha es menor a la fecha de la actividad. '
                                                .$dateF->format('d/m/Y'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function buscarActividad($grupo = ''){
        $data['actividad'] = $this->actividad_realizada_model->get_ActividadSinRealizar($grupo);
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