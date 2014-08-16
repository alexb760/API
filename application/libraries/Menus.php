<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Menus 
{
	private $arr_opciones;
  private $ci;

	public function __construc(){
  }


  public function inicializador(){

      $this->ci =& get_instance();
      $this->ci->load->model('dai/usuario_model');
  }

public function render_submenu(){
  return '<a  href="<?php site_url("index.php/adminapp")'.'/'.'$this->uri->segment(2)?>; /add" class="btn btn-success">Nuevo</a>';
}

  public function menu_usuario($id_usuario){ 
          $this->inicializador();
          $menu = $this->menu(TRUE, $id_usuario); 
          if (is_array($menu)) {
                # Rederiza menu de acuerdo al ROL_USUARIO 
                $menu_user = '<li class="divider"></li>';
                $menu_user .= '<li class="dropdown-submenu">';
                  foreach ($menu as $key) {
                    if ($key['submenu']  === null) {
                        $menu_user .= '<li class="dropdown-submenu">';
                        $menu_user .= '<a href="'.
                              base_url().'index.php/'.$key['directorio'].'/'.$key['controlador'].'/'
                              .$key['funcion'].'?smr='.base64_encode($key['id']).'">';
                        $menu_user .= '<span class="glyphicon glyphicon-cog"></span>';
                        $menu_user .= '<strong>'.$key['nombre'].'</strong></a>';
                        $array = $this->menu(FALSE,$key['id']);
                        if ( is_array($array)) {
                            $menu_user .= $this->sub_menu_usuario($array);
                         } 
                   $menu_user .= '<li class="divider"></li>'; 
                 }
                }
                
              }
      return   $menu_user;      
  }

  public function sub_menu_usuario($paramentro){
    $respons_submenu = '<ul class="dropdown-menu">';
    foreach ($paramentro as $key ) {
      $respons_submenu .= '<li><a tabindex="-1" href="'.base_url("index.php/").'/'.$key['directorio'].'/'.$key['controlador'].'/'.$key['funcion'].'">';
      $respons_submenu .= $key['nombre'].' </a></li>';
    }
    $respons_submenu .= '</ul>';
    return $respons_submenu;
  }

/**
    * Devuelve un menu principal o un submenu
    * recibe TRUE para menu
    * Recibe FALSE para submenu
    * @return array
    */
    private function menu($bandera, $_id){
        if ($bandera) {
            return $this->ci->usuario_model->get_menu_rol($_id);
        }else{
            return $this->ci->usuario_model->get_menu_submenu($_id); 
        }
    } 

 /**
 *Funcion para obtener los permisos sobre cada Controlador por usuario 
 *los permisos estan alojados en la base de Datos
 */   
 public function get_permisos_controlador($p_array){
   $this->inicializador(); 
   $data_respons  = $this->ci->usuario_model->get_permiso_controlado($p_array);
   if (count($data_respons) > 0 ) {
     foreach ($data_respons as $key) {
        foreach ($key as $col => $value) {
           $data_respons[$col] = $value;
        }
   }
   }else{
      $data_respons = null;
   }
    return $data_respons;
 }

 // funcion que será llamada por el controlador en caso de  no  tener permiso para el controlador.

public function errors($p_error){
        $this->inicializador(); 
        $datos['nombre_error']  = 'Esto es vergonzoso... '.'<br>'.
                                  ((isset($p_error['header'])) ? $p_error['header'] : '.');
        $datos['descripcion']   = $p_error['message'];
        $datos['menu']          = $p_error['menu'];
        $datos['main_content'] = 'includes/errors';
        $this->ci->load->view('includes/template', $datos);
    }
//devuelve un array con valores segun permiso
 /**
* D E I value 
* 0 0 0   0       CONSULTA
* 0 0 1   1       INSERTAR
* 0 1 0   2       EDITAR
* 0 1 1   3       INSERTAR/EDITAR
* 1 0 0   4       ELIMINAR
* 1 0 1   5       INSERTAR/ELIMINAR
* 1 1 0   6       EDITAR/ELIMINAR
* 1 1 1   7       TODO
*@return array;
*/   
 function permisos_funciones($p_value){
  $array_permisos;
  switch ($p_value) {
    case 0:
      $array_permisos['CONSULTAR']    = TRUE;
      $array_permisos['INSERTAR']     = FALSE;
      $array_permisos['EDITAR']       = FALSE;
      $array_permisos['ELIMINAR']     = FALSE;
        break;
    case 1:
      $array_permisos['INSERTAR']     = TRUE;
      $array_permisos['EDITAR']       = FALSE;
      $array_permisos['ELIMINAR']     = FALSE;
        break;
    case 2:
      $array_permisos['INSERTAR']     = FALSE;
      $array_permisos['EDITAR']       = TRUE;
      $array_permisos['ELIMINAR']     = FALSE;
        break;
    case 3:
      //$array_permisos['CONSULTAR']    = FALSE;
      $array_permisos['INSERTAR']     = TRUE;
      $array_permisos['EDITAR']       = TRUE;
      $array_permisos['ELIMINAR']     = FALSE;
        break;
    case 4:
      //$array_permisos['CONSULTAR']    = FALSE;
      $array_permisos['INSERTAR']     = FALSE;
      $array_permisos['EDITAR']       = FALSE;
      $array_permisos['ELIMINAR']     = TRUE;
      break;
    case 5:
      //$array_permisos['CONSULTAR']    = TRUE;
      $array_permisos['INSERTAR']     = TRUE;
      $array_permisos['EDITAR']       = FALSE;
      $array_permisos['ELIMINAR']     = TRUE;
      break;
    case 6:
       // $array_permisos['CONSULTAR']    = TRUE;
        $array_permisos['INSERTAR']     = FALSE;
        $array_permisos['EDITAR']       = TRUE;
        $array_permisos['ELIMINAR']     = TRUE;
        break;
    case 7:
        //$array_permisos['CONSULTAR']    = TRUE;
        $array_permisos['INSERTAR']     = TRUE;
        $array_permisos['EDITAR']       = TRUE;
        $array_permisos['ELIMINAR']     = TRUE;
        break;
  }
  return $array_permisos;
 } 
/**
*Valida permiso sobre una funcion
*recibe permiso 
* array
*@return TRUE | FALSE
*/
function permiso_funcion($p_array){
  if (isset($p_array['funcion']) && $p_array['funcion'] != null) {
    $funcion = $this->get_permisos_controlador($p_array);
    if (is_array($funcion) && count($funcion) >0 ) {
      return TRUE;
    }else
      return FALSE;
  }
}

}
?>