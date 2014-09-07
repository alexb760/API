<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Proyecto_investigacion_model extends CI_Model
{
	private $tb_name ='proyecto_investigacion';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*function get_all(){
		return $this->db->get($this->tb_name)->result();
	}*/

	/*function get_by_id($id = null){
		if(is_null($id))
			return null;
		else{
			 $this->db->where('id',$id);
			 $this->db->select();
			 return $this->db->get($this->tb_name)->result(); 
		}
	}*/

	function count($search_string=null, $order=null){

		$this->db->select('*');
		$this->db->from($this->tb_name);
		if($search_string){
			$this->db->like('nombre_pro', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();  
	}


	function add($data){
		return 	$this->db->insert($this->tb_name,$data) ;
				
	}

 /**
    * Get product by his is
    * @param int $product_id 
    * @return array
*/
	function get_by_id($id){
		$campo = array(
			'proyecto_investigacion.id as id',
			'proyecto_investigacion.nombre_pro AS nombre_pro',
			'proyecto_investigacion.descripcion as descripcion',
			'proyecto_investigacion.sigla as sigla',
			'proyecto_investigacion.objetivo as objetivo'
			);
		$this->db->select($campo);
		$this->db->from($this->tb_name);
		$this->db->where('proyecto_investigacion.id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}


	function get_all_proyectos($limit, $offset){
		
			$campo = array(
				'proyecto_investigacion.id',
				'proyecto_investigacion.nombre_pro AS nombre',
				'proyecto_investigacion.descripcion',
				'proyecto_investigacion.sigla',
				'proyecto_investigacion.objetivo',
				'proyecto_investigacion.fecha_creacion',
				'proyecto_investigacion.fecha_caducado',
				'linea_investigacion.tema'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('linea_investigacion','linea_investigacion_id = linea_investigacion.id','inner');
			$this->db->order_by('proyecto_investigacion.nombre_pro','DESC');
			$this->db->limit($limit, $offset);
			return $this->db->get($this->tb_name)->result();
	}


	function get_proyecto($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		
			$campo = array(
				'proyecto_investigacion.id',
				'proyecto_investigacion.nombre_pro AS Proyecto',
				'proyecto_investigacion.descripcion AS Detalle',
				'proyecto_investigacion.sigla AS Sigla',
				'proyecto_investigacion.objetivo AS Objetivo',
				'proyecto_investigacion.fecha_creacion',
				'proyecto_investigacion.fecha_caducado',
				'CONCAT(proyecto_investigacion.sigla , "/",proyecto_investigacion.path_documento) AS Documento',
				'grupo.nombre_grupo'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('grupo','proyecto_investigacion.grupo_id = grupo.id','inner');
			$this->db->join('integrante','grupo.id = integrante.grupo_id','inner');
			$this->db->where('integrante.usuario_id', $this->session->userdata('id_user'));
			$this->db->where('integrante.is_asesor', 1);

		if($search_string !== null && $search_string !== ''){
			$this->db->like('nombre_pro', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
		    //$this->db->order_by('id', $order_type);
		    $this->db->order_by('proyecto_investigacion.id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('10', '0');

		$query = $this->db->get();
		return $query->result_array();
	}

 public function get_grupos($grupo_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    { 
		$campo = array(
				'proyecto_investigacion.id',
				'proyecto_investigacion.nombre_pro AS nombre',
				'proyecto_investigacion.descripcion',
				'proyecto_investigacion.sigla',
				'proyecto_investigacion.objetivo',
				'proyecto_investigacion.fecha_creacion',
				'proyecto_investigacion.fecha_caduco',
				'linea_investigacion.tema'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
		if($search_string){
			$this->db->like('sigla', $search_string);
		}
		$this->db->join('linea_investigacion',' linea_investigacion_id = linea_investigacion.id','inner');
		//$this->db->group_by('products.id');
		if ($grupo_id != null && $grupo_id != 0)
			$this->db->where('grupo_id', $grupo_id);

		if($search_string){
			$this->db->like('nombre_pro', $search_string);
		}
		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');

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
    function count_proyectos($estado_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from($this->tb_name);
		if($manufacture_id != null && $manufacture_id != 0){
			$this->db->where('estado_id', $estado_id);
		}
		if($search_string){
			$this->db->like('nombre_pro', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_proyecto($id, $data)
    {
		$this->db->where('id', $id);
		return $this->db->update($this->tb_name, $data);
		/*$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report['error'] !== 0){
			return true;
		}*/
	}

    /**
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	function delete_product($id){
		$this->db->where('id', $id);
		$this->db->delete($this->tb_name); 
	}

function show_info_pro( $limit_start, $limit_end){
		
			$campo = array(
				'proyecto_investigacion.id',
				'proyecto_investigacion.nombre_pro AS Proyecto',
				'proyecto_investigacion.descripcion AS Detalle',
				'proyecto_investigacion.sigla AS Sigla',
				'proyecto_investigacion.objetivo AS Objetivo',
				'proyecto_investigacion.fecha_creacion',
				'proyecto_investigacion.fecha_caducado',
				'CONCAT(proyecto_investigacion.sigla , "/",proyecto_investigacion.path_documento) AS Documento',
				'grupo.nombre_grupo'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('grupo','proyecto_investigacion.grupo_id = grupo.id','inner');
			$this->db->join('integrante','grupo.id = integrante.grupo_id','inner');

		$this->db->limit( $limit_end, $limit_start);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function _count_all(){

			$campo = array(
				'proyecto_investigacion.id',
				'proyecto_investigacion.nombre_pro AS Proyecto',
				'proyecto_investigacion.descripcion AS Detalle',
				'proyecto_investigacion.sigla AS Sigla',
				'proyecto_investigacion.objetivo AS Objetivo',
				'proyecto_investigacion.fecha_creacion',
				'proyecto_investigacion.fecha_caducado',
				'CONCAT(proyecto_investigacion.sigla , "/",proyecto_investigacion.path_documento) AS Documento',
				'grupo.nombre_grupo'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
			$this->db->join('grupo','proyecto_investigacion.grupo_id = grupo.id','inner');
			$this->db->join('integrante','grupo.id = integrante.grupo_id','inner');

		$query = $this->db->get();

		$row = $query->num_rows();

		$limit_start = rand(0, $row);

		if(($row - $limit_start) < 3){
			$limit_start = $limit_start - (3 - ($row - $limit_start));
			if($limit_start < 0)
				$limit_start = 0;
		}
		return $limit_start;
	}

}

?>