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
          <a href="#">New</a>
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
        echo mensaje_response($flash_message, 'Nuevo Usuario Agregado');
      }
      ?>
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'role'=>'form', 'id' => '');
      //$options_rol = array('' => "Select");
      foreach ($options_rol as $row)
      {
        $options[$row['id']] = $row['nombre'];
      }

      //form validation
      //echo validation_errors();

      echo form_open('index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/add', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="cedula" class="col-lg-2 control-label">Cedula:</label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="cedula" name="cedula"
               placeholder="Digite su Documento de Identidad" required="required"
              value="<?php echo set_value('cedula'); ?>" >
              <span class="help-inline"><?php echo form_error('cedula'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="codigo" class="col-lg-2 control-label">Codigo:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="codigo" name="codigo"
               placeholder="Digite su Código  deEstudiante" 
              value="<?php echo set_value('codigo'); ?>" >
             <span class="help-inline"><?php echo form_error('codigo'); ?></span>
            </div>
            </div>  
             <div class="form-group">
            <label for="nombres" class="col-lg-2 control-label">Nombres:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="nombres" name="nombres"
               placeholder="Digite su Nombre" 
              value="<?php echo set_value('nombres'); ?>" >
               <span class="help-inline"><?php echo form_error('nombre'); ?></span>
            </div> 
            </div>
            <div class="form-group">
            <label for="apellido" class="col-lg-2 control-label">Apellidos:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="apellido" name="apellido"
               placeholder="Digite su Apellido" 
              value="<?php echo set_value('apellido'); ?>" >
              <span class="help-inline"><?php echo form_error('apellido'); ?></span>
            </div> 
            </div>
            <div class="form-group">
            <label for="direccion" class="col-lg-2 control-label">Direccion: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="direccion" name="direccion"
               placeholder="Digite su Dirección" 
              value="<?php echo set_value('direccion'); ?>" >
               <span class="help-inline"><?php echo form_error('direccion'); ?></span>
            </div>
            </div>
            <div class="form-group">
            <label for="telefono" class="col-lg-2 control-label">Teléfono: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="telefono" name="telefono"
               placeholder="Digite su Dirección" 
              value="<?php echo set_value('telefono'); ?>" >
               <span class="help-inline"><?php echo form_error('telefono'); ?></span>
            </div>
            </div> 
             <div class="form-group">
            <label for="correo" class="col-lg-2 control-label">Correo:</label>
            <div class="col-lg-8">
              <input type="email" class="form-control" id="correo" name="correo"
               placeholder="Digite su Correo Electronico" 
              value="<?php echo set_value('correo'); ?>" >
               <span class="help-inline"><?php echo form_error('correo'); ?></span>
            </div>
            </div> 
            <div class="form-group">
            <label for="login" class="col-lg-2 control-label">Login:</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="login" name="login"
               placeholder="Digite su Login De Usuario" 
              value="<?php echo set_value('login'); ?>" >
               <span class="help-inline"><?php echo form_error('login'); ?></span>
            </div>
            </div>
            <div class="form-group">
            <label for="clave" class="col-lg-2 control-label">Clave:</label>
            <div class="col-lg-8">
              <input type="password" class="form-control" id="clave" name="clave"
               placeholder="Digite su Clave De Usuario" 
              value="<?php echo set_value('clave'); ?>" >
               <span class="help-inline"><?php echo form_error('clave'); ?></span>
            </div>
            </div>   
          <?php
          echo '<div class="form-group">';
            echo '<label for="rol_usuario" class="col-lg-2 control-label">Rol Usuario<em>* :</em></label>';
            echo '<div class="col-lg-8">';
              
              echo form_dropdown('rol_usuario', $options, set_value('id'), 'class="form-control"');

            echo '</div>';
          echo '</div>';
          ?>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset" value="Reset">Cancelar</button>
          </div>
          </div>  <?php echo form_close();?>
        </fieldset>
    </div>
     