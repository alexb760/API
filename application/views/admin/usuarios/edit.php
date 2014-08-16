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

      echo form_open('index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/update/'.$this->uri->segment(4), $attributes);
      ?>
        <fieldset>
         <div class="form-group">
            <label for="cedula" class="col-lg-2 control-label">Cedula: </label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="cedula" name="cedula" min="1" disabled
               placeholder="Digite su Documento de Identidad" 
              value="<?php echo $usuario[0]['cedula']; ?>">
              <span class="help-inline"><?php echo form_error('cedula'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="codigo" class="col-lg-2 control-label">Codigo: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="codigo" name="codigo" min="0" disabled
               placeholder="Digite su Código  deEstudiante" 
              value="<?php echo $usuario[0]['codigo']; ?>" >
             <span class="help-inline"><?php echo form_error('codigo'); ?></span>
            </div>
            </div>  
             <div class="form-group">
            <label for="nombres" class="col-lg-2 control-label">Nombres: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="nombres" name="nombres"
               placeholder="Digite su Nombre" 
              value="<?php echo $usuario[0]['nombre']; ?>" >
               <span class="help-inline"><?php echo form_error('nombre'); ?></span>
            </div> 
            </div>
            <div class="form-group">
            <label for="apellido" class="col-lg-2 control-label">Apellidos: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="apellido" name="apellido"
               placeholder="Digite su Apellido" 
              value="<?php echo $usuario[0]['apellido']; ?>" >
              <span class="help-inline"><?php echo form_error('apellido'); ?></span>
            </div> 
            </div>
            <div class="form-group">
            <label for="direccion" class="col-lg-2 control-label">Direccion: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="direccion" name="direccion"
               placeholder="Digite su Dirección" 
              value="<?php echo $usuario[0]['direccion']; ?>" >
               <span class="help-inline"><?php echo form_error('direccion'); ?></span>
            </div>
            </div>
            <div class="form-group">
            <label for="telefono" class="col-lg-2 control-label">Teléfono: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="telefono" name="telefono"
               placeholder="Digite su Telefono" 
              value="<?php echo $usuario[0]['telefono']; ?>" >
               <span class="help-inline"><?php echo form_error('telefono'); ?></span>
            </div>
            </div> 
             <div class="form-group">
            <label for="correo" class="col-lg-2 control-label">Correo: </label>
            <div class="col-lg-8">
              <input type="email" class="form-control" id="correo" name="correo"
               placeholder="Digite su Correo Electronico" 
              value="<?php echo $usuario[0]['correo']; ?>" >
               <span class="help-inline"><?php echo form_error('correo'); ?></span>
            </div>
            </div>   
          <?php
          echo '<div class="form-group">';
            echo '<label for="rol_usuario" class="col-lg-2 control-label">Rol Usuario: </label>';
            echo '<div class="col-lg-8">';
            echo '<select name="rol_usuario" id="rol_usuario">';
            echo '<option value="">Seleccine un Rol</option>';
            foreach ($options_rol as $row) {
              echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
            }
            echo '</select>';
            echo '<span class="help-inline">'. form_error('rol_usuario') .'</span>';    
            echo '</div>';
          echo '</div>';
          ?>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset">Cancelar</button>
          </div>
          </div>  <?php echo form_close(); ?>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     