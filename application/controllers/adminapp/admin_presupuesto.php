<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Presupuesto extends CI_Controller
{

    var $permiso;
    var $per_controlador;
    var $id_menu;

    function __construct()
    {
		parent::__construct();
        $this->load->model('dai/presupuesto_model');
        $this->load->model('dai/grupo_model');
        $this->load->model('dai/actividad_model');
		
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
        $config['base_url'] = base_url().'index.php/adminapp/admin_presupuesto/index/';
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

            $this->session->set_userdata($filter_session_data);

            $data['manufactures'] = null;

            $data['count_products']= $this->presupuesto_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            if($search_string){
                if($order){
                $data['products'] = $this->presupuesto_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                $data['products'] = $this->presupuesto_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                  $data['products'] = $this->presupuesto_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                 $data['products'] = $this->presupuesto_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            $data['search_string_selected'] = '';
            $data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            $data['count_products']= $this->presupuesto_model->count_();
            $data['products'] = $this->presupuesto_model->get_all('', '', $order_type, $config['per_page'],$limit_end);

            $config['total_rows'] = $data['count_products'];
        }

        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));

        $this->pagination->initialize($config);
            $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $data['submenu'] = $this->menus->render_submenu();
            $data['id_menu'] =  $this->id_menu;    

        $data['main_content'] = 'admin/presupuesto/list';
        $this->load->view('includes/template', $data); 
        }
    }

    public function add()
    {
     $sw = false;
        try{
            $var = null;
            $tmp['1'] = 'funcion';
            if ($this->menus->permiso_funcion($this->instancia($tmp))){
                $idGrupo = null;
                $actividad = null;

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('grupo','grupo','required');
            $this->form_validation->set_rules('valor','valor','required');

            $actividad = $this->input->post('actividad');
            $idGrupo = $this->input->post('grupo');

            if($idActividad !== ""){
                $this->form_validation->set_rules('actividad','actividad','required');
                $this->form_validation->set_rules('valorActividad','valor actividad','required');
                $sw = true;
            }

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');
                if ($this->form_validation->run())
                {

                    $data_to_store = array(
                        'fechasistema' => date('y-mm-dd'),
                        'valor' => $this->input->post('valor'),
                        'autoriza' => $this->session->userdata('id_user'),
                        'grupo_id' => $idGrupo,
                    );

                    $idPresupuesto = $this->presupuesto_model->add($data_to_store);
                    if($idPresupuesto > 0){
                        if($sw){
                            $data_to_store = array(
                                'presupuesto_id' => $idPresupuesto,
                                'actividad_id' => $this->input->post('actividad'),
                                'valor_gasto' => $this->input->post('valorActividad')
                            );

                            if($this->presupuesto_model->addPresupuestoA($data_to_store)){
                                $data['idPresupuesto'] = $idPresupuesto;
                                $this->session->set_flashdata('flash_add', 'add');
                            }else{
                                $this->session->set_flashdata('flash_message', 'not_addA');
                            }
                        }else{
                            $this->session->set_flashdata('flash_message', 'add');
                            $this->session->set_flashdata('flash_add', 'add');
                        }
                    }else{
                        $this->session->set_flashdata('flash_message', 'not_add'); 
                    }
                    redirect('index.php/adminapp/admin_presupuesto/add');
                }else{
                    $var = $idGrupo;
                    $data['actividadV'] = $actividad;
                    $data['grupoV'] = $idGrupo;
                }
        }
        $data['idPresupuesto'] = 0;
        $userLogin = $this->session->userdata('user_name');
        $data['grupo'] = $this->grupo_model->getxUsuario($userLogin);

        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
                    $data['op_submenu'] = $this->menus->render_submenu();
                    $data['id_menu'] = $this->id_menu;
                    $data['options_rol'] = $this->usuario_model->get_rol_option(
                                                                $this->session->userdata('user_rol_id'),
                                                                $this->session->userdata('user_rol'));
                    $data['controlador'] = $this->router->fetch_method();

        $data['manufactures'] = null; 
        $data['main_content'] = 'admin/presupuesto/add';
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
        $id = $this->uri->segment(4);
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    
                );


                if($this->actividad_realizada_model->update($id, $data_to_store) == TRUE){
                    
                   $this->session->set_flashdata('flash_message', 'updated'); 
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                
                redirect('index.php/adminapp/admin_presupuesto/update/'.$id.'');
            }
        }
        
            //$data['product'] = $this->actividad_realizada_model->get_ByID_Edit($id); 
            
            $data['main_content'] = 'admin/presupuesto/edit';
            $this->load->view('includes/template', $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->products_model->delete_product($id);
        redirect('admin/products');
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