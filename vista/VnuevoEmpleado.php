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
                  <li role="presentation" class="active"><a href="#nuevo_men" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus fa-fw"></i> REGISTRAR EMPLEADO</a></li>
                  <li role="presentation"><a href="#gestor" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-fw"></i> GESTOR DE EMPLEADOS</a></li>
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
                            $Formulario->iniciarForm('login', 'post', 'index.php?controlador=Empleado&accion=registrar', 'multipart/form-data');
                            
                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL EMPLEADO:');
                                $Formulario->Texto('cedula_per','cedula_per', 'C&eacute;dula', 'Ingrese aqui ...', 'Por favor ingrese el ced&uacute;la', @$_POST['cedula_per'], 1, @$Funcion->recibirArrayUrl(@$campo["cedula_per"]), 6, 'text');
                                
                                $Formulario->Texto('nombre_per','nombre_per', 'Nombre', 'Ingrese aqui ...', 'Por favor ingrese el nombre del empleado', @$_POST['nombre_per'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_per"]), 6, 'text');
                                $Formulario->Texto('apellido_per','apellido_per', 'Apellido', 'Ingrese aqui ...', 'Por favor ingrese el apellido del empleado', @$_POST['apellido_per'], 1, @$Funcion->recibirArrayUrl(@$campo["apellido_per"]), 6, 'text');
                                $Formulario->radioBoton('sexo_per', 'sexo_per', 'Sexo', 'Seleccionar sexo del empleado', @$_POST['sexo_per'], $opciones = array('F'=>'F', 'M'=>'M'), null, @$Funcion->recibirArrayUrl(@$campo["sexo_per"]), 6);  
                                $Formulario->texto_calendar('fecha_nac_per','fecha_nac_per', 'Fecha nacimiento', 'dia/mes/a&ntilde;o', 'Por favor ingrese la fecha de nacimiento', @$_POST['fecha_nac_per'], 1, @$Funcion->recibirArrayUrl(@$campo["fecha_nac_per"]), 6, 'text');
                                
                               // $Formulario->radioBoton('activar_men', 'activar_men', 'Activar', 'Desea activar este menu.', @$_POST['activar_men'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_men"]), 6);  
                                $Formulario->lista('licencia_per', 'licencia_per', 'Licencia', 'Seleccionar', 'Seleccionar de lista', @$_POST['lincencia_per'], $opciones = array('LICENCIA DE 1ERA'=>'LICENCIA DE 1ERA', 'LICENCIA DE 2DA'=>'LICENCIA DE 2DA', 'LICENCIA DE 3ERA'=>'LICENCIA DE 3ERA', 'LICENCIA DE 4TA'=>'LICENCIA DE 4TA', 'LICENCIA DE 5TA'=>'LICENCIA DE 5TA'), null, $Funcion->recibirArrayUrl(@$campo["licencia_per"]), 6);
                              
                              $Formulario->cerrarFieldset();

                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEl CARGO:'); 
                               $Formulario->lista('id_Cargo', 'id_Cargo', 'Cargos', 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Cargo'], $cargo, 1, $Funcion->recibirArrayUrl(@$campo["id_Cargo"]), 6);
                              
                              $Formulario->cerrarFieldset();


                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE DIRECCI&Oacute;N:');
                               $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('id_Estado', 'id_Ciudad'));
                               $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('id_Estado', 'id_Municipio'));
                               $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('id_Municipio', 'id_Parroquia'));
                                
                                //$evento = array('evento'=>'onclick', 'nombre'=>'editar' ,'parametros'=>array(6, 'usuario', 2, 4, 5, 'juan'));
                                $Formulario->lista_2('id_Estado', 'id_Estado', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Estado'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["id_Estado"]), 6);
                                    
                                $Formulario->lista_2('id_Ciudad', 'id_Ciudad', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['id_Ciudad'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Ciudad"]), 6);
                                $Formulario->lista_2('id_Municipio', 'id_Municipio', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Municipio'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Municipio"]), 6);
                                $Formulario->lista_2('id_Parroquia', 'id_Parroquia', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Parroquia'], null, 1, $Funcion->recibirArrayUrl(@$campo["id_Parroquia"]), 6);
                              
                                $Formulario->textArea('direccion_per','direccion_per', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['direccion_per'], null, @$Funcion->recibirArrayUrl(@$campo["direccion_per"]), 6, 'text');
                              
                              $Formulario->cerrarFieldset();

                              $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE CONTACTO:');
                                $Formulario->Texto('telefono_movil_per','telefono_movil_per', 'Telefono m&oacute;vil', 'Ingrese aqui ...', 'Por favor ingrese el telefono celular de contacto', @$_POST['telefono_movil_per'], 1, @$Funcion->recibirArrayUrl(@$campo["telefono_movil_per"]), 6, 'text');
                                $Formulario->Texto('telefono_fijo_per','telefono_fijo_per', 'Telefono Fijo', 'Ingrese aqui ...', 'Por favor ingrese el telefono local de contacto', @$_POST['telefono_fijo_per'], 1, @$Funcion->recibirArrayUrl(@$campo["telefono_fijo_per"]), 6, 'text');
                                $Formulario->Texto('correo_per','correo_per', 'Correo', 'Ingrese aqui ...', 'Por favor ingrese una direcci&oacute;n de correo electronico', @$_POST['correo_per'], null, @$Funcion->recibirArrayUrl(@$campo["correo_per"]), 6, 'text');
                                //$Formulario->textArea_js('comentario_con','comentario_con', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['comentario_con'], null, @$Funcion->recibirArrayUrl(@$campo["comentario_con"]), 6, 'text');
                              
                              $Formulario->cerrarFieldset();

                              $Formulario->botonSubmit('enviar', 'btn btn-primary', 'Guardar');

                            $Formulario->cerrarForm();
                        ?>
                  </div>
                  

                </div>
                  
                <div role="tabpanel" class="tab-pane" id="gestor">
                  <div class="panel-body">
                    <?php $Plantilla->tabla_join('personas as P, empleados as E, cargos as C', '(P.id_Persona=E.id_Persona AND E.id_Cargo=C.id_Cargo) AND E.status_emp=1', 'Empleado', 'lista_emp', array("P.cedula_per"=>"CEDULA", "P.nombre_per"=>"NOMBRE", "P.apellido_per"=>"APELLIDO", "P.telefono_movil_per"=>"TELEFONO", "C.nombre_car"=>"CARGO"), 1); ?> 
                  </div>
                </div>

                 <!-- CONTENIDO -->
                    <div style="display:None;" id="modal_modificar_empleado" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <!--<div class="modal-header"><i class="fa fa-lock"></i> Ingresar Usuario
                            <button type="button" class="close" data-dismiss="modal">x</button><br/>
                            <h4 class="modal-title"></h4>
                          </div>-->

                          <div class="panel-body">

                            <fieldset class="scheduler-border"><legend class="scheduler-border"><i class="fa fa-pencil"></i> Modificar Empleado<button type="button" class="close" data-dismiss="modal">x</button></legend>
                              <div class="panel-body">
                              <div id="respuesta"></div>

                                <?php 
                                  echo '<form method="post" action="#" class="form-horizontal" id="form_modificar_empleado_ajax">';
                                    $Formulario->campoOculto('Mid_Empleado', null);
                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEL EMPLEADO:');
                                        $Formulario->Texto_js('Mcedula_per','Mcedula_per', 'C&eacute;dula', 'Ingrese aqui ...', 'Por favor ingrese el ced&uacute;la', @$_POST['cedula_per'], 1, @$Funcion->recibirArrayUrl(@$campo["cedula_per"]), 6, 'text');
                                        
                                        $Formulario->Texto_js('Mnombre_per','Mnombre_per', 'Nombre', 'Ingrese aqui ...', 'Por favor ingrese el nombre del empleado', @$_POST['nombre_per'], 1, @$Funcion->recibirArrayUrl(@$campo["nombre_per"]), 6, 'text');
                                        $Formulario->Texto('Mapellido_per','Mapellido_per', 'Apellido', 'Ingrese aqui ...', 'Por favor ingrese el apellido del empleado', @$_POST['apellido_per'], 1, @$Funcion->recibirArrayUrl(@$campo["apellido_per"]), 6, 'text');
                                        $Formulario->radioBoton_js('Msexo_per', 'Msexo_per', 'Sexo', 'Seleccionar sexo del empleado', @$_POST['sexo_per'], $opciones = array('F'=>'F', 'M'=>'M'), null, @$Funcion->recibirArrayUrl(@$campo["sexo_per"]), 6);  
                                        $Formulario->texto_calendar_js('Mfecha_nac_per','Mfecha_nac_per', 'Fecha nacimiento', 'dia/mes/a&ntilde;o', 'Por favor ingrese la fecha de nacimiento', @$_POST['fecha_nac_per'], 1, @$Funcion->recibirArrayUrl(@$campo["fecha_nac_per"]), 6, 'text');
                                        
                                       // $Formulario->radioBoton('activar_men', 'activar_men', 'Activar', 'Desea activar este menu.', @$_POST['activar_men'], $opciones = array(1=>'SI', 0=>'NO'), 1, @$Funcion->recibirArrayUrl(@$campo["activar_men"]), 6);  
                                        $Formulario->lista_js('Mlicencia_per', 'Mlicencia_per', 'Licencia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['lincencia_per'], $opciones = array('LICENCIA DE 1ERA'=>'LICENCIA DE 1ERA', 'LICENCIA DE 2DA'=>'LICENCIA DE 2DA', 'LICENCIA DE 3ERA'=>'LICENCIA DE 3ERA', 'LICENCIA DE 4TA'=>'LICENCIA DE 4TA', 'LICENCIA DE 5TA'=>'LICENCIA DE 5TA'), null, $Funcion->recibirArrayUrl(@$campo["licencia_per"]), 6);
                                      
                                      $Formulario->cerrarFieldset();

                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DEl CARGO:'); 
                                       $Formulario->lista_js('Mid_Cargo', 'Mid_Cargo', 'Cargos', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['id_Cargo'], $cargo, 1, $Funcion->recibirArrayUrl(@$campo["id_Cargo"]), 6);
                                      
                                      $Formulario->cerrarFieldset();


                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE DIRECCI&Oacute;N:');
                                       $event_estado = array('evento'=>'onchange', 'nombre'=>'ajaxCargarCiudad' ,'parametros'=>array('Mid_Estado', 'Mid_Ciudad'));
                                       $event_ciudad = array('evento'=>'onchange', 'nombre'=>'ajaxCargarMunicipio' ,'parametros'=>array('Mid_Estado', 'Mid_Municipio'));
                                       $event_municipio = array('evento'=>'onchange', 'nombre'=>'ajaxCargarParroquia' ,'parametros'=>array('Mid_Municipio', 'Mid_Parroquia'));
                                        
                                        //$evento = array('evento'=>'onclick', 'nombre'=>'editar' ,'parametros'=>array(6, 'usuario', 2, 4, 5, 'juan'));
                                        $Formulario->lista_js('Mid_Estado', 'Mid_Estado', 'Estado', $event_estado, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Estado'], $estado, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Estado"]), 6);
                                            
                                        $Formulario->lista_js('Mid_Ciudad', 'Mid_Ciudad', 'Ciudad', $event_ciudad,'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Ciudad'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Ciudad"]), 6);
                                        $Formulario->lista_js('Mid_Municipio', 'Mid_Municipio', 'Municipio', $event_municipio, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Municipio'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Municipio"]), 6);
                                        $Formulario->lista_js('Mid_Parroquia', 'Mid_Parroquia', 'Parroquia', null, 'Seleccionar', 'Seleccionar de lista', @$_POST['Mid_Parroquia'], null, 1, $Funcion->recibirArrayUrl(@$campo["Mid_Parroquia"]), 6);
                                      
                                        $Formulario->textArea_js('Mdireccion_per','Mdireccion_per', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['Mdireccion_per'], null, @$Funcion->recibirArrayUrl(@$campo["Mdireccion_per"]), 6, 'text');
                                      
                                      $Formulario->cerrarFieldset();

                                      $Formulario->iniciarFieldset('fa fa-link', 'DATOS DE CONTACTO:');
                                        $Formulario->Texto_js('Mtelefono_movil_per','Mtelefono_movil_per', 'Telefono m&oacute;vil', 'Ingrese aqui ...', 'Por favor ingrese el telefono celular de contacto', @$_POST['Mtelefono_movil_per'], 1, @$Funcion->recibirArrayUrl(@$campo["Mtelefono_movil_per"]), 6, 'text');
                                        $Formulario->Texto_js('Mtelefono_fijo_per','Mtelefono_fijo_per', 'Telefono Fijo', 'Ingrese aqui ...', 'Por favor ingrese el telefono local de contacto', @$_POST['Mtelefono_fijo_per'], 1, @$Funcion->recibirArrayUrl(@$campo["Mtelefono_fijo_per"]), 6, 'text');
                                        $Formulario->Texto_js('Mcorreo_per','Mcorreo_per', 'Correo', 'Ingrese aqui ...', 'Por favor ingrese una direcci&oacute;n de correo electronico', @$_POST['Mcorreo_per'], null, @$Funcion->recibirArrayUrl(@$campo["Mcorreo_per"]), 6, 'text');
                                        //$Formulario->textArea_js('comentario_con','comentario_con', 'Direcci&oacute;n', 'Escriba aqui ....', 'Por favor ingresar el contenido aqui ...', @$_POST['comentario_con'], null, @$Funcion->recibirArrayUrl(@$campo["comentario_con"]), 6, 'text');
                                      
                                      $Formulario->cerrarFieldset();
                                    $Formulario->boton('btn_modificar_empleado_ajax', 'btn btn-primary', 'Guardar');
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
