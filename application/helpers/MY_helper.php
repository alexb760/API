<?php
function render_submenu($parametro){
	
}

/**
*Funcion para imprimir los mensaje de exito
* o fracaso de un isert  u opercion contra la base de datos.
*Funcion  recibe TRUE
*Recibe String con mensaje que se desee imprimir.
* @return String
*/
function mensaje_response($p_error, $target ){
  if(is_bool($p_error)){
  	if($p_error == TRUE){
  		    $respons = '<div class="alert alert-success">';
          $respons .= '<a class="close" data-dismiss="alert">&times;</a>';
          $respons .= '<strong>Proceso Exitoso!</strong> '.$target;
          $respons .= '<em>En hora buena, esta operación ha concluido exitosamente</em> ';
          $respons .= '</div>';

          }else{
            $respons = '<div class="alert alert-danger">';
            $respons .= '<a class="close" data-dismiss="alert">&times;</a>';
            $respons .= '<strong>Ops!</strong> Valida los datos e intenta de Nuevo. '.$p_error;
            $respons .= '</div>';          
          }
    }else{
      if ($p_error['status'] = TRUE) {
          $respons = '<div class="alert alert-success">';
          $respons .= '<a class="close" data-dismiss="alert">&times;</a>';
          $respons .= '<strong>En hora buena! </strong>'.$p_error['message'];
          $respons .= (isset($p_error['info'])? '<pre>'.$p_error['info'] .'</pre>': '');
          $respons .= '</div>';
      }else{
        $respons = '<div class="alert alert-warning">';
          $respons .= '<a class="close" data-dismiss="alert">&times;</a>';
          $respons .= '<strong>Ops! </strong>'.$p_error['message'].'<br>'.'no hay de que preocuparse todo ha sigo guardado.';
          $respons .= '</div>';
      }
      
    }
        return $respons;
	}

  function print_table_vertical($p_data, $p_permiso, $parametros){
    if (is_array($p_data) && count($p_data) > 0) {
    $respons = '<table class="table table-striped table-bordered table-condensed table-hover" >'.
                '<thead>'.
                 '<tr>';
    $respons .=  ($p_permiso['EDITAR'] == FALSE && $p_permiso['ELIMINAR']  == FALSE) ? '' :
                                                      '<th class="text-center">Acciones</th>';
    $respons .=  '<th class="text-center">Campos</th>'.
                  '<th class="text-center">Datos</th>'.
                '</tr>'.
                '</thead>'. 
                '<tbody>';
     foreach ($p_data as $key) {
      if (($p_permiso['EDITAR'] == TRUE || $p_permiso['ELIMINAR']  == TRUE)) {

        $respons .= '<tr border="4">';
        $respons .= '<td rowspan="'. (count($key) + 1) .'" class="crud-actions text-center">';
        if ($p_permiso['EDITAR'] == TRUE) {
          $respons .= '<a href="'.$parametros['site_url'].'/'.$parametros['segment'].'/update/'.$key['id'].
            '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>' ; 
        }
        if ($p_permiso['ELIMINAR']) {
          $respons .= '<a href="'.
              $parametros['site_url'].'/'.$parametros['segment'].'/delete/'.$key['id'].
            '" class="btn btn-default btn-lg">'.
              '<span class="glyphicon glyphicon-remove-sign"></span></a></td>';
        }
      }
        
         foreach($key as $value => $dato){
            $respons .= '<tr>';
            $respons .= '<th>'.$value.'</th>';
            $respons .= '<td>'. $dato .'</td>';  
            $respons .= '</tr>';
          }
          $respons .= '<tr class = "divider"></tr>';
          $respons .= '</tr>';
          $respons .= '<tr>';
          $respons .= '</tr>';
    }
    }else{
      $respons = '<div class="alert bg-warning">'.
                      '<strong>Opps!: </strong>'.'No hay datos registrados'.'</div>';
    } 
      return $respons;                         
  }

 function print_table_horizontal($p_data, $p_permiso, $parametros){
  if (is_array($p_data) && count($p_data) > 0) {
    $respons = '<table class="table table-striped table-bordered table-condensed table-hover" >'.
                '<thead>'.
                 '<tr>';
      $tmp_array = $parametros['header'];
      foreach ($tmp_array as $key) {
        $respons .= '<th class="text-center">'.$key.'</th>';
      }
      $respons .=  ($p_permiso['EDITAR'] == FALSE && $p_permiso['ELIMINAR']  == FALSE) ? '' :
                                                        '<th class="text-center">Acciones</th>';
      $respons .= '</tr>'.
                '</thead>'. 
                '<tbody>';
foreach($p_data as $row ) {
    $respons .= '<tr>';
    foreach ($row as $key => $value) {
       $respons .= '<td>'.$value.'</td>';
    }
    if ($p_permiso['EDITAR'] == TRUE || $p_permiso['ELIMINAR']  == TRUE) {
       $respons .= '<td class="crud-actions">';
      if ($p_permiso['EDITAR'] == TRUE) { 
        $respons .= '<a href="'.$parametros['site_url'].'/'.$parametros['segment'].'/update/'.$row['id'].
        '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>';  
      }
      if ($p_permiso['ELIMINAR'] == TRUE) {
        $respons .= '<a href="'.$parametros['site_url'].'/'.$parametros['segment'].'/delete/'.$row['id'].
        '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-remove-sign"></span></a>';
      }
    }
    $respons .= '</td>';
    $respons .= '</tr>';                        
  }
}else{
   $respons = '<div class="alert bg-warning">'.
                      '<strong>Opps!: </strong>'.'No hay datos registrados'.'</div>';
}
  return $respons;   
}

function encabezado_consulta($p_array){
  $opciones = array();
  foreach ($p_array as $array) {
              foreach ($array as $key => $value) {
                $opciones[$key] = $key;
              }
              break;
            }
  return  $opciones;        
}

?>