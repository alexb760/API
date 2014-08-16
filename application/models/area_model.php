<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Modelo para la tabla area
*/
class Area_model extends CI_model 
{
	//Nombre de la tabla 
	public $table = 'area';

	function __construct()
	{
		parent::__construct();
	}

	 function insertar_area($area){
		if ($this->db->insert('area',$area)) 
			return true;
		else
			return false;
	}
}

?>