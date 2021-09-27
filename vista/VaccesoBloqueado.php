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
              
              <div role="tabpanel" class="">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#permisos" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-lock fa-fw"></i> ACCESO DENEGADO</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane active" id="nuevo_men">
                     <div class="panel-body">
                       <h3 style="color:red;"><i class="fa fa-ban fa-fw"></i>  ACCESO DENEGADO POR FAVOR COMUNIQUESE CON SU ADMINISTRADOR.</h3>
                  </div> 
				  
                </div>
                 <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_2" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <!--<div class="modal-header"><i class="fa fa-lock"></i> Ingresar Usuario
                            <button type="button" class="close" data-dismiss="modal">x</button><br/>
                            <h4 class="modal-title"></h4>
                          </div>-->

                          <div class="panel-body">

                           
                          </div>
                        </div>
                      </div>
                    </div>

                    </div>

                <!-- fFIN DE MODAL -->

            </div>
          </div>
        </div>
      </div>
      
    <!-- Page-Level Plugin Scripts - Tables -->

    </div>

  </body>
 
</html>
