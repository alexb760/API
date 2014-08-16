<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Usuario_model extends CI_model
{
	private $tbl_name =''; 

	function __construct()
	{
		parent::__construct();
		$this->tbl_name ='usuario';
	}

public function get($estado_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    { 
		$campo = array(
				'usuario.id  ',
				'usuario.cedula',
				'usuario.codigo',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.direccion',
				'usuario.telefono',
				'usuario.correo',
				'usuario.login',
				'usuario.create_at AS "Fecha Creacion"',
				'IF(usuario.is_activo, "SI","NO") AS activo',
				'rol_usuario.nombre AS rol'
				);
		$this->db->select($campo);
		$this->db->from($this->tbl_name);
		$this->db->join('rol_usuario','usuario.rol_usuario_id = rol_usuario.id','inner');
			
		if($search_string != null && $search_string != ''){
			$this->db->like('sigla', $search_string);
		}
		//$this->db->group_by('products.id');
		if ($estado_id != null && $estado_id != '')
			$this->db->where('estado_id', $estado_id);

		if($order != null && $order != ''){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('0', '4');

		$query = $this->db->get();
		
		return $query->result_array();	
    }



function validate($user_name, $password)
	{
		$this->db->where('login', $user_name);
		$this->db->where('clave', $password);
		$query = $this->db->get($this->tbl_name);
		
		if($query->num_rows == 1)
		{
			$user =  array();
			$user['existe'] = true;
			foreach ($query->result_array() as $key ) {
				$user['id'] = $key['id'];
				$user['nombre'] = $key['nombre'];
				$user['apellido'] = $key['apellido'];
				$user['correo'] = $key['correo'];
				$user['super_usuario'] = $key['super_usuario'];
				$user['rol_id'] = $key['rol_usuario_id'];
			}	
			return $user;
		}		
	}

    /**
    * Serialize the session data stored in the database, 
    * store it in a new array and return it to the controller 
    * @return array
    */
	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['user_name'] = $udata['user_name']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}

		return $user;
	}

function add($data){
		return 	$this->db->insert($this->tbl_name,$data) ;				
}
	
function get_by_id($id){
		$this->db->select('*');
		$this->db->from($this->tbl_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}

/**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->tbl_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return $report;
		}
	}

	/**
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_name); 
	}


	public function get_all(){
		return $this->db->get($this->tbl_name); 
	}

	public function count(){
		return $this->db->count_all($this->tbl_name);
	}

	##############################################################
	#			TABLA ROLES DE usuario 					   		 #
	##############################################################
#Obtiene el rol de cada usuario por su id
	public function get_rol_by_id($id){
		$campos = array('*');

		$this->db->select($campos);
		$this->db->from('rol_usuario');
		$this->db->where('id',$id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	/*Obtiene el menú de cada usuario por el rol_id y usuario_id
	* @return array
	*/
	public function get_menu_rol($id_rol){
		$campos = array('menu.id',
						'menu.nombre',
						'menu.directorio', 
						'menu.controlador',
						'menu.funcion',
						'menu.submenu',
						'rol_menu.permiso'
						);

		$this->db->select($campos);
		$this->db->from('rol_usuario');
		$this->db->join('rol_menu','rol_usuario.id = rol_menu.rol_usuario_id', 'inner');
		$this->db->join('menu', 'rol_menu.menu_id = menu.id', 'inner');
		$this->db->where('rol_menu.rol_usuario_id',$id_rol);
		$this->db->where('menu.submenu',null);
		$this->db->order_by('menu.id','asc');
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function get_menu_submenu($menu_id){
		$campos = array('menu.id',
						'menu.nombre',
						'menu.directorio', 
						'menu.controlador',
						'menu.funcion',
						'menu.submenu',
						'rol_menu.permiso'
						);

		$this->db->select($campos);
		$this->db->from('rol_usuario');
		$this->db->join('rol_menu','rol_usuario.id = rol_menu.rol_usuario_id', 'inner');
		$this->db->join('menu', 'rol_menu.menu_id = menu.id', 'inner');
		$this->db->where('menu.submenu',$menu_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
/**
*Recibe rol_id
*Recibe Rol Nombre
*@return array 
*/
public function get_rol_option($rol_id, $rol_nombre){
	$campos =   array('*');
	$this->db->select($campos);
	$this->db->from('rol_usuario');

	if($rol_nombre == 'ROL_DIRECTOR_GRUPO'){

		$this->db->where('nombre' ,  'ROL_JOVEN_INVESTIGADOR');
		$this->db->or_where('nombre' ,  'ROL_TUTOR_SEMILLERO' );

	}elseif ($rol_nombre === 'ROL_DIRECTIVO' || $rol_nombre === 'ROL_COMITE' ) {

		$this->db->where('nombre' ,  'ROL_DIRECTOR_GRUPO');
		$this->db->or_where('nombre' ,  'ROL_ADMINISTRADOR');
		$this->db->or_where('nombre' ,  'ROL_COMITE');
		$this->db->or_where('nombre' ,  'ROL_DIRECTIVO');
		$this->db->or_where('nombre' ,  'ROL_TUTOR_SEMILLERO');

	}elseif ($rol_nombre === 'ROL_JOVEN_INVESTIGADOR' 	|| 
			 $rol_nombre === 'ROL_DOCENTE' 				|| 
			 $rol_nombre === 'ROL_TUTOR_SEMILLERO' ) {

		$condicion  = array('nombre' =>  null);
		$this->db->where($condicion);
	}	
	$this->db->order_by('id','desc');
	$query = $this->db->get()->result_array();
return $query;
}

public function get_permiso_controlado($p_array){
	$campos = array('menu.nombre',
					'menu.controlador ',
					'menu.funcion',
					'rol_menu.permiso'	);

	$this->db->select($campos);
	$this->db->from('rol_usuario');
	$this->db->join('rol_menu','rol_usuario.id = rol_menu.rol_usuario_id', 'inner');
	$this->db->join('menu', 'menu.id = rol_menu.menu_id  ', 'inner');
	$this->db->where('menu.controlador',$p_array['controlador']);
	$this->db->where('rol_usuario.id',$p_array['user_rol_id']);
	(isset($p_array['funcion'])) ? $this->db->where('menu.funcion',$p_array['funcion']) :
									$this->db->where('menu.funcion',null);
	//$this->db->where('menu.submenu',null);
	$this->db->order_by('rol_menu.permiso','desc');
	$query = $this->db->get()->result_array();
	return $query;
}
}

?>