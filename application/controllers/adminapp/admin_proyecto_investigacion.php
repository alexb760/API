<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Proyecto_investigacion extends CI_Controller
{
    var $permiso;
    var $per_controlador;
    var $id_menu;


  function __construct()
    {
		parent::__construct();
		$this->load->model('dai/proyecto_investigacion_model');
        $this->load->model('dai/linea_investigacion_model');
        $this->load->model('dai/grupo_model');

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
        if ( $this->per_controlador === null && $this->per_controlador['controlador'] != 
            $this->router->fetch_class()) {

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

        $config['per_page'] = 2;
        $config['base_url'] = base_url().'index.php/adminapp/admin_proyecto_investigacion/index/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class= "pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config["uri_segment"] = 4;
    

    //limit end
        $page = $this->uri->segment(4);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
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
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

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

            $data['count']= $this->proyecto_investigacion_model->count($search_string, $order);
            $config['total_rows'] = $data['count'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                $data['products'] = $this->proyecto_investigacion_model->get_proyecto($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                $data['products'] = $this->proyecto_investigacion_model->get_proyecto($search_string, '', $order_type, $config['per_page'],$limit_end);           
                // $data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }else{
                if($order){
                  $data['products'] = $this->proyecto_investigacion_model->get_proyecto('', $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                 $data['products'] = $this->proyecto_investigacion_model->get_proyecto('', '', $order_type, $config['per_page'],$limit_end);        
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
            $data['products'] = $this->proyecto_investigacion_model->get_proyecto('', '', $order_type, $config['per_page'],$limit_end);
            $data['count']= count($data['products']);
            $config['total_rows'] = $data['count'];

        }

        $this->pagination->initialize($config);   

        //load the view
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id')); 
        $data['main_content'] = 'admin/proyecto_investigacion/list';
        $this->load->view('includes/template', $data); 
    }
}

 public function add()
    {
        try{
        $tmp['1'] = 'funcion';
        if ($this->menus->permiso_funcion($this->instancia($tmp))) {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('nombre_pro', 'nombre', 'required|min_length[5]|is_unique[proyecto_investigacion.nombre_pro]');
            $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
            $this->form_validation->set_rules('sigla','sigla','required|min_length[2]|is_unique[proyecto_investigacion.sigla]');
            $this->form_validation->set_rules('objetivo','objetivo','required|min_length[5]');
            $this->form_validation->set_rules('grupo','grupo','required');
            //$this->form_validation->set_rules('upload_file','upload_file','required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close danger" data-dismiss="alert">&times</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $params['dir_user'] = $this->input->post('sigla');
                $params['file']     = 'upload_file';#nombre del campo type=file.

                $data['flash_message'] = $this->menus->upload_file($params);
                if($data['flash_message']['status']){

                    $data_to_store = array(
                        'nombre_pro'    => $this->input->post('nombre_pro'),
                        'descripcion'   => $this->input->post('descripcion'),
                        'sigla'         => $this->input->post('sigla'),
                        'objetivo'      => $this->input->post('objetivo'),
                        'fecha_creacion'=> date('Y-m-d H:m:s'),
                        'grupo_id'      => $this->input->post('grupo'),
                        'path_documento'=> $data['flash_message']['info']['file_name']
                        );
                        $file ='Documento: '.$data['flash_message']['info']['file_name'].'<br>';
                        $file .='Tipo: '.$data['flash_message']['info']['file_type'].'<br>';
                        $file .='Peso: '.$data['flash_message']['info']['file_size'].'<br>';
                    $data['flash_message']['info'] = $file; 
                    //if the insert has returned true then we show the flash message
                    if($this->proyecto_investigacion_model->add($data_to_store)){
                        $data['flash_message']['status'] = TRUE;
                        $data['flash_message']['info'] .= 'Proyecto guardado con Éxito'.'<br>'; 
                    }else{
                        $data['flash_message']['status'] = FALSE; 
                    }
                }
            }
        }
		$grupo_id = 0;
        if ( isset($_GET['id_grupo']) && $this->input->server('REQUEST_METHOD') === 'GET') {
                $grupo_id = $_GET['id_grupo'];     
        }
        //fetch manufactures data to populate the select field
        //$data['manufactures'] = null; //$this->linea_investigacion_model->get_manufacturers();
         if($grupo_id == 0)
            $data['grupos'] = $this->grupo_model->get_all_();
        else
            $data['grupos'] = $this->grupo_model->get_by_id($grupo_id);
        //load the view
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id')); 
        $data['main_content'] = 'admin/proyecto_investigacion/add';
        $this->load->view('includes/template', $data); 
        }else{
            $p_error['header'] = 'Acceso No autorizado';
            $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
            $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->menus->errors($p_error);   
        }

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }  
    }

    public function update()
    {
        try{
        //product id 
        $id = $this->uri->segment(4);

        
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('nombre_pro', 'nombre', 'required|min_length[5]');
            $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
            $this->form_validation->set_rules('sigla','sigla','required|min_length[2]');
            $this->form_validation->set_rules('objetivo','objetivo','required|min_length[5]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close danger" data-dismiss="alert">&times</a><strong>', '</strong></div>');
            //if the form has passed through the validation

            if ($this->form_validation->run())
            {  
                $params['dir_user'] = $this->input->post('sigla');
                $params['file']     = 'upload_file';#nombre del campo type=file.

                $data['flash_message'] = $this->menus->upload_file($params);

                $data_to_store = array(
                'nombre_pro'    => $this->input->post('nombre_pro'),
                'descripcion'   => $this->input->post('descripcion'),
                'sigla'         => $this->input->post('sigla'),
                'objetivo'      => $this->input->post('objetivo'),
                'path_documento'=> (is_array($data['flash_message']['info'])? $data['flash_message']['info']['file_name']:null)
                );
                if($data['flash_message']['status']){

                    $file ='Documento: '.$data['flash_message']['info']['file_name'].'<br>';
                    $file .='Tipo: '.$data['flash_message']['info']['file_type'].'<br>';
                    $file .='Peso: '.$data['flash_message']['info']['file_size'].'<br>';
                    $data['flash_message']['info'] = $file; 

            }
         //if the insert has returned true then we show the flash message
        if($this->proyecto_investigacion_model->update_proyecto($id, $data_to_store)){
            $data['flash_message']['status'] = TRUE;
            $data['flash_message']['message'] .= ' Proyecto Actualizado con Éxito'.'<br>';
             $this->session->set_flashdata('flash_message', $data['flash_message']); 
        }else{
            $data['flash_message']['status'] = FALSE;
            $this->session->set_flashdata('flash_message', $data['flash_message']);  
        }
        redirect('index.php/adminapp/admin_proyecto_investigacion/update/'.$id.'');

    }//validation run

    }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['product'] = $this->proyecto_investigacion_model->get_by_id($id);
        //load the view
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
        $data['main_content'] = 'admin/proyecto_investigacion/edit';
        $this->load->view('includes/template', $data); 
        }catch(Exception $e){
          show_error($e->getMessage().' --- '.$e->getTraceAsString());
        } 

    }//update

    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->products_model->delete_product($id);
        redirect('admin/products');
    }//edit


}
?>