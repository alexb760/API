<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Linea_investigacion_model extends CI_Model
{
	private $tb_name ='linea_investigacion';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function count($search_string=null, $order=null){

		$this->db->select('*');
		$this->db->from($this->tb_name);
		if($search_string){
			$this->db->like('tema', $search_string);
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
		$this->db->select('*');
		$this->db->from($this->tb_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}


	function get_all($search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end){
		
			$campo = array(
				'*'
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);

		if($search_string !== null && $search_string !== ''){
			$this->db->like('tema', $search_string);
		}

		if($order !== null && $order !== ''){
			$this->db->order_by($order, $order_type);
		}else{
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
function get_all_(){
		
			$campo = array(
				'*',
				);
			$this->db->select($campo);
			$this->db->from($this->tb_name);
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
		$this->db->update($this->tb_name, $data);
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
		$this->db->delete($this->tb_name); 
	}



}

?>