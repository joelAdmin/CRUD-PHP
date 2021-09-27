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
  <body onload="cargarSubmenu();">
   
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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVO SUB-MENU</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE SUB-MENU</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane active" id="nuevo_men">
                     <div class="panel-body">
    
                        <?php 
                          $evento = array('evento'=>'onclick', 'nombre'=>'editar' ,'parametros'=>array('pedro',6, 'usuario', 2, 4, 5, 'juan'));
                        if(isset($msj)) 
                        {
                          echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><a href="#" class="alert-link"></a>.
                                '.$msj.'
                                </div>';
                        }
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=SubMenu&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'INFORMACION DEL NUEVO SUB-MENU:');
                                $Formulario->lista('id_Menu', 'id_Menu', 'Menus', 'Seleccionar', 'Seleccionar un menu de la lista.', @$_POST['id_Menu'], @$menu, 1, $Funcion->recibirArrayUrl(@$campo["id_Menu"]), 6);
                                $Formulario->Texto('etiqueta_sub','etiqueta_sub', 'Etiqueta', 'Ingrese el nombre del menu', 'Por favor ingresar un nombre para el menu.', @$_POST['etiqueta_sub'], 1, $Funcion->recibirArrayUrl(@$campo["etiqueta_sub"]), 6, 'text');
                                $Formulario->Texto('url_sub','url_sub', 'Url', 'Ingresar url:', 'Por favor ingrese el enlace de url al que va hacer referencia el menu.', @$_POST['url_sub'], 1, @$Funcion->recibirArrayUrl(@$campo["url_sub"]), 6, 'text');
                                $Formulario->Texto('evento_sub','evento_sub', 'Evento js', 'Ingresar funcion js', 'Por favor ingrese funcion js, Jquery o ajax a utilizar.', @$_POST['evento_sub'], null, @$Funcion->recibirArrayUrl(@$campo["evento_sub"]), 6, 'text');
                              $Formulario->cerrarFieldset();

                              $Formulario->iniciarFieldset('fa fa-link', 'POSICION DEL SUB-MENU:');
                                $Formulario->Texto('clase_sub','clase_sub', 'Clase css', 'Escribir aqui ...', 'Por favor ingresar clase de estilo css a utilizar.', @$_POST['clase_sub'], null, @$Funcion->recibirArrayUrl(@$campo["clase_sub"]), 6, 'text');
                                $Formulario->radioBoton('posicion_sub', 'posicion_sub', 'Posicion', 'Desea activar este menu.', @$_POST['posicion_sub'], $opciones = array('ANTES'=>'ANTES', 'DESPUES'=>'DESPUES'), 1, @$Funcion->recibirArrayUrl(@$campo["posicion_sub"]), 6);
                                $Formulario->lista('subMenu_sub', 'subMenu_sub', 'Sub-Menus', 'Seleccionar', 'Seleccionar un menu de la lista.', @$_POST['subMenu_sub'], null, 1, $Funcion->recibirArrayUrl(@$campo["subMenu_sub"]), 6);
                                $Formulario->radioBoton('activar_sub', 'activar_sub', 'Activar', 'Desea activar este menu.', @$_POST['activar_sub'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_sub"]), 6);  
                              $Formulario->cerrarFieldset();
                              
                              $Formulario->iniciarFieldset('fa fa-pencil-square-o', 'CONTENIDO NUEVO SUB-MENU:');
                                $Formulario->textArea_ck('contenido_sub','contenido_sub', 'Contenido', 'Ingresar contenido', 'Por favor ingresar el contenido aqui ...', @$_POST['contenido_sub'], null, @$Funcion->recibirArrayUrl(@$campo["contenido_sub"]), 14, 'text');
                              $Formulario->cerrarFieldset();

                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                          <div class="panel-body">
                            
                             <?php $Plantilla->tabla_join('submenus as sub, menus as men', 'sub.id_Menu=men.id_Menu', 'SubMenu', 'lista_sub', array("sub.etiqueta_sub"=>"ETIQUETA", "men.etiqueta_men"=>"MENU", "sub.posicion_sub"=>"ORDEN", /*"activar_men"=>"ACTIVO",*/ ), 1); ?>
                             
                          </div>
                </div>

                 <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_2" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          
                          <div class="panel-body">

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-lock"></i> Modificar Sub-Menu<button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>

                                <?php 
                                  
                                  echo '<form method="post" action="#" class="form-horizontal" id="form_modificar_submenu">';
                                    $Formulario->iniciarFieldset('fa fa-link', 'INFORMACION DEL NUEVO MENU:');
                                    $Formulario->campoOculto('Mid_SubMenu', null);
                                    $Formulario->lista_js('Mid_Menu', 'Mid_Menu', 'Menus', null, 'Seleccionar', 'Seleccionar un menu de la lista.', @$_POST['Mid_Menu'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Menu"]), 6);
                                    $Formulario->Texto_js('Metiqueta_sub','Metiqueta_sub', 'Etiqueta', 'Ingrese el nombre del menu', 'Por favor ingresar un nombre para el menu.', @$_POST['Metiqueta_sub'], 1, $Funcion->recibirArrayUrl(@$campo["Metiqueta_sub"]), 6, 'text');
                                    $Formulario->Texto_js('Murl_sub','Murl_sub', 'Url', 'Ingresar url:', 'Por favor ingrese el enlace de url al que va hacer referencia el menu.', @$_POST['Murl_sub'], 1, @$Funcion->recibirArrayUrl(@$campo["Murl_sub"]), 6, 'text');
                                    $Formulario->Texto_js('Mevento_sub','Mevento_sub', 'Evento js', 'Ingresar funcion js', 'Por favor ingrese funcion js, Jquery o ajax a utilizar.', @$_POST['Mevento_sub'], null, @$Funcion->recibirArrayUrl(@$campo["Mevento_sub"]), 6, 'text');
                                  $Formulario->cerrarFieldset();

                                  $Formulario->iniciarFieldset('fa fa-link', 'POSICION DEL MENU:');
                                    $Formulario->Texto_js('Mclase_sub','Mclase_sub', 'Clase css', 'Escribir aqui ...', 'Por favor ingresar clase de estilo css a utilizar.', @$_POST['Mclase_sub'], null, @$Funcion->recibirArrayUrl(@$campo["Mclase_sub"]), 6, 'text');
                                    $Formulario->radioBoton_js('Mposicion_sub', 'Mposicion_sub', 'Posicion', 'Desea activar este menu.', @$_POST['Mposicion_sub'], $opciones = array('ANTES'=>'ANTES', 'DESPUES'=>'DESPUES'), 1, @$Funcion->recibirArrayUrl(@$campo["Mposicion_sub"]), 6);
                                    $Formulario->lista_js('MsubMenu_sub', 'MsubMenu_sub', 'Sub-Menus', null, 'Seleccionar', 'Seleccionar un menu de la lista.', @$_POST['Mmenu_sub'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mmenu_sub"]), 6);
                                    $Formulario->radioBoton('Mactivar_sub', 'Mactivar_sub', 'Activar', 'Desea activar este menu.', @$_POST['Mactivar_sub'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["Mactivar_sub"]), 6);  
                                  $Formulario->cerrarFieldset();
                                  
                                  $Formulario->iniciarFieldset('fa fa-pencil-square-o', 'CONTENIDO NUEVO MENU:');
                                    $Formulario->textArea_ck('Mcontenido_sub','Mcontenido_sub', 'Contenido', 'Ingresar contenido', 'Por favor ingresar el contenido aqui ...', @$_POST['Mcontenido_sub'], null, @$Funcion->recibirArrayUrl(@$campo["Mcontenido_sub"]), 14, 'text');
                                  $Formulario->cerrarFieldset();

                                   $Formulario->boton('btn_mod_subMenu', 'btn btn-primary', 'Guardar');


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
