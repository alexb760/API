<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Main extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('dai/usuario_model');
	}


	public function index()
	{
		/*
		$dato['cadena'] = 'Mensaje desde el controlador: ';
		$this->load->view('layout/headers');
		$this->load->view('layout/wraper');
		//$this->load->view('welcome_message', $dato);
		*/

		if(!$this->session->userdata('is_logged_in')){
		
			//redirect('index.php/main/validate_credentials');
			$this->load->view('admin/login');
        }else{
        	redirect('index.php/main/principal');
        }
	}


    /**
    * encript the password 
    * @return mixed
    */	
    function __encrip_password($password) {
        return md5($password);
    }
	


    /**
    * check the username and the password with the database
    * @return void
    */
	function validate_credentials()
	{	

		$user_name = $this->input->post('user_name');
		$password = $this->__encrip_password($this->input->post('password'));

		$is_valid = $this->usuario_model->validate($user_name, $password);
		
		if($is_valid['existe'])
		{
			if ( $is_valid['super_usuario'] == 0) {
				$rol = $this->usuario_model->get_rol_by_id($is_valid['rol_id']);
			}else{
				$rol = "SUPER_USUARIO";
			}
			
			$data = array(
				'id_user' => $is_valid['id'],
				'user' => ucwords($is_valid['nombre'].' '.$is_valid['apellido']),
				'user_correo' => $is_valid['correo'],
				'user_rol_id' => is_numeric($is_valid['rol_id'])? $is_valid['rol_id'] : null,
				'user_rol' => is_array($rol) ? $rol[0]['nombre'] : $rol,
				'is_logged_in' => true
			);
			#Validar que tipo de usuario es para cargar los permisos necesarios sobre el menú.
			if(!$data['user_rol_id'] == 0){
				$datos['menu'] =  $this->menus->menu_usuario($data['user_rol_id']);
			}
			
			$this->session->set_userdata($data);
			
			$datos['main_content'] = 'admin/main';
			$datos['session'] = $data;
			//redirect('index.php/adminapp/admin_linea_investigacion');
			$this->load->view('includes/template', $datos); 
		}
		else // incorrect username or password
		{
			$data['message_error'] = TRUE;
			$this->load->view('admin/login', $data);	
		}
	}	

    /**
    * The method just loads the signup view
    * @return void
    */
	function signup()
	{
		$this->load->view('admin/signup_form');	
	}

	function logout(){
		$this->session->sess_destroy();
			$this->load->view('admin/login');
		
	}

	function principal(){
		$datos['menu'] =  $this->menus->menu_usuario($this->session->userdata('user_rol_id'));
		$datos['main_content'] = 'admin/main';
			//redirect('index.php/adminapp/admin_linea_investigacion');
		$this->load->view('includes/template', $datos); 
	}
	
}