<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Actividad extends CI_Controller
{
    private $id_actividad;
    var $permiso;
    var $per_controlador;
    var $id_menu;
    
    function __construct()
    {
		parent::__construct();
		$this->load->model('dai/actividad_model');
        $this->load->model('dai/integrante_model');
        $this->load->model('dai/grupo_model');
        $this->load->model('dai/sub_actividad_model');

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
            $config['base_url'] = base_url().'index.php/adminapp/admin_actividad/index/';
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
            }else{
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

                $data['count_products']= $this->actividad_model->count($search_string, $order);
                $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
                if($search_string){
                    if($order){
                    $data['products'] = $this->actividad_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                    }else{
                    $data['products'] = $this->actividad_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                    }
                }else{
                    if($order){
                        $data['products'] = $this->actividad_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                    }else{
                        $data['products'] = $this->actividad_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
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
                $data['products'] = $this->actividad_model->get_all('', '', $order_type, $config['per_page'],$limit_end);
                //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end);        
                //$data['products'] = $this->proyecto_investigacion_model->get_all_();        

                $config['total_rows'] = $data['count_products'];

            }
                $var = $this->session->flashdata('idActividad');
                if($var !== ""){
                    $data['idActividad'] = $var;
                }else{
                    $data['idActividad'] = 0;
                }
            $this->pagination->initialize($config);
            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $data['submenu'] = $this->menus->render_submenu();
            $data['id_menu'] =  $this->id_menu;   

            $data['main_content'] = 'admin/actividad/list';
            $this->load->view('includes/template', $data); 
        }
    }

    public function add()
    {
        try{
        $tmp['1'] = 'funcion';
        if ($this->menus->permiso_funcion($this->instancia($tmp))) {
            $val = null;
            if ($this->input->server('REQUEST_METHOD') === 'POST')
            {
                $this->form_validation->set_rules('grupo','grupo','required');
                $this->form_validation->set_rules('descripcion', 'nombre', 'trim|required|min_length[3]|max_length[200]|is_unique[actividad.descripcion]');
                $this->form_validation->set_rules('fecha_inicio', 'fecha inicio', 'required');
                $this->form_validation->set_rules('fecha_fin','fecha fin','callback_fechas');
                $this->form_validation->set_rules('duracion', 'duración', 'trim|required|is_natural|integer|max_length[3]');

                if($this->input->post('observacion') !== NULL){
                    $this->form_validation->set_rules('observacion','observacion','required');
                }  

                $this->form_validation->set_rules('responsable', 'Responsable', 'required');
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close danger" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

                if ($this->form_validation->run())
                { 
                    $data_to_store = array(
                        'descripcion'   => trim($this->input->post('descripcion')),
                        'fecha_inicio'  => $this->input->post('fecha_inicio'),
                        'fecha_fin'     => $this->input->post('fecha_fin'),
                        'observacion'   => trim($this->input->post('observacion')),
                        'grupo_id'      => $this->input->post('grupo'),
                        'realizada'     => 1
                    );
                    $IdActividad = $this->actividad_model->add($data_to_store);
                    //$IdActividad = 3;
                    if($IdActividad != NULL){
                        $data_responsable = array(
                            'actividad_id' => $IdActividad,
                            'integrante_id' => $this->input->post('responsable'),
                            'duracion' => $this->input->post('duracion')
                        );

                        if($this->integrante_model->addResponsable($data_responsable)){
                            $this->session->set_flashdata('flash_message', 'add');
                        }else{
                            $this->session->set_flashdata('flash_message', 'not_add');
                        }
                    }

                    $data['idactividad'] = $IdActividad;
                    $this->session->set_flashdata('idActividad',$data['idactividad']);
                    redirect('index.php/adminapp/admin_actividad/add');
                }else{
                    $val = 0;
                    $data['grupoV'] = $this->input->post('grupo');
                    $data['integranteV'] = $this->input->post('responsable');
                    $data['integrantes'] = $this->integrante_model->get_by_id_grupo($data['grupoV']);//id del grupo
                }   
            }
            $id = $this->session->flashdata('idActividad');//$this->menu(FALSE);
            if($id != NULL){
                $data['product'] = $this->actividad_model->get_by_id_edit($id); //id actividad
            }else{
                $data['product'] = NULL;
                $userLogin = $this->session->userdata('user_name');
                $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);

                if($val === null){
                    $data['validator'] = 1;
                }else{
                    $data['validator'] = 0;    
                }
            }

            $data['idactividad'] = $id;
            $data['manufactures'] = null; 
            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $data['op_submenu'] = $this->menus->render_submenu();
            $data['id_menu'] = $this->id_menu;
            $data['options_rol'] = $this->usuario_model->get_rol_option(
                                                                $this->session->userdata('user_rol_id'),
                                                                $this->session->userdata('user_rol'));
            $data['controlador'] = $this->router->fetch_method();
            $data['main_content'] = 'admin/actividad/add';
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
    }

    public function update()
    { 
        try{

        $varG = null;
        $id = $this->uri->segment(4);
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('descripcion', 'nombre', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('fecha_inicio', 'fecha inicio', 'required');
            $this->form_validation->set_rules('fecha_fin','fecha fin','callback_fechas');
            $this->form_validation->set_rules('duracion', 'duración', 'trim|required|is_natural|integer|max_length[3]');  

            if($this->input->post('observacion') !== NULL){
                $this->form_validation->set_rules('observacion','observacion','required');
            }  
            
            $this->form_validation->set_rules('responsable', 'Responsable', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'descripcion' => trim($this->input->post('descripcion')),
                    'fecha_inicio' => $this->input->post('fecha_inicio'),
                    'fecha_fin' => $this->input->post('fecha_fin'),
                    'observacion' => trim($this->input->post('observacion')),
                    'grupo_id' => $this->input->post('grupo'),
                    'realizada' => 1
                );

                $responsable = $this->input->post('responsable');
                $duracion = $this->input->post('duracion');

                $idActividad = $this->session->flashdata('idActividad');
                $idR = $this->session->flashdata('idResponsable');
                if($this->actividad_model->update($idActividad, $data_to_store) == TRUE){ //id de la actividad
                    if($this->integrante_model->updateResponsable($idR, $responsable, $duracion) == TRUE){
                       $this->session->set_flashdata('flash_message', 'updated'); 
                   }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                   }
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                //redirect('index.php/adminapp/admin_actividad/update/?ael='.$_GET['ael']);
                redirect('index.php/adminapp/admin_actividad/update/'.$id);
            }else{
                $varG = $this->input->post('grupo');
                $data['grupoV'] = $varG;
                $data['responsableV'] = $this->input->post('responsable');
            }
        }
            //$id = $this->menu(FALSE);

        if($varG === NULL){
            if($id !== NULL){
                echo $id.'id';
                $this->session->set_flashdata('idActividad', $id);
                $data['product'] = $this->actividad_model->get_by_id_edit($id); //id actividad
                $data['integrantes'] = $this->integrante_model->get_by_id_grupo($data['product'][0]['idG']);//id del grupo
                $data['url'] = $id;//$_GET['ael'];
                $this->session->set_flashdata('idResponsable',$data['product'][0]['IdResponsable']);
            }
        }else{
                $idR = $this->session->flashdata('idResponsable');
                $this->session->set_flashdata('idResponsable',$idR);
                $data['product'] = NULL;
                $data['integrantes'] = $this->integrante_model->get_by_id_grupo($varG);
                $data['url'] = $id;//$_GET['ael'];
                $userLogin = $this->session->userdata('user_name');
                $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);
            }

            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $data['op_submenu'] = $this->menus->render_submenu();
            $data['options_rol'] = $this->usuario_model->get_rol_option(
                                                                $this->session->userdata('user_rol_id'),
                                                                $this->session->userdata('user_rol'));
            $data['main_content'] = 'admin/actividad/edit';
            $this->load->view('includes/template', $data); 

        }catch(Excepcion $e){   
            show_error($e->getMessage().'---'.$e->getTraceAsString());
        }
    }

    public function addSub(){ 
        $Nombre = $_REQUEST["n"]; 
        $fechaI = $_REQUEST["fi"];
        $fechaF = $_REQUEST["ff"];
        $observacion = $_REQUEST["ob"];
        $idActividad = $_REQUEST["idAct"];
        $fechaFA = $_REQUEST["ffa"]; //fecha final de la actividad.
        $fechaIA = $_REQUEST["fia"]; //fecha inicial de la actividad.
        $hint="";
        $sw = TRUE;

        $fechaInicial = strtotime($fechaI);
        $fechaFinal = strtotime($fechaF);
        $fechaFinalA = strtotime($fechaFA);
        $fechaInicialA = strtotime($fechaIA);

        if($Nombre == ""){
            $sw = FALSE;
        }else if($fechaI == "") {
            $sw = FALSE;
        }else if($fechaF == ""){
            $sw = FALSE;
        }
            /*
                0 = div danger.
                1 = div warning.
                2 = div info.
                3 = div success. 
            */

        if($sw == FALSE){
            $hint = "0, Faltan campos por llenar!";
        }else if($fechaInicial > $fechaFinalA || $fechaFinal > $fechaFinalA){
            $hint = "1, La fecha debe estar en el rango de la actividad!";
        }else if($fechaInicial < $fechaInicialA || $fechaFinal < $fechaInicialA){
            $hint = "1, La fecha debe estar en el rango de la actividad!";
        }else if($fechaInicial > $fechaFinal){
            $hint = "1, Fecha invalida!";
        }else{
            $data_to_store = array(
                'descripcion' => trim($Nombre),
                'fecha_inicio' => $fechaI,
                'fecha_fin' => $fechaF,
                'observacion' => trim($observacion),
                'actividad_id' => $idActividad,
                'realizada' => 0
            );

            if($this->sub_actividad_model->add($data_to_store)){
                $hint = "3, Guardado con exito!";
            }else{
                $hint = "0, Error al guardar sub actividad!";
            }
                
        }
        echo $hint ==="" ? "0, Error al configurar sub actividad!":$hint;
    }

    public function deleteActividad(){
        try{
            $id = $_REQUEST["id"];

            $this->sub_actividad_model->deleteXactividad($id);
            $this->integrante_model->deleteXactividad($id);
            $this->actividad_model->delete($id);
        
        }catch(Excepciones $e){
             show_error($e->getMessage().'---'.$e->getTraceAsString());
        }
    }

    public function delete()
    {
        try{
            $idActividad = $this->uri->segment(4);
            $data['subActividad'] = $this->sub_actividad_model->getXactividad($idActividad);

            if($data['subActividad'] <= 0){
                $tmp['1'] = "funcion";
                $id = $this->uri->segment(4);
                $this->integrante_model->deleteXactividad($id);
                $this->actividad_model->delete($id);
            
                $this->session->set_flashdata('flash_message', 'delete');
                redirect('index.php/adminapp/admin_actividad/');
            }else{
                $this->session->set_flashdata('flash_message', 'Nodelete');
                $this->session->set_flashdata('idActividad',$idActividad);
                redirect('index.php/adminapp/admin_actividad/');
            }
        }catch(Excepcion $e){
            show_error($e->getMessage().'---'.$e->getTraceAsString());
        }
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

    public function fechas($valid){
        if($this->input->post('fecha_fin') == null){
            $this->form_validation->set_message('fechas','The fecha fin field is required.');
            return FALSE;
        }
        else if($this->input->post('fecha_fin') < $this->input->post('fecha_inicio')){
            $this->form_validation->set_message('fechas','Fecha fin debe ser mayor a la inicial.');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function buscarResponsable($grupo = ''){
        $data['responsable'] = $this->integrante_model->get_by_id_grupo($grupo);

        return $data['responsable'];
    }

    public function addResponsable(){
        $html = null;
        
        if(isset($_POST['grupo'])){
            if($_POST['grupo'] === 0){
                $html = "<option value=''>Seleccione </option>";
            }else{
                $responsable = $this->buscarResponsable($_POST['grupo']);
                $html = "<option value=''>Seleccione </option>";
                foreach ($responsable as $key => $value) {
                    $html .= "<option value='".$value['IdIntegrante']."'>".$value['Usuario']."</option>";
                }       
            }

            $respuesta = array("html" => $html);
            echo json_encode($respuesta);
        }
    }
}
?>