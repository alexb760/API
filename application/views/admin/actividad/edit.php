<div class="container top">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo site_url("index.php/adminapp"); ?>">
        <?php echo ("Inicio"); ?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li>
      <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
        <?php echo ("Actividades"); ?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      <a href="#">Update</a>
    </li>
  </ul>
      
  <div class="page-header">
    <h2> Actualizar <?php echo ("Actividad"); ?></h2>
  </div>
 
  <?php
    if($this->session->flashdata('flash_message'))
    {
      if($this->session->flashdata('flash_message') == 'updated')
      {
        echo '<div class="alert alert-success">';
          echo '<a class="close" data-dismiss="alert">&times;</a>';
          echo '<strong>Proceso Exitoso!</strong> Actividad actualizada con exito.';
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
    
    echo form_open('index.php/adminapp/admin_actividad/update/?ael='.$url.'', $attributes);
  ?>
  
  <fieldset>
    <div class="form-group">
      <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
      <div class="col-lg-8">
        <select name="grupo" id="grupo" class="form-control">  
          <?php
            if($product[0]['nombreG'] !== NULL){
              echo '<option value="'.$product[0]['idG'].'">'.$product[0]['nombreG'].'</option>';
            }else{
              foreach($grupo as $grup) {
                if($grup['idGrupo'] === $grupoV){
                  echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
                }
              }
            }
          ?> 
        </select>
        <span class="help-inline"><?php echo form_error('grupo');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="descripcion" class="col-lg-2 control-label" >Nombre:</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escriba nombre de la actividad" 
          value="<?php 
                    if($product[0]['descripcion'] != NULL){
                      echo $product[0]['descripcion'];
                    }else{
                      echo set_value('descripcion');
                    }
                ?>">
        <span class="help-inline"><?php echo form_error('descripcion');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="fecha_inicio" class="col-lg-2 control-label" >Fecha Inicio:</label>
      <div class="col-lg-8">
        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
          value="<?php 
                    if($product[0]['fecha_inicio'] != NULL){
                      echo $product[0]['fecha_inicio'];
                    }else{
                      echo set_value('fecha_inicio');
                    }
                  ?>">
        <span class="help-inline"><?php echo form_error('fecha_inicio');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
      <div class="col-lg-8">
        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
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
      <label for="duracion" class="col-lg-2 control-label" >Duración:</label>
      <div class="col-lg-8">
        <input type="number" class="form-control" id="duracion" name="duracion" min="1" placeholder="Escriba la duración de la actividad en horas" 
          value="<?php 
                    if($product[0]['duracion'] != NULL){
                      echo $product[0]['duracion'];
                    }else{
                      echo set_value('duracion');
                    }
                  ?>">
        <span class="help-inline"><?php echo form_error('duracion');?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="observacion" class="col-lg-2 control-label">Observaciones:</label>
      <div class="col-lg-8">
        <textarea class="form-control" id="observacion" rows="3" name="observacion" style="resize:none"
          placeholder="Escriba las observaciones de la actividad" maxlength="500"
          value=""><?php 
                      if($product[0]['observacion'] !== NULL){
                        echo $product[0]['observacion'];
                      }else{
                        echo set_value('observacion');
                      }
                    ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="responsable" class="col-lg-2 control-label">Resposable:</label>
      <div class="col-lg-8">
        <select name="responsable" id="responsable" class="form-control" value="">  
          <?php
            if($product[0]['IdIntegrante'] !== NULL){
              foreach ($product as $prod) {
                echo '<option value="'.$prod['IdIntegrante'].'">'.$prod['nombreU'].'</option>';
              } 
              foreach ($integrantes as $inte) {
                if($inte['IdIntegrante'] != $prod['IdIntegrante']){
                  echo '<option value="'.$inte['IdIntegrante'].'">'.$inte['Usuario'].'</option>';
                }
              }
            }else{
              foreach ($integrantes as $inte) {
                if($inte['IdIntegrante'] === $responsableV){
                  echo '<option value="'.$inte['IdIntegrante'].'">'.$inte['Usuario'].'</option>';
                }
              }
            } 
          ?> 
        </select>
        <span class="help-inline"><?php echo form_error('responsable');?></span>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-offset-2 col-lg-8">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </div>
  </fieldset>
  <?php echo form_close(); ?>
</div>