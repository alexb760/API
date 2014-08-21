<div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo "Inicio"; ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php echo "Sub Actividad"; ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Actualizar</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Actualizar <?php echo "Sub Actividad";?>
        </h2>
      </div>
 
      <?php
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Proceso Exitoso!</strong> Sub actividad actualizada con exito.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Ops!</strong> Valida los datos e intenta de Nuevo.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");
      echo form_open('index.php/adminapp/admin_sub_actividad/update/?ael='.$url.'', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="actividad_id" class="col-lg-2 control-label">Actividad:</label>
            <div class="col-lg-8">
              <select name="actividad" id="actividad" class="form-control" >  
              <?php 
                    if($product[0]['nombreA'] !== NULL){
                      echo '<option value="'.$product[0]['idA'].'">'.$product[0]['nombreA'].'</option>';
                    }else{
                      if($actividad[0]['Actividad'] !== NULL){
                        foreach ($actividad as $acti) {
                          echo '<option value="'.$acti['IdActividad'].'">'.$acti['Actividad'].'</option>';
                        }
                      }
                    }
              ?> 
              </select>
              <span class="help-inline"><?php echo form_error('actividad');?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-lg-2 control-label" >Nombre:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="descripcion" name="descripcion" 
              placeholder="Escriba Nombre de la Actividad" 
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
            <label for="observacion" class="col-lg-2 control-label">Observaciones:</label>
            <div class="col-lg-8">
              <textarea class="form-control" id="observacion" rows="3" name="observacion" maxlenght="500"
              placeholder="Escriba las Observaciones de la Actividad" style="resize:none"
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
            <label for="realizada" class="col-lg-2 control-label">Realizada:</label>
            <div class="col-lg-3" >
                <input type="checkbox" class="form-control" id="realizada" name="realizada"
                style="width: 20px; height: 20px; align:left;"
                  <?php
                    if($product[0]['realizada'] !== NULL){
                      if($product[0]['realizada'] == 1){
                        echo 'checked';
                      }
                    }else{
                      if($realizada !== NULL){
                        if($realizada == 1){
                          echo 'checked';
                        }
                      }
                    } 
                  ?> 
              </div>
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