<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sub_Actividad_Model extends CI_model
{

	private $tbl_subActividad = 'sub_actividad';
	private $tbl_actividad = 'actividad';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		if($this->db->insert($this->tbl_subActividad,$data)){
			return 	$this->db->insert_id();
		}else{
			return 0;	
		}
	}

	public function update($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->tbl_subActividad, $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		
		if($report !== 0){
			return true;
		}else{
			return $report;
		}
	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_subActividad); 
	}

	public function deleteXactividad($id){
		$this->db->where('actividad_id', $id);
		$this->db->delete($this->tbl_subActividad);
	}

	function get_by_id_sub($id){
		$campo = array (
			'sub_actividad.id as idS',
			'sub_actividad.descripcion as descripcion',
			'sub_actividad.fecha_inicio as fecha_inicio',
			'sub_actividad.fecha_fin as fecha_fin',
			'sub_actividad.observacion as observacion',
			'sub_actividad.realizada as realizada',
			'actividad.descripcion as nombreA',
			'actividad.id as idA',
			'grupo.id as idG',
			'grupo.nombre_grupo as nombreG');
		$this->db->select($campo);
		$this->db->from($this->tbl_subActividad);
		$this->db->join('actividad','sub_actividad.actividad_id = actividad.id','inner');
		$this->db->join('grupo','actividad.grupo_id = grupo.id','inner');
		$this->db->where('sub_actividad.id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}

	public function getXactividad($idActividad){
		$campos = array(
			'sub_actividad.id as id',
			'sub_actividad.descripcion as descripcion',
			'sub_actividad.fecha_inicio as fechainicio',
			'sub_actividad.fecha_fin as fecha_fin',
			'sub_actividad.observacion as observacion',
			'sub_actividad.realizada as realizada');
		$this->db->select($campos);
		$this->db->from($this->tbl_subActividad);
		$this->db->where('sub_actividad.actividad_id', $idActividad);

		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_all_sub($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		$campo = array (
			'sub_actividad.id as id',
			'sub_actividad.descripcion as "Descripción"',
			'sub_actividad.fecha_inicio as "Fecha inicio"',
			'sub_actividad.fecha_fin as "Fecha fin"',
			'sub_actividad.observacion as "Observación"',
			'actividad.descripcion as Actividad');
		$this->db->select($campo);
		$this->db->from($this->tbl_subActividad);
		$this->db->join('actividad','sub_actividad.actividad_id = actividad.id','inner');

		if($search_string !== null && $search_string !== ''){
			$this->db->like('sub_actividad.descripcion', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('sub_actividad.id', $order_type);
		}

		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$datos =  array('sql' => $this->db->last_query(),
						'datos' => $query->result_array() );
		return $query->result_array();
	}

	function count($actividad_id=null, $search_string=null)
    {
		$this->db->select('*');
		$this->db->from($this->tbl_subActividad);
		if($actividad_id != null && $actividad_id != 0){
			$this->db->where('id', $actividad_id);
		}
		if($search_string){
			$this->db->like('descripcion', $search_string);
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

   function count_(){
		$this->db->select('*');
		$this->db->from($this->tbl_subActividad);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function subActividadRealizadas($idA , $idG){
		$result = $this->db->query('SELECT sub_actividad.id,sub_actividad.descripcion from sub_actividad 
		inner join actividad on sub_actividad.actividad_id = actividad.id 
		inner join grupo on actividad.grupo_id = grupo.id
		where actividad.id ="'.$idA.'"
		and grupo.id = "'.$idG.'"
		and sub_actividad.realizada = 1');

		return $result->num_rows();
	}

}
?>