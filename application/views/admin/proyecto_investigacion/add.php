<div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Nuevo</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Nuevo <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
 
      <?php
      //flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Proceso Exitoso!</strong> Nuevo Proyecto Investigacion';
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
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");

      //form validation
      echo validation_errors();
      
      echo form_open('index.php/adminapp/admin_proyecto_investigacion/add', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="nombre" class="col-lg-2 control-label">Nombre:</label>
           <div class="col-lg-8">
              <input class="form-control" type="text" id="nombre" name="nombre_pro" value="<?php echo set_value('tema'); ?>" 
			  placeholder="Escriba el nombre del Proyecto">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-lg-2 control-label">Descripcion:</label>
            <div class="col-lg-8">
              <textarea class="form-control input-xlarge"  id="descripcion" rows="4" 
              name="descripcion" value="<?php echo set_value('descripcion'); ?>"></textarea>
            </div>
          </div> 
          <div class="form-group">
            <label for="sigla" class="col-lg-2 control-label">Sigla</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" id="sigla" name="sigla" 
			  value="<?php echo set_value('sigla'); ?>">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="form-group">
            <label for="objetivo" class="col-lg-2 control-label">Objetivo:</label>
            <div class="col-lg-8">
              <textarea class="form-control input-xlarge"  id="objetivo" rows="4" 
              name="descripcion" value="<?php echo set_value('objetivo'); ?>"></textarea>
            </div>
          </div>
			<!--		  
          <div class="form-group">
            <label for="fecha" class="control-label">Fecha Caduca</label>
            <div class="controls">
              <input type="date" id="fecha_caducado" 
              name="fecha_caducado" value="<?php echo set_value('fecha_caducado'); ?>">
            </div>
          </div>-->
          <div class="form-group">
            <label for="linea_investigacion" class="col-lg-2 control-label">Linea Investigacion</label>
            <div class="col-lg-8">
              <select class="form-control" name="linea_investigacion">
              <?php 
              echo '<option value="">seleccione</option>';
              foreach ($lineas as $key) {
                echo '<option value="'.$key['id'].'">'.$key['tema'].'</option>';
              } ?>  
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="grupo" class="col-lg-2 control-label">Grupo</label>
            <div class="col-lg-8">
              <select class="form-control" name="grupo" >  
              <?php 
              echo '<option value="">seleccione</option>';
              foreach ($grupos as $grup) {
                echo '<option value="'.$grup['id'].'">'.$grup['nombre_grupo'].'</option>';
              } ?> 
              </select>
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

      

    </div>