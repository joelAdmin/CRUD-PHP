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
  <body onload="mostrar_pedido_cache_ajax('lista_rutas');">
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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVO GUIA</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE GUIAS</a></li>
                  <li role="presentation"><a href="#gps" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-street-view fa-fw"></i> SERVICIO GPS </a></li>
                
                </ul>

                <!-- Tab panes FORMULARIO PRINCINPAL-->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane active" id="nuevo_men">
                     <div class="panel-body">
                      <div id="respuesta2"></div>
                        <?php 
                        
                        if(isset($msj)) 
                        {
                          echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><a href="#" class="alert-link"></a>.
                                '.$msj.'
                                </div>';
                          /*echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;X</button><a href="#" class="alert-link"></a>.
                                '.$msj.'
                                </div>';*/
                        }

                         
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Guia&accion=procesar_pedido', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'BUSCAR CLIENTE:');
                                $evento_cedula = array('evento'=>'onblur', 'nombre'=>'ajaxBuscarCliente' ,'parametros'=>array('cedula_cli', 'nombre_cli'));
                                $Formulario->texto_buscar('cedula_cli','cedula_cli', 'Ced&uacute;la', 'Buscar cliente ...', 'Por favor ingrese la ced&ula.', @$_POST['cedula_cli'], 1, @$Funcion->recibirArrayUrl(@$campo["cedula_cli"]), 6, 'text', '<a href="#" onClick="nuevoCliente(\'cedula_cli\', \'cedula_per\');"><i class="fa-plus fa"></i> Cliente</a>', $evento_cedula);
                                $Formulario->Texto_2('nombre_cli','nombre_cli', 'Cliente', 'Esperando resultado de busqueda ...', 'Datos ciente seleccionado', @$_POST['nombre_cli'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_cli"]), 6, 'text', '<i class="fa-user fa"></i>', null);
                                $Formulario->lista('id_PagoFactura', 'id_PagoFactura', 'Forma de Pago', 'Seleccionar', 'Seleccionar de lista', @$_POST['id_PagoFactura'], $pagoFactura, 1, $Funcion->recibirArrayUrl(@$campo["id_PagoFactura"]), 6);
                             
                                $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Procesar Pedido');
                              $Formulario->cerrarFieldset();
                            $Formulario->cerrarForm();

                            $Formulario->iniciarFieldset('fa fa-list', 'RUTAS SELECCIONADAS:');
                            echo'<div id="lista_rutas"></div>';
                            $Formulario->cerrarFieldset();
                            
                            $Formulario->iniciarFieldset('fa fa-link', 'AGREGAR RUTAS: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="nuevaRuta(\'cedula_cli\', \'cedula_per\');"><i class="fa-plus fa"></i> Nueva ruta </a>');

                            $Plantilla->tabla_guia_join('rutas as r, estados as e, ciudades as c, municipios as m, parroquias as p', 'status_rut=1 AND r.id_Estado=e.id_Estado AND r.id_Ciudad=c.id_Ciudad AND r.id_Municipio=m.id_Municipio AND r.id_parroquia=p.id_parroquia', 'Ruta', 'lista_rutas_ajax', array("e.estado"=>"ESTADO", "c.ciudad"=>"CIUDAD",  "m.municipio"=>"MUNICIPIO", "p.parroquia"=>"PARROQUIA", "r.direccion_rut"=>"DIRECCI&Oacute;N", "r.precio_rut"=>"MONTO"), 1);
                            $Formulario->cerrarFieldset();
                        ?>
                  </div>

                </div>
                <!-- FINDE FORMULARIO PRINCIPAL -->

                <!-- TAB GPS -->
                  
                  <div role="tabpanel" class="tab-pane" id="gps">
                    <div class="video">
                      <iframe width="840px;" height="560px;" src="librerias/gpstracker/displaymap.php" frameborder="0" allowfullscreen></iframe>
                    </div>

                  <div class="panel-body">
                    <?php ?>       
                  </div>
                  </div>

                <!-- FIN TAB GPS -->

                <div role="tabpanel" class="tab-pane" id="gestor">
                  <div class="panel-body">
                    <?php 
                  
                        //$Plantilla->tabla_join('pedidos as Ped, facturas as Fac, transportes as Tra, rutas as Rut', '(Ped.id_Factura=Fac.id_Factura AND Ped.id_Transporte=Tra.id_Transporte AND Ped.id_Ruta=Rut.id_Ruta)', 'Guia', 'lista_rutas', array("Fac.codigo_fac"=>"N DE FACTURA", "Tra.tipo_tra"=>"TRANSPORTE", "Rut.nombre_rut"=>"RUTA"), 1);
                        //SELECT * FROM `pedidos` as Ped, transportes as Tra WHERE (Ped.id_Transporte=Tra.id_Transporte)
                        $Plantilla->tabla_guia_per('pedidos as Ped, transportes as Tra', '(Ped.id_Transporte=Tra.id_Transporte)', 'Guia', 'lista_gui', array("Tra.tipo_tra"=>"N DE FACTURA", "Tra.marca_tra"=>"N DE FACTURA", "Tra.marca_tra"=>"N DE FACTURA"), 1);
                        //$Plantilla->tabla_join('personas as P, empleados as E, cargos as C', '(P.id_Persona=E.id_Persona AND E.id_Cargo=C.id_Cargo) AND E.status_emp=1', 'Empleado', 'lista_emp', array("P.cedula_per"=>"CEDULA", "P.nombre_per"=>"NOMBRE", "P.apellido_per"=>"APELLIDO", "P.telefono_movil_per"=>"TELEFONO", "C.nombre_car"=>"CARGO"), 1);
                     ?>
                            
                  </div>
                </div>

                 <!-- 1 DIV MODAL PARA AGREGAR UNA RUTA A LA LISTA -->
                    <div style="display:None;" id="form_agregarRutaAjax" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">
                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-users"></i> TRANSPORTE <button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                                <div id="respuesta_agregar_pedido"></div>
                                  <?php 
                                      // echo $transporte->fetch();
                                      echo '<form method="post" action="#" class="form-horizontal" name="form_selec_chofer_transporte" id="form_selec_chofer_transporte">';
                                      $Formulario->iniciarFieldset('fa fa-link', 'SELECCIONAR TRANSPORTE Y CHOFER:');
                                      $Formulario->lista_js('Mid_Transporte', 'Mid_Transporte', 'Transporte', null, 'Seleccionar', 'Seleccionar uno de la lista.', @$_POST['Mmenu_men'], @$transporte, 1, $Funcion->recibirArrayUrl(@$campo["Mmenu_men"]), 8);
                                      $Formulario->lista_js('Mid_Empleado', 'Mid_Empleado', 'Chofer', null, 'Seleccionar', 'Seleccionar uno de la lista.', @$_POST['Mmenu_men'], @$chofer, 1, $Funcion->recibirArrayUrl(@$campo["Mmenu_men"]), 8);
                                      $Formulario->textArea_js('Mdescripcion_ped','Mdescripcion_ped', 'Descripci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar la descripci&oacute;n del pedido hacer transportado.', @$_POST['Mdescripcion_ped'], null, @$Funcion->recibirArrayUrl(@$campo["Mdescripcion_ped"]), 8, 'text');
                        
                                      $Formulario->campoOculto('Mid_Ruta', null);
                                      $Formulario->cerrarFieldset();

                                      $Formulario->boton('btn_selec_chofer_transporte', 'btn btn-primary', 'Listo');
                                      $Formulario->cerrarForm();
                                  ?>
                              </div>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- fFIN DE MODAL --> 

                  <!-- 2 DIV MODAL PARA AGREGAR NUEVO CLIENTE A LA LISTA -->
                    <div style="display:None;" id="modal_nuevo_cliente" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">
                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-users"></i> NUEVO CLIENTE <button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                                <div id="respuesta_nuevo_cliente"></div>
                                  <?php 
                                      // echo $transporte->fetch();
                                      echo '<form method="post" action="#" class="form-horizontal" name="form_nuevo_cliente_ajax" id="form_nuevo_cliente_ajax">';
                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL CLIENTE:');
                                        $Formulario->Texto_js('cedula_per','cedula_per', 'Ced&uacute;la', 'Ingrese aqui ...', 'Por favor ingrese el ced&uacute;la', @$_POST['cedula_per'], 1, @$Funcion->recibirArrayUrl(@$campo["cedula_per"]), 6, 'text');
                                       
                                        $Formulario->Texto_js('nombre_per','nombre_per', 'Nombre', 'Ingrese aqui ...', 'Por favor ingrese el nombre del cliente', @$_POST['nombre_per'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_per"]), 6, 'text');
                                        $Formulario->Texto_js('apellido_per','apellido_per', 'Apellido', 'Ingrese aqui ...', 'Por favor ingrese el nombre del cliente', @$_POST['apellido_per'], 1, @$Funcion->recibirArrayUrl(@$campo["apellido_per"]), 6, 'text');
                                        $Formulario->radioBoton_js('sexo_per', 'sexo_per', 'Sexo', 'Seleccionar sexo del cliente', @$_POST['sexo_per'], $opciones = array('F'=>'F', 'M'=>'M'), 1, @$Funcion->recibirArrayUrl(@$campo["sexo_per"]), 6);  
                                        
                                        $Formulario->texto_calendar_js('fecha_nac_per','fecha_nac_per', 'Fecha nacimiento', 'dia/mes/a&ntilde;o', 'Por favor ingrese la fecha de nacimiento', @$_POST['fecha_nac_per'], 1, @$Funcion->recibirArrayUrl(@$campo["fecha_nac_per"]), 6, 'text');
                                          
                                      $Formulario->cerrarFieldset();

                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE DIRECCI&Oacute;N:');
                                       $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('id_Estado', 'id_Ciudad'));
                                       $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('id_Estado', 'id_Municipio'));
                                       $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('id_Municipio', 'id_Parroquia'));
                                        
                                        //$evento = array('evento'=>'onclick', 'nombre'=>'editar' ,'parametros'=>array(6, 'usuario', 2, 4, 5, 'juan'));
                                        $Formulario->lista_js('id_Estado', 'id_Estado', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Estado'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["id_Estado"]), 6);
                                        
                                        $Formulario->lista_js('id_Ciudad', 'id_Ciudad', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['id_Ciudad'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Ciudad"]), 6);
                                        $Formulario->lista_js('id_Municipio', 'id_Municipio', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Municipio'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Municipio"]), 6);
                                        $Formulario->lista_js('id_Parroquia', 'id_Parroquia', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Parroquia'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Parroquia"]), 6);
                                      
                                        $Formulario->textArea_js('direccion_per','direccion_per', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['direccion_per'], null, @$Funcion->recibirArrayUrl(@$campo["direccion_per"]), 6, 'text');
                                      $Formulario->cerrarFieldset();

                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE CONTACTO:');
                                        $Formulario->Texto_js('telefono_movil_per','telefono_movil_per', 'Telefono movil', 'Ingrese aqui ...', 'Por favor ingrese el telefono celular de contacto', @$_POST['telefono_movil_per'], 1, @$Funcion->recibirArrayUrl(@$campo["telefono_movil_per"]), 6, 'text');
                                        $Formulario->Texto_js('telefono_fijo_per','telefono_fijo_per', 'Telefono Fijo', 'Ingrese aqui ...', 'Por favor ingrese el telefono local de contacto', @$_POST['telefono_fijo_per'], 1, @$Funcion->recibirArrayUrl(@$campo["telefono_fijo_per"]), 6, 'text');
                                        $Formulario->Texto_js('correo_per','correo_per', 'Correo', 'Ingrese aqui ...', 'Por favor ingrese una direcci&oacute;n de correo electronico', @$_POST['correo_per'], null, @$Funcion->recibirArrayUrl(@$campo["correo_per"]), 6, 'text');
                                        //$Formulario->textArea_js('comentario_con','comentario_con', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['comentario_con'], null, @$Funcion->recibirArrayUrl(@$campo["comentario_con"]), 6, 'text');
                                      $Formulario->cerrarFieldset();

                                      $Formulario->boton('btn_guardar_cliente_ajax', 'btn btn-primary', 'Guardar');
                                      $Formulario->cerrarForm();
                                      
                                  ?>
                              </div>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- fFIN DE MODAL --> 

                  <!-- 3 DIV MODAL PARA AGREGAR UNA RUTA A LA LISTA -->
                    <div style="display:None;" id="modal_nueva_ruta" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">
                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-chuck"></i> REGISTRAR NUEVA RUTA <button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                                <div id="respuesta_nueva_ruta"></div>
                                  <?php 
                                      // echo $transporte->fetch();
                                      echo '<form method="post" action="#" class="form-horizontal" name="form_nueva_ruta_ajax" id="form_nueva_ruta_ajax">';
                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE LA RUTA:');
                                        $Formulario->Texto_js('nombre_rut','nombre_rut', 'Nombre de Ruta', 'Ingrese aqui ...', 'Por favor ingrese el nombre de la ruta.', @$_POST['nombre_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_rut"]), 6, 'text');
                                        $Formulario->lista_js('tipo_rut', 'tipo_rut', 'Tipo de Ruta', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['tipo_rut'], $opciones = array('CORTA'=>'CORTA', 'MEDIANA'=>'MEDIANA', 'LARGA'=>'LARGA'), 1, $Funcion->recibirArrayUrl(@$campo["tipo_rut"]), 6);
                                        $Formulario->Texto_js('precio_rut','precio_rut', 'Precio', 'Escribir aqui ...', 'Por favor ingresar el precio a cobrar por la asignacion de la ruta.', @$_POST['precio_rut'], 1, @$Funcion->recibirArrayUrl(@$campo["precio_rut"]), 6, 'text');
                                        $Formulario->radioBoton_js('activar_rut', 'activar_rut', 'Activar', 'Desea activar este menu.', @$_POST['activar_rut'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_rut"]), 6);  
                                     
                                      $Formulario->cerrarFieldset();

                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS GEOGRAFICOS DE LA RUTA:');
                                        $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('id_Estado_rut', 'id_Ciudad_rut'));
                                        $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('id_Estado_rut', 'id_Municipio_rut'));
                                        $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('id_Municipio_rut', 'id_Parroquia_rut'));
                                        
                                        $Formulario->lista_js('id_Estado_rut', 'id_Estado_rut', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Estado_rut'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["id_Estado_rut"]), 6);   
                                        $Formulario->lista_js('id_Ciudad_rut', 'id_Ciudad_rut', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['id_Ciudad_rut'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Ciudad_rut"]), 6);
                                        $Formulario->lista_js('id_Municipio_rut', 'id_Municipio_rut', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Municipio_rut'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Municipio_rut"]), 6);
                                        $Formulario->lista_js('id_Parroquia_rut', 'id_Parroquia_rut', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Parroquia_rut'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Parroquia_rut"]), 6);
                                      
                                        $Formulario->textArea_js('direccion_rut','direccion_rut', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar direcci&oacute;n de la ruta .', @$_POST['direccion_rut'], null, @$Funcion->recibirArrayUrl(@$campo["direccion_rut"]), 6, 'text');
                                      
                                      $Formulario->cerrarFieldset();
                                      $Formulario->boton('btn_nueva_ruta_ajax', 'btn btn-primary', 'Guardar');
                                    $Formulario->cerrarForm();
                                  ?>
                              </div>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- fFIN DE MODAL -->

                  <!-- 4 DIV MODAL CAMBIAR ESTADO DE PEDIDOS -->
                    <div style="display:None;" id="modal_cambiar_estatus" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">
                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-edit"></i> CAMBIAR ESTADO <button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                                <div id="respueta_cambiar_estatus"></div>
                                  <?php 
                                      // echo $transporte->fetch();
                                      echo '<form method="post" action="#" class="form-horizontal" name="form_cambiar_estatus_ajax" id="form_cambiar_estatus_ajax">';
                                      $Formulario->iniciarFieldset('fa fa-arrow-right', '<label id="modal_titulo_estatus_ajax"></label>');
                                        $Formulario->campoOculto('id_Pedido', null);
                                        $Formulario->lista_js('estado_ped', 'estado_ped', 'Estatus', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['estado_ped'], NULL, /*array('EN RUTA'=>'EN RUTA', 'ENTREGADO'=>'ENTREGADO', 'ACCIDENTADO'=>'ACCIDENTADO', 'DISPONIBLE'=>'DISPONIBLE')*/ 1, $Funcion->recibirArrayUrl(@$campo["estado_ped"]), 6);   
                                       
                                        $Formulario->textArea_js('observacion_pob','observacion_pob', 'Observaci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar obserbaci&oacute;n .', @$_POST['observacion_pob'], null, @$Funcion->recibirArrayUrl(@$campo["observacion_pob"]), 6, 'text');
                                      
                                      $Formulario->cerrarFieldset();
                                      $Formulario->boton('btn_cambiar_estatus_ajax', 'btn btn-primary', 'Guardar');
                                    $Formulario->cerrarForm();
                                  ?>
                              </div>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- fFIN DE MODAL -->

                  <!-- 5 DIV MODAL PARA MOSTRAR FACTURA -->
                    <div style="display:None;" id="modal_ver_factura" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="panel-body">
                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-arrow-right"></i> FACTURA <button type="button" class="close" data-dismiss="modal">   [x]  </button> <a href="#" class="close" onclick="PrintElem('#respueta_ver_factura');"><i class="fa fa-print fa-fw"></i>  Imprimir</a> </legend>
                              <div class="panel-body">
                                <div id="respueta_ver_factura"></div>
                              </div>
                              <a href="#" onclick="PrintElem('#respueta_ver_factura');"><i class="fa fa-print fa-fw"></i>  Imprimir</a>
                  
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- fFIN DE MODAL -->

              </div>

            </div>
          </div>
        </div>
      </div>
      
    <!-- Page-Level Plugin Scripts - Tables -->

    </div>

  </body>
 
</html>
