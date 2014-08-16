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
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> product updated with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
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

      echo form_open('index.php/adminapp/admin_proyecto_investigacion/add'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Nombre</label>
            <div class="controls">
              <input type="text" id="nombre" name="nombre_pro" value="<?php echo $product[0]['nombre_pro']; ?>" 
              style="margin: 0px; width: 512px; height: 20px;">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Descripcion</label>
            <div class="controls">
              <textarea class="input-xlarge" id="descripcion" rows="3" style="margin: 0px; width: 512px; height: 120px;"
              name="descripcion"><?php echo $product[0]['descripcion']; ?></textarea>
            </div>
          </div> 
          <div class="control-group">
            <label for="inputError" class="control-label">Sigla</label>
            <div class="controls">
              <input type="text" id="sigla" name="sigla" value="<?php echo $product[0]['sigla']; ?>" 
              style="margin: 0px; width: 512px; height: 20px;">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Objetivo</label>
            <div class="controls">
              <textarea class="input-xlarge" id="objetivo" rows="3" style="margin: 0px; width: 512px; height: 120px;"
              name="objetivo"><?php echo $product[0]['objetivo']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Fecha Caduca</label>
            <div class="controls">
              <input type="datetime" id="fecha_caduca" style="margin: 0px; width: 512px; height: 20px;"
              name="fecha_caduca" value="<?php echo $product[0]['fecha_caducado']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Linea Investigación</label>
            <div class="controls">
              <select name="linea_investigacion" style="margin: 0px; width: 300px; height: 25px;"> 
                <?php
                  foreach ($linea as $lin) {
                    echo '<option value="'.$lin['id'].'">'.$lin['tema'].'</option>';
                  }
                  foreach ($lineas as $key) {
                    if($key['id']!=$lin['id']){
                    echo '<option value="'.$key['id'].'">'.$key['tema'].'</option>';
                    }
                  }
                  ?>
               
              </select>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Grupo</label>
            <div class="controls">
              <select name="grupo" style="margin: 0px; width: 300px; height: 25px;"
              value="<?php echo $product[0]['linea_investigacion_id']; ?>"> 
              <?php
                  foreach ($grupo as $grup) {
                    echo '<option value="'.$grup['id'].'">'.$grup['nombre_grupo'].'</option>';
                  }
                  foreach ($grupos as $grups) {
                    if($grups['id']!=$grup['id']){
                    echo '<option value="'.$grups['id'].'">'.$grups['nombre_grupo'].'</option>';
                    }
                  }
                  ?>
              </select>
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