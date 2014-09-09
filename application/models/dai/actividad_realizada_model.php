<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividad_Realizada_Model extends CI_model
{
	private $tb_actividad = 'actividad';
	private $tb_responsable = 'responsable';
	//private $tb_sub = 'sub_actividad';
	private $tbl_ActividadRealizada = 'actividad_realizada';
	private $tbl_presupuestoA = 'presupuesto_actividad';
	
	function __construct()
	{
		parent::__construct();
		 $this->load->database();
	}

	function add($data){
	if($this->db->insert($this->tbl_ActividadRealizada,$data))
		return 	$this->db->insert_id();
	else
		return 0;
	}

	function get_all_(){
		$this->db->select('*');
		$this->db->from($this->tbl_ActividadRealizada);
		$query = $this->db->get();
		return $query->result_array(); 
	}

	function get_all($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		$campo = array (
			'actividad_realizada.id as id',
			'actividad_realizada.fecha_fin as "Fecha fin"',
			'actividad_realizada.observacion as "Observación"',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as "Responsable"',
			'grupo.nombre_grupo as "Grupo"',
			//'actividad_realizada.ejecutada as ejecutada',
			'presupuesto_actividad.valor_gasto as valor',
			'actividad.descripcion as Actividad');
		$this->db->select($campo);
		$this->db->from($this->tbl_ActividadRealizada);
		$this->db->join('actividad','actividad_realizada.actividad_id = actividad.id','inner');
		$this->db->join('presupuesto_actividad','actividad.id = presupuesto_actividad.actividad_id','left');
		//$this->db->join('presupuesto','presupuesto_actividad.presupuesto_id = presupuesto.id','left');
		$this->db->join('responsable','actividad.id = responsable.actividad_id','inner');
		$this->db->join('integrante','responsable.integrante_id = integrante.id','inner');
		$this->db->join('grupo','integrante.grupo_id = grupo.id','inner');
		$this->db->join('usuario','integrante.usuario_id = usuario.id','inner');


		if($search_string !== null && $search_string !== ''){
			$this->db->like('actividad_realizada.fecha_fin', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('actividad_realizada.id', $order_type);
		}

		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$datos =  array('sql' => $this->db->last_query(),
						'datos' => $query->result_array() );
		return $query->result_array();
	}

	function get_ActividadSinRealizar($idGrupo){

		$result = $this->db->query('SELECT actividad.id AS IdActividad ,actividad.descripcion AS Actividad 
									FROM actividad
									WHERE not exists (SELECT * FROM actividad_realizada
									WHERE actividad_realizada.actividad_id = actividad.id)
									AND actividad.fecha_fin < sysdate()
									AND actividad.grupo_id ='.$idGrupo);
		
		return $result->result_array();
	}

	

	/*function get_integrante($id_grupo){
		$campo = array(
			'usuario.id as idU',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as nombreU');
		$this->db->select($campo);
		$this->db->from($this->tb_responsable);
		$this->db->join('integrante','integrante_id = integrante.id','inner');
		$this->db->join('usuario','usuario_id = usuario.id','inner');
		$this->db->join('grupo','integrante.grupo_id = grupo.id','inner');
		//$this->db->where('grupo.id ='.$id_grupo);

		$query = $this->db->get();
		return $query->result_array();
	}*/

	/*function presupuesto_Actividad($actividad_id){
		$this->db->select('*');
		$this->db->from($this->tbl_presupuestoA);
		$this->db->where('actividad_id = '.$actividad_id);
		$query = $this->db->get();
		return $query->result_array();
	}*/

	function get_ByID_Edit($id)
	{
		$campo = array (
			'actividad_realizada.id as idActividadR',
			'actividad_realizada.fecha_fin as fecha_fin',
			'actividad_realizada.observacion as observacion',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as Usuario',
			'usuario.id as idUsuario',
			'actividad_realizada.ejecutada as ejecutada',
			'presupuesto_actividad.valor_gasto as valor',
			'actividad.descripcion as Actividad',
			'actividad.id as IdActividad',
			'grupo.id as idGrupo',
			'grupo.nombre_grupo as Grupo',
			'integrante.id as IdIntegrante',
			'responsable.id as IdResponsable');
		$this->db->select($campo);
		$this->db->from($this->tbl_ActividadRealizada);
		$this->db->join('actividad','actividad_realizada.actividad_id = actividad.id','inner');
		$this->db->join('presupuesto_actividad','actividad.id = presupuesto_actividad.actividad_id','left');
		//$this->db->join('presupuesto','presupuesto_actividad.presupuesto_id = presupuesto.id','left');
		$this->db->join('responsable','actividad.id = responsable.actividad_id','inner');
		$this->db->join('integrante','responsable.integrante_id = integrante.id','inner');
		$this->db->join('usuario','integrante.usuario_id = usuario.id','inner');
		$this->db->join('grupo','actividad.grupo_id = grupo.id','inner');
		$this->db->where('actividad_realizada.id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}

    function count($actividad_id=null, $search_string=null)
    {
		$this->db->select('*');
		$this->db->from($this->tbl_ActividadRealizada);
		if($actividad_id != null && $actividad_id != 0){
			$this->db->where('id', $actividad_id);
		}
		if($search_string){
			$this->db->like('fecha_fin', $search_string);
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

	function count_(){
		$this->db->select('*');
		$this->db->from($this->tbl_ActividadRealizada);
		$query = $this->db->get();
		return $query->num_rows();
	}

    function update($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->tbl_ActividadRealizada, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return $report;
		}
	}

	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_ActividadRealizada); 
	}
}
?>