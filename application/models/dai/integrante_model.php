<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Integrante_model extends CI_model
{
	private $tbl_name =''; 

	function __construct()
	{
		parent::__construct();
		$this->tbl_name ='integrante';
	}

	function get_all(){
		$campos = array('facultad.id',
						'facultad.nombre'
						);

		$this->db->select($campos);
		$this->db->from($this->tbl_name);
		$query = $this->db->get()->result_array();
		return $query;
	}

	/**
	*Funcion para guardar en base datos
	*/
	function add($data){
		return 	$this->db->insert($this->tbl_name,$data) ;				
	}
}
