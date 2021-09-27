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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVO CARGO</a></li>
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
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Cargo&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL CARGO:');
                                $Formulario->Texto('nombre_car','nombre_car', 'Denominación', 'Ingrese aqui ...', 'Por favor ingrese el nombre del cargo', @$_POST['nombre_car'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_car"]), 6, 'text');
                                $Formulario->lista('tipo_car', 'tipo_car', 'Condición de Cargo', 'Seleccionar', 'Seleccionar de lista', @$_POST['tipo_car'], $opciones = array('CONTRATADO'=>'CONTRATADO', 'FIJO'=>'FIJO'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_car"]), 6);
                              
                                $Formulario->textArea('descripcion_car','descripcion_car', 'Descripci&oacute;n', 'Escriba aqui ....', 'Por favor escriba aqui ...', @$_POST['descripcion_car'], null, @$Funcion->recibirArrayUrl(@$campo["descripcion_car"]), 6, 'text');
                                
                              $Formulario->cerrarFieldset();

                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                          <div class="panel-body">
                            
                                            
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

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-lock"></i> Modificar Menu<button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>

                                <?php 
                                  
                                  echo '<form method="post" action="#" class="form-horizontal" id="form_modificar">';
                                    $Formulario->iniciarFieldset('fa fa-link', 'INFORMACION DEL TRANSPORTE:');
                                    $Formulario->lista_js('Mmenu_men', 'Mmenu_men', 'Tipo', array('CAMION', 'GANDOLA', 'ENCAVA'), 'Seleccionar', 'Seleccionar uno de la lista.', @$_POST['Mmenu_men'], @$menu, 1, $Funcion->recibirArrayUrl(@$campo["Mmenu_men"]), 6);
                                    
                                    $Formulario->campoOculto('Mid_Menu', null);
                                    $Formulario->Texto_js('Metiqueta_men','Metiqueta_men', 'Etiqueta', 'Ingrese el nombre del menu', 'Por favor ingresar un nombre para el menu.', @$_POST['Metiqueta_men'], 1, $Funcion->recibirArrayUrl(@$campo["Metiqueta_men"]), 6, 'text');
                                    $Formulario->Texto_js('Murl_men','Murl_men', 'Url', 'Ingresar url:', 'Por favor ingrese el enlace de url al que va hacer referencia el menu.', @$_POST['Murl_men'], 1, @$Funcion->recibirArrayUrl(@$campo["Murl_men"]), 6, 'text');
                                    $Formulario->Texto_js('Mevento_men','Mevento_men', 'Evento js', 'Ingresar funcion js', 'Por favor ingrese funcion js, Jquery o ajax a utilizar.', @$_POST['Mevento_men'], null, @$Funcion->recibirArrayUrl(@$campo["Mevento_men"]), 6, 'text');
                                  $Formulario->cerrarFieldset();

                                  $Formulario->iniciarFieldset('fa fa-link', 'POSICION DEL MENU:');
                                    $Formulario->Texto_js('Mclase_men','Mclase_men', 'Clase css', 'Escribir aqui ...', 'Por favor ingresar clase de estilo css a utilizar.', @$_POST['Mclase_men'], null, @$Funcion->recibirArrayUrl(@$campo["Mclase_men"]), 6, 'text');
                                    $Formulario->radioBoton_js('Mposicion_men', 'Mposicion_men', 'Posicion', 'Desea activar este menu.', @$_POST['Mposicion_men'], $opciones = array('ANTES'=>'ANTES', 'DESPUES'=>'DESPUES'), 1, @$Funcion->recibirArrayUrl(@$campo["Mposicion_men"]), 6);
                                   $Formulario->radioBoton('Mactivar_men', 'Mactivar_men', 'Activar', 'Desea activar este menu.', @$_POST['Mactivar_men'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["Mactivar_men"]), 6);  
                                  $Formulario->cerrarFieldset();
                                  
                                  $Formulario->iniciarFieldset('fa fa-pencil-square-o', 'CONTENIDO NUEVO MENU:');
                                    $Formulario->textArea_ck('Mcontenido_men','Mcontenido_men', 'Contenido', 'Ingresar contenido', 'Por favor ingresar el contenido aqui ...', @$_POST['Mcontenido_men'], null, @$Funcion->recibirArrayUrl(@$campo["Mcontenido_men"]), 14, 'text');
                                  $Formulario->cerrarFieldset();

                                   $Formulario->boton('btn_mod_menu', 'btn btn-primary', 'Guardar');


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
