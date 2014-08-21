<div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo "Inicio"; 
            //echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo "Sub Actividades"; 
          //echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo "Sub Actividades"; 
          //echo ucfirst($this->uri->segment(2));?> 
          <a  href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
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
                <th class="yellow header headerSortDown">Nombre</th>
                <th class="green header">Fecha Inicio</th>
                <th class="red header">Fecha Fin</th>
                <th class="blue header">Observacion</th>
                <th class="blue header">Actividad</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($products as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['idS'].'</td>';
                echo '<td>'.$row['descripcion'].'</td>';
                echo '<td>'.$row['fecha_inicio'].'</td>';
                echo '<td>'.$row['fecha_fin'].'</td>';
                echo '<td>'.$row['observacion'].'</td>';
                echo '<td>'.$row['nombreA'].'</td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("index.php/adminapp").'/'.$this->uri->segment(2).'/update/?ael='.base64_encode($row['idS']).
                  '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>  
                  <a href="'.site_url("index.php/adminapp").'/products/delete/'.base64_encode($row['idS']).
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