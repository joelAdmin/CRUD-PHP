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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVA RUTA</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE RUTAS</a></li>
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
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Ruta&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE LA RUTA:');
                                $Formulario->Texto('nombre_rut','nombre_rut', 'Nombre de Ruta', 'Ingrese aqui ...', 'Por favor ingrese el nombre de la ruta.', @$_POST['nombre_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_rut"]), 6, 'text');
                                $Formulario->lista_2('tipo_rut', 'tipo_rut', 'Tipo de Ruta', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['tipo_rut'], $opciones = array('CORTA'=>'CORTA', 'MEDIANA'=>'MEDIANA', 'LARGA'=>'LARGA'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_rut"]), 6);
                                $Formulario->radioBoton('activar_rut', 'activar_rut', 'Activar', 'Desea activar este menu.', @$_POST['activar_rut'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_rut"]), 6);  
                             
                              $Formulario->cerrarFieldset();

                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS GEOGRAFICOS DE LA RUTA:');
                                $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('id_Estado', 'id_Ciudad'));
                                $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('id_Estado', 'id_Municipio'));
                                $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('id_Municipio', 'id_Parroquia'));
                                
                                $Formulario->lista_2('id_Estado', 'id_Estado', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Estado'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["id_Estado"]), 6);   
                                $Formulario->lista_2('id_Ciudad', 'id_Ciudad', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['id_Ciudad'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Ciudad"]), 6);
                                $Formulario->lista_2('id_Municipio', 'id_Municipio', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Municipio'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Municipio"]), 6);
                                $Formulario->lista_2('id_Parroquia', 'id_Parroquia', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Parroquia'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Parroquia"]), 6);
                              
                                $Formulario->textArea('direccion_rut','direccion_rut', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar direcci&oacute;n de la ruta .', @$_POST['direccion_rut'], null, @$Funcion->recibirArrayUrl(@$campo["direccion_rut"]), 6, 'text');
                                $Formulario->Texto('precio_rut','precio_rut', 'Tarifa', 'Escribir aqui ...', 'Por favor ingresar la tarifa a cobrar por la asignacion de la ruta.', @$_POST['precio_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["precio_rut"]), 6, 'text');
                               
                              $Formulario->cerrarFieldset();
                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                          <div class="panel-body">
                            
                            <?php 
                                $Plantilla->tabla_join('rutas as r, estados as e, ciudades as c, municipios as m, parroquias as p', 'status_rut=1 AND r.id_Estado=e.id_Estado AND r.id_Ciudad=c.id_Ciudad AND r.id_Municipio=m.id_Municipio AND r.id_Parroquia=p.id_Parroquia', 'Ruta', 'lista_guia', array("e.estado"=>"ESTADO", "c.ciudad"=>"CIUDAD",  "m.municipio"=>"MUNICIPIO", "p.parroquia"=>"PARROQUIA", "r.direccion_rut"=>"DIRECCI&Oacute;N", "r.precio_rut"=>"MONTO"), 1);
                                //$Plantilla->tabla('menus', 'status_men=1', 'Menu', 'lista_ruta', array("etiqueta_men"=>"ETIQUETA", "posicion_men"=>"ORDEN",  "url_men"=>"ENLACE"), 1); 
                            ?>
                             
                          </div>
                </div>

                 <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_editar_ruta" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-pencil"></i> Modificar Ruta<button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>
                                <?php 
                                  
                                  echo '<form method="post" action="#" class="form-horizontal" name="form_modificar_ruta" id="form_modificar_ruta">';
                                    $Formulario->campoOculto('Mid_Ruta', null);
                                    $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE LA RUTA:');
                                      $Formulario->Texto_js('Mnombre_rut','Mnombre_rut', 'Nombre de Ruta', 'Ingrese aqui ...', 'Por favor ingrese el nombre de la ruta.', @$_POST['nombre_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_rut"]), 6, 'text');
                                      $Formulario->lista_js('Mtipo_rut', 'Mtipo_rut', 'Tipo de Ruta', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['tipo_rut'], $opciones = array('CORTA'=>'CORTA', 'MEDIANA'=>'MEDIANA', 'LARGA'=>'LARGA'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_rut"]), 6);
                                      $Formulario->radioBoton_js('Mactivar_rut', 'Mactivar_rut', 'Activar', 'Desea activar este menu.', @$_POST['activar_rut'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_rut"]), 6);  
                                   
                                    $Formulario->cerrarFieldset();

                                    $Formulario->iniciarFieldset('fa fa-link', 'DATOS GEOGRAFICOS DE LA RUTA:');
                                      $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('Mid_Estado', 'Mid_Ciudad'));
                                      $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('Mid_Estado', 'Mid_Municipio'));
                                      $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('Mid_Municipio', 'Mid_Parroquia'));
                                      
                                      $Formulario->lista_js('Mid_Estado', 'Mid_Estado', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Estado'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Estado"]), 6);   
                                      $Formulario->lista_js('Mid_Ciudad', 'Mid_Ciudad', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Ciudad'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Ciudad"]), 6);
                                      $Formulario->lista_js('Mid_Municipio', 'Mid_Municipio', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Municipio'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Municipio"]), 6);
                                      $Formulario->lista_js('Mid_Parroquia', 'Mid_Parroquia', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Parroquia'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Parroquia"]), 6);
                                    
                                      $Formulario->textArea_js('Mdireccion_rut','Mdireccion_rut', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar direcci&oacute;n de la ruta .', @$_POST['Mdireccion_rut'], null, @$Funcion->recibirArrayUrl(@$campo["Mdireccion_rut"]), 6, 'text');
                                    $Formulario->Texto_js('Mprecio_rut','Mprecio_rut', 'Tarifa', 'Escribir aqui ...', 'Por favor ingresar la tarifa a cobrar por la asignacion de la ruta.', @$_POST['precio_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["precio_rut"]), 6, 'text');
                                      
                                    $Formulario->cerrarFieldset();
                                    $Formulario->boton('btn_modificar_ruta_ajax', 'btn btn-primary', 'Guardar');
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
