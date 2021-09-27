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
                  <li role="presentation" class="active"><a href="#crear_permiso" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> CREAR PERMISO</a></li>
                  <li role="presentation" class=""><a href="#permisos" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-lock fa-fw"></i> ACCESO DE MODULOS</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane" id="permisos">
                    <div class="panel-body">
                        <?php 
            							//$Plantilla->tabla_permiso_guia('submenus as sub, menus as men', 'sub.id_Menu=men.id_Menu', 'SubMenu', 'lista_sub', array("sub.etiqueta_sub"=>"ETIQUETA", "men.etiqueta_men"=>"MENU", "sub.posicion_sub"=>"ORDEN"), 1);
            							echo '<form method="post" action="#" class="form-horizontal" id="form_js">';
                                $Formulario->iniciarFieldset('fa fa-link', 'PERMISOS DE USUARIO:');
            										$Formulario->campoOculto('Mid_Menu', null);
            										$Formulario->lista_js('Musuario_usu_permiso', 'Musuario_usu_permiso', 'Usuarios', null, 'Seleccionar', 'Seleccionar un menu de la lista.', @$_POST['Musuario_usu_permiso'], @$usuario, 1, $Funcion->recibirArrayUrl(@$campo["Musuario_usu_permiso"]), 6);
            							echo '<div id="div_mostrarPermisos"></div>';
                              $Formulario->cerrarFieldset();
            								$Formulario->cerrarForm();
            									
            						?>            
                    </div> 
				          </div>

                  <div role="tabpanel" class="tab-pane active" id="crear_permiso">
                    <div class="panel-body">
                        <?php
                          if(isset($msj)) 
                          {
                            echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><a href="#" class="alert-link"></a>.
                                  '.$msj.'
                            </div>';
                          } 
                          
                          $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Permiso&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'INFORMACI&Oacute;N DEL PERMISO:');
                                $Formulario->lista('id_Usuario', 'id_Usuario', 'Usuarios', 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Usuario'], @$usuario, null, $Funcion->recibirArrayUrl(@$campo["id_Usuario"]), 6);
                                $Formulario->Texto('nombre_prm','nombre_prm', 'Nombre', 'Ingrese aqui ...', 'Por favor ingrese un nombre para asociar el permiso.', @$_POST['nombre_prm'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_prm"]), 6, 'text');
                                $Formulario->Texto('controlador_prm','controlador_prm', 'Controlador', 'Ingrese aqui ...', 'Por favor ingrese el controlador de clase.', @$_POST['controlador_prm'], 1, @$Funcion->recibirArrayUrl(@$campo["controlador_prm"]), 6, 'text');
                                $Formulario->Texto('accion_prm','accion_prm', 'Acci&oacute;n', 'Ingrese aqui ...', 'Por favor ingrese la acci&oacute;n o metodo de la clase.', @$_POST['accion_prm'], 1, @$Funcion->recibirArrayUrl(@$campo["accion_prm"]), 6, 'text');
                                $Formulario->radioBoton('estado_prm', 'estado_prm', 'Activar', 'Desea activar este permiso.', @$_POST['estado_prm'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["estado_prm"]), 6);  
                             
                              $Formulario->cerrarFieldset();
                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');
                          $Formulario->cerrarForm();    
                        ?>            
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
