<div class="container top">
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst("Inicio"); ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst("Presupuesto");?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Actualizar</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2> Actualizar <?php echo ucfirst("Presupuesto"); ?></h2>
      </div>
 
      <?php
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Actualizado!</strong> Presupuesto actualizado con exito.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'not_calculate'){
          echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Ops!</strong> El valor debe ser mayor al de las actividades asociadas!.';
          echo '</div>';          
        }else{
          echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Ops!</strong> No se realizò la actualizaciòn.';
          echo '</div>';
        }
      }
      ?>
      
      <?php
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");
      echo form_open('index.php/adminapp/admin_presupuesto/update/'.$url.'', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
            <div class="col-lg-8">
              <select name="grupo" id="grupo" class="form-control" >  
              <?php 
              if($product[0]['nombreG'] !== NULL){
                echo '<option value="'.$product[0]['grupo_id'].'">'.$product[0]['nombreG'].'</option>';
              }else{
              foreach($grupo as $grup) {
                if($grup['idGrupo'] === $grupoV){
                  echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
                }
              }
            } 
              ?> 
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="valor" class="col-lg-2 control-label" >Valor:</label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="valor" name="valor" min="50" step="50" required
              placeholder="Ingrese valor sin puntos ni comas." pattern="[0-9]*" title="Ingrese valor sin puntos ni comas."
              value="<?php 
                    if($product[0]['valor'] != NULL){
                      echo $product[0]['valor'];
                    }else{
                      echo set_value('valor');
                    }
                ?>">
                <span class="help-inline"><?php echo form_error('valor');?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="fecha_inicio" class="col-lg-2 control-label" >Fecha Inicio:</label>
            <div class="col-lg-8">
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required
               title="Se requiere fecha de inicio." value="<?php 
                    if($product[0]['fecha_inicio'] != NULL){
                      echo $product[0]['fecha_inicio'];
                    }else{
                      echo set_value('fecha_inicio');
                    }
                ?>">
                <span class="help-inline"><?php echo form_error('fecha_inicio');?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
            <div class="col-lg-8">
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required
               title="se requiere fecha fin." value="<?php 
                    if($product[0]['fecha_fin'] != NULL){
                      echo $product[0]['fecha_fin'];
                    }else{
                      echo set_value('fecha_fin');
                    }
                ?>">
                <span class="help-inline"><?php echo form_error('fecha_fin');?></span>
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