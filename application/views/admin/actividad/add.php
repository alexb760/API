<script type="text/javascript">
  /*function Abrir(idactividad){
      window.open("http://localhost/app/index.php/adminapp/admin_sub_actividad/add/?ael="+idactividad,"SUB ACTIVIDAD", "width=1000, height=700, top=20, left=40, scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES, location=YES, status=NO,resizable=NO");
    }*/

    function GrupoInfo(){
      xmlhttp = null;

      if(window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
      }else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
          document.getElementById("responsable").innerHTML = xmlhttp.responseText;
        }
      }
      var url = location.href;
      xmlhttp.open("GET",url, true);
      xmlhttp.send();
    }

    function inhabilitarCampos(){
      document.getElementById("grupo").disabled = true ;
      document.getElementById("descripcion").disabled = true;
      document.getElementById("fecha_inicio").disabled = true;
      document.getElementById("fecha_fin").disabled = true;
      document.getElementById("duracion").disabled = true;
      document.getElementById("observacion").disabled = true;
      document.getElementById("responsable").disabled = true;
      document.getElementById("btnGuardar").disabled = true;
    }

    function showModal(){
          $('#subActividad').modal('show');
          document.getElementById("subdescripcion").value = "";
          document.getElementById("subfecha_inicio").value = "";
          document.getElementById("subfecha_fin").value = "";
          document.getElementById("subobservacion").value = "";
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
          echo ("Actividades");
        ?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      <a href="#">Nuevo</a>
    </li>
  </ul>
      
  <div class="page-header">
    <h2> Nueva <?php echo ("Actividad");?> </h2>
  </div>
  
  <br>
  <div class="modal fade" id="subActividad">
    <script type="text/javascript">
      function showDivs(div){
        var divDanger = document.getElementById("divDanger");
        var divWarning = document.getElementById('divWarning');
        var divInfo = document.getElementById("divInfo");
        var divSuccess = document.getElementById("divSuccess");
        var divHide = document.getElementById(div);//id del que se va a mostrar

        $(divSuccess).hide();
        $(divDanger).hide();
        $(divInfo).hide();
        $(divWarning).hide();
        $(divHide).show();//el que se muestra
      }

      function DropData(){
        document.getElementById("subdescripcion").value = "";
        document.getElementById("subfecha_inicio").value = "";
        document.getElementById("subfecha_fin").value = "";
        document.getElementById("subobservacion").value = "";
      }

      function showPrueba(){
        var xmlhttp = null;
        var nombre = document.getElementById("subdescripcion").value;
        var fechaI = document.getElementById("subfecha_inicio").value;
        var fechaF = document.getElementById("subfecha_fin").value;
        var subobser = document.getElementById("subobservacion").value;
        var fechaFA = document.getElementById("fecha_fin").value;
        var fechaIA = document.getElementById("fecha_inicio").value;

        if(window.ActiveXObject){
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }else{
          if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
          }
        }

        xmlhttp.onreadystatechange = function(){
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            $('#modal2').modal('show');

            var str = xmlhttp.responseText;
            var val = str.substring(0,1);
            var res = str.substring(3, xmlhttp.responseText.length);
              
              if(val == "3"){
                showDivs("divSuccess");
                document.getElementById("divSuccess").innerHTML = res;
                DropData();
              }else if(val == "2"){
                showDivs("divInfo");
                document.getElementById("divInfo").innerHTML = res;
              }else if(val == "1"){
                showDivs("divWarning");
                document.getElementById("divWarning").innerHTML = res;
              }else{
                showDivs("divDanger");
                document.getElementById("divDanger").innerHTML = res;// "Error al guardar!";
              }
          }
        }
        
          var url = location.href;
          var idA = "<?php echo $idactividad; ?>";
          xmlhttp.open("GET",url+"Sub?n="+nombre+"&fi="+fechaI+"&ff="+fechaF+"&ob="+subobser+"&idAct="+idA+"&ffa="+fechaFA+"&fia="+fechaIA,true);
          xmlhttp.send();
        }
    </script>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-tittle">Sub Actividad</h4>
        </div>
        <div class="modal-body">
          <fieldset>
            <br> 
            <div class="form-group">
              <label for="descripcion" class="col-lg-2 control-label" >Nombre:</label>
              <div class="col-lg-8">
                <input type="text" class="form-control" id="subdescripcion" name="subdescripcion" maxlenght="150" 
                placeholder="Escriba nombre de la sub actividad" value="<?php echo set_value('subdescripcion'); ?>" required>
              </div>
            </div>
            <br> <br> 
            <div class="form-group">
              <label for="subfecha_inicio" class="col-lg-2 control-label" >Fecha Inicio:</label>
              <div class="col-lg-8">
                <input type="date" class="form-control" id="subfecha_inicio" name="subfecha_inicio" required
                placeholder="" value="<?php echo set_value('subfecha_inicio'); ?>">
              </div>
            </div>
            <br> <br>
            <div class="form-group">
              <label for="fecha_fin" class="col-lg-2 control-label" >Fecha Fin:</label>
              <div class="col-lg-8">
                <input type="date" class="form-control" id="subfecha_fin" name="subfecha_fin" 
                placeholder="" value="<?php echo set_value('fecha_fin'); ?>" >
              </div>
            </div>
            <br> <br>
            <div class="form-group">
              <label for="subobservacion" class="col-lg-2 control-label">Observaciones:</label>
              <div class="col-lg-8">
                <textarea class="form-control" id="subobservacion" rows="3" name="subobservacion"
                placeholder="Escriba las Observaciones de la Actividad" style="resize:none" maxlength="500"
                value=""><?php echo set_value('subobservacion'); ?></textarea>
              </div>
            </div>
            <br> <br>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button id="ale" onclick="showPrueba()" type="submit" class="btn btn-primary">Guardar</button>
          <button data-dismiss="modal" class="btn">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade modal-two" id="modal2">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      <br>
        <div class="modal-body">
          <div id="divDanger" style="display:none" class="alert alert-danger"></div>
          <div id="divWarning" style="display:none" class="alert alert-warning"></div>
          <div id="divInfo" style="display:none" class="alert alert-info"></div>
          <div id="divSuccess" style="display:none" class="alert alert-success"></div>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" type="submit" class="btn btn-primary">OK</button>
        </div>
      </div>
    </div>
  </div>

  <?php
    if($this->session->flashdata('flash_message')){
      if($this->session->flashdata('flash_message') == 'add')
      {
        echo '<div class="alert alert-success">';
          echo '<a class="close" data-dismiss="alert">&times;</a>';
          echo '<strong>Proceso Exitoso!</strong> Actividad guardada con exito!.';
        echo '</div>';       
      }else{
        echo '<div class="alert alert-danger">';
          echo '<a class="close" data-dismiss="alert">&times;</a>';
          echo '<strong>Ops!</strong> Valida los datos e intenta de Nuevo.';
        echo '</div>';          
        }
    }

    if($idactividad > 0) {
      echo '<ul class="nav nav-tabs">';
        echo "<li>";
          echo "<a  href=javascript:showModal()>Sub Actividad</a>";
        echo "</li>";
      echo '</ul>';
    }
      
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    $options_manufacture = array('' => "Select");

    echo form_open('index.php/adminapp/admin_actividad/add', $attributes);
    ?>
    <fieldset>
      <div class="form-group">
        <label for="grupo" class="col-lg-2 control-label">Grupo:</label>
        <div class="col-lg-8">
          <select name="grupo" id="grupo" class="form-control">  
            <?php 
            if($product[0]['nombreG'] != NULL){
              foreach ($product as $prod) {
                echo '<option value="'.$prod['idG'].'">'.$prod['nombreG'].'</option>';
              }
            }else{
              if($validator === 0){
                foreach ($grupo as $grup) {
                  if($grup['idGrupo'] === $grupoV){
                    echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
                  }
                }
                foreach ($grupo as $grup) {
                    if($grup['idGrupo'] !== $grupoV){
                      echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
                    }
                }
              }else{
                echo '<option value="0">Seleccione</option>';
                foreach ($grupo as $grup) {
                  echo '<option value="'.$grup['idGrupo'].'">'.$grup['nombreG'].'</option>';
                }
              }
            }?> 
          </select>
          <span class="help-inline"><?php echo form_error('grupo');?></span>
        </div>
      </div>
      <div class="form-group">
        <label for="descripcion" class="col-lg-2 control-label" >Nombre:</label>
        <div class="col-lg-8">
          <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="150" required
            placeholder="Escriba nombre de la actividad" title="Se requiere el nombre de actividad" 
            value="<?php 
            if($product[0]['descripcion'] != NULL){
              echo $product[0]['descripcion'];
            }else{
              echo set_value('descripcion');
            }
            ?>">
          <span id="spdescripcion"  class="help-inline"><?php echo form_error('descripcion');?></span>
        </div>
      </div>
      <div class="form-group">
        <label for="fecha_inicio" class="col-lg-2 control-label" >Fecha Inicio:</label>
        <div class="col-lg-8">
          <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required
            value="<?php 
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
            value="<?php 
              if($product[0]['fecha_fin'] != NULL){
                echo $product[0]['fecha_fin'];
              }else{
                echo set_value('fecha_fin');
              }
            ?>">
              <span id="sp" class="help-inline"><?php echo form_error('fecha_fin');?></span>
        </div>
      </div>
      <div class="form-group">
        <label for="duracion" class="col-lg-2 control-label" >Duración:</label>
        <div class="col-lg-8">
          <input type="number" class="form-control" id="duracion" name="duracion" required
            placeholder="Escriba la duración de la actividad en horas" min="1" 
            value="<?php 
              if($product[0]['duracion'] != NULL){
                echo $product[0]['duracion'];
              }else{
              echo set_value('duracion');
              }
            ?>">
          <span class="help-inline"><?php echo form_error('duracion');?></span>
        </div>
      </div>
      <div class="form-group">
        <label for="observacion" class="col-lg-2 control-label">Observaciones:</label>
        <div class="col-lg-8">
          <textarea class="form-control" id="observacion" rows="3" name="observacion" maxlength="500"
            placeholder="Escriba las observaciones de la actividad" style="resize:none"
            value=""><?php 
                if($product[0]['observacion'] != NULL){
                  echo $product[0]['observacion'];
                }else{
                  echo set_value('observacion');
                }
              ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="responsable" class="col-lg-2 control-label">Resposable:</label>
        <div class="col-lg-8">
          <select name="responsable" id="responsable" class="form-control" required>  
            <?php 
              if($product[0]['IdIntegrante'] != NULL){
                foreach ($product as $prod){
                  echo '<option value="'.$prod['IdIntegrante'].'">'.$prod['nombreU'].'</option>';
                }
             }else if($validator === 0){
                foreach ($integrantes as $inte) {
                  if($inte['IdIntegrante'] === $integranteV){
                    echo '<option value="'.$inte['IdIntegrante'].'">'.$inte['Usuario'].'</option>';
                  }
                }
                foreach ($integrantes as $inte) {
                    if($inte['IdIntegrante'] !== $integranteV){
                      echo '<option value="'.$inte['IdIntegrante'].'">'.$inte['Usuario'].'</option>';
                    }
                }
              }else{
                echo '<option value="">Seleccione</option>';
              }
            ?> 
          </select>
          <span class="help-inline"><?php echo form_error('responsable');?></span>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-8">
          <button id="btnGuardar" class="btn btn-primary" type="submit">Guardar</button>
          <button data-dismiss="container" class="btn" type="reset">Cancelar</button>
        </div>
      </div>
    </fieldset>
    <script type="text/javascript">
      $('#grupo').on('change', buscarResponsable);

      function buscarResponsable(){
        var urlR = location.href;

        $grupo = $('#grupo').val();

        if($grupo !== ""){
            $.ajax({
                dataType: "json",
                data: {"grupo": $grupo},
                url: urlR+'Responsable',
                type: 'post',
                beforeSend: function(){
                },
                success: function(respuesta){
                  $("#responsable").html(respuesta.html);
                },
                error: function(xhr,err){
                  alert("readyState: " + xhr.readyState + "\nstatus:" + xhr.status + "\n \n responseText: " + xhr.responseText);
                }
            });
        }
    }
    </script>
    <?php
     if($idactividad > 0) {
      echo '<script type="text/javascript">';
      echo 'inhabilitarCampos();';
      echo '</script>';
    }
    ?>
    <?php echo form_close(); ?>
</div>