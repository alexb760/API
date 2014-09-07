<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Integrante extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('dai/integrante_model');
        $this->load->model('dai/grupo_model');

		if (!$this->session->userdata('is_logged_in')) {
			redirect('index.php/main/index');
		}
	}

  /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
        //all the posts sent by the view
        $manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 7;
        $config['base_url'] = base_url().'index.php/adminapp/admin_integrante/index/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class = "pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

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
            $data['manufactures'] = $this->manufacturers_model->get_manufacturers();

            $data['count_products']= $this->products_model->count_products($manufacture_id, $search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['products'] = $this->products_model->get_products($manufacture_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['products'] = $this->products_model->get_products($manufacture_id, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['products'] = $this->products_model->get_products($manufacture_id, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['products'] = $this->products_model->get_products($manufacture_id, '', '', $order_type, $config['per_page'],$limit_end);        
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
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
            $data['count_products']= $this->integrante_model->count_();
            $data['products'] = $this->integrante_model->get('', '', '', '', $config['per_page'], $limit_end);        
            //$data['products'] = $this->grupo_model->get_todo();
            $config['total_rows'] = $data['count_products'];

        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   
       
        //load the view
        $data['main_content'] = 'admin/integrante/list';
        $this->load->view('includes/template', $data);  
    }//index

     public function add()
    {
        $grupo =0;

        if ( $this->input->server('REQUEST_METHOD') === 'GET') {
            if (isset($_GET['id_grupo'])) {
                $grupo_id = $_GET['id_grupo'];
            }
            else
                $grupo_id = 0;
        }
        $grupo = $grupo_id;

        if($grupo == 0){
            $data['grupos'] = $this->grupo_model->get_all_();
        }else{
            $data['grupos'] = $this->grupo_model->get_by_id($grupo_id);
        }
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('usuario_id', 'usuario', 'required');
            $this->form_validation->set_rules('grupo_id', 'grupo', 'required');
            $this->form_validation->set_rules('activo', 'activo', 'required');
            $this->form_validation->set_rules('facultad_id', 'facultad_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'usuario_id' => ucwords($this->input->post('usuario_id')),
                    'grupo_id' => ucwords($this->input->post('grupo_id')),
                    'activo' => ucwords($this->input->post('activo')),
                    'facultad_id'=> ucwords($this->input->post('facultad_id'))
                );
                //if the insert has returned true then we show the flash message
                
                if($this->integrante_model->add($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }
            }

        }

        if ( $this->input->server('REQUEST_METHOD') === 'GET') {
            if (isset($_GET['id_grupo'])) {
                $grupo_id = $_GET['id_grupo'];
            }
            else
                $grupo_id = 0;
        }
        $grupo = $grupo_id;

        if($grupo == 0){
            $data['grupos'] = $this->grupo_model->get_all_();
        }else{
            $data['grupos'] = $this->grupo_model->get_by_id($grupo_id);
        }
        //fetch manufactures data to populate the select field
        $data['manufactures'] = null; //$this->linea_investigacion_model->get_manufacturers();
        //load the view 
        $data['main_content'] = 'admin/integrante/add';
        $this->load->view('includes/template', $data);  
    }


}

?>