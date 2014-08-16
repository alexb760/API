<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Admin_linea_investigacion extends CI_Controller
{
    private $id_menu;
    var $per_controlador;

    function __construct()
    {
		parent::__construct();
		$this->load->model('dai/linea_investigacion_model');
        $this->load->model('dai/usuario_model');

		if (!$this->session->userdata('is_logged_in')) {
			redirect('index.php/main/index');
		}else{
                $instancia['user_rol']      = $this->session->userdata('user_rol') ;
                $instancia['user_rol_id']   = $this->session->userdata('user_rol_id');
                $instancia['id_user']       = $this->session->userdata('id_user');    
                $instancia['controlador']   = $this->router->fetch_class();
        }
        $this->per_controlador = $this->menus->get_permisos_controlador($instancia);
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
  /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
        $data;
        if ( $this->per_controlador === null && $this->per_controlador['controlador'] != $this->router->fetch_class()) {
            $p_error['header'] = 'Acceso No autorizado';
            $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
            $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->menus->errors($p_error);
        }else{  
        $data['permiso'] = $this->menus->permisos_funciones($this->per_controlador['permiso']);

        //all the posts sent by the view
        $manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 7;
        $config['base_url'] = base_url().'index.php/adminapp/admin_linea_investigacion/index/';
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

        //if order type was changed
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


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
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

            $data['count_products']= $this->linea_investigacion_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['products'] = $this->linea_investigacion_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['products'] = $this->linea_investigacion_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['products'] = $this->linea_investigacion_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['products'] = $this->linea_investigacion_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
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
            $data['count_products']= $this->linea_investigacion_model->count();
            $data['products'] = $this->linea_investigacion_model->get_all('', '', '', $order_type, $config['per_page'],$limit_end);        
            //$data['products'] = $this->linea_investigacion_model->get_all_();        

            $config['total_rows'] = $data['count_products'];

        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config); 
        #Obtiene memus para cada funcion   
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
        $data['submenu'] = $this->menus->render_submenu(); 
        $data['id_menu'] = $this->id_menu;
        
        //load the view
        $data['main_content'] = 'admin/linea_investigacion/list';
        $this->load->view('includes/template', $data);
    }  

}//index


   public function add() {
         $tmp['1'] = 'funcion';
    if ($this->menus->permiso_funcion($this->instancia($tmp))) {
        //if save button was clicked, get the data sent via post

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('linea', 'linea', 'required');
            $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close danger" data-dismiss="alert">&times</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'linea'         => strtoupper(trim($this->input->post('linea'))),
                    'descripcion'   => trim($this->input->post('descripcion')),
                    'fecha_sistema' => date('Y-m-d H:m:s')
                );
                //if the insert has returned true then we show the flash message
                if($this->linea_investigacion_model->add($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
        //fetch manufactures data to populate the select field
        $data['manufactures'] = null; //$this->linea_investigacion_model->get_manufacturers();
        #Obtiene memus para cada funcion   
       $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
        $data['id_menu'] = $this->id_menu;
        //load the view
        $data['main_content'] = 'admin/linea_investigacion/add';
        $this->load->view('includes/template', $data);
    }else{
            $p_error['header'] = 'Acceso No autorizado';
            $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
            $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->menus->errors($p_error);   
    }   
    }


public function update()
    {
        //product id 
        $id = $this->uri->segment(4);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('linea', 'linea', 'required');
            $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close danger" data-dismiss="alert">&times</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                 $data_to_store = array(
                    'linea'         => strtoupper(trim($this->input->post('linea'))),
                    'descripcion'   => trim($this->input->post('descripcion'))
                    );
                //if the insert has returned true then we show the flash message
                if($this->linea_investigacion_model->update($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', TRUE);
                }else{
                    $this->session->set_flashdata('flash_message', FALSE);
                }
                redirect('index.php/adminapp/admin_linea_investigacion/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['linea'] = $this->linea_investigacion_model->get_by_id($id);
        #Obtiene memus para cada funcion   
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id')); 
        //load the view
        $data['main_content'] = 'admin/linea_investigacion/edit';
        $this->load->view('includes/template', $data);            

    }//update

    /**
    * Delete product by his id
    * @return void
    */
    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->linea_investigacion_model->delete($id);
        redirect('index.php/adminapp/admin_linea_investigacion/');
    }//edit    

}

?>