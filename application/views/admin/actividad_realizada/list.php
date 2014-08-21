<link href="<?php echo base_url(); ?>assets/css/admin/bootstrap3-1/css/bootstrap.css" rel="stylesheet" type="text/css">
<!--<link href="<?php echo base_url(); ?>assets/css/admin/bootstrap.css" rel="stylesheet" type="text/css">-->
<style type="text/css">
.bootstrap-bar{margin: 40px;}
</style>
<div class="container top">
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php //echo ucfirst($this->uri->segment(1));
            echo ("Inicio");
            ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php //echo ucfirst($this->uri->segment(2));
          echo ("Actividades Realizadas");
          ?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php //echo ucfirst($this->uri->segment(1));
          echo ("Actividades Realizadas");
          ?> 
          <a  href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>

      <div class="bootstrap-bar" align="center">
          <label style="align-text:center"><?php echo "Actividades Realizadas ".$realizadas." de ".$activas." Actividades Vigentes" ?></label>
        <div class="progress progress-striped active">
          <span class="sr-only">70% completo</span>
          <div id="pro" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="30" aria-valuemin="0" 
                aria-valuemax="100" style="width:<?php echo $ActividadesR?>%;">
                <label><?php echo $ActividadesR.'%' ?></label>
          </div>
        </div>  
      </div>

      <div class="row">
        <div class="span12 columns">
          <div class="well">
            <?php
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
            $options_manufacture = array(0 => "all");
            $options_products = array();    
              foreach ($products as $array) {
                foreach ($array as $key => $value) {
                  $options_products[$key] = $key;
                }
                break;
              }
              echo form_open('adminapp/admin_usuario', $attributes);
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 170px; height: 26px;"');
              echo form_label('Filter by manufacturer:', 'manufacture_id');
              echo form_dropdown('manufacture_id', $options_manufacture, $manufacture_selected, 'class="span2"');
              echo form_label('Order by:', 'order');
              echo form_dropdown('order', $options_products, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
              echo form_submit($data_submit);
              echo form_close();
            ?>
          </div>
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">id</th>
                <th class="yellow header headerSortDown">Nombre Actividad</th>
                <th class="red header">Fecha Fin</th>
                <th class="blue header">Responsable</th>
                <th class="blue header">Valor</th>
                <th class="blue header">Ejecutada</th>
                <th class="blue header">Observacion</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($products as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['idR'].'</td>';
                echo '<td>'.$row['nombreA'].'</td>';
                echo '<td>'.$row['fecha_fin'].'</td>';
                echo '<td>'.$row['nombreU'].'</td>';
                echo '<td>'.$row['valor'].'</td>';
                echo '<td>'.$row['ejecutada'].'</td>';
                echo '<td>'.$row['observacion'].'</td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("index.php/adminapp").'/'.$this->uri->segment(2).'/update/?ael='.base64_encode($row['idR']).
                  '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>  
                  <a href="'.site_url("index.php/adminapp").'/products/delete/'.$row['idR'].
                  '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-remove-sign"></span></a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>
          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>
      </div>
    </div>