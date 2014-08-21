<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Presupuesto extends CI_Controller
{

  function __construct()
    {
		parent::__construct();
        $this->load->model('dai/presupuesto_model');
		
        session_start();

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

            $data['count_products']= $this->presupuesto_model->count($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                $data['products'] = $this->presupuesto_model->get_all($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                $data['products'] = $this->presupuesto_model->get_all($search_string, '', $order_type, $config['per_page'],$limit_end);           
                // $data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }
            }else{
                if($order){
                  $data['products'] = $this->presupuesto_model->get_all('', $order, $order_type, $config['per_page'],$limit_end);        
                 //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end); 
                }else{
                 $data['products'] = $this->presupuesto_model->get_all('', '', $order_type, $config['per_page'],$limit_end);        
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
            $data['count_products']= $this->presupuesto_model->count_();
            $data['products'] = $this->presupuesto_model->get_all('', '', $order_type, $config['per_page'],$limit_end);
            //$data['products'] = $this->proyecto_investigacion_model->get_all_proyectos($config['per_page'],$limit_end);        
            //$data['products'] = $this->proyecto_investigacion_model->get_all_();        

            $config['total_rows'] = $data['count_products'];
        }

        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/presupuesto/list';
        $this->load->view('includes/template', $data); 
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //$this->form_validation->set_rules('fecha_fin', 'Fecha Fin', 'required');


            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
                if ($this->form_validation->run())
                {
                    $data_to_store = array(
                        //'fecha_fin' => $this->input->post('fecha_fin'),
                        
                    );

                    if($this->sub_actividad_model->subActividadRealizadas($data_to_store['actividad_id'], 1) == 0){
                        $this->session->set_flashdata('flash_message', 'add'); 
                    }else{
                        $this->session->set_flashdata('flash_message', 'not_sub'); 
                    }
                    redirect('index.php/adminapp/admin_pesupuesto/add/');
                }
        }
        $data['manufactures'] = null; 
        $data['main_content'] = 'admin/presupuesto/add';
        $this->load->view('includes/template', $data);  
    }

    public function update()
    {
        $id = $this->uri->segment(4);
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           // $this->form_validation->set_rules('fecha_fin', 'Fecha Fin', 'required');
           
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    //'fecha_fin' => $this->input->post('fecha_fin'),
                    
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

}
?>