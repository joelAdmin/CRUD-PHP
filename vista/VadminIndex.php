<?php 
	require_once 'libs/Formulario.class.php';
	$Formulario = new Formulario('libs/Formulario.class.php');
	require_once 'libs/PlantillaAdmin.class.php';
	$PlantillaAdmin = new PlantillaAdmin('libs/PlantillaAdmin.class.php');
	require_once 'libs/Session.class.php'; 
	$Session = new Session('libs/Session.class.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <?php $PlantillaAdmin->head(false); ?>
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->      
      <div style="position:relative;">
      </div>
  	<!--LOGO-->
	<?php $PlantillaAdmin->divSuperior(); ?>
<!-- USER TOOLS END -->    
<div class="grid_16" id="header">
<!-- MENU START -->
<?php $PlantillaAdmin->menu(1); ?>
<!-- MENU END -->
</div>
<div class="grid_16">
<!-- TABS START -->
   <?php $PlantillaAdmin->submenu("inicio", array(1=>"#;INICIO"), 1); ?>
<!-- TABS END -->    
</div>
<!-- HIDDEN SUBMENU START -->
<div class="grid_16" id="hidden_submenu"></div>
<!-- HIDDEN SUBMENU END -->  
<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
		<div class="grid_9">
		<h1 class="inicio">INICIO</h1>
		</div>
		<!--RIGHT TEXT/CALENDAR END-->
		<div class="clear"></div>
		<!--  TITLE END  -->    
		<!-- #PORTLETS START -->
    
		<div id="portlets">
		<!-- FIRST SORTABLE COLUMN START -->
		  <div class="column" id="left"></div>
		  <!-- FIRST SORTABLE COLUMN END -->
		  
		  <!-- SECOND SORTABLE COLUMN START -->
		  <div class="column"> </div>
		<!--  SECOND SORTABLE COLUMN END -->
		<div class="formulario">
				<div class="contenido">
					<H5>SISTEMA DE CONTROL Y GESTIÓN DDEL CONTENIDO INFORMATIVO DE LA PAGINA WEB</H5>
				<center><img src="css/images/logo.png" ></center>
				</div>
			</div>
	<!--  END #PORTLETS -->  
	   </div>
    <div class="clear"> </div>
   
<!-- END CONTENT-->    
  </div>
  
<div class="clear"> </div>
</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<?php $PlantillaAdmin->footer(); ?>
<!-- FOOTER END -->
</body>
</html>
