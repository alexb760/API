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
      //form data   , 'enctype'=>'multipart/form-data'
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      
      echo form_open_multipart('index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/update/'.$this->uri->segment(4), $attributes);
      ?>
        <fieldset>
          <div class="form-group">
            <label for="nombre_pro" class="col-lg-2 control-label">Descarga de Formatos:</label>
           <div class="col-lg-8">
              <div class="span3">
                <a href="<?php echo base_url(); ?>assets/downloads/formatos/f1.pdf" target="_blank" class="btn btn-default"> 
                  <span class="glyphicon glyphicon-random"></span> Formato 1 </a>
                <a href="<?php echo base_url(); ?>assets/downloads/formatos/f2.pdf" class="btn btn-primary"> 
                  <span class="glyphicon glyphicon-download-alt"></span> Formato 1 </a>
                <a href="<?php echo base_url(); ?>assets/downloads/formatos/REQUERIMIENTOS.docx" class="btn btn-primary"> 
                  <span class="glyphicon glyphicon-download-alt"></span> Formato 1 </a>
              </div>
              <p class="help-block">Favor descargar los formatos y diligenciarlos puntualmente.<br>
                                    es de vital importancia el contenido claro y conciso de estos documentos. <br>
                                    <strong>Adjuntar los archivos correctamente diligenciados.</strong>, [ Obligatorio ].</p>
            </div>
          </div>


          <div class="form-group">
            <label for="nombre_pro" class="col-lg-2 control-label">Nombre:</label>
           <div class="col-lg-8">
              <input class="form-control" type="text" id="nombre_pro" name="nombre_pro" 
                value="<?php echo $product[0]['nombre_pro']; ?>" 
               placeholder="Escriba el nombre del Proyecto">
              <span class="help-inline"><?php echo form_error('nombre_pro'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-lg-2 control-label">Descripcion:</label>
            <div class="col-lg-8">
              <textarea class="form-control input-xlarge"  id="descripcion" rows="4" 
              name="descripcion" value=""><?php  echo $product[0]['descripcion']; ?></textarea>
            </div>
          </div> 
          <div class="form-group">
            <label for="sigla" class="col-lg-2 control-label">Sigla</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" id="sigla" name="sigla" 
              value="<?php  echo $product[0]['sigla']; ?>">
              <span class="help-inline"><?php echo form_error('sigla'); ?></span>
            </div>
          </div>
         <div class="form-group">
            <label for="objetivo" class="col-lg-2 control-label">Objetivo:</label>
            <div class="col-lg-8">
              <textarea class="form-control input-xlarge"  id="objetivo" rows="4" 
              name="objetivo" value=""><?php echo $product[0]['objetivo']; ?></textarea>
              <span class="help-inline"><?php echo form_error('objetivo'); ?></span>
            </div>
          </div>
            <div class="form-group">
            <label for="upload_file" class="col-lg-2 control-label">Adjuntar Archivo:</label>
            <div class="col-lg-8">
             <input type="file" class="form-control"  name= "upload_file"
             value="<?php echo set_value('upload_file'); ?>">
              <span class="help-inline"><?php echo form_error('upload_file'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn" type="reset">Cancelar</button>
          </div>
          </div><?php echo form_close(); ?>
        </fieldset>

    </div>