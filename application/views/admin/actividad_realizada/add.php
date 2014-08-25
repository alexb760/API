<div class="container top">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo site_url("index.php/adminapp"); ?>">
        <?php echo ("Inicio");?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li>
      <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
        <?php echo ("Actividades Realizadas"); ?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      <a href="#">Nuevo</a>
    </li>
  </ul>
      
  <div class="page-header">
    <h2> Nueva <?php echo ("Actividad Realizada"); ?></h2>
  </div>
 
  <?php
    if($this->session->flashdata('flash_message')){
      if($this->session->flashdata('flash_message') == 'add'){
        echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">&times;</a>';
        echo '<strong>Proceso Exitoso!</strong> Nueva Actividad Realizada';
        echo '</div>';       
      }else if($this->session->flashdata('flash_message') == 'not_sub'){
        echo '<div class="alert alert-danger">';
        echo '<a class="close" data-dismiss="alert">&times;</a>';
        echo '<strong>Ops!</strong> Existen Sub Actividades sin realizar';
        echo '</div>';         
      }else{
        echo '<div class="alert alert-danger">';
        echo '<a class="close" data-dismiss="alert">&times;</a>';
        echo '<strong>Ops!</strong> Valida los datos e intenta de Nuevo.';
        echo '</div>'; 
      }

    }
      
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    $options_manufacture = array('' => "Select");

    echo form_open('index.php/adminapp/admin_actividad_realizada/add', $attributes);
  ?>
  
  <fieldset>
    <div class="form-group">
      <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
      <div class="col-lg-8">
        <select name="grupo" id="grupo" class="form-control" required>  
          <?php 
            if($grupoV !== NULL){
            foreach ($grupo as $grup) {
              if($grup['idGrupo'] === $grupoV){
                echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
              }
            }
            foreach ($grupo as $grup) {
              if($grup['idGrupo'] !== $grupoV){
                echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
              }
            }
          }else if($product !== NULL){
            foreach ($product as $prod) {
              echo '<option value="'.$prod['idGrupo'].'">'.$prod['Grupo'].'</option>';
            }
          }else{
            echo '<option value="0">Seleccione</option>';
            foreach ($grupo as $grup) {
              echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
            }
          } 
          ?> 
        </select>
        <span class="help-inline"><?php echo form_error('grupo');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="actividad" class="col-lg-2 control-label">Actividad:</label>
      <div class="col-lg-8">
        <select name="actividad" id="actividad" class="form-control" required title="Se requiere la actividad!">  
          <?php 
            if($actividadV !== NULL){
              echo 'ea1';
              foreach ($actividad as $acti) {
                if($acti['IdActividad'] === $actividadV){
                  echo '<option value="'.$acti['IdActividad'].'">'.$acti['Actividad'].'</option>';
                }
              }
              foreach ($actividad as $acti) {
                if($acti['IdActividad'] !== $actividadV){
                  echo '<option value="'.$acti['IdActividad'].'">'.$acti['Actividad'].'</option>';
                }
              }
            }else if($product !== NULL){
              echo 'ea2';
              foreach ($product as $prod) {
                echo '<option value="'.$prod['IdActividad'].'">'.$prod['Actividad'].'</option>';
              }
            }else{
              echo 'ea3';
              echo '<option value="">Seleccione</option>';
            } 
          ?> 
        </select>
        <span class="help-inline"><?php echo form_error('actividad');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
      <div class="col-lg-8">
        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required
           title="Ingrese fecha de realización" 
           value="<?php 
              if($product[0]['fecha_fin'] != NULL){
                echo $product[0]['fecha_fin'];
              }else{
              echo set_value('fecha_fin');
              }
            ?>">
            <span class="help-inline"><?php echo form_error('fecha_fin');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="observacion" class="col-lg-2 control-label">Observaciones:</label>
      <div class="col-lg-8">
        <textarea class="form-control" id="observacion" rows="3" name="observacion" maxlength="500"
          placeholder="Escriba las observaciones de la actividad realizada" style="resize:none"
          value=""><?php 
              if($product[0]['observacion'] != NULL){
                echo $product[0]['observacion'];
              }else{
              echo set_value('observacion');
              }
            ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-offset-2 col-lg-8">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </div>
  </fieldset>
  <script type="text/javascript">
      $('#grupo').on('change', buscarActividad);

      function buscarActividad(){
        var urlR = location.href;

        $grupo = $('#grupo').val();

        if($grupo !== ""){
            $.ajax({
                dataType: "json",
                data: {"grupo": $grupo},
                url: urlR+'Actividad',
                type: 'post',
                beforeSend: function(){
                },
                success: function(respuesta){
                  $("#actividad").html(respuesta.html);
                },
                error: function(xhr,err){
                  alert("readyState: " + xhr.readyState + "\nstatus:" + xhr.status + "\n \n responseText: " + xhr.responseText);
                }
            });
        }
    }
  </script>
  <?php echo form_close(); ?>
</div>