<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Modelo para la tabla area
*/
class Consulta_model extends CI_Model 
{
	//Nombre de la tabla 
	//public $table = 'area';

	function __construct()
	{
		parent::__construct();
	}

	public function Actividades(){
		//$query = $this->db->where('grupo_id','1');
		//$query = $this->db->get('actividad');

        
        //$row = $result->result();
        //$row = $result->row();
		//$num = $this->db->count_all_results();

		//$result = $this->db->get_row('actividad');
 
		$result = $this->db->get('actividad')->num_rows();


		//$result = $this->db->count_all_results($this->'actividad');



		return $result;
	}


	public function ActividadRealizada(){

		/*$this->db->select('*')->from('actividad_realizada');
		//$this->db->join('presupuesto_actividad','actividad_realizada.presupuesto_actividad_id = presupuesto_actividad.id','inner');
		//$this->db->join('actividad','presupuesto_actividad.actividad_id = actividad.id','inner');
		//$this->db->num_rows();
		//$this->db->num_rows(); 
*/
		$result = $this->db->query('SELECT *
									FROM actividad_realizada AS ar
									INNER JOIN presupuesto_actividad AS pa ON ar.presupuesto_actividad_id = pa.id
									INNER JOIN actividad AS a ON pa.actividad_id = a.id')->num_rows(); 

		
		return $result;
		//return $this->db->get('actividad_realizada')->result();
	}
}

?>