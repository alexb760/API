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
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
     if($this->session->flashdata('flash_message')){
        $tmp = $this->session->flashdata('flash_message');
        echo mensaje_response($tmp, '');
        }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      //form validation
      echo validation_errors();

      echo form_open('index.php/adminapp/admin_linea_investigacion/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
         <div class="form-group">
            <label for="cedula" class="col-lg-2 control-label">Linea:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="linea" name="linea"
              value="<?php echo $linea[0]['linea']; ?>">
              <span class="help-inline"><?php echo form_error('linea'); ?></span>
            </div>
          </div>

         <div class="form-group">
            <label for="cedula" class="col-lg-2 control-label">Descripción:</label>
            <div class="col-lg-8">
              <textarea class="form-control"  rows="4"  id="descripcion" name="descripcion"
              value=""><?php echo $linea[0]['descripcion']; ?></textarea>
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
     