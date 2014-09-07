<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividad_Model extends CI_model
{
	private $tbl_Actividad = 'actividad';
	private $tb_responsable = 'responsable';
	private $tb_sub = 'sub_actividad';
	private $tb_realizada = 'actividad_realizada';
	
	function __construct()
	{
		parent::__construct();
		 $this->load->database();
	}

	public function add($data){
		if($this->db->insert($this->tbl_Actividad,$data)){
			return 	$this->db->insert_id();
		}else{
			return 0;
		}
	}

	public function getxID($idActividad){
		$campos = array(
			'actividad.id as IdActividad',
			'actividad.descripcion as Actividad',
			'actividad.fecha_inicio as fecha_inicio',
			'actividad.fecha_fin as fecha_fin',
			'actividad.observacion as observacion',
			'actividad.grupo_id as idGrupo');
		$this->db->select($campos);
		$this->db->from($this->tbl_Actividad);
		$this->db->where('actividad.id', $idActividad);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_id_edit($id){
		$campo = array (
			'actividad.id as idA',
			'actividad.descripcion as descripcion',
			'actividad.fecha_inicio as fecha_inicio',
			'actividad.fecha_fin as fecha_fin',
			'responsable.duracion as duracion',
			'responsable.id as IdResponsable',
			'integrante.id as IdIntegrante',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as nombreU',
			'usuario.id as idU',
			'grupo.nombre_grupo as nombreG',
			'grupo.id as idG',
			'actividad.observacion as observacion');
		$this->db->select($campo);
		$this->db->from($this->tb_responsable);
		$this->db->join('integrante','responsable.integrante_id = integrante.id','inner');
		$this->db->join('usuario','integrante.usuario_id = usuario.id','inner');
		$this->db->join('actividad','responsable.actividad_id = actividad.id','inner');
		$this->db->join('grupo','actividad.grupo_id = grupo.id','left');
		$this->db->where('actividad.id', $id);
		
		$query = $this->db->get();
		return $query->result_array(); 
	}

	public function get_byId_grupo($id){
		$campos = array(
			'actividad.id as IdActividad',
			'actividad.descripcion as Actividad',
			'actividad.fecha_inicio as FechaInicio',
			'actividad.fecha_fin as FechaFin',
			'actividad.observacion as Observacion',
			'actividad.grupo_id as IdGRupo',
			'grupo.nombre_grupo as Grupo');
		$this->db->select($campos);
		$this->db->from($this->tbl_Actividad);
		$this->db->join('grupo','actividad.grupo_id = grupo.id','inner');
		$this->db->where('actividad.grupo_id',$id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_(){
		$this->db->select('*');
		$this->db->from($this->tbl_Actividad);
		
		$query = $this->db->get();
		return $query->result_array(); 
	}

 	public function get_all($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		$campo = array (
			'actividad.id as id',
			'actividad.descripcion as "Descripción"',
			'actividad.fecha_inicio as "Fecha inicio"',
			'actividad.fecha_fin as "Fecha fin"',
			'responsable.duracion as "Duración"',
			'grupo.nombre_grupo as Grupo',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as Responsable',
			'actividad.observacion as "Observación"');
		$this->db->select($campo);
		$this->db->from($this->tb_responsable);
		$this->db->join('integrante','responsable.integrante_id = integrante.id','inner');
		$this->db->join('usuario','integrante.usuario_id = usuario.id','inner');
		$this->db->join('actividad','responsable.actividad_id = actividad.id','inner');
		$this->db->join('grupo','actividad.grupo_id = grupo.id','left');

		if($search_string !== null && $search_string !== ''){
			$this->db->like('actividad.descripcion', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('actividad.id', $order_type);
		}

		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$datos =  array('sql' => $this->db->last_query(),
						'datos' => $query->result_array() );
		return $query->result_array();
	}

    public function count($actividad_id=null, $search_string=null){
		$this->db->select('*');
		$this->db->from($this->tbl_Actividad);

		if($actividad_id != null && $actividad_id != 0){
			$this->db->where('id', $actividad_id);
		}
		if($search_string){
			$this->db->like('descripcion', $search_string);
		}
		
		$query = $this->db->get();
		return $query->num_rows();        
    }

    public function count_(){
		$this->db->select('*');
		$this->db->from($this->tbl_Actividad);
		$query = $this->db->get();
		return $query->num_rows();
	}

    public function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->tbl_Actividad, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return $report;
		}
	}

	public function updateEstado($id){
		$this->db->where('id', $id);
		$this->db->update($this->tbl_Actividad, 'realizada', 0);

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
		$this->db->delete($this->tbl_Actividad); 
	}
}
?>