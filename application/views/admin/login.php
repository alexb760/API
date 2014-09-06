<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>API.</title>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container login">
      <?php 
      $attributes = array('class' => 'form-signin');
      echo form_open('index.php/main/validate_credentials', $attributes);
      echo '<h2 class="form-signin-heading">Login</h2>';
      echo form_input('user_name', '', 'placeholder="Username"');
      echo form_password('password', '', 'placeholder="Password"');
      if(isset($message_error) && $message_error){
          echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">&times;</a>';
            echo '<strong>Oops!</strong> Usuario o Contraseña Invalidos. Intente nuevamente';
          echo '</div>';             
      }
      echo form_error();
      echo "<br />";
      echo anchor('admin/signup', 'Recuperar Contraseña!');
      echo "<br />";
      echo "<br />";
      echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary"');
      echo form_close();
      ?>      
    </div><!--container-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/admin/bootstrap3-1/js/bootstrap.min.js"></script>
  </body>
</html>    
    