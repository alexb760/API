
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="es">
 <head>
   <title>Progress Bar</title>
 <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/js/jquery.js" type="text/javascript"></script>
	<script src="js/js/modernizr.js" type="text/javascript"></script>
 <style type="text/css">
.out{
	height: 25px;
	width: 500px;
	border: solid 1px #000;
}

.in{
	height: 25px;
	width: <?php echo 10 ?>%;
	border-right: solid 1px #000;
	background-color: lightblue;
}

.progressbar {  
    background-color: #f3f3f3;  
    border: 0;  
    height: 18px;  
    border-radius: 9px;  
}

.progreso{width: 100px; height: 20px; border:1px solid black; float:left;}
.avance{height:20px; float:left; background: red;}


 </style>
 <script src="js/js/jquery.js" type="text/javascript">


$(document).ready(function() { 
    var progressb = $('#barprogress'), 
        max = progressb.attr('max'), 
        time = (1000/max)*5,     
        value = progressb.val(); 
 
    var loading = function() { 
        value += 1; 
        addValue = progressb.val(value); 
         
        $('.progressbar-value').html(value + '%'); 
 
        if (value == max) { 
            clearInterval(animate);                     
        } 
    }; 
 
    var animate = setInterval(function() { 
        loading(); 
    }, time); 
};


 </script>


 </head>
<body>

<div id="progress" style="width:500px;border:1px solid #ccc;">
<div id="information" style="width:2px"></div></div>
<?php

$total=2;
$maxi= $resultado;
for($i=1; $i<=$maxi; $i++){
$percent = intval($i/$total * 100);


echo '<script language ="javascript">
document.getElementById("progress").innerHTML="<div style=\"width:'.$maxi.'%; background-color: lightblue;\">&nbsp;</div>"
document.getElementById("information").innerHTML="'.$i.'row(s) processed."
</script>';
 
echo str_repeat(' ', 1024*64);

flush();

sleep(1);
}
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
?>
<progress id="barprogress" class="progressbar" value="20" max="100"></progress>
<span class="progress-value">0%</span>
<div class="out">
<div class="in">
</div>
</div>
<div class="progreso">
	
</div>
<h1>
<?php echo $resultado; ?>
</h1>

</body>
</html>


