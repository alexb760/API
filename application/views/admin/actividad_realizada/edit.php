<div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst("Inicio"); 
            //echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst("Actividades Realizadas");
            //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Actualizar <?php echo ucfirst("Actividad Realizada"); ?>
        </h2>
      </div>
 
      <?php
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Actualizado!</strong> Actividad Realizada actualizada con exito.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Ops!</strong> No se realizò la actualizaciòn.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");
      echo form_open($url, $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="actividad" class="col-lg-2 control-label">Actividad:</label>
            <div class="col-lg-8">
              <select name="actividad" id="actividad" class="form-control">  
              <?php 
                if($product[0]['IdActividad'] !== NULL){
                  foreach ($product as $prod) {
                  echo '<option value="'.$prod['IdActividad'].'">'.$prod['Actividad'].'</option>';
                } 
              }else{
                foreach ($actividades as $acti) {
                  if($acti['IdActividad'] === $actividadV){
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
            <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
            <div class="col-lg-8">
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
              value="<?php 
                      if($product[0]['fecha_fin'] !== NULL){
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
              <select name="responsable" id="responsable" class="form-control">  
              <?php 

                if($product[0]['IdIntegrante'] !== NULL){
                  foreach ($product as $prod) {
                  echo '<option value="'.$prod['IdIntegrante'].'">'.$prod['Usuario'].'</option>';
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
                foreach ($integrantes as $inte) {
                  if($inte['IdIntegrante'] !== $responsableV){
                    echo '<option value="'.$inte['IdIntegrante'].'">'.$inte['Usuario'].'</option>';
                  }
                }
              }
                ?> 
              </select>
              <span class="help-inline"><?php echo form_error('responsable');?></span>
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