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
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Proceso Exitoso!</strong> Nuevo Integrante';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
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
      
      echo form_open('index.php/adminapp/admin_integrante/add', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="descripcion" class="col-lg-2 control-label">Usuario:</label>
            <div class="col-lg-8">
              <select name="usuario_id" class="form-control">
                <?php
                echo '<option value="">Seleccione</option>';
                foreach ($usuarios as $usu) {
                  echo '<option value="'.$usu['id'].'">'.$usu['nombre'].'</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
            <div class="col-lg-8">
              <select name="grupo_id" class="form-control">
                <?php
                echo '<option value="">Seleccione</option>';
                foreach ($grupo as $grup) {
                  echo '<option value="'.$grup['id'].'">'.$grup['nombre'].'</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="activo" class="col-lg-2 control-label">Estado:</label>
            <div class="col-lg-8">
              <input type="text" id="activo" name="activo" class="form-control" 
              value="<?php echo set_value('activo')?>">
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
            <div class="checkbox">
              <label>
              <input type="checkbox" id="is_asesor" name="is_asesor" 
              value="<?php echo set_value('is_asesor')?>">Asesor:
            </label>
            </div>
          </div>
          </div>
          <div class="form-group">
            <label for="facultad" class="col-lg-2 control-label">Facultad:</label>
            <div class="col-lg-8">
              <select name="facultad_id" class="form-control">
                <?php
                echo '<option value="">Seleccione</option>';
                foreach ($facultad as $fac) {
                  echo '<option value="'.$fac['id'].'">'.$fac['nombre'].'</option>';
                }
                ?>
              </select>
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