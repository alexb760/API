<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Usuario extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//cargamos la base de datos por defecto
		$this->load->database('default');
		//cargamos el helper url y el helper form
		$this->load->helper(array('url','form'));
		//cargamos la librería form_validation
		//$this->load->library(array('form_validation'));
		//cargamos el modelo crud_model
		//$this->load->model('dai/usuario_model');
		$this->load->library('grocery_crud');
	}

	public function index(){

		/*$dato = array('titulo' => 'Administración Usuario',
					'registros' => $this->usuario_model->count(),  
					'usuarios' => $this->usuario_model->get_all());
		$this->load->view('layout/headers');
		$this->load->view('usuario_view',$dato);*/

		redirect('usuario/usuarios');
	}

		function usuarios(){
			try{
				$crud = new grocery_CRUD();
				
				$crud->set_theme('flexigrid');

				$crud->set_table('usuario');

				$crud->set_subject('Usuarios');

				$crud->set_language('spanish');


				$crud->columns(
					'cedula',
					'apellido',
					'nombre',
					'direccion',
					'correo',
					'login',
					'clave',
					'super_usuario',
					'rol_usuario_id',
					'is_activo');

				$crud->set_rules('cedula','Cedula','trim|required|min_length[6]|max_length[11]');

				$crud->display_as('rol_usuario_id','Rol')->display_as('is_activo','Estado');

				$crud->add_fields(
					'cedula',
					'apellido',
					'nombre',
					'direccion',
					'correo',
					'login',
					'clave',
					'super_usuario',
					'rol_usuario_id',
					'is_activo');

				$crud->set_rules(
					'correo',
					'E-mail ',
					'required|valid_email|is_unique[usuario.correo]');

				$crud->edit_fields(
					'cedula',
					'apellido',
					'nombre',
					'direccion',
					'correo',
					'login',
					'clave',
					'super_usuario',
					'rol_usuario_id',
					'is_activo');

				$crud->field_type('clave', 'password');

				$crud->required_fields(
					'cedula',
					'apellido',
					'nombre',
					'correo',
					'login',
					'clave',
					'super_usuario',
					'rol_usuario_id',
					'is_activo'
					);

				$crud->set_Relation(
					'rol_usuario_id',
					'rol_usuario',
					'nombre');

	            $crud->callback_before_insert(array($this,'encrypt_password_callback'));
	
				$output= $crud->render();

				//$this->load->view('layout/headers_groceryCrud');
				//$this->load->view('layout/wraper_grocery');
				//$this->load->view('layout/page_wraper',$output);
				$this->load->view('usuario_view',$output);

			}catch(Exception $e){
             /* Si algo sale mal cachamos el error y lo mostramos */
             show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
		}

	function encrypt_password_callback($post_array) {
	  $this->load->library('encrypt');
	  $key = 'hasta-el-infinito';
	  $post_array['clave'] = $this->encrypt->encode($post_array['clave'], $key);
	 
	  return $post_array;
} 	
	
}

?>