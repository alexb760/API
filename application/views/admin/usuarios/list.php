    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("index.php/adminapp"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php 
            echo ucfirst($this->uri->segment(2));
          ?> 
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
            $options_manufacture = array(0 => "all");
            /*foreach ($manufactures as $row)
            {
              $options_manufacture[$row['id']] = $row['name'];
            }*/
            //save the columns names in a array that we will use as filter         
            $options_products = array();    
            foreach ($products as $array) {
              foreach ($array as $key => $value) {
                $options_products[$key] = $key;
              }
              break;
            }
            
              echo form_open('admin/grupo', $attributes);
     
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
           <div class="table-responsive">
           <?php
           $parametros['site_url'] = site_url("index.php/adminapp");
           $parametros['segment']  = $this->uri->segment(2);
            echo print_table_vertical($products, $permiso, $parametros);
           ?>
          </tbody>
          <tfooter>
            <tr ><td colspan="3"><span class=""><?php echo $count_products.' Registros'; ?></span></td></tr>
          </tfooter>
          </table>
      </div>
        <div class="col-md-12">
          <?php echo '<div class="pagination">'.($this->pagination->create_links()).'</div>'; ?>
        </div>
       
    </div>