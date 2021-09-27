<?php
	class ValidarForm
	{
		Public function validarModulo($get, $controlador)
		{
			require_once 'modelo/PermisoModel.php';
			$PermisoModel = new PermisoModel('modelo/PermisoModel.php');
			$cod_permiso = $get.''.$controlador;
			$id_Usuario = $_SESSION['id_usuarios'];

			$consulta = $PermisoModel->consultar('permisos', 'status_prm=1 && id_Usuario='.$id_Usuario.' && codigo_prm="'.$cod_permiso.'" ', 'assoc', null);
			if($consulta['estado_prm']==0)
			{
				header('Location:index.php?controlador=Permiso&accion=bloqueado');
				exit;
			}
			
		}

		Public function limpiar_form($form)
		{
			echo '<script type="text/javascript">
					function lim(miForm) 
					{
						//alert(miForm);
						$(":input", miForm).each(function() 
						{
							var type = this.type;
							var tag = this.tagName.toLowerCase();
							if (type == "text" || type == "password" || tag == "textarea")
							{
								this.value = "";
							}else if (type == "checkbox" || type == "radio")
							{
								this.checked = false;
							}else if (tag == "select")
							{
								this.selectedIndex = -1;	
							}	
						});
					}
					 lim($("#'.$form.'"));
			 	</script>';
		}

		Public function mensaje_jquery($id, $mensaje, $tipo)
		{
			
			    echo '<script type="text/javascript">
	            			var html = "";
	            			html = "<i class=\"fa fa-saved\"></i>";
	            			
	            			$("#'.$id.'").attr("class", "alert alert-'.$tipo.' alert-dismissable");
	            			$("#'.$id.'").html("<i class=\"fa '.$fa.'\"></i>'.$mensaje.'");
	            		</script>';
		}

		Public function mensaje_jquery_2($id, $mensaje, $tipo, $fa)
		{
			
			    echo '<script type="text/javascript">
	            			var html = "";
	            			html += "<i class=\"fa '.$fa.'\"></i>";
	            		
	            			
	            			$("#'.$id.'").append("<div id=\"msj_ajax\"></div>");
	            			$("#msj_ajax").attr("class", "alert alert-'.$tipo.' alert-dismissable");
	            			$("#msj_ajax").html("<i class=\"fa '.$fa.'\"></i><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><a href=\"#\" class=\"alert-link\"></a>'.$mensaje.'");
	            			
	            		</script>';
		}

		Public function mostrar_error($id, $mensaje)
		{
			echo '<script type="text/javascript"> $("#div_texto_'.$id.'").attr("class", "form-group has-error has-feedback alert alert-danger alert-dismissable")
			    $("#span_texto_'.$id.'").text("'.$mensaje.'")</script>';

		}  

		Public function limpiar_error($id)
		{
			echo '<script type="text/javascript"> $("#div_texto_'.$id.'").attr("class", "form-group")
			    $("#span_texto_'.$id.'").text("")</script>';
		}

		Public function texto_url($texto)
		{
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');

			$error_vacio = $Funcion->enviarArrayUrl(array($key=$texto));
		    return $error_vacio;


		}

		Public function actualizar_text($id, $elemento, $dato)
		{
			foreach ($dato->fetch() as $key => $value) 
			{
				if(!is_numeric($key))
				{
					$id_js = ''.$elemento.'_'.$key.'_'.$id.'';
					echo '<script type="text/javascript">
					$("#'.$id_js.'").text("'.$value.'");
					//$("#'.$id_js.'").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" })	
			      	</script>';
				}	
			}
			/*
			echo '<script type="text/javascript">
					$("#tr_'.$id.'").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" });	
				</script>';	*/
		}

		Public function actualizar_text_2($id, $elemento, $dato)
		{
			$id_js = ''.$elemento.'_'.$id.'';
			echo '<script type="text/javascript">
			$("#'.$id_js.'").html("'.$dato.'");
			$("#'.$id_js.'").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" })	
			 </script>';	
		}

		Public function cerrar_modal($id_modal)
		{
			echo '
			<script type="text/javascript">
			$("#'.$id_modal.'").modal("hide");
			</script>';
		}

		
		Public function edit_tr($id, $Modelo, $dato)
		{
			foreach ($dato->fetch() as $key => $value) 
			{
				if(!is_numeric($key))
				{
					$id_js = 'td_'.$key.'_'.$id.'';
					echo '<script type="text/javascript">$("#'.$id_js.'").text("'.$value.'");</script>';
				}	
			}
			echo '<script type="text/javascript">
				/*$("#tr_'.$Modelo.'_'.$id.'").removeClass("odd");
				$("#tr_'.$Modelo.'_'.$id.'").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" });	
				*/
				$("#tr_'.$Modelo.'_'.$id.' .Edit_td").css({"background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center"});	
		
			</script>';		
		}

		Public function css_tr($id)
		{
			echo '<script type="text/javascript">
					 $("#contador_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
					 $("#td_cliente_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
					 $("#td_transporte_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
                     $("#td_ruta_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
                     $("#td_estado_ped_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
                     $("#td_pago_'.$id.'").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
                     $("#div_estado_ped_'.$id.'").html("<center><b>ANULADA</b></center>");
                     $("#div_factura_'.$id.'").html("<center><b>ANULADA</b></center>");
				</script>
			';	
		}

		Public function add_tr_ruta($id, $elemento, $dato)
		{
			//$id_js = ''.$elemento.'_'.$key.'_'.$id.'';
			echo '<script type="text/javascript">
					$("#lista_rutas_ajax tr:first").after("<tr class=\'add_t\' id=\'nuevo_tr_'.$id.'\'><b><td><center><i class=\'fa fa-check-circle\'></i> </center></td><td>'.$dato["estado"].'</td><td>'.$dato["ciudad"].'</td><td>'.$dato["municipio"].'</td><td>'.$dato["parroquia"].'</td><td>'.$dato["direccion_rut"].'</td><td>'.$dato["precio_rut"].'</td><td><a href=\'#\'  onclick=\'agregarRutaAjax('.$id.');\' class=\'btn-xs primary\'><i class=\'fa fa-plus fa-fw\'></i> A&ntilde;adir</a></td></b></tr>");
					$("#nuevo_tr_'.$id.'").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" });	
				</script>
			';
			/*foreach ($dato->fetch() as $key => $value) 
			{
				if(!is_numeric($key))
				{
					$id_js = ''.$elemento.'_'.$key.'_'.$id.'';
					echo '<script type="text/javascript">
							$("#lista_rutas_ajax > tbody:first").append("<tr><td></td><td>more data</td><td>my data</td><td>more data</td><td>my data</td><td>more data</td><td>more data</td><td><a href=\'#\'  onclick=\'agregarRutaAjax('.$id.');\' class=\'btn-xs primary\'><i class=\'fa fa-plus fa-fw\'></i> A&ntilde;adir</a></td></tr>");
							$("#'.$id_js.'").text("'.$value.'");
							$("#tr_10").css({ "background-color": "#CEF6CE", "border-left": "5px solid #ccc", "text-align" : "center" })	
						</script>
					';
				}
			}*/	
		}

		Public function validar($valor, $reglas)
		{
			require_once 'libs/Validar.class.php';
			$Validar = new Validar('libs/Validar.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			//$regla = array(1=>'vacio', 2=>'numerico');
			foreach ($reglas as $key => $value) 
			{
				if($value == 'vacio')
				{
					if($Validar->vacio($valor))
	         		{
						$error_vacio = $Funcion->enviarArrayUrl(array($key="El campo no puede estar vacio."));
		            	return $error_vacio;
					}
				}elseif($value == 'MayorEdad')
				{
					$valor = $Funcion->fechaMysql($valor, '/');
					//echo $valor;
					if($Validar->calculaEdad($valor) < 18)
	         		{
						$error_vacio = $Funcion->enviarArrayUrl(array($key="No cumple con la edad necesaria para el registro."));
		            	return $error_vacio;
					}
				}elseif($value == 'telefono')
				{
					
					if (is_numeric($valor)) 
					{
						$valor =  (string) $valor;
					}
					
					if(strlen($valor) > 11 )
	         		{
						$error_vacio = $Funcion->enviarArrayUrl(array($key="El n&uacute;mero no puede ser mayor a 11 d&iacute;gitos."));
		            	return $error_vacio;
					}elseif(strlen($valor) < 11)
					{
						$error_vacio = $Funcion->enviarArrayUrl(array($key='El n&uacute;mero no puede ser menor a 11 d&iacute;gitos.'));
		            	return $error_vacio;
					}
				}elseif($value == 'correo') 
		        {
		        	if($Validar->validateEmail($valor))
	         		{
	         			$error_correo = $Funcion->enviarArrayUrl(array($key="Por favor ingresar una cuenta de correo válida."));
		            	return $error_correo;
	         		}
		        }elseif($value == 'validateEspacioBlanco')
				{
					if($Validar->validateEspacioBlanco($valor)) 
	           		{
	           			$espacioBlanco = $Funcion->enviarArrayUrl(array($key="No puede contener espacios en blanco."));
	                    return $espacioBlanco;
	           		}

				}elseif($value == 'numerico') 
		        {
		        	if($Validar->numerico($valor))
	         		{
	         			$error_numerico = $Funcion->enviarArrayUrl(array($key="El campo tiene que ser numerico."));
		            	return $error_numerico;
	         		}
		        }elseif (is_array($value)) 
		        {
		        	$i=0;
		        	foreach ($value as $key2 => $value2) 
		        	{
		        		$i++;
		        		//echo $value2;
		        		if ($value2 == 'confirmarPassword' ) 
		        		{

		        			if($Validar->confirmarPassword($value[$i+0], $value[$i+1]))
	         				{
	         					$error_confirmarClave = $Funcion->enviarArrayUrl(array($key="Las clave de usuario no son igual"));
		            			return $error_confirmarClave;
	         				}
		        			
		        		}elseif ($value2 == 'longitudMenor') 
		        		{
		        			if ($Validar->longitudMenor($value[$i+0], $value[$i+1])) 
		        			{
		        				$error_longitudMenor = $Funcion->enviarArrayUrl(array($key="La clave no puede ser tan corta"));
		            			return $error_longitudMenor;
		        			}
		        		}elseif ($key2 == 'file') 
		        		{
		        			if (is_array($value2))
		        			{
		        				$cont = 0;
		        				$size = count($value2);
		        				foreach ($value2 as $k => $v) 
		        				{
		        					$cont++;
		        					if($k == 'nombre_file') 
		        					{
		        						$nombre_file = $v;
		        					}elseif ($k == 'formato_file') 
		        					{
		        						if (is_array($v))
		        						{
		        							foreach ($v as $k_form => $v_form) 
			        						{
			        							$formato_file[$k_form] = $v_form;
			        						}
			        						//$formato_file[] = $v;
		        						}
		        						
		        					}

		        					if($cont == $size) 
		        					{
		        						/*foreach ($formato_file as $key12 => $value12) 
		        						{
		        							echo $key12.'='.$value12.'<br>';
		        						}*/
		        						if(!$Validar->validarFile($nombre_file, $formato_file))
		        						{
		        							$error_file = $Funcion->enviarArrayUrl(array($key2="El formato de archivo no es correcto."));
		            						return $error_file;
		        						}
		        					}	
		        				}
		        			}

		        			//validarFile($_FILES[$value2]['type'], $formatos)
		        		}
		        	}
		        }
								
			}
		}

		Public function modal($id, $bandera)
		{
			echo '<script type="text/javascript"> 
				$("#'.$id.'").modal("'.$bandera.'");
			</script>';
		}

		function comparar_fecha_mayor($fecha1, $fecha2)
	    {
	    	//$fechadb = '2014-06-10',
			// Pasa la fecha de la DB a epoch y le aqgrega 7 días
			$tmp = explode('-', $fecha1);
			$fecha1_tmp = mktime(0,0,0,$tmp[1],$tmp[2],@$tmp[0]);
			// pasa la fecha actual a epoch
			//$fecha = date("Y-m-d");
			$tmp_2 = explode('-',$fecha2);
			$fecha2_tmp = mktime(0,0,0,$tmp_2[1],$tmp_2[2],@$tmp_2[0]);
			// Compara ahora que las fechas son enteror
			if( $fecha1_tmp > $fecha2_tmp)
			{
			   return true;
			} 
			else 
			{
			   return false;
			}
	    }	
	}
?>