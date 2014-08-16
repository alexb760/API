<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Proyecto_investigacion extends CI_Controller
{

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


 public function index()
    {
    	$manufacture_id = $this->input->post('manufacture_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        $config['per_page'] = 7;
        $config['base_url'] = base_url().'index.php/adminapp/admin_proyecto_investigacion/index/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
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
        echo $limit_end;
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

            $data['count_products']= $this->proyecto_investigacion_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                $data['products'] = $this->proyecto_investigacion_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                $data['products'] = $this->proyecto_investigacion_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                // $data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }else{
                if($order){
                  $data['products'] = $this->proyecto_investigacion_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                 $data['products'] = $this->proyecto_investigacion_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
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
            $data['count_products']= $this->proyecto_investigacion_model->count();
            $data['products'] = $this->proyecto_investigacion_model->get_all('', '', $order_type, $config['per_page'],$limit_end);
            //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end);        
            //$data['products'] = $this->proyecto_investigacion_model->get_all_();        

            $config['total_rows'] = $data['count_products'];

        }

        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/proyecto_investigacion/list';
        $this->load->view('includes/template', $data); 
    }

 public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('nombre_pro', 'nombre', 'required');
            $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
            $this->form_validation->set_rules('sigla','sigla','required');
            $this->form_validation->set_rules('objetivo','objetivo','required');
            $this->form_validation->set_rules('fecha_caducado','fecha caducado','required');
            $this->form_validation->set_rules('linea_investigacion','linea investigacion','required');
            $this->form_validation->set_rules('grupo','grupo','required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {

                $data_to_store = array(
                    'nombre_pro' => $this->input->post('nombre_pro'),
                    'descripcion' => $this->input->post('descripcion'),
                    'sigla'=>$this->input->post('sigla'),
                    'objetivo'=>$this->input->post('objetivo'),
                    'fecha_creacion'=> date('Y-m-d H:m:s'),
                    'fecha_caducado'=> $this->input->post('fecha_caducado'),
                    'linea_investigacion_id'=>$this->input->post('linea_investigacion'),
                    'grupo_id'=>$this->input->post('grupo')
                );
                //if the insert has returned true then we show the flash message
                if($this->proyecto_investigacion_model->add($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }
            }
        }
		$grupo_id = 0;
        if ( isset($_GET['id_grupo']) && $this->input->server('REQUEST_METHOD') === 'GET') {
                $grupo_id = $_GET['id_grupo'];     
        }
        //fetch manufactures data to populate the select field
        //$data['manufactures'] = null; //$this->linea_investigacion_model->get_manufacturers();
         $data['lineas'] = $this->linea_investigacion_model->get_all_();
         if($grupo_id == 0)
            $data['grupos'] = $this->grupo_model->get_all_();
        else
            $data['grupos'] = $this->grupo_model->get_by_id($grupo_id);
        //load the view
        $data['main_content'] = 'admin/proyecto_investigacion/add';
        $this->load->view('includes/template', $data);  
    }

    public function update()
    {
        //product id 
        $id = $this->uri->segment(4);

        
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
            $this->form_validation->set_rules('cost_price', 'cost_price', 'required|numeric');
            $this->form_validation->set_rules('sell_price', 'sell_price', 'required|numeric');
            $this->form_validation->set_rules('manufacture_id', 'manufacture_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stock'),
                    'cost_price' => $this->input->post('cost_price'),
                    'sell_price' => $this->input->post('sell_price'),          
                    'manufacture_id' => $this->input->post('manufacture_id')
                );
                //if the insert has returned true then we show the flash message
                if($this->products_model->update_product($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/products/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['product'] = $this->proyecto_investigacion_model->get_by_id($id);

        foreach ($data['product'] as $row) {
            $line = $row['linea'];
            $group = $row['grupo'];
        }
        $data['linea'] = $this->linea_investigacion_model->get_by_id($line);
        $data['lineas'] = $this->linea_investigacion_model->get_all_();
        $data['grupo'] = $this->grupo_model->get_by_id($group);
        $data['grupos'] = $this->grupo_model->get_all_();

        //load the view
        $data['main_content'] = 'admin/proyecto_investigacion/edit';
        $this->load->view('includes/template', $data);            

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