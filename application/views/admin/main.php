
<div class="divider"></div>
<div  class="container top">

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <hr class="featurette-divider">
      <div class="row">
        <?php
          foreach ($social as $key ) {
            echo '<div class="col-lg-4">';
            echo '<img class="img-circle" src="/app/assets/imagenes/001.jpg" alt="Generic placeholder image" style="width: 140px; height: 140px;">';
            echo '<h2>'.$key['Nombre'].'</h2>';
            echo '<p>'.$key['Web'].'</p>';
            echo '<p><a class="btn btn-default" href="#" role="button">Detalles &raquo;</a></p>';
            echo '</div>';
          }
        ?>
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->
      <hr class="featurette-divider">
      <div class="col-lg-7">
        <div class="panel panel-primary">
         <div class="panel-heading">Proyectos De Investigación</div>
         <div class="panel-body">
      <?php 
        foreach ($proyect_info as $key) {
          echo '<div class="row featurette">';
          echo '<div class="col-md-12">';
          echo '<h2 class="featurette-heading">'.$key['Proyecto'].
                '<span class="text-muted"> &nbsp;'. $key['Sigla'].'</span></h2>';
          echo '<p class="lead" style="font-size:15px;"> '.$key['Objetivo'].'</p>';
          echo '</div>';
          echo '</div>';
          echo '<hr class="featurette-divider">';
        }
      ?>
      </div>
      </div>
      </div>
      <div class="col-lg-5">
      <div class="panel panel-info">
         <div class="panel-heading">Productos Desarrollados</div>
         <div class="panel-body">
         <?php
            foreach ($productos_grupo as $key ) {
              echo '<div class="list-group">';
              echo ' <h4 class="list-group-item-heading">'.$key['producto'].'</h4>';
              echo '<p class="list-group-item-text">'.$key['descripcion'].'</p>';
              echo '<em>';
              echo '<i class="fa fa-users"><strong> Grupo:&nbsp;</strong> '.$key['Nombre'].'</i>';
              echo '<br class="">';
              echo '<i class="fa fa-bookmark"><strong>&nbsp;Clasificacion:&nbsp;</strong> '.$key['Clasificacion'].'</i>';
              echo '<br class="">';
              echo '<i class="fa fa-link"><strong>&nbsp;Web:&nbsp;</strong> '.$key['Web'].'</i>';
              echo '<br class="">';
              echo '<i class="fa fa-link"><strong>&nbsp;Colciencias:&nbsp;</strong> '.$key['Colciencias'].'</i>';
              echo '</em>';
              echo '<br class="">';
              echo '<span class="list-group-item-text btn btn-default fa fa-link" >&nbsp;'.$key['ruta'].'</span>';
              echo '</div>';
              echo '<hr class="divider">';
            }
          ?>
        </div>
        </div>
      </div>
      <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->
