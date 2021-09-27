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
              <div role="tabpanel" class="">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#nuevo_usu" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> NUEVO USUARIO</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE USUARIOS</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content panel panel-default legend">
                  <div role="tabpanel" class="tab-pane active" id="nuevo_usu">
                     <div class="panel-body">
                        <?php 
                        
                        if(isset($msj)) 
                        {
                          echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><a href="#" class="alert-link"></a>
                                '.$msj.'
                                </div>';
                        }
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Usuario&accion=registrar', 'multipart/form-data');
                            
                            $Formulario->iniciarFieldset('fa fa-user', 'CREAR NUEVO USUARIO:');
                            $Formulario->Texto('usuario_usu','usuario_usu', 'Usuario', 'Ingresar Usuario', 'Por favor ingresar su usuario creado.', @$_POST['usuario_usu'], 1, $Funcion->recibirArrayUrl(@$campo["error_1"]), 6, 'text');
                            
                            $Formulario->Texto('password_usu','password_usu', 'Clave', 'Ingresar su clave', 'Por favor ingresar su clave de usuario.', @$_POST['password_usu'], 1, @$Funcion->recibirArrayUrl(@$campo["error_2"]), 6, 'password');
                            
                            $Formulario->Texto('clave_usu2','clave_usu2', 'Repetir clave', 'Repetir su clave', 'Por favor repetir su clave de usuario.', @$_POST['clave_usu2'], 1, $Funcion->recibirArrayUrl(@$campo["error_3"]), 6, 'password');
                           
                            $Formulario->lista('tipo_usu', 'tipo_usu', 'Tipo', 'Seleccionar', 'Seleccionar tipo de Usuario', @$_POST['tipo_usu'], $opciones = array('1'=>'ADMINISTRADOR', '2'=>'USUARIO'), 1, $Funcion->recibirArrayUrl(@$campo["error_4"]), 6);
                            $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');
                            $Formulario->cerrarFieldset();

                            $Formulario->cerrarForm();
                        ?>
                  </div>

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                          <div class="panel-body">
                            
                             <?php $Plantilla->tabla('usuarios', 'status_usu=1', 'Usuario', 'lista_usu', array("usuario_usu"=>"USUARIO", "status_usu"=>"ACTIVO", "conectado_usu"=>"CONECTADO"), 1); ?>
                             
                          </div>
                </div>

                 <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_2" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!--<div class="modal-header"><i class="fa fa-lock"></i> Ingresar Usuario
                            <button type="button" class="close" data-dismiss="modal">x</button><br/>
                            <h4 class="modal-title"></h4>
                          </div>-->

                          <div class="panel-body">

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-lock"></i> Ingresar Usuario <button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>

                                <?php 
                                   //$Formulario->iniciarForm('modificar', '', '#', 'multipart/form-data');
                               
                                 /*  echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{mensaje.mensaje | capfirst}}<a href="#" class="alert-link"></a>.
                                    '.$msj.'
                                    </div>';*/
                                
                                  echo '<form method="post" class="form-horizontal" id="form_modificar">';
                                  $Formulario->iniciarFieldset('fa fa-user', 'MODIFICAR USUARIO 2:');
                                  $Formulario->campoOculto('Mid_Usuario', null);
                                  $Formulario->texto_js('Musuario_usu','Musuario_usu', 'Usuario', 'Ingresar Usuario', 'Por favor ingresar su usuario creado.', @$_POST['usuario_usu'], 1, $Funcion->recibirArrayUrl(@$campo["error_1"]), 6, 'text');
                                  
                                /*  $Formulario->Texto('Mpassword_usu','Mpassword_usu', 'Nueva Clave', 'Ingresar su clave', 'Por favor ingresar su clave de usuario.', @$_POST['password_usu'], 1, @$Funcion->recibirArrayUrl(@$campo["error_2"]), 6, 'password');
                                  
                                  $Formulario->Texto('Mclave_usu2','Mclave_usu2', 'Repetir clave', 'Repetir su clave', 'Por favor repetir su clave de usuario.', @$_POST['clave_usu2'], 1, $Funcion->recibirArrayUrl(@$campo["error_3"]), 6, 'password');
                                 */
                                  $Formulario->lista_js('Mtipo_usu', 'Mtipo_usu', 'Tipo', null, 'Seleccionar', 'Seleccionar tipo de Usuario', @$_POST['tipo_usu'], $opciones = array('1'=>'ADMINISTRADOR', '2'=>'USUARIO'), 1, $Funcion->recibirArrayUrl(@$campo["error_4"]), 6);
                                  $Formulario->boton('btn_mod_usuario', 'btn btn-primary', 'Guardar');
                                  $Formulario->cerrarFieldset();

                                  $Formulario->cerrarForm();
                                ?>
                              </div>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>

                    </div>

                    <?php
                    if(isset($editar))
                    {
                         // echo $editar['usuario_usu'];
                         /* echo ' 
                            <script type="text/javascript">
                            $(document).ready(function() {
                            $("#modal_2").modal("show" );
                             });
                          </script>';*/
                    }
                        
                   
                    ?>

                <!-- fFIN DE MODAL -->


             <!-- <fieldset><legend class="legend logo"><div class="leyenda">[NUEVO USUARIO]</div></legend>
                <div class="panel-body">
                  <?php /*
                  if(isset($msj)) {
                    echo '<div class="alert alert-'.$tipo.' alert-dismissable"><i class="fa fa-saved"></i>
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{mensaje.mensaje | capfirst}}<a href="#" class="alert-link"></a>.
                          '.$msj.'
                          </div>';
                  }
                      $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Usuario&accion=registrar', 'multipart/form-data');
                      
                      $Formulario->iniciarFieldset('fa fa-user', 'CREAR NUEVO USUARIO:');
                      $Formulario->Texto('usuario_usu','usuario_usu', 'Usuario', 'Ingresar Usuario', 'Por favor ingresar su usuario creado.', @$_POST['usuario_usu'], 1, $Funcion->recibirArrayUrl(@$campo["error_1"]), 6, 'text');
                      
                      $Formulario->Texto('password_usu','password_usu', 'Clave', 'Ingresar su clave', 'Por favor ingresar su clave de usuario.', @$_POST['password_usu'], 1, @$Funcion->recibirArrayUrl(@$campo["error_2"]), 6, 'password');
                      
                      $Formulario->Texto('clave_usu2','clave_usu2', 'Repetir clave', 'Repetir su clave', 'Por favor repetir su clave de usuario.', @$_POST['clave_usu2'], 1, $Funcion->recibirArrayUrl(@$campo["error_3"]), 6, 'password');
                     
                      $Formulario->lista('tipo_usu', 'tipo_usu', 'Tipo', 'Seleccionar', 'Seleccionar tipo de Usuario', @$_POST['tipo_usu'], $opciones = array('1'=>'ADMINISTRADOR', '2'=>'USUARIO'), 1, $Funcion->recibirArrayUrl(@$campo["error_4"]), 6);
                      $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');
                      $Formulario->cerrarFieldset();

                      $Formulario->cerrarForm();*/
                  ?>
                </div>
              </fieldset>-->

            </div>
          </div>
        </div>
      </div>
      

    <!-- Page-Level Plugin Scripts - Tables -->
    
      


    </div>

  </body>
 
</html>
