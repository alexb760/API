    <div class="container top">
    <div class="row">  
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
          <a href="#">New</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Adding <?php echo ucfirst($this->uri->segment(2));?>
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
      $options_manufacture = array('' => "Select");
      /*foreach ($manufactures as $row)
      {
        $options_manufacture[$row['id']] = $row['name'];
      }*/

       echo form_open('index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/add', $attributes);
      ?>
        <fieldset>
        <div class="col-xs-8">
          <div class="form-group">
            <label for="nombre_grupo" class="col-lg-2 control-label">Nombre Grupo<em class="">* :</em></label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="nombre_grupo" name="nombre_grupo"
               placeholder="Digite el nombre de su grupo" 
              value="<?php echo set_value('nombre_grupo'); ?>" >
              <span class="help-inline"><?php echo form_error('nombre_grupo'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="sigla" class="col-lg-2 control-label">Sigla<em>* :</em></label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="sigla" name="sigla"
               placeholder="Digite su Sigla del Grupo " 
              value="<?php echo set_value('sigla'); ?>" >
             <span class="help-inline"><?php echo form_error('sigla'); ?></span>
            </div>
            </div>  
             <div class="form-group">
            <label for="pagina_web" class="col-lg-2 control-label">Pagina WEB: </label>
            <div class="col-lg-8">
              <input type="url" class="form-control" id="pagina_web" name="pagina_web"
               placeholder="Digite su página WEB Ejem: http://mipagina.com.co"
               pattern="https?://.+" 
              value="<?php echo set_value('pagina_web'); ?>" >
               <span class="help-inline"><?php echo form_error('pagina_web'); ?></span>
            </div> 
            </div>
             <div class="form-group">
            <label for="correo" class="col-lg-2 control-label">Correo<em>* :</em></label>
            <div class="col-lg-8">
              <input type="email" class="form-control" id="correo" name="correo"
               placeholder="Digite su Correo Electronico" 
              value="<?php echo set_value('correo'); ?>" >
               <span class="help-inline"><?php echo form_error('correo'); ?></span>
            </div>
            </div>
            <div class="form-group">
            <label for="path_colciencias" class="col-lg-2 control-label">link Colciencias: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="path_colciencias" name="path_colciencias"
               placeholder="Digite su link colciencias"
               pattern="https?://.+"  
              value="<?php echo set_value('path_colciencias'); ?>" >
               <p class="help-block">Link de Colciencias del Grupo, [ Opcional ].</p>
               <span class="help-inline"><?php echo form_error('path_colciencias'); ?></span>
            </div>
            </div>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset" value="Reset">Cancelar</button>
          </div>
          </div>  
    </div>
  
  <div class="col-xs-4">
  <div class="form-group">
    <label for="facultad">Facultad: </label>
    <?php
            echo '<select class="form-control" name="facultad" id="facultad">';
            echo '<option value="">Seleccine una Facultad</option>';
            foreach ($facultad as $row) {
              echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
            }
            echo '</select>';
            echo '<span class="help-inline">'. form_error('facultad') .'</span>';   
          ?>
  </div>  
  <div class="form-group">
  <label for="pagina_web_d" >Página Web Director: </label>
    <input type="url" class="form-control" id="pagina_web_d" name="pagina_web_d"
     placeholder="Digite su página WEB Ejem: http://mipagina.com.co"
     pattern="http?://.+" 
    value="<?php echo set_value('pagina_web_d'); ?>" >
    <em class="help-block">Link de Colciencias del direcctor, [ Opcional ].</em>
     <span class="help-inline"><?php echo form_error('pagina_web_d'); ?></span>
  </div>
    <div class="form-group">
    <label for="linea_investigacion" class="control-label">Linea Investigacion</label>
      <select class="form-control" name="linea_investigacion">
      <?php 
      echo '<option value="">seleccione</option>';
      foreach ($lineas as $key) {
        echo '<option value="'.$key['id'].'">'.$key['linea'].'</option>';
              } ?>  
      </select>
      <?php echo form_error('linea_investigacion'); ?>
  </div>
  </div><?php echo form_close(); ?>
</fieldset>
</div> <!--Fin Row--> 
</div>
     