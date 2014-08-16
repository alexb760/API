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
            echo '<strong>Proceso Exitoso!</strong> Nuevo Estado';
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
      
      echo form_open('index.php/adminapp/admin_estado/add', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Descripcion</label>
            <div class="controls">
              <input type="text" id="decripcion" name="descripcion" value="<?php echo set_value('descripcion'); ?>" 
              style="margin: 0px; width: 512px; height: 20px;">
            </div>
          </div> 
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset">Cancelar</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>