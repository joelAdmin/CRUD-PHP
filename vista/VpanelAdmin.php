<?php 
	require_once 'libs/PlantillaAdmin.class.php';
	require_once 'libs/Formulario.class.php';
	require_once 'libs/Funciones.class.php';
	$Plantilla = new PlantillaAdmin('libs/PlantillaAdmin.class.php');
	$Formulario = new Formulario('libs/Formulario.class.php');
	$Funcion = new Funcion('libs/Funciones.class.php');

?>
<!DOCTYPE html>
<html>
  <head>
   <?php  $Plantilla->head(); ?>
  </head>
  <body>
  <!-- { load biblioteca_extra } -->
  
    <div id="wrapper">

        <?php
         	$Plantilla->menuSuperior();
         	$Plantilla->menuIzquierdo();
          
         ?>
        
        <div id="page-wrapper">

              <div class="row">
                <div class="col-lg-12">
                    <div id="contenedor" class="">

                    <!--<div class="alert alert-info alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{mensaje.mensaje | capfirst}}<a href="#" class="alert-link"></a>.
                    </div>-->

                    
                    <center><h1><?php echo Idioma::TITULO_PANEL_ADMIN; ?> </h1><BR><img width="600px;" height="300px;" src="media/imagen/imagen/camion2.png" ><BR><h1><?php echo Idioma::SISTEMA_VERSION; ?></h1></center>
                    <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_2" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">x</button><br/>
									<h4 class="modal-title"></h4>
								</div>

								<div class="panel-body">

								
								</div>
                    		</div>
                    	</div>
                    </div>

         <!-- <script type="text/javascript">
	 					$(document).ready(function() {
						$('#modal_2').modal('show');
						 });
					</script>-->
						

                    <!-- FIN CONTENIDO -->  
                    </div>
                </div>
                <!-- /.col-lg-12 -->
        </div>
         
    </div>

   
</body>

 <!--<script src="administrador/admin/js/bootstrap.min.js"></script>
    <script src="administrador/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>


    <script src="administrador/admin/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="administrador/admin/js/plugins/morris/morris.js"></script>

   
    <script src="administrador/admin/js/sb-admin.js"></script>

   
    <script src="administrador/admin/js/demo/dashboard-demo.js"></script>-->
    
</html>
