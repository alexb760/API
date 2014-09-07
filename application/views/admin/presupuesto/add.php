<script type="text/javascript">
  function inhabilitarCampos(){
      document.getElementById("grupo").disabled = true ;
      document.getElementById("valor").disabled = true;
      document.getElementById("actividad").disabled = true;
      document.getElementById("valorActividad").disabled = true;
      document.getElementById("btnGuardar").disabled = true;
    }
</script>
<div class="container top">
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php 
              echo ("Inicio");
            ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>">
            <?php 
            echo ("Presupuesto");
            ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Nuevo</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Nuevo <?php 
          echo ("Presupuesto");
          ?>
        </h2>
      </div>
      <?php

      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
          echo '<a class="close" data-dismiss="alert">&times;</a>';
          echo '<strong>Proceso Exitoso!</strong> Nuevo Presupuesto.';
          echo '</div>';       
        }
        else{
          echo '<div class="alert alert-danger">';
          echo '<a class="close" data-dismiss="alert">&times;</a>';
          echo '<strong>Ops!</strong> Valida los datos e intenta de Nuevo.';
          echo '</div>'; 
        }

      }
      ?>
      <?php
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");

      echo form_open('index.php/adminapp/admin_presupuesto/add', $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
            <div class="col-lg-8">
              <select name="grupo" id="grupo" class="form-control" >  
              <?php 
              echo '<option value="">Seleccione</option>';
              foreach ($grupo as $grup) {
                echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
              } 
              ?> 
              </select>
              <span class="help-inline"><?php echo form_error('grupo');?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="valor" class="col-lg-2 control-label" >Valor:</label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="valor" name="valor" min="50" step="50" required
              placeholder="Ingrese valor sin puntos ni comas." pattern="[0-9]*" title="Ingrese valor sin puntos ni comas."
              value="<?php echo set_value('valor'); ?>">
              <span class="help-inline"><?php echo form_error('valor');?></span>
            </div>
          </div>
          
          <div class="form-group">
            <label for="actividad" class="col-lg-2 control-label">Actividad:</label>
            <div class="col-lg-8">
              <select name="actividad" id="actividad" class="form-control" title="Seleccione actividad">  
              <?php 
              echo '<option value="">Seleccione</option>';
              ?> 
              </select>
              <span class="help-inline"><?php echo form_error('actividad');?></span>
            </div>
          </div>
          
          <div class="form-group">
            <label for="valorActividad" class="col-lg-2 control-label" >Valor Actividad:</label>
            <div class="col-lg-8">
              <input type="number" class="form-control" id="valorActividad" name="valorActividad" min="50" step="50"
              placeholder="Ingrese valor sin puntos ni comas." pattern="[0-9]*" title="Ingrese valor sin puntos ni comas."
              value="<?php echo set_value('valorActividad'); ?>">
              <span class="help-inline"><?php echo form_error('valorActividad');?></span>
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
        <script type="text/javascript">
      $('#grupo').on('change', buscarActividad);

      function buscarActividad(){
        var urlR = location.href;

        $grupo = $('#grupo').val();

        if($grupo !== ""){
            $.ajax({
                dataType: "json",
                data: {"grupo": $grupo},
                url: urlR+'Actividad',
                type: 'post',
                beforeSend: function(){
                },
                success: function(respuesta){
                  $("#actividad").html(respuesta.html);
                },
                error: function(xhr,err){
                  alert("readyState: " + xhr.readyState + "\nstatus:" + xhr.status + "\n \n responseText: " + xhr.responseText);
                }
            });
        }
    }
  </script>
  <?php
     if($idPresupuesto > 0) {
      echo '<script type="text/javascript">';
      echo 'inhabilitarCampos();';
      echo '</script>';
    }
    ?>
      <?php echo form_close(); ?>
     </div>