<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends CI_model
{
	private $tbl_name = 'producto';
	private $tbl_tipo = 'tipo_producto';
	private $tbl_autoria = 'autoria';
	function __construct()
	{
		parent::__construct();
		 $this->load->database();
	}

 public function show_info_producto($limit, $inicio){ 
		$campo = array(
				'grupo.nombre_grupo AS Nombre',
				'grupo.avalado_col AS Avalado_Colciencia',
				'grupo.clasificacion AS Clasificacion',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",grupo.pagina_web,"'.'>",grupo.pagina_web,"</a>"').') AS Web'),
				'grupo.correo AS Correo',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",grupo.path_colciencias,"'.'>",grupo.path_colciencias,"</a>"').') AS Colciencias'),
				'producto.nombre AS producto',
				'producto.descripcion',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",producto.ruta,"'.'>","Detalles &raquo;","</a>"').') AS ruta'),
				);
		$this->db->select($campo);
		$this->db->from('grupo');
		$this->db->join('integrante','integrante.grupo_id = grupo.id','inner');
		$this->db->join('producto','producto.grupo_id = grupo.id','inner');
##establece el numero de columnas para parametrizar de forma aleatoria el limit
		$this->db->limit( $inicio, $limit );
		$query = $this->db->get();
		return $query->result_array();  
	}

	public function _count_all(){

		$campo = array(
				'grupo.nombre_grupo AS Nombre',
				'grupo.avalado_col AS Avalado_Colciencia',
				'grupo.clasificacion AS Clasificacion',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",grupo.pagina_web,"'.'>",grupo.pagina_web,"</a>"').') AS Web'),
				'grupo.correo AS Correo',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",grupo.path_colciencias,"'.'>",grupo.path_colciencias,"</a>"').') AS Colciencias'),
				'producto.nombre AS producto',
				'producto.descripcion',
				'CONCAT("<a target=_blank href='.prep_url(auto_link('",producto.ruta,"'.'>","Detalles &raquo;","</a>"').') AS ruta'),
				);
		$this->db->select($campo);
		$this->db->from('grupo');
		$this->db->join('integrante','integrante.grupo_id = grupo.id','inner');
		$this->db->join('producto','producto.grupo_id = grupo.id','inner');
##establece el numero de columnas para parametrizar de forma aleatoria el limit
		$query = $this->db->get();

		$row = $query->num_rows();

		$limit_start = rand(0, $row);

		if(($row - $limit_start) < 2){
			$limit_start = $limit_start - (2 - ($row - $limit_start));
		}
		return $limit_start;
	}

}