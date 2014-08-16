    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2).'/?smr='.$id_menu; ?>">
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
        echo mensaje_response($flash_message, '');
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'role'=>'form', 'id' => '');

      //form validation
      
      echo form_open('index.php/adminapp/admin_linea_investigacion/add', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="linea" class="col-lg-2 control-label">Linea: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="linea" name="linea"
               placeholder="Digite linea de Investigacion" 
              value="<?php echo set_value('linea'); ?>" >
              <span class="help-inline"><?php echo form_error('linea'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="descripcion" class="col-lg-2 control-label">Descripcion: </label>
            <div class="col-lg-8">
              <textarea class="form-control input-xlarge"  id="descripcion" rows="6" 
              name="descripcion" value="<?php echo set_value('descripcion'); ?>"></textarea>
              <span class="help-inline"><?php echo form_error('descripcion'); ?></span>
            </div>
          </div> 
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset">Cancelar</button>
          </div>
          </div>  <?php echo form_close(); ?>
        </fieldset>

    </div>
     