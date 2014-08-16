<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Estado_model extends CI_model
{
	private $tb_name = 'estado';
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	function add($data){
		return 	$this->db->insert($this->tb_name,$data) ;
	}

	function get_all_(){
		return $this->db->get($this->tb_name)->result();
	}

	function get_all($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		
			$this->db->select('*');
			$this->db->from($this->tb_name);

		if($search_string !== null && $search_string !== ''){
			$this->db->like('descripcion', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
		    //$this->db->order_by('id', $order_type);
		    $this->db->order_by('id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('10', '0');


		$query = $this->db->get();
		
		$datos =  array('sql' => $this->db->last_query(),
						'datos' => $query->result_array() );
		//return $query->result_array();
		return $query->result_array();
	}

	function get_by_id($id){
		$this->db->select('*');
		$this->db->from($this->tb_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}

	function count($search_string=null, $order=null){

		$this->db->select('*');
		$this->db->from($this->tb_name);
		if($search_string){
			$this->db->like('descripcion', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();  
	}

	function count_(){
		$this->db->select('*');
		$this->db->from($this->tb_name);
		$query = $this->db->get();
		return $query->num_rows();
	}
}
?>