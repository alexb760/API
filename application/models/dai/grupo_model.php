<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Grupo_model extends CI_model
{
	private $tb_name = 'grupo';
	//--------------------------------------------------------------------
	/*
	*Tablas detalles en las cuales se debe realizar algún tipo de relacion
	*/
	//--------------------------------------------------------------------
	private $tb_name_grupo = ''; // relacion con la misma tabla para determinar grupo o semillero.
	private $tb_name_estado_grupo = ''; // Relacion para determinar el estado del grupo.
	
	function __construct()
	{
		parent::__construct();
		 $this->load->database();
	}

	/**
	*add
	* @return bolean
	*/
function add($data){
	if($this->db->insert($this->tb_name,$data))
		return  $this->db->insert_id();
				
}

 /**
	* Get product by his is
	* @param int $product_id 
	* @return array
*/
function get_by_id($id){
		$this->db->select('*');
		$this->db->from('grupo');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}

//Obtiene todo los datos po una condicion custumizada
function get_all_(){
		$campo = array(
		'grupo.id',
		'grupo.nombre_grupo'
		);
		$this->db->select($campo);
		$this->db->from('grupo');
		$this->db->join('estado','estado.id = grupo.estado_id or  grupo.estado_id = null','inner');
		$this->db->join('integrante','integrante.grupo_id = grupo.id','inner');
		$this->db->where('integrante.usuario_id', $this->session->userdata('id_user'));
		$this->db->where('integrante.is_asesor',1);
		$query = $this->db->get();
		return $query->result_array(); 
	}


	function get_all_group($is_grupo,$limit, $offset){
		if ($is_grupo = 0) {
			$campo = array(
				'grupo.id',
				'grupo.nombre AS grupo',
				'grupo.sigla',
				'estado.descripcion',
				'estado_grupo.observacion',
				'estado_grupo.fecha_estado'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('estado_grupo',' grupo.id = estado_grupo.grupo_id','inner');
			$this->db->join('estado',' estado_grupo.id = estado.id','inner');
			$this->db->where('grupo.semillero',$is_grupo);
			$this->db->order_by('grupo.nombre','DESC');
			$this->db->limit($limit, $offset);
			return $this->db->get($this->tb_name)->result();
		}else{
			$campo = array(
				'grupo.id',
				'grupo.nombre AS semeillero',
				'grupo.sigla',
				'Grupo.nombre',
				'estado.descripcion',
				'estado_grupo.observacion',
				'estado_grupo.fecha_estado'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('grupo',' grupo.id = grupo.grupo_id','inner');
			$this->db->join('estado_grupo',' grupo.id = estado_grupo.grupo_id','inner');
			$this->db->join('estado',' estado_grupo.id = estado.id','inner');
			$this->db->where('grupo.semillero',$is_grupo);
			$this->db->order_by('grupo.nombre','DESC');
			$this->db->limit($limit, $offset);
			return $this->db->get($this->tb_name)->result();
		}
	}

 public function get_grupo($estado_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
	{ 
		$campo = array(
				'grupo.id',
				'grupo.nombre_grupo AS Nombre',
				'grupo.sigla As Sigla',
				'grupo.semillero AS Semillero',
				'grupo.grupo_id  AS Grupo_padre',
				'grupo.avalado_col AS Avalado_Colciencia',
				'grupo.clasificacion AS Clasificacion',
				'grupo.pagina_web AS Web',
				'grupo.correo AS Correo',
				'grupo.fecha_creacion AS Fecha_Creado',
				'grupo.path_colciencias AS Colciencas',
				'estado.descripcion AS Estado',
				'estado.observacion AS Observacion'
				);
		$this->db->select($campo);
		$this->db->from($this->tb_name);
		$this->db->join('estado','estado.id = grupo.estado_id or  grupo.estado_id = null','inner');
		$this->db->join('integrante','integrante.grupo_id = grupo.id','inner');
		$this->db->where('integrante.usuario_id', $this->session->userdata('id_user'));
		$this->db->where('integrante.is_asesor',1);
			
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


	/**
	* Count the number of rows
	* @param int $manufacture_id
	* @param int $search_string
	* @param int $order
	* @return int
	*/
	function count($estado_id=null, $search_string=null)
	{
		$this->db->select('*');
		$this->db->from('grupo');
		if($estado_id != null && $estado_id != 0){
			$this->db->where('estado_id', $estado_id);
		}
		if($search_string){
			$this->db->like('nombre', $search_string);
		}
		$query = $this->db->get();
		return $query->num_rows();        
	}

	/**
	* Update product
	* @param array $data - associative array with data to store
	* @return boolean
	*/
	function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('grupo', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	/**
	* Delete product
	* @param int $id - product id
	* @return boolean
	*/
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('grupo'); 
	}

}
?>