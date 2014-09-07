<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presupuesto_Model extends CI_model
{
	private $tbl_Presupuesto = 'presupuesto';
	private $tbl_PresupuestoA = 'presupuesto_actividad';
	
	function __construct()
	{
		parent::__construct();
		 $this->load->database();
	}

	function add($data){
	if($this->db->insert($this->tbl_Presupuesto,$data))
		return 	$this->db->insert_id();
	else
		return 0;
	}

	public function addPresupuestoA($data){
		if($this->db->insert($this->tbl_PresupuestoA, $data)){
			return $this->db->insert_id();
		}else{
			return 0;
		}
	}

	function get_all_(){
		$this->db->select('*');
		$this->db->from($this->tbl_Presupuesto);
		$query = $this->db->get();
		return $query->result_array(); 
	}

	function get_all($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		$campos = array (
			'presupuesto.id as id',
			'presupuesto.valor as Valor',
			'concat_ws(" ",usuario.nombre,usuario.apellido) as Autoriza',
			'grupo.nombre_grupo as "Nombre Grupo"',
			'presupuesto_actividad.valor_gasto as "Valor Gasto"',
			'actividad.descripcion as Actividad'
			);
		$this->db->select($campos);
		$this->db->from($this->tbl_Presupuesto);
		$this->db->join('grupo','presupuesto.grupo_id = grupo.id','inner');
		$this->db->join('presupuesto_actividad','presupuesto.id = presupuesto_actividad.presupuesto_id','left');
		$this->db->join('actividad','presupuesto_actividad.actividad_id = actividad.id','left');
		$this->db->join('usuario','presupuesto.autoriza = usuario.id','inner');

		$query = $this->db->get();
		$datos =  array('sql' => $this->db->last_query(),
						'datos' => $query->result_array() );
		return $query->result_array();
	}

    function count($presupuesto_id =null, $search_string=null)
    {
		$this->db->select('*');
		$this->db->from($this->tbl_Presupuesto);
		if($presupuesto_id != null && $presupuesto_id != 0){
			$this->db->where('id', $presupuesto_id);
		}
		if($search_string){
			$this->db->like('valor', $search_string);
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    function count_(){
		$this->db->select('*');
		$this->db->from($this->tbl_Presupuesto);
		$query = $this->db->get();
		return $query->num_rows();
	}

    function update($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->tbl_Presupuesto, $data);
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
		$this->db->delete($this->tbl_Presupuesto); 
	}
}
?>