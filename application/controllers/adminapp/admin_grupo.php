<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Admin_grupo extends CI_Controller
{
    var $per_controlador;
    var $id_menu;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('dai/grupo_model');
        $this->load->model('dai/facultad_model');
        $this->load->model('dai/integrante_model');

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
		//Recibe parametro para envar parametro de la funcion que el usuario requiere.
        if (!is_null($key)) {
            $instancia[$key['1']] =  $this->router->fetch_method();
        }
        return  $instancia ;
    }

  /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index(){
        $this->per_controlador = $this->menus->get_permisos_controlador($this->instancia(null));
        $data;
        $data['permiso'] =  $this->menus->permisos_funciones($this->per_controlador['permiso']);

        if ( $this->per_controlador === null && $this->per_controlador['controlador'] != 
            $this->router->fetch_class()) {

            $p_error['header'] = 'Acceso No autorizado';
            $p_error['message'] = 'Permisos insuficientes para. '.$this->router->fetch_class();
            $p_error['menu'] = $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
            $this->menus->errors($p_error);

        }else{  

        //all the posts sent by the view
        $manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 1;
        $config['base_url'] = base_url().'index.php/adminapp/admin_grupo/index/';
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
        if($manufacture_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
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

            $data['count_grupos']= $this->grupo_model->count();
            $config['total_rows'] = $data['count_grupos'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['products'] = $this->products_model->get_products($manufacture_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['products'] = $this->products_model->get_products($manufacture_id, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if(false/*$order*/){
                    $data['products'] = $this->products_model->get_products($manufacture_id, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    //fetch sql data into arrays
                    $data['products'] = $this->grupo_model->get_grupo('', '', '', '', $config['per_page'], $limit_end);
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;

            //pre selected options
            $data['search_string_selected'] = '';
            $data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
            $data['count_grupos']= $this->grupo_model->count();
            $data['products'] = $this->grupo_model->get_grupo('', '', '', '', $config['per_page'], $limit_end);        
            //$data['products'] = $this->grupo_model->get_todo();
            $config['total_rows'] = $data['count_grupos'];

        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config); 
        $data['menu']= $this->menus->menu_usuario($this->session->userdata('user_rol_id'));    
        //$data['menu'] = $this->menu(TRUE);
        $data['submenu'] = $this->menus->render_submenu();
        $data['id_menu'] =  $this->id_menu;
        //load the view
        $data['main_content'] = 'admin/grupo/list';
        $this->load->view('includes/template', $data); 
    }
}//index

     public function add()
    {
        try{
            $data['id_grupo'] = 0;
            //if save button was clicked, get the data sent via post
            if ($this->input->server('REQUEST_METHOD') === 'POST')
            {

                //form validation
                $this->form_validation->set_rules('nombre_grupo', 'nombre_grupo', 'required|min_length[3]|is_unique[grupo.nombre_grupo]');
                $this->form_validation->set_rules('sigla', 'sigla', 'required|min_length[2]|is_unique[grupo.sigla]');
                $this->form_validation->set_rules('correo', 'correo', 'required|min_length[2]|is_unique[grupo.correo]');
                $this->form_validation->set_rules('facultad', 'facultad', 'required');

                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></p>');

                //if the form has passed through the validation
                if ($this->form_validation->run())
                {
                    $data_to_store = array(
                        'nombre_grupo'        => ucwords($this->input->post('nombre_grupo')),
                        'sigla'               => strtoupper(trim($this->input->post('sigla'))),
                        'pagina_web'          =>  $this->input->post('pagina_web'),
                        'correo'              =>  $this->input->post('correo'),
                        'fecha_creacion'      =>  date('Y-m-d H:m:s'),
                        'path_colciencias'    =>  $this->input->post('path_colciencias'),
                        'estado_id'           =>  1
                    );
                    //arreglo para almacenar el  director del grupo
                    $id_grupo = $this->grupo_model->add($data_to_store);
                    if ( $id_grupo != null) {
                        $data_acesor_grupo  = array(
                            'usuario_id' => (int) $this->session->userdata('user_rol_id'),
                            'grupo_id'   => $id_grupo,
                            'activo'     => 1,
                            'is_asesor'  => 1,
                            'facultad_id'=> (int) $this->input->post('facultad'), );
                    //if the insert has returned true then we show the flash message
                    if($this->integrante_model->add($data_acesor_grupo)){

                            $param['from'] =  'alexb760@gmail.com';
                            $param['to'] =   array($data_to_store['correo']);
                            $param['message'] = $data_to_store['nombre_grupo'].' Ha sido registrado con éxito';
                            $data['flash_message'] = $this->menus->send_mail($param);
                        }
                        else{
                            $data['flash_message'] = FALSE; 
                            $this->$this->grupo_model->delete($id_grupo); 
                        }
                     }  
                }

            }
            //fetch manufactures data to populate the select field
            $data['manufactures'] = null; //$this->linea_investigacion_model->get_manufacturers();
            //Obtiene todas las facultades para pintarlas en el combo box
            $data['facultad'] = $this->facultad_model->get_all();
            //load the view 
            $data['main_content'] = 'admin/grupo/add';
            $this->load->view('includes/template', $data);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        } 
    }


}

?>