<?php
Class PlantillaAdmin
{
  Public function head()
  {
    echo 
    '
    <meta charset="utf-8">
      <title>FRIOPAN 9287 </title>
      
        <!-- **********+libreria prototype ************************************ -->
          <!-- Core CSS - Include with every page -->
      <link href="plantillas/01/css/bootstrap.css" rel="stylesheet">
      <link href="plantillas/01/font-awesome/css/font-awesome.css" rel="stylesheet">

      <!-- Page-Level Plugin CSS - Dashboard -->
      <link href="plantillas/01/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
      <link href="plantillas/01/css/plugins/timeline/timeline.css" rel="stylesheet">

      <!-- SB Admin CSS - Include with every page -->
      <link href="plantillas/01/css/sb-admin.css" rel="stylesheet">
      <script src="plantillas/01/js/jquery-1.10.2.js"></script>
      <link href="plantillas/01/css/jquery-ui-1.10.4.custom.css" rel="stylesheet">
      <script src="plantillas/01/js/jquery-ui-1.10.4.custom.js"></script>

      <script src="plantillas/01/js/bootstrap.min.js"></script>
      <link href="plantillas/01/css/style.css" rel="stylesheet">

      <script src="plantillas/01/js/funciones_ajax.js"></script>

      <!-- MOSTRAR TABLA JQUERY -->
      <script src="plantillas/01/js/plugins/metisMenu/jquery.metisMenu.js"></script>
      <script src="plantillas/01/js/plugins/dataTables/jquery.dataTables.js"></script> <!-- esta linea coloca el buscador en la tablas -->
      <script src="plantillas/01/js/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script src="plantillas/01/js/sb-admin.js"></script>
      <!-- FIN MOSTRAR TABLA JQUERY -->

       <script src="librerias/ckeditor/ckeditor.js"></script>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
    ';
      
  }

  Public function tabla_permiso_guia()
  {
      require_once 'modelo/PermisoModel.php';
      $PermisoModel = new PermisoModel('modelo/PermisoModel.php');

      //$td = $PermisoModel->consultar('permisos as P, permisos_system as PS, usuarios as U', '(P.id_Usuario=U.id_Usuario && P.id_PermisoSystem=PS.id_PermisoSystem)', 2, null);
      //$th = $PermisoModel->consultar('permisos_system as PS', 'PS.status_sys=1 ORDER BY PS.id_PermisoSystem ASC', 2, null);
      
      $th = $PermisoModel->consultar('permisos as P, usuarios as U', 'P.id_Usuario=U.id_Usuario ORDER BY P.id_Permiso ASC', 2, null);
      $td = $PermisoModel->consultar('permisos as P, usuarios as U', 'P.id_Usuario=U.id_Usuario ORDER BY P.id_Permiso ASC', 2, null);
	    $tr = $PermisoModel->consultar('permisos as P, usuarios as U', 'P.id_Usuario=U.id_Usuario ORDER BY P.id_Permiso ASC', 2, null);
	    $usuario = $PermisoModel->consultar('permisos as P, usuarios as U', 'P.id_Usuario=U.id_Usuario ORDER BY P.id_Permiso ASC', 2, null);
        echo '<div class="table-responsive">
                <div class=""> 
                  <table class="table table-striped table-bordered table-hover fija" id="tabla_permiso">
                    <thead><tr><th style="width:10px;"><center>#</center></th>';
                    echo '<th width="100px;"><center>USUARIO</center></th>';
                      while($rowTH = $th->fetch())
                      {
                        echo '<th width="100px;"><center>'.$rowTH["nombre_prm"].'</center></th>'; 
                      }

                      echo '</tr></thead>
                      <tbody> ';
                      $j=0;
					  $i=0;
						
						
					while($rowUS = $usuario->fetch())
                    {	
					  $i++; $i = $i +1;
                      echo '<tr id="tr_Permiso_" >';
					  echo '<td class="Edit_td" style="width:5px;" ><center>'.$i.'</center></td>';
					  echo '<td class="Edit_td" style="width:5px;" ><center>'.$rowUS["usuario_usu"].'</center></td>';
						  while($rowTD = $td->fetch())
						  {
							$j++;
							if($rowTD['id_Usuario'] == $rowUS['id_Usuario'])
							{
								
									echo '<td class="Edit_td" style="width:5px;" ><center>'.$rowTD["accion_prm"].'b</center></td>';
								
								
									echo '<td class="Edit_td" style="width:5px;" ><center>'.$rowTD["controlador_prm"].'b</center></td>';
								
							}
							/*
							if($j==2){
								echo '<td class="Edit_td" style="width:5px;" ><center></center></td>';  
							}
							$id_Usuario = $rowTD["usuario_usu"];
							echo '<td class="Edit_td" style="width:5px;" ><center>'.$rowTD["usuario_usu"].'b</center></td>';
							 */          
						  }
					   echo '</tr>';
					}
					
                    echo '
                      </tbody>
                  </table>
                </div>
              </div>';
  }

  Public function tabla_guia_per($tabla, $where, $modelo, $nombre, $opciones=array(), $tipo=null)
  {
      require_once 'libs/Funciones.class.php';
      $Funcion = new Funcion('libs/Funciones.class.php');
      require_once 'libs/ValidarForm.class.php';
      $ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
      require_once 'modelo/'.$modelo.'Model'.'.php';  
      @$m .= $modelo.'Model';
      $Modelo = new $m('modelo/'.$modelo.'Model'.'.php');
      $id = 'id_Pedido'; //hace referencia al campo id de tabla modelo.
      $i=0;
      foreach($opciones as $key => $value) 
      {
        $i++;
        if ($i==1) 
        {
          @$campos .= $id.','.$key;
        }else
        {
          $campos .= ','.$key;
        }
      }
      //echo ''.$tabla.',<br>'.$where.',<br>'.$campos.'';
      //SELECT id_Transporte,Tra.tipo_tra,Tra.marca_tra FROM pedidos as Ped, transportes as Tra WHERE (Ped.id_Transporte=Tra.id_Transporte)
      $consulta = $Modelo->consultar('pedidos as Ped, transportes as Tra, facturas as Fac, personas as Per, clientes as Cli, rutas as Rut, estados as Est , ciudades as Ciu, municipios as Mun, parroquias as Par, empleados as Emp', '((Ped.id_Transporte=Tra.id_Transporte AND Ped.id_Factura=Fac.id_Factura AND Ped.id_Ruta=Rut.id_Ruta AND Rut.id_Estado=Est.id_Estado AND Rut.id_Ciudad=Ciu.id_Ciudad AND Rut.id_Municipio=Mun.id_Municipio AND Rut.id_Parroquia=Par.id_Parroquia) AND (Fac.id_Cliente=Cli.id_Cliente AND  Cli.id_Persona=Per.id_Persona) AND (Ped.id_Empleado=Emp.id_Empleado))', 2, null);

      if($consulta)
      {
        echo '<div class="table-responsive">
                <div class=""> 
                  <table class="table table-striped table-bordered table-hover fija" id="'.$nombre.'">
                    <thead><tr><th style="width:10px;"><center>#</center></th>';
                      
                        echo '
                            <th width="100px;"><center>CLIENTE</center></th>
                            <th width="100px;"><center>TRANSPORTE</center></th>
                            <th width="100px;"><center>RUTA</center></th>
                            <th width="70px;"><center>ESTATUS</center></th>
                            <th width="90px;"><center>PAGO</center></th>
                           <!-- <th width="60px;" style=""  ><center><i class="fa fa-cogs"></i> </center></th>
                            <th style="width:60px;"  ><center><i class="fa fa-cogs fa-4" ></i> </center></th>-->';
                       

                      echo '</tr></thead><tbody> ';

                      $j=0;
                      while($row = $consulta->fetch())
                      {
                        $j++;
                        $id_Empleado = $row["id_Empleado"];

                        $resultSQL = $Modelo->consultar('empleados as E, personas P', "(E.id_Persona=P.id_Persona AND E.id_Empleado=$id_Empleado) AND P.status_per=1", 'assoc', null);
                        echo '<tr id="tr_Pedido_'.$row["$id"].'" ><td id="contador_'.$row["$id"].'" class="Edit_td" style="width:5px;" ><center>'.$j.'</center></td>';
                        echo '<td class="Edit_td" id="td_cliente_'.$row["$id"].'">
                                <dl>
                                  <dt><b><i class="fa fa-chevron-circle-right "></i> Info. Cliente:</b></dt>
                                  <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>CI:</b>'.$row["cedula_per"].'</dd>
                                  <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>Nombre:</b>'.$row["apellido_per"].' '.$row["nombre_per"].'</dd>
                               ';
                               if(!empty($row["telefono_movil_per"]))
                               {
                                  echo '<dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>Telf:</b>'.$row["telefono_movil_per"].'</dd>';
                               }
                               echo'
                                </dl>
                              </td>
                              <td class="Edit_td" id="td_transporte_'.$row["$id"].'">
                                <dl>
                                  <dt><b><i class="fa fa-chevron-circle-right "></i> Transporte:</b></dt>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Tipo:</b>'.$row["tipo_tra"].' </dd>
                                    <!-- <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cod. Barra:</b>'.$row["matricula_tra"].'</dd> -->
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Placa:</b>'.$row["matricula_tra"].'</dd>
                                    <dt><b><i class="fa fa-chevron-circle-right "></i> Chofer:</b></dt>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> CI:</b>'.$resultSQL["cedula_per"].'</dd>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Nombre:</b>'.$resultSQL["apellido_per"].' '.$resultSQL["nombre_per"].'</dd>
                                    ';
                                    if(!empty($resultSQL["telefono_movil_per"]))
                                    {
                                       echo '<dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>Telf:</b>'.$resultSQL["telefono_movil_per"].'</dd>';
                                    }
                                    echo'
                                </dl>
                              </td>
                              <td class="Edit_td" id="td_ruta_'.$row["$id"].'">
                                <dl>
                                  <dt><b><i class="fa fa-chevron-circle-right "></i> Destino:</b></dt>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>Edo.</b> '.$row["estado"].'</dd>
                                    <b><dd>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Ciud. </b>'.$row["ciudad"].'</dd>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Muni. </b>'.$row["municipio"].'</dd>
                                    <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Parroq. </b>'.$row["parroquia"].'</dd>
                                <dl>
                              </td>
                             
                              <td class="Edit_td" id="td_estado_ped_'.$row["$id"].'">
                                <div class="row" id="div_estado_ped_'.$row["$id"].'">
                                <center><i class="fa fa-chevron-circle-right  "></i> '.$row["estado_ped"].'</center>';
                                if($row["estado_ped"]<>"DISPONIBLE") 
                                {
                                  echo '<br><p class="text-center"><a href="#" onclick="actualizar_estado_pedido_ajax('.$row["id_Pedido"].', '.$row["codigo_fac"].');"><small><em><i class="fa fa-refresh"></i>  Actualizar</a></em></small></p>';
                                } 
                                echo'</div>
                              </td>
                              <td class="Edit_td" id="td_pago_'.$row["$id"].'">
                                <dl>
                                  <dt><i class="fa fa-chevron-circle-right "></i><b> Info. Factura </b></dt>
                                 <!-- <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Numero:</b>'.$row["codigo_fac"].'</dd>-->
                                  <dd><b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>  Monto:</b> Bs '.$row["total_fac"].'</dd>
                                </dl>
                                <br>
                                
                                <div class="row" id="div_factura_'.$row["$id"].'">
                                 <!-- <div class="col-md-7"><p class="text-left"><a href="#"><small><em><i class="fa fa-download"></i>  Descargar</a></em></small></p></div> -->
                                  <div class="col-md-5"><p class="text-right"><a href="#" onclick="ver_factura('.$row["id_Factura"].');"><small><em><i class="fa fa-eye"></i>  Ver</a></em></small></p></div>
                                  <div class="col-md-5"><p class="text-right"><a href="#" onclick="anular_factura('.$row["id_Factura"].', '.$row["$id"].');"><small><em><i class="fa fa-trash"></i>  Anular</a></em></small></p></div>
                                </div>
                              
                              </td>
                          <!--<td style="width:40px;" ><a href="#"  onclick="editar'.$modelo.'('.$row["$id"].');" class="btn-xs primary"><i class="fa fa-pencil fa-fw"></i> EDITAR</a></td>
                          <td width="40px;" ><a href="#" id="#" onclick="eliminar'.$modelo.'('.$row["$id"].');"  class="btn-xs primary"><i class="fa fa-trash"></i> ELIMINAR</a></td>-->
                          ';
                        
                        echo '</tr>'; 

                        if($row["status_fac"]==0)
                        {
                          $ValidarForm->css_tr($row["id_Pedido"]);
                        }              
                      }
 
                      echo ' </tbody></table></div></div>
                          <script>
                              $(document).ready(function() {
                                  $("#'.$nombre.'").dataTable();
                              });
                          </script>';
      }else
      {
        echo '<div class="alert alert-info alert-dismissable"><i class="fa fa-saved"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-circle fa"></i>  NO HAY DATOS REGISTRADOS<a href="#" class="alert-link"></a>.
              </div>';
      }
  }

  Public function tabla_guia_join($tabla, $where, $modelo, $nombre, $opciones=array(), $tipo=null)
  {
      require_once 'modelo/'.$modelo.'Model'.'.php';  
      @$m .= $modelo.'Model';
      $Modelo = new $m('modelo/'.$modelo.'Model'.'.php');
      $id = 'id_'.$modelo; //hace referencia al campo id de tabla modelo.
      $i=0;
      foreach($opciones as $key => $value) 
      {
        $i++;
        if ($i==1) 
        {
          @$campos .= $id.','.$key;
        }else
        {
          $campos .= ','.$key;
        }
      }

      $consulta = $Modelo->consultar($tabla, $where, 4, $campos);

      if($consulta)
      {
        echo '<div class="table-responsive">
                <div class=""> 
                  <table class="table table-striped table-bordered table-hover fija" id="'.$nombre.'">
                    <thead><tr><th style="width:36px;"><center>#</center></th>';
                      foreach ($opciones as $key => $value) 
                      {
                        echo '
                            <th width="100px;"><center>'.$value.'</center></th>
                            <!--<th width="17%" ><i class="fa fa-pencil"></i> EDITAR</th>-->
                             '; 
                      }
                      if ($tipo!=null) 
                      {
                        if ($tipo==1) 
                        {
                          echo'<th width="70px;" style=""  ><center><i class="fa fa-cogs"></i> </center></th>';
                        } 
                      }

                      echo '</tr></thead><tbody> ';

                      $j=0;
                      while($row = $consulta->fetch())
                      {
                        $j++;
                        echo '<tr id="tr_'.$row["$id"].'" ><td class="Edit_td" style="width:5px;" ><center>'.$j.'</center></td>';
                        foreach($opciones as $key => $value) 
                        {
                          $key = explode('.', $key);
                          //echo $key[1];
                          echo '<td class="Edit_td" id="td_'.$key[1].'_'.$row["$id"].'"><center>'.$row[''.$key[1].''].'</center></td>'; 
                        }
                        
                        if ($tipo!=null) 
                        {
                          if ($tipo==1) 
                          {
                            
                            echo'<td class="Edit_td" ><a href="#"  onclick="agregarRutaAjax('.$row["$id"].');" class="btn-xs primary"><i class="fa fa-plus fa-fw"></i> A&ntilde;adir</a></td>
                            ';
                          }   
                        }
                        echo '</tr>';               
                      }
 
                      echo ' </tbody></table></div></div>
                          <script>
                              $(document).ready(function() {
                                  $("#'.$nombre.'").dataTable();
                              });
                          </script>';
      }else
      {
        echo '<div class="alert alert-info alert-dismissable"><i class="fa fa-saved"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-circle fa"></i>  NO HAY DATOS REGISTRADOS<a href="#" class="alert-link"></a>.
              </div>';
      }
  }

  Public function tabla($tabla,$where, $modelo, $nombre, $opciones=array(), $tipo=null)
  {
    require_once 'modelo/'.$modelo.'Model'.'.php';  
    @$m .= $modelo.'Model';
    $Modelo = new $m('modelo/'.$modelo.'Model'.'.php');
    $id = 'id_'.$modelo; //hace referencia al campo id de tabla modelo.
    $i=0;
    foreach($opciones as $key => $value) 
    {
      $i++;
      if ($i==1) 
      {
        @$campos .= $id.','.$key;
      }else
      {
        $campos .= ','.$key;
      }
    }

    $cadena = 'status_'.substr($tabla, 0,3);
   // echo $cadena;
    $consulta = $Modelo->consultar($tabla, $where, 4, $campos);

    if($consulta)
    {
      echo '<div class="table-responsive">
              <div class=""> 
                <table class="table table-striped table-bordered table-hover fija" id="'.$nombre.'">
                  <thead><tr><th style="width:10px;"><center>#</center></th>';
                    foreach ($opciones as $key => $value) 
                    {
                      echo '<th width="100px;"><center>'.$value.'</center></th>
                            <!--<th width="17%" ><i class="fa fa-pencil"></i> EDITAR</th>-->';
                    }
                    if ($tipo!=null) 
                    {
                      if ($tipo==1) 
                      {
                        echo'<th width="60px;" style=""  ><center><i class="fa fa-cogs"></i> </center></th>
                          <th style="width:60px;"  ><center><i class="fa fa-cogs fa-4" ></i> </center></th>';
                      }
                    }
                    echo '</tr>
                  </thead>
                  <tbody> ';
                    $j=0;
                    while($row = $consulta->fetch())
                   {
                      $j++;
                      echo '<tr id="tr_'.$modelo.'_'.$row["$id"].'" ><td class="Edit_td" style="width:5px;" ><center>'.$j.'</center></td>';
                      foreach($opciones as $key => $value) 
                      {
                        echo '<td class="Edit_td" id="td_'.$key.'_'.$row["$id"].'"><center>'.$row[''.$key.''].'</center></td>'; 
                      }
                    
                      if ($tipo!=null) 
                      {
                        if ($tipo==1) {
                          echo'<td class="Edit_td" style="width:40px;" ><a href="#"  onclick="editar'.$modelo.'('.$row["$id"].');" class="btn-xs primary"><i class="fa fa-pencil fa-fw"></i> EDITAR</a></td>
                          <td class="Edit_td" width="40px;" ><a href="#" id="#" onclick="eliminar'.$modelo.'('.$row["$id"].');" class="btn-xs primary"><i class="fa fa-trash"></i> ELIMINAR</a></td>';
                        }
                      }
                      echo '</tr>';
                    }
                    echo '
                  </tbody>
                </table>
              </div>
            </div>
            <script> $(document).ready(function() {$("#'.$nombre.'").dataTable();});</script>';
    }else
    {
      echo '<div class="alert alert-info alert-dismissable"><i class="fa fa-saved"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-circle fa"></i>  NO HAY DATOS REGISTRADOS<a href="#" class="alert-link"></a>.</div>';
    }
  }

  Public function tabla_join($tabla, $where, $modelo, $nombre, $opciones=array(), $tipo=null)
  {
      require_once 'modelo/'.$modelo.'Model'.'.php';  
      @$m .= $modelo.'Model';
      $Modelo = new $m('modelo/'.$modelo.'Model'.'.php');
      $id = 'id_'.$modelo; //hace referencia al campo id de tabla modelo.
      $i=0;
      foreach($opciones as $key => $value) 
      {
        $i++;
        if ($i==1) 
        {
          @$campos .= $id.','.$key;
        }else
        {
          $campos .= ','.$key;
        }
      }
      //echo ''.$tabla.',<br>'.$where.',<br>'.$campos.'';
      //SELECT id_Transporte,Tra.tipo_tra,Tra.marca_tra FROM pedidos as Ped, transportes as Tra WHERE (Ped.id_Transporte=Tra.id_Transporte)
      $consulta = $Modelo->consultar($tabla, $where, 4, $campos);

      if($consulta)
      {
        echo '<div class="table-responsive">
                <div class=""> 
                  <table class="table table-striped table-bordered table-hover fija" id="'.$nombre.'">
                    <thead><tr><th style="width:10px;"><center>#</center></th>';
                      foreach ($opciones as $key => $value) 
                      {
                        echo '
                            <th width="100px;"><center>'.$value.'</center></th>
                            <!--<th width="17%" ><i class="fa fa-pencil"></i> EDITAR</th>-->
                             '; 
                      }
                      if ($tipo!=null) 
                      {
                        if ($tipo==1) 
                        {
                          echo'<th width="60px;" style=""  ><center><i class="fa fa-cogs"></i> </center></th>
                               <th style="width:60px;"  ><center><i class="fa fa-cogs fa-4" ></i> </center></th>';
                        } 
                      }

                      echo '</tr></thead><tbody> ';

                      $j=0;
                      while($row = $consulta->fetch())
                      {
                        $j++;
                        echo '<tr id="tr_'.$modelo.'_'.$row["$id"].'" ><td class="Edit_td" style="width:5px;" ><center>'.$j.'</center></td>';
                        foreach($opciones as $key => $value) 
                        {
                          $key = explode('.', $key);
                          //echo $key[1];
                          echo '<td class="Edit_td" id="td_'.$key[1].'_'.$row["$id"].'"><center>'.$row[''.$key[1].''].'</center></td>'; 
                        }
                        
                        if ($tipo!=null) 
                        {
                          if ($tipo==1) 
                          {
                            
                            echo'<td class="Edit_td" style="width:40px;" ><a href="#"  onclick="editar'.$modelo.'('.$row["$id"].');" class="btn-xs primary"><i class="fa fa-pencil fa-fw"></i> EDITAR</a></td>
                            <td class="Edit_td" width="40px;" ><a href="#" id="#" onclick="eliminar'.$modelo.'('.$row["$id"].');"  class="btn-xs primary"><i class="fa fa-trash"></i> ELIMINAR</a></td>';
                          }   
                        }
                        echo '</tr>';               
                      }
 
                      echo ' </tbody></table></div></div>
                          <script>
                              $(document).ready(function() {
                                  $("#'.$nombre.'").dataTable();
                              });
                          </script>';
      }else
      {
        echo '<div class="alert alert-info alert-dismissable"><i class="fa fa-saved"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-circle fa"></i>  NO HAY DATOS REGISTRADOS<a href="#" class="alert-link"></a>.
              </div>';
      }
  }

	Public function footer()
	{

		echo '<div class="container_16" id="footer">Panel Administrativo del sitio <b>Corre:</b><a href="#"> joelalexanderlamacastillo@gmail.com</a></div>';
	}
	
	Public function menuSuperior(){

		echo '<nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="log" class="navbar-brand" href="index.php"><i class="fa fa-home fa-fw"></i>'.Idioma::TITULO_SISTEMA.'</a>
            </div>

            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">';
              if(isset($_SESSION["usuario"]))
              {
              	echo '<a><em>'.Idioma::USUARIO.':'.$_SESSION["usuario"].' </em></a> ';
              }
              echo '
              <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                       <li>
                            <a href="index.php?controlador=Menu&accion=registrar" >
                                <div>
                                    <i class="fa fa-server fa-fw"></i> '.Idioma::MENU.'
                                    <span class="pull-right text-muted small"><i title="'.Idioma::MENU.'" class="fa fa-info-circle fa-fw"></i></span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?controlador=SubMenu&accion=registrar">
                                <div>
                                    <i class="fa fa-bars fa-fw"></i> '.Idioma::SUBMENU.'
                                    <span class="pull-right text-muted small"><i title="'.Idioma::SUBMENU.'" class="fa fa-info-circle fa-fw"></i></span>
                                </div>
                            </a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="index.php?controlador=Permiso&accion=registrar">
                                <div>
                                    <i class="fa fa-lock fa-fw"></i> '.Idioma::PERMISOS.'
                                    <span class="pull-right text-muted small"><i title="'.Idioma::PERMISOS.'" class="fa fa-info-circle fa-fw"></i></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
              </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-info-circle fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                   
                      <li class="divider"></li>
                      <li>
                            <a href="media/pdf/manual/MANUAL.pdf" target="_black">
                                <div>
                                    <i class="fa fa-download fa-fw"></i> Manual de usuario
                                    <span class="pull-right text-muted small">Descargar Pdf</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                      
                        <li>
                            <a class="text-center" href="#">
                                <strong></strong>
                                
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                      <li><a href="index.php?controlador=Usuario&accion=registrar"><i class="fa fa-sign-out fa-fw"></i>'.Idioma::NUEVO_USUARIO.'</a></li>
                      <li class="divider"></li>
                      ';
                       		if(isset($_SESSION["id"]))
                       		{
                       			echo '<li><a href="index.php?controlador=Usuario&accion=salir"><i class="fa fa-sign-out fa-fw"></i>'.Idioma::SALIR.'</a></li>';
                       		}else
                       		{
                       			echo '<li><a href="index.php?controlador=Usuario&accion=iniciarSession"><i class="fa fa-sign-out fa-fw"></i>'.Idioma::INICIAR_SESION.'</a></li>';
                       		}
                           
                      
                            echo'
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>';

	}

	Public function menuIzquierdo()
  {

		require_once "modelo/MenuModel.php";
    $modelo = new MenuModel("modelo/MenuModel.php");
    $menu =  $modelo->consultar('menus', 'status_men=1 AND activar_men=1 ORDER BY posicion_men ASC', 2);
    require_once "modelo/SubMenuModel.php";
    $modeloSub = new SubMenuModel("modelo/SubMenuModel.php");
    echo '<nav class="navbar-inverse2 navbar-static-side" role="navigation">
            <div class="sidebar-collapse legend">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        
                        <!-- /input-group -->
                    </li>
                    ';

                    $i=0;
                    while($menuArray = $menu->fetch())
                    {
                      $i++;
                      if ($i == 10) 
                      {
                        break;
                      }
                      if($menuArray["id_Menu"]!=null)
                      {

                        echo '<li>';
                        if((empty($menuArray["url_men"])) OR ($menuArray["url_men"]=='#'))
                        {
                          echo'<a id="menu_'.$menuArray["id_Menu"].'" href="#" onclick="'.html_entity_decode($menuArray["evento_men"], ENT_QUOTES, "UTF-8").'" ><i class="fa '.$menuArray["clase_men"].' fa-fw"></i> <span class="fa arrow"></span>'.$menuArray["etiqueta_men"].'</a>';
                        }else
                        {
                          echo'<a id="menu_'.$menuArray["id_Menu"].'" href="'.$menuArray["url_men"].'" ><i class="fa '.$menuArray["clase_men"].' fa-fw"></i> <span class="fa arrow"></span>'.$menuArray["etiqueta_men"].'</a>';
                        }
                        $submenu =  $modeloSub->consultar('submenus', 'id_Menu='.$menuArray["id_Menu"].' && status_sub=1 && activar_sub=1 ORDER BY posicion_sub ASC', 2);
                        echo'<ul class="nav nav-second-level">';
                        while($submenuArray = $submenu->fetch())
                        {
                          if((empty($submenuArray["url_sub"])) OR ($submenuArray["url_sub"]=='#'))
                          {
                            echo'<li><a id="submenu_'.$submenuArray["id_SubMenu"].'" href="#"  onclick="'.$submenuArray["evento_sub"].'"><i class="fa '.$submenuArray["clase_sub"].' fa-fw"></i>'.$submenuArray["etiqueta_sub"].'</a></li>';
                          }else
                          {
                            echo'<li><a id="submenu_'.$submenuArray["id_SubMenu"].'" href="'.$submenuArray["url_sub"].'" '.html_entity_decode($submenuArray["evento_sub"], ENT_QUOTES, "UTF-8").' ><i class="fa '.$submenuArray["clase_sub"].' fa-fw"></i>'.$submenuArray["etiqueta_sub"].'</a></li>';
                          }
                        }
                        echo'</ul>';
                        echo '</li>';
                      }
                    }
              echo '</ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>';
	}

	Public function notificacion($notificacion, $mensaje)
	{
		echo '<div class="notification '.$notificacion.'  png_bg"><a href="#" class="close"><img src="css/images/icons/borrar.png" title="Close this notification" alt="close" /></a>
							<div>'.$mensaje.'</div>
			</div>';
	}
	
	Public function menu($activa=null)
	{
			//if($activa==2){echo'current';}
			echo '';
  }
    
  Public function crearArrayStr($cadena, $signo)//hacerle modificacion para que cree un array asociativo
	{
		$cadenaArray = explode($signo, $cadena);
		return $cadenaArray;
	}
	
  Public function submenu($menu=null, $submenu=array(), $activar=null)
  {
		 echo
			'
				 <div id="tabs">
				 <div class="container">
					<ul>';
						foreach($submenu as $key=>$value)
						{
							$valor = $this->crearArrayStr($value, ';');
							if($activar==$key)
							{
								echo'<li><a href="'.$valor[0].'" class="current"><span>'.$valor[1].'</span></a></li>';	
							}else
							{
								echo'<li><a href="'.$valor[0].'" class=""><span>'.$valor[1].'</span></a></li>';	
							}
						}	          
			echo'   </ul>
				</div>
				</div>
			';
	}
			
}
?>
