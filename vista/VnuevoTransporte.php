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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVO TRANSPORTE</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE TRANSPORTE</a></li>
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
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Transporte&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL TRANSPORTE:');
                                $Formulario->lista_2('tipo_tra', 'tipo_tra', 'Tipo', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['tipo_tra'], $opciones = array('CAMION'=>'CAMI&Oacute;N', 'GANDOLA'=>'GANDOLA'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_tra"]), 6);
                                $Formulario->Texto('matricula_tra','matricula_tra', 'Matricula', 'Ingrese aqui ...', 'Por favor ingresar la placa de el transporte.', @$_POST['matricula_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["matricula_tra"]), 6, 'text');
                                $Formulario->Texto('precio_tra','precio_tra', 'Tarifa', 'Escribir aqui ...', 'Por favor ingrese la tarifa a cobrar por esta unidad de transporte.', @$_POST['precio_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["precio_tra"]), 6, 'text');
                                
                              $Formulario->cerrarFieldset();

                              $Formulario->iniciarFieldset('fa fa-link', 'DESCRIPCI&Oacute;N DEL TRANSPORTE:');
                                $Formulario->Texto('marca_tra','marca_tra', 'Marca', 'Ingrese aqui ...', 'Por favor ingrese la marca.', @$_POST['marca_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["marca_tra"]), 6, 'text');
                                $Formulario->Texto('modelo_tra','modelo_tra', 'Modelo', 'Ingrese aqui ...', 'Por favor ingrese funcion js, Jquery o ajax a utilizar.', @$_POST['modelo_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["modelo_tra"]), 6, 'text');
                                $Formulario->Texto('anio_tra','anio_tra', 'A&ntilde;o', 'Ingrese aqui ...', 'Por favor ingrese aqui el a&ntilde;o del transposte.', @$_POST['anio_tra'], null, @$Funcion->recibirArrayUrl(@$campo["anio_tra"]), 6, 'text');
                                $Formulario->Texto('color_tra','color_tra', 'Color', 'Ingrese aqui ...', 'Por favor ingrese aqui el a&ntilde;o del transposte.', @$_POST['color_tra'], null, @$Funcion->recibirArrayUrl(@$campo["color_tra"]), 6, 'text');
                                $Formulario->lista('traccion_tra', 'traccion_tra', 'Tracci&oacute;n', 'Seleccionar', 'Seleccionar de lista', @$_POST['traccion_tra'], $opciones = array('SIMPLE'=>'SIMPLE', 'DOBLE'=>'DOBLE'), null, $Funcion->recibirArrayUrl(@$campo["traccion_tra"]), 6);
                                $Formulario->Texto('capacidad_tra','capacidad_tra', 'Capacidad', '000000 kg', 'Por favor ingrese la capacidad soportada por el transposte expresada en kilogramos', @$_POST['capacidad_tra'], null, @$Funcion->recibirArrayUrl(@$campo["capacidad_tra"]), 6, 'text');
                                
                              $Formulario->cerrarFieldset();
                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                          <div class="panel-body">
                            
                             <?php $Plantilla->tabla('transportes', 'status_tra=1', 'Transporte', 'lista_tra', array("tipo_tra"=>"TIPO", "matricula_tra"=>"PLACA", "marca_tra"=>"MARCA",  "precio_tra"=>"COSTO"), 1); ?>
                             
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
                                    $Formulario->lista_js('Mtipo_tra', 'Mtipo_tra', 'Tipo', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mtipo_tra'], $opciones = array('CAMION'=>'CAMI&Oacute;N', 'GANDOLA'=>'GANDOLA'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_tra"]), 6);
                                    $Formulario->Texto_js('Mmatricula_tra','Mmatricula_tra', 'Matricula', 'Ingrese aqui ...', 'Por favor ingresar la placa de el transporte.', @$_POST['Mmatricula_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["Mmatricula_tra"]), 6, 'text');
                                    $Formulario->Texto_js('Mprecio_tra','Mprecio_tra', 'Tarifa', 'Escribir aqui ...', 'Por favor ingresar el tarifa a cobrar por esta unidad de transporte.', @$_POST['precio_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["precio_tra"]), 6, 'text');
                                  $Formulario->cerrarFieldset();

                                  $Formulario->iniciarFieldset('fa fa-link', 'DESCRIPCI&Oacute;N DEL TRANSPORTE:');
                                    $Formulario->Texto_js('Mmarca_tra','Mmarca_tra', 'Marca', 'Ingrese aqui ...', 'Por favor ingrese la marca.', @$_POST['Mmarca_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["Mmarca_tra"]), 6, 'text');
                                    $Formulario->Texto_js('Mmodelo_tra','Mmodelo_tra', 'Modelo', 'Ingrese aqui ...', 'Por favor ingrese funcion js, Jquery o ajax a utilizar.', @$_POST['Mmodelo_tra'], 1, @$Funcion->recibirArrayUrl(@$campo["Mmodelo_tra"]), 6, 'text');
                                    $Formulario->Texto_js('Manio_tra','Manio_tra', 'A&ntilde;o', 'Ingrese aqui ...', 'Por favor ingrese aqui el a&ntilde;o del transposte.', @$_POST['Manio_tra'], null, @$Funcion->recibirArrayUrl(@$campo["Manio_tra"]), 6, 'text');
                                    $Formulario->Texto_js('Mcolor_tra','Mcolor_tra', 'Color', 'Ingrese aqui ...', 'Por favor ingrese aqui el a&ntilde;o del transposte.', @$_POST['Mcolor_tra'], null, @$Funcion->recibirArrayUrl(@$campo["Mcolor_tra"]), 6, 'text');
                                    $Formulario->lista_js('Mtraccion_tra', 'Mtraccion_tra', 'Tracci&oacute;n', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mtraccion_tra'], $opciones = array('SIMPLE'=>'SIMPLE', 'DOBLE'=>'DOBLE'), null, $Funcion->recibirArrayUrl(@$campo["Mtraccion_tra"]), 6);
                                    $Formulario->Texto_js('Mcapacidad_tra','Mcapacidad_tra', 'Capacidad', '000000 kg', 'Por favor ingrese la capacidad soportada por el transposte expresada en kilogramos', @$_POST['Mcapacidad_tra'], null, @$Funcion->recibirArrayUrl(@$campo["Mcapacidad_tra"]), 6, 'text');
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
