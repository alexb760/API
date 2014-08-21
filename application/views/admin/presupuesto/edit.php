<div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst("Inicio"); 
            //echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst("Presupuesto");
            //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Actualizar</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Actualizar <?php echo ucfirst("Presupuesto"); 
          //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Actualizado!</strong> Presupuesto actualizado con exito.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Ops!</strong> No se realizò la actualizaciòn.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");
      echo validation_errors();
      echo form_open('index.php/adminapp/admin_presupuesto/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="fecha_inicio" class="col-lg-2 control-label" >Fecha Inicio:</label>
            <div class="col-lg-8">
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
              placeholder="" value="">
              <?php //echo $product[0]['fecha_fin'];?>
            </div>
          </div>
          <div class="form-group">
            <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
            <div class="col-lg-8">
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
              placeholder="" value="<?php echo set_value('fecha_fin'); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="valor" class="col-lg-2 control-label" >Valor:</label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="valor" name="valor" 
              placeholder="" value="<?php echo set_value('valor'); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="autoriza" class="col-lg-2 control-label">Autoriza:</label>
            <div class="col-lg-8">
              <select name="autoriza" id="autoriza" class="form-control" >  
              <?php 
              echo '<option value="">Seleccione</option>';
              /*foreach ($actividad as $acti) {
                echo '<option value="'.$acti['IdActividad'].'">'.$acti['Actividad'].'</option>';
              } */
                //echo form_open('index.php/adminapp/admin_actividad_realizada/responsableActividad', $attributes);
              ?> 
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
            <div class="col-lg-8">
              <select name="grupo" id="grupo" class="form-control" >  
              <?php 
              echo '<option value="">Seleccione</option>';
              /*foreach ($actividad as $acti) {
                echo '<option value="'.$acti['IdActividad'].'">'.$acti['Actividad'].'</option>';
              } */
                //echo form_open('index.php/adminapp/admin_actividad_realizada/responsableActividad', $attributes);
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