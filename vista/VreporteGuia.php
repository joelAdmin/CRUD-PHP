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
  <body onload="bloqueaCampoReporteGuia();">
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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> REPORTES DE GUIAS</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane active" id="nuevo_men">
                     <div class="panel-body">
    
                        <?php 
                        
                        if(isset($msj)) 
                        {
                          echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><a href="#" class="alert-link"></a>.
                                '.$msj.'
                                </div>';
                        }
                            $Formulario->iniciarForm('login', 'POST', 'index.php?controlador=Guia&accion=reporteGuia');
                            
                              $Formulario->iniciarFieldset('fa fa-search', 'REALIZAR BUSQUEDA:');
                                $Formulario->radioBoton('filtrar_fecha_guia', 'filtrar_fecha_guia', 'Filtrar', 'FILTRAR POR FECHA DE REGISTRO', @$_POST['filtrar_fecha_guia'], $opciones = array('SI'=>'SI', 'NO'=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["filtrar_fecha_guia"]), 6);  
                             
                                $Formulario->texto_calendar('desde','desde', 'Desde', 'dia/mes/a&ntilde;o', 'Por favor ingrese la fecha de nacimiento', @$_POST['desde'], null, @$Funcion->recibirArrayUrl(@$campo["desde"]), 6, 'text');
                                $Formulario->texto_calendar('hasta','hasta', 'Hasta', 'dia/mes/a&ntilde;o', 'Por favor ingrese la fecha de nacimiento', @$_POST['hasta'], null, @$Funcion->recibirArrayUrl(@$campo["hasta"]), 6, 'text');
                               
                              $Formulario->cerrarFieldset();

                              
                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Procesar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
      

                 <!-- MODAL EDITAR CONTENIDO -->
                    <div style="display:None;" id="modal_editar_transporte" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        
                          <div class="panel-body">

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-pencil"></i> Modificar Transporte<button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>

                                <?php 
                                  
                                  echo '<form method="post" action="#" class="form-horizontal" name="form_modificar_transporte" id="form_modificar_transporte">';
                                  $Formulario->campoOculto('Mid_Transporte', null);
                                  $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL TRANSPORTE:');
                                    $Formulario->cerrarFieldset(); 

                                  $Formulario->boton('btn_modificar_transporte_ajax', 'btn btn-primary', 'Guardar');
                                  $Formulario->cerrarForm();
                                ?>
                              </div>
                            </fieldset>
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
