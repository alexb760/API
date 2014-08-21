<div class="container top">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo site_url("index.php/adminapp"); ?>">
        <?php echo ("Inicio"); ?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      <?php echo ("Actividades"); ?>
    </li>
  </ul>

  <div class="page-header users-header">
    <h2><?php echo ("Actividades"); ?> 
      <a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
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

      <?php
        if($products == null){
          echo  '<div class="alert bg-warning">';
            echo '<strong>Opps!: </strong>No hay datos de actividades...';
          echo '</div>';
        }
      ?>
          <!--<div class="table_responsive">
            <?php
              $parametros['site_url'] = site_url("index.php/adminapp");
              $parametros['segment'] = $this->uri->segment(2);
              //echo prin_table_horizontal($products, $permiso, $parametros);
            ?>
            <tfooter>
              <tr>
                <td colspan="3">
                  <span class="">
                    <?php //echo $count_products.' Registros'; ?>
                  </span>
                </td>
              </tr>
            </tfooter>
          </div>
          <div class="col-md-12">
            <?php //echo '<div class="pagination">'.($this->pagination->create_links()).'</div>'; ?>
          </div>-->
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th class="header">id</th>
            <th class="yellow header headerSortDown">Nombre</th>
            <th class="green header">Fecha Inicio</th>
            <th class="red header">Fecha Fin</th>
            <th class="red header">Duraciòn</th>
            <th class="blue header">Responsable</th>
            <th class="blue header">Grupo</th>
            <th class="blue header">Observaciòn</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $valor = 0;
            foreach($products as $row){
              echo '<tr>';
                echo '<td>'.$row['idA'].'</td>';
                echo '<td>'.$row['descripcion'].'</td>';
                echo '<td>'.$row['fecha_inicio'].'</td>';
                echo '<td>'.$row['fecha_fin'].'</td>';
                echo '<td>'.$row['duracion'].' Hora(s)</td>';
                echo '<td>'.$row['nombreU'].'</td>';
                echo '<td>'.$row['nombreG'].'</td>';
                echo '<td>'.$row['observacion'].'</td>';
                echo '<td class="crud-actions">';
                  echo '<a href="'.site_url("index.php/adminapp").'/'.$this->uri->segment(2).'/update/?ael='.base64_encode($row['idA']).
                  '" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></a>
                  <input type="hidden" name="uno" value="'.base64_encode($row['idA']).'" />  
                  <a href="'.site_url("index.php/adminapp").'/products/delete/'.$row['idA'].
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
</div>