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
                //$menu_user .= '<li class="dropdown-submenu">';
                  foreach ($menu as $key) {
                    if ($key['submenu']  === null) {
                        $menu_user .= '<li class="dropdown-submenu">';
                        $menu_user .= '<a href="'.
                              base_url().'index.php/'.$key['directorio'].'/'.$key['controlador'].'/'
                              .$key['funcion'].'?smr='.base64_encode($key['id']).'">';
                        $menu_user .= '<span class="glyphicon glyphicon-cog"></span>';
                        $menu_user .= '<strong>'.utf8_decode($key['nombre']).'</strong></a>';
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
      $respons_submenu .= utf8_decode($key['nombre']).' </a></li>';
    }
    $respons_submenu .= '</ul></li>';
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
/*
|--------------------------------------------------------------------------
| FUNCIONES MANEJO DE CORREO
|--------------------------------------------------------------------------
|
| Funciones para envío de correo,
| 
|
*/

/**
*funcion Mail
*@param array
*@return
*/
  public function send_mail($param){
        try{
            $this->inicializador(); 
            //libreria mail de codeigniter
            $this->ci->load->library('email');
            //parametros de envio
            $this->ci->email->from($param['from'], $param['from']);
            $this->ci->email->to($param['to']); 
            $this->ci->email->cc( (isset($param['cc'])? $param['cc'] : null)); 
            $this->ci->email->bcc( (isset($param['bcc'])? $param['bcc'] : null)); 

            $this->ci->email->subject( (isset($param['subject'])? $param['subject'] : 'Mensaje del sistema'));
            //valida si la variable parametros trae ruta adjunto
            if(isset($param['attach']))
                $this->ci->email->attach($param['attach']);

            $this->ci->email->message((isset($param['message'])? 
                    (is_array($param['message']) ? $this->body_mail($param['message']) : 
                      $param['message'] ) : 'Mensaje del Sistema'));
            if(!$this->ci->email->send()){
                $result['status'] = FALSE;
                $formato = 'Esto es extraño.'.'\n'.' no se ha enviado ningún mensaje ha %s ';
                $result['message'] =  sprintf($formato, implode(',',$param['to']));
              }
              else{
                $result['status'] = TRUE;
                $formato = 'Un mensaje nuevo se ha enviado a %s ';
                $result['message'] =  sprintf($formato, implode('\n',$param['to']));
              }
            $this->ci->email->clear();
            return $result;

        }catch(Exception $e){
          show_error($e->getMessage().' --- '.$e->getTraceAsString());
        } 

    }

  private function body_mail($p_mensaje){
    try {
      $body = '<pre style="text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666666; background: #f9fee8;">';
      foreach ($p_mensaje as $key => $value) {
        $body .= '<strong style="color: #9caa6d; text-decoration:none;">'.$key.' '.'</strong><em>'.$value.'</em><br>';
      }
      $body .= '</pre>';
      return $body;
    } catch (Exception $e) {
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }

  }

  private function response_mail($p_mensaje){
    try {
      
    } catch (Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
  /*-------------------------------------------------------------------------------*/

  /*
|--------------------------------------------------------------------------
| FUNCIONES UPLOAD FILE CON CODEIGNITER.
|--------------------------------------------------------------------------
|
| funciones de manejo de archivos.| 
|
*/
public function upload_file($params){
  try{
      $max_size = 1024;
      $this->inicializador(); 
      //libreria mail de codeigniter
      $this->ci->load->helper('string');
      $status = FALSE;
      $message = '';
      $info = '';
      $file_element_name = $params['file'];
      $dir_user = $params['dir_user'];
    if(!is_dir(dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/uploads/grupos/'. $dir_user)){
            if(@mkdir(dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/uploads/grupos/'.$dir_user))
                echo 'Directorio creado';
              else
                echo 'directorio no creado';
      }
          //$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/uploads/grupos/'";
          $config['upload_path'] = './assets/uploads/grupos/'.$dir_user;
          //$config['upload_url'] = base_url()."/assets/uploads/grupos/";
          //$config['upload_path'] = './uploads/grupos/'.$dir_user;
          $config['allowed_types'] = 'doc|docx|pdf|txt|xsl|xslx|html|odf|rar|zip|7zip';
          $config['max_size'] = $max_size * 8;
          $config['overwrite'] = TRUE;
          $this->ci->load->library('upload',$config);
          //$this->ci->upload->initialize($config);
          if (!$this->ci->upload->do_upload($file_element_name)) {// Validation Errors. FAIL
              $status = FALSE;
              $message = $this->ci->upload->display_errors('', '');
              $info = implode(' | ',$this->ci->upload->data());
          } else {
              $data = $this->ci->upload->data();
          // casi siempre queremos guardar ese archivo en la base de datos. para eso llamamos el metodo del modelo indicado
          // $insertFile = $this->SOME_MODEL->SAVE_FILE($data, $title);  // Llamada al modelo para guardar
          $insertFile = TRUE;
                        if ($insertFile) {  // File was added correctly to DB
                            $status = TRUE;
                            $message = 'Archivo enviado con Éxito!';
                            $info = $data;
                        } else {    // Record wasnt added to DB
                            unlink($data['full_path']); # Deletes the File
                            $status = FALSE;
                            $message = 'Algo va Mal!!...';
                            $info = '';
                        }
                    }
      return array('message' => $message, 'status' => $status, 'info' => $info);
    } catch (Exception $e){
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
}

/*--------------------------------------------------------------------------*/
}
?>