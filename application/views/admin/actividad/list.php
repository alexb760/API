<script type="text/javascript">
function showPrueba(){
        var xmlhttp = null;

        if(window.ActiveXObject){
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }else{
          if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
          }
        }

        xmlhttp.onreadystatechange = function(){
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            window.location.assign("http://localhost/api/index.php/adminapp/admin_actividad/")
            var divSuccess = document.getElementById("divSuccess");
            $(divSuccess).show(); 
          }
        }
        
          var url = location.href;
          var idA = "<?php echo $idActividad; ?>"; 
          xmlhttp.open("GET",url+"/deleteActividad?id="+idA,true);
          xmlhttp.send();
        }
</script>
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
      <!--<a href="<?php echo site_url("index.php/adminapp").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>-->
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
            echo form_open('adminapp/admin_actividad', $attributes);
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
      if($this->session->flashdata('flash_message'))
            {
              if($this->session->flashdata('flash_message') == 'delete')
              {
                echo '<div class="alert alert-success" id="divSuccess">';
                echo '<a class="close" data-dismiss="alert">&times;</a>';
                echo '<strong>Proceso Exitoso!</strong> Actividad eliminada con exito.';
                echo '</div>';    
              }else{
                echo '<script type="text/javascript">
                      $(document).ready(function() {
                      $("#modalConfirm").modal("show");

                      });
                      </script>';      
              }
            }
      ?>
      
      <div class="modal fade modal-two" id="modalConfirm">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          <br>
            <div class="modal-body">
              <div id="divInfo" class="alert alert-info">la actividad tiene asociadas sub actividades. Desea continuar?</div>
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" onclick="showPrueba()" type="submit" class="btn btn-primary">Aceptar</button>
              <button data-dismiss="modal" class="btn">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="alert alert-success" id="divSuccess" style="display:none">
        <a class="close" data-dismiss="alert">&times;</a>
        <strong>Proceso Exitoso!</strong> Actividad Eliminada con exito!.
      </div> 
      <div class="table_responsive">
        <?php
          $parametros['site_url'] = site_url("index.php/adminapp");
          $parametros['segment'] = $this->uri->segment(2);
          echo print_table_vertical($products, $permiso, $parametros);
        ?>
      </tbody>
        <tfooter>
          <tr>
            <td colspan="3">
              <span class="">
                <?php echo $count_products.' Registros'; ?>
              </span>
            </td>
          </tr>
        </tfooter>
      </table>
      </div>
      <div class="col-md-12" id="div1">
        <?php echo '<div class="pagination">'.($this->pagination->create_links()).'</div>'; ?>
      </div>
    </div>