function imprimir_div(printpage)
{
	var headstr = "<html><head><title></title></head><body>";
	var footstr = "</body>";
	var newstr = document.all.item(printpage).innerHTML;
	var oldstr = document.body.innerHTML;
	document.body.innerHTML = newstr;/*headstr+newstr+footstr;*/
	window.print();
	document.body.innerHTML = oldstr;
	return false;
}

function PrintElem(elem)
{
    Popup($(elem).html());
}

function Popup(data) 
{
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();
    mywindow.close();

    return true;
}

function limpiaForm(miForm) {
	// recorremos todos los campos que tiene el formulario
	//alert(miForm);
	$(':input', miForm).each(function() 
	{
		var type = this.type;
		var tag = this.tagName.toLowerCase();
		//limpiamos los valores de los campos…
		if (type == 'text' || type == 'password' || tag == 'textarea')
		{
			this.value = '';
		}else if (type == 'checkbox' || type == 'radio')
		{
			// excepto de los checkboxes y radios, le quitamos el checked // pero su valor no debe ser cambiado
			this.checked = false;
			// los selects le ponesmos el indice a -
		}else if (tag == 'select')
		{
			this.selectedIndex = -1;	
		}	
	});
}

function borrarEstilo(miForm) 
{
	// recorremos todos los campos que tiene el formulario
	$(':input', miForm).each(function() 
	{
		var type = this.type;
		var tag = this.tagName.toLowerCase();
		var id_type = '';
		//limpiamos los valores de los campos…
		if (type == 'text' || type == 'password' || tag == 'textarea')
		{
			//this.value = '';
			id_type =this.id;
			$('#div_texto_'+id_type+'').attr('class', 'form-group');
			$('#span_texto_'+id_type+'').text('');

		}else if (type == 'checkbox' || type == 'radio')
		{
			
			id_type =this.id;
			$('#div_texto_'+id_type+'').attr('class', 'form-group');
			$('#span_texto_'+id_type+'').text('');
			
		}else if (tag == 'select')
		{
			id_type =this.id;
			$('#div_texto_'+id_type+'').attr('class', 'form-group');
			$('#span_texto_'+id_type+'').text('');	
		}	
	});
}

function cargarSubmenu(){
	
		var id = $("#id_Menu").val();
		$.ajax({
			type:'GET',
			url:'index.php?controlador=SubMenu&accion=mostrar_submenu_ajax&dato='+id+'',
			success: function(data){
				var html = ''
				
				data = eval('(' + data + ')');
				//alert(data);
				if(data != '' )
				{
					$('#subMenu_sub').prop('disabled', false);
					$('#posicion_sub1').attr('disabled', false);
					$('#posicion_sub2').attr('disabled', false);

					$.each(data, function(i,v){
						num = parseInt(data[i]['id_SubMenu']);
						html += '<option value="'+num+'">'+data[i]['etiqueta_sub']+'</option>';
					});
					
				}else
				{
					$('#posicion_sub1').attr('checked', false);
					$('#posicion_sub2').attr('checked', false);
					$('#subMenu_sub').prop('disabled', true);
					$('#posicion_sub1').attr('disabled', true);
					$('#posicion_sub2').attr('disabled', true);
					//html += '<option value="">----NO HAY REGISTRO ----</option>';
				}
				$("#subMenu_sub").html(html);
			}		
		});	
}

function cargarSubmenu_editar(id_SubMenu)
{
	
	var id = null; //lo inicializo en null para que no me genere error 
	$("#Mid_Menu option").each(function()
	{
		if($(this).attr('value') != ''){id = $(this).attr('value');}
	});
	
	$.ajax({
		type:'GET',
		url:'index.php?controlador=SubMenu&accion=mostrar_submenu_ajax&dato='+id+'',
		success: function(data)
		{
			var html = ''
			data = eval('(' + data + ')');
			if(data != '' )
			{
				$('#MsubMenu_sub').prop('disabled', false);
				$('#Mposicion_sub1').attr('disabled', false);
				$('#Mposicion_sub2').attr('disabled', false);
				$.each(data, function(i,v){
					num = parseInt(data[i]['id_SubMenu']);
					html += '<option value="'+num+' ">'+data[i]['etiqueta_sub']+'</option>';
				});
					
			}else
			{
				alert('bloqueado');
				$('#Mposicion_sub1').attr('checked', false);
				$('#Mposicion_sub2').attr('checked', false);
				$('#MsubMenu_sub').prop('disabled', true);
				$('#Mposicion_sub1').attr('disabled', true);
				$('#Mposicion_sub2').attr('disabled', true);
				//html += '<option value="">----NO HAY REGISTRO ----</option>';
			}
			$("#MsubMenu_sub").html(html);
			$("#MsubMenu_sub option").each(function()
			{	   
				if(id_SubMenu == parseInt($(this).attr('value')) )
				{
					$(this).attr('selected', 'selected');
				}
			});
		}	
	});
}

$(function()
{
	$("#id_Menu").change(function()
	{
		cargarSubmenu();
	});

	$("#btn_mod_usuario").click(function()
	{	
		//$("#modal_2").modal("show" );
		//$("#respuesta").attr("class", "");
		$('#respuesta').removeClass('alert alert-info alert-dismissable	');
		//html = '';
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Usuario&accion=procesar_editar_ajax',
		    data: $("#form_modificar").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
		       // return false;
		    }
		 });
		return false;
	});

	$('#btn_mod_menu').click(function()
	{
		//alert("enviado correctamente");
		CKEDITOR.instances.Mcontenido_men.setData(CKEDITOR.instances.Mcontenido_men.getData()); //para poder captura el value de este campo.
		$("#Mcontenido_men").val(CKEDITOR.instances.Mcontenido_men.getData());
		$('#respuesta').removeClass('alert alert-info alert-dismissable	');
	
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Menu&accion=procesar_editar_ajax',
		    data: $("#form_modificar").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
		       // return false;
		    }
		 });
		return false;
	});

	$('#btn_mod_subMenu').click(function()
	{
		//alert('jojo');
		CKEDITOR.instances.Mcontenido_sub.setData(CKEDITOR.instances.Mcontenido_sub.getData()); //para poder captura el value de este campo.
		$("#Mcontenido_sub").val(CKEDITOR.instances.Mcontenido_sub.getData());
		$('#respuesta').removeClass('alert alert-info alert-dismissable	');
	
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=SubMenu&accion=procesar_editar_ajax',
		    data: $("#form_modificar_submenu").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
		       // return false;
		    }
		 });
		return false;
	});

	$('#btn_selec_chofer_transporte').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta').removeClass('alert alert-info alert-dismissable	');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Guia&accion=registrar_pedido_cache_ajax',
		    data: $("#form_selec_chofer_transporte").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       //$("#respuesta_agregar_pedido").html(data); // Mostrar lista_rutas la respuestas del script PHP.
		         $("#lista_rutas").html(data);
		       // return false;
		    }
		 });
		return false;
	});

	$('#btn_guardar_cliente_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta_nuevo_cliente').removeClass('alert alert-info alert-dismissable');
		$('#respuesta_nuevo_cliente').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Cliente&accion=registrar_cliente_ajax',
		    data: $("#form_nuevo_cliente_ajax").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       //$("#respuesta_agregar_pedido").html(data); // Mostrar lista_rutas la respuestas del script PHP.
		         $("#respuesta_nuevo_cliente").html(data);
		         //limpiaForm($('#form_nuevo_cliente_ajax'))
		       // return false;
		    }
		 });
		return false;
	});

	$('#btn_nueva_ruta_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta_nueva_ruta').removeClass('alert alert-info alert-dismissable');
		$('#respuesta_nueva_ruta').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Ruta&accion=registrar_ruta_ajax',
		    data: $("#form_nueva_ruta_ajax").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta_nueva_ruta").html(data);
		    }
		 });
		return false;
	});

	$('#btn_modificar_transporte_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta').removeClass('alert alert-info alert-dismissable');
		$('#respuesta').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Transporte&accion=procesar_editar_ajax',
		    data: $("#form_modificar_transporte").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data);
		    }
		 });
		return false;
	});

	$('#btn_modificar_ruta_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta').removeClass('alert alert-info alert-dismissable');
		$('#respuesta').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Ruta&accion=procesar_editar_ajax',
		    data: $("#form_modificar_ruta").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data);
		    }
		 });
		return false;
	});

	$('#btn_modificar_empleado_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta').removeClass('alert alert-info alert-dismissable');
		$('#respuesta').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Empleado&accion=procesar_editar_ajax',
		    data: $("#form_modificar_empleado_ajax").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data);
		    }
		 });
		return false;
	});

	$('#btn_modificar_cliente_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respuesta').removeClass('alert alert-info alert-dismissable');
		$('#respuesta').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Cliente&accion=procesar_editar_ajax',
		    data: $("#form_modificar_cliente_ajax").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respuesta").html(data);
		    }
		 });
		return false;
	});

	$('#btn_cambiar_estatus_ajax').click(function()
	{
		//alert("enviado correctamente");
		$('#respueta_cambiar_estatus').removeClass('alert alert-info alert-dismissable');
		$('#respueta_cambiar_estatus').html('');
		$.ajax({
		    type: "POST",
		    url:'index.php?controlador=Guia&accion=procesar_cambiar_estatus_ajax',
		    data: $("#form_cambiar_estatus_ajax").serialize(), // Adjuntar los campos del formulario enviado.
		    success: function(data)
		    {
		       var html = ''
		       $("#respueta_cambiar_estatus").html(data);
		    }
		 });
		return false;
	});

	$('#filtrar_fecha_guia1').click(function()
	{
	
		$('#desde').attr('disabled', false);
		$('#hasta').attr('disabled', false);
		
	});

	$('#filtrar_fecha_guia2').click(function()
	{
		$('#desde').attr('disabled', true);
		$('#hasta').attr('disabled', true);
		//$('#desde').val('');
		//$('#hasta').val('');	
	});

	$('#Musuario_usu_permiso').change(function()
	{
	 	
	 	$("#div_mostrarPermisos").html(html);
	 	var id = $('#Musuario_usu_permiso').val();
	 	var html = '';
	 	$.ajax({
		    type: "GET",
		    url:'index.php?controlador=Permiso&accion=mostrar_permiso_ajax&dato='+id+'',
		    success: function(data)
		    {
		       
		       data = eval('(' + data + ')');
		   	   
		   	   if(data != '')
		   	   {
					$.each(data, function(i,v)
					{
						var estado_prm = parseInt(data[i]['estado_prm']);
						if (estado_prm==1) 
						{
							html +='<blockquote><li><b>Modulo:</b>'+data[i]["nombre_prm"]+'</li><div class="checkbox"><label><input type="checkbox" onClick="estado_prm('+data[i]["id_Permiso"]+');" id="'+data[i]["codigo_prm"]+'" name="'+data[i]["codigo_prm"]+'" value="0" checked>Activar</label></div></blockquote>';
						}else
						{
							html +='<blockquote><li><b>Modulo:</b>'+data[i]["nombre_prm"]+'</li><div class="checkbox"><label><input type="checkbox" onClick="estado_prm('+data[i]["id_Permiso"]+');" id="'+data[i]["codigo_prm"]+'" name="'+data[i]["codigo_prm"]+'" value="1">Activar</label></div></blockquote>';
						}
					});
					$("#div_mostrarPermisos").html('<div id="div_78" class="form-group"><div id="div_" class="form-group "><label for="inputEmail3" class="col-sm-2 control-label">Permiso:</label><br><div class="col-sm-6 input-group">'+html+'</div></div></div>');
				}else
				{
					alert('El usuario no tiene permisos creados.');
					$("#div_mostrarPermisos").html('');
				} 
		    }
		 });
	});

});

function estado_prm(id_Permiso)
{
	//alert(''+id_Permiso+'');
	$.ajax({
		    type: "GET",
		    url:'index.php?controlador=Permiso&accion=procesar_permiso_ajax&dato='+id_Permiso+'',
		    success: function(data)
		    {
		       var html = ''
		       data = eval('(' + data + ')');
		       if (data["estado_prm"]==1) 
		       {
		       		$('#'+data["codigo_prm"]+'').attr('checked', true);
		       }else if(data["estado_prm"]==0)
		       {
		       		$('#'+data["codigo_prm"]+'').attr('checked', false);
		       }
		     
		    }
	});
}
function bloqueaCampoReporteGuia()
{
	//$('#desde').attr('disabled', true);
	//$('#hasta').attr('disabled', true);
	/*$('#desde').val('');
	$('#hasta').val('');*/
}

function editarSubMenu(id)
{
	$('#div_texto_Metiqueta_sub').attr('class', 'form-group')
	$('#span_texto_Metiqueta_sub').text('')
	$('#div_texto_Murl_sub').attr('class', 'form-group')
	$('#span_texto_Murl_sub').text('')
	$('#div_texto_Mposicion_sub').attr('class', 'form-group')
	$('#span_texto_Mposicion_sub').text('')
	$('#div_texto_Mmenu_sub').attr('class', 'form-group')
	$('#span_texto_Mmenu_sub').text('')
	$('#div_texto_Mactivar_sub').attr('class', 'form-group')
	$('#span_texto_Mactivar_sub').text('')
	$("#modal_2").modal("show" );
	$.ajax({
		url : 'index.php?controlador=SubMenu&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			data = eval('(' + data + ')');
			html =''
			$("#Mid_SubMenu").val(id);
			$.each(data, function(i,v)
			{		
				num = parseInt(data[i]['id_SubMenu']);
				$("#Mid_Menu option").each(function()
				{
					if(data[i]['id_Menu']!='') 
					{
						html += '<option value="'+data[i]['id_Menu']+'" selected="selected">....'+data[i]['etiqueta_men']+'</option>';
					}		
				});

				$("#Mid_Menu").html(html);
				if(data[i]['activar_sub']==0)
				{
					document.getElementById('Mactivar_sub2').checked=true;
				}else
				{
					document.getElementById('Mactivar_sub1').checked=true;
				}
				$("#Metiqueta_sub").val(data[i]['etiqueta_sub']);
				$("#Murl_sub").val(data[i]['url_sub']);
				$("#Mevento_sub").val(data[i]['evento_sub']);
				$("#Mclase_sub").val(data[i]['clase_sub']);
				$("#Mcontenido_sub").val(data[i]['contenido_sub']);//cargo el value
				CKEDITOR.instances.Mcontenido_sub.setData(data[i]['contenido_sub']);
				cargarSubmenu_editar(id);
				//html += '<option value="'+num+'">'+data[i]['etiqueta_sub']+'</option>';
			});

			
		}
	});
}

function editarMenu(id)
{
	$('#div_texto_Metiqueta_men').attr('class', 'form-group')
	$('#span_texto_Metiqueta_men').text('')
	$('#div_texto_Murl_men').attr('class', 'form-group')
	$('#span_texto_Murl_men').text('')
	$('#div_texto_Mposicion_men').attr('class', 'form-group')
	$('#span_texto_Mposicion_men').text('')
	$('#div_texto_Mmenu_men').attr('class', 'form-group')
	$('#span_texto_Mmenu_men').text('')
	$('#div_texto_Mactivar_men').attr('class', 'form-group')
	$('#span_texto_Mactivar_men').text('')
    $("#modal_2").modal("show" );
    //CKEDITOR.instances.Mcontenido_men.destroy();
   // alert('wr3r3r3r3r3r3r');
	$.ajax({
		url : 'index.php?controlador=Menu&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			var html = ''
			json = eval('(' + data + ')');
			$("#Mid_Menu").val(id);
			$("#Metiqueta_men").val(json['etiqueta_men']);
			$("#Murl_men").val(json['url_men']);
			//CKEDITOR.instances.Mcontenido_men.insertText(' line1 \n\n line2');
			//CKEDITOR.instances.Mcontenido_men.insertHtml(json['contenido_men']);
			$("#Mcontenido_men").val(json['contenido_men']);//cargo el value
			CKEDITOR.instances.Mcontenido_men.setData(json['contenido_men']); //actualizo el campo
			 
			$("#Mclase_men").val(json['clase_men']);
			$("#Mevento_men").val(json['evento_men']);
			$("#Mmenu_men option").each(function(){
   				if($(this).attr('value') == json['id_Menu'] )
   				{
   					$(this).attr('selected', 'selected');
   					//$(this).remove();
   				}
			});

			if(json['activar_men']==0)
			{
				document.getElementById('Mactivar_men2').checked=true;
			}else
			{
				document.getElementById('Mactivar_men1').checked=true;
			}
		}
	});
	
}

function editarUsuario(id)
{
	//alert('exito'+id+'');
	$('#div_texto_Mtipo_usu').attr('class', 'form-group')
	$('#span_texto_Mtipo_usu').text('')
	$('#div_texto_Musuario_usu').attr('class', 'form-group')
	$('#span_texto_Musuario_usu').text('')
	$('#respuesta').attr('class','');
	$('#respuesta').text('');

	$.ajax({
		url : 'index.php?controlador=Usuario&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			/*alert(data);*/
			var html = ''
			json = eval('(' + data + ')');
			var html = ''
			//html += '<option value="'+json['tipo_usu']+'">'+json['tipo_usu']+'</option>';
			$("#Mtipo_usu option").each(function(){
   				//alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'))
   				//alert($(this).attr('value'));
   				if($(this).attr('value') == json['tipo_usu'])
   				{
   					$(this).attr('selected', 'selected');
   				}
   				//$("#id_tema option:first").attr('selected', 'selected');
			});

			$("#Musuario_usu").val(json['usuario_usu']);
			$("#Mid_Usuario").val(id);
			
		}
	});
	$("#modal_2").modal("show" );
	
}

function mostrarContenidoAjax()
{
	//alert('entro');
}

function ajaxCargarCiudad(id_1, id_2)
{
	var id = $("#"+id_1+"").val();
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Empleado&accion=ajax_cargar_ciudad&dato='+id+'',
			success: function(data){
				var html = ''
				data = eval('(' + data + ')');				
				$.each(data, function(i,v)
				{
					num = parseInt(data[i]['id_Ciudad']);
					html += '<option value="'+num+'">'+data[i]['ciudad']+'</option>';
				});
				$("#"+id_2+"").html(html);
			}		
		});
}

function ajaxCargarMunicipio(id_1, id_2)
{
	var id = $("#"+id_1+"").val();
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Empleado&accion=ajax_cargar_municipio&dato='+id+'',
			success: function(data){
				var html = ''
				data = eval('(' + data + ')');				
				$.each(data, function(i,v)
				{
					num = parseInt(data[i]['id_Municipio']);
					html += '<option value="'+num+'">'+data[i]['municipio']+'</option>';
				});
				$("#"+id_2+"").html(html);
			}		
		});
}

function ajaxCargarParroquia(id_1, id_2)
{
	var id = $("#"+id_1+"").val();
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Empleado&accion=ajax_cargar_parroquia&dato='+id+'',
			success: function(data){
				var html = ''
				data = eval('(' + data + ')');				
				$.each(data, function(i,v)
				{
					num = parseInt(data[i]['id_Parroquia']);
					html += '<option value="'+num+'">'+data[i]['parroquia']+'</option>';
				});
				$("#"+id_2+"").html(html);
			}		
		});
}

function agregarRutaAjax(id)
{
	
	$("#form_agregarRutaAjax").modal("show" );
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Guia&accion=ajax_cargar_transporte_chofer&dato='+id+'',
			success: function(data){
				var lista_transporte = ''
				var lista_chofer = ''
				data = eval('(' + data + ')');
				$.each(data, function(i,v)
				{
					var objetoJson = eval('(' + data[i] + ')');
					$.each(objetoJson, function(j,k)
					{
						if (objetoJson[j]['id_Empleado']) 
						{
							
							num_chofer = parseInt(objetoJson[j]['id_Empleado']);
							lista_chofer += '<option value="'+num_chofer+'">CI: '+objetoJson[j]['cedula_per']+' / '+objetoJson[j]['apellido_per']+' '+objetoJson[j]['nombre_per']+' '+' / ['+objetoJson[j]['licencia_per']+']</option>';
						
						}else if(objetoJson[j]['id_Transporte'])
						{
							
							num_transporte = parseInt(objetoJson[j]['id_Transporte']);
							lista_transporte += '<option value="'+num_transporte+'">'+objetoJson[j]['tipo_tra']+' / ['+objetoJson[j]['marca_tra']+' - '+objetoJson[j]['modelo_tra']+'] / Placa['+objetoJson[j]['matricula_tra']+'] / Bs '+objetoJson[j]['precio_tra']+'</option>';
						}
					});
				});
				$("#Mid_Ruta").val(id);
				$("#Mid_Transporte").html(lista_transporte);
				$("#Mid_Empleado").html(lista_chofer);
				$("#Mid_Empleado").prepend("<option value='' selected='selected'>Seleccione ..</option>");
				$("#Mid_Transporte").prepend("<option value='' selected='selected'>Seleccione ..</option>");
				
			}		
		});

}

function ajaxBuscarCliente(id, id2)
{
	var valor = $("#"+id+"").val();
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Guia&accion=ajax_buscar_cliente&dato='+valor+'',
			success: function(data){
				var html = ''
				//data = eval('(' + data + ')');
				json = eval('(' + data + ')');
				if(json) 
				{
					
					$('#div_'+id+'').attr('class', 'form-group has-success has-feedback');
					$('#div_'+id2+'').attr('class', 'form-group has-success has-feedback');
					$('#'+id2+'').val(''+json['apellido_per']+' '+json['nombre_per']+'');
					$('#'+id2+'').attr('disabled', true);
				
					$('#span_text_'+id+'').html('');
					
				}else
				{
					$('#div_'+id+'').attr('class', 'form-group  has-error has-feedback');
					$('#'+id2+'').val('');
					$('#div_'+id2+'').attr('class', 'form-group  has-error has-feedback');
					$('#'+id2+'').attr('disabled', true);
					
					$('#span_text_'+id+'').html('');

				}
				
				/*			
				$.each(data, function(i,v)
				{
					num = parseInt(data[i]['id_Parroquia']);
					html += '<option value="'+num+'">'+data[i]['parroquia']+'</option>';
				});
				$("#"+id_2+"").html(html);*/
			}		
		});
}

function eliminar_div(id, id_Pedido_cache)
{
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Guia&accion=eliminar_pedido_cache_ajax&dato='+id_Pedido_cache+'',
			success: function(data)
			{
				var html = ''
				//data = eval('(' + data + ')');
				//json = eval('(' + data + ')');
				alert(data);
				$("#"+id+"").hide("slow");
			}
	});
	
	//$("#"+id+"").hide("slow");
	//$("#"+id+"").remove();
}

function mostrar_pedido_cache_ajax(id)
{
	//alert(id);
	$('#nombre_cli').attr('disabled', true); // para deshabilitarlo al comienzo de la pagina.
	$.ajax({
			type:'GET',
			url:'index.php?controlador=Guia&accion=mostrar_pedido_cache_ajax',
			success: function(data)
			{
				var html = ''
				//data = eval('(' + data + ')');
				//json = eval('(' + data + ')');
				
				$("#"+id+"").html(data);
			}
	});
	
	//$("#"+id+"").hide("slow");
	//$("#"+id+"").remove();
}

function nuevoCliente(cedula_cli, cedula_per)
{
	$('#respuesta_nuevo_cliente').removeClass('alert alert-info alert-dismissable');
	var cedula =  $("#"+cedula_cli+"").val();
	$("#"+cedula_per+"").val(""+cedula+"");
	$('#modal_nuevo_cliente').modal("show" );	
}

function nuevaRuta(cedula_cli, cedula_per)
{
	//aqui falta la funcion para eliminar los mensaje de error
	$('#respuesta_nueva_ruta').removeClass('alert alert-info alert-dismissable');
	$('#respuesta_nueva_ruta').html('');
	limpiaForm($('#form_nueva_ruta_ajax'));
	borrarEstilo($('#form_nueva_ruta_ajax'));
	$('#modal_nueva_ruta').modal("show" );	
}

function editarTransporte(id)
{
	//aqui falta la funcion para eliminar los mensaje de error
	$('#respuesta').removeClass('alert alert-info alert-dismissable');
	$('#respuesta').html('');
	borrarEstilo($('#form_modificar_transporte'));
    $("#modal_editar_transporte").modal("show" );

	$.ajax({
		url : 'index.php?controlador=Transporte&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			var html = ''
			json = eval('(' + data + ')');
			$("#Mid_Transporte").val(json['id_Transporte']);
			$("#Mmatricula_tra").val(json['matricula_tra']);
			$("#Mprecio_tra").val(json['precio_tra']);
			$("#Mmarca_tra").val(json['marca_tra']);
			$("#Mmodelo_tra").val(json['modelo_tra']);
			$("#Manio_tra").val(json['anio_tra']);
			$("#Mcolor_tra").val(json['color_tra']);
			$("#Mtraccion_tra").val(json['traccion_tra']);
			$("#Mcapacidad_tra").val(json['capacidad_tra']);
			$("#Mtipo_tra option").each(function(){
   				if($(this).attr('value') == json['tipo_tra'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});
			
		}
	});	
}

function editarRuta(id)
{
	//aqui falta la funcion para eliminar los mensaje de error
	$('#respuesta').removeClass('alert alert-info alert-dismissable');
	$('#respuesta').html('');
	borrarEstilo($('#form_modificar_ruta'));
    $("#modal_editar_ruta").modal("show" );

	$.ajax({
		url : 'index.php?controlador=Ruta&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			var html = ''
			json = eval('(' + data + ')');
			
			$("#Mid_Ruta").val(json['id_Ruta']);
			$("#Mnombre_rut").val(json['nombre_rut']);
			$("#Mprecio_rut").val(json['precio_rut']);

			if(json['activar_rut']==0)
			{
				document.getElementById('Mactivar_rut2').checked=true;
			}else
			{
				document.getElementById('Mactivar_rut1').checked=true;
			}

			$("#Mtipo_rut option").each(function(){
   				if($(this).attr('value') == json['tipo_rut'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});

			$("#Mid_Estado option").each(function(){
   				if($(this).attr('value') == json['id_Estado'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});

			$("#Mid_Ciudad").html('<option value="'+json['id_Ciudad']+'" selected="selected">'+json['ciudad']+'</option>');
			$("#Mid_Municipio").html('<option value="'+json['id_Municipio']+'" selected="selected">'+json['municipio']+'</option>');
			$("#Mid_Parroquia").html('<option value="'+json['id_Parroquia']+'" selected="selected">'+json['parroquia']+'</option>');
			$("#Mdireccion_rut").val(json['direccion_rut']);
			
		}
	});	
}

function editarEmpleado(id)
{
	//aqui falta la funcion para eliminar los mensaje de error
	//alert('entro');
	$('#respuesta').removeClass('alert alert-info alert-dismissable');
	$('#respuesta').html('');
	borrarEstilo($('#form_modificar_empleado_ajax'));
    $("#modal_modificar_empleado").modal("show" );

	$.ajax({
		url : 'index.php?controlador=Empleado&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			var html = ''
			json = eval('(' + data + ')');
			
			$("#Mid_Empleado").val(json['id_Empleado']);
			$("#Mcedula_per").val(json['cedula_per']);
			$("#Mnombre_per").val(json['nombre_per']);
			$("#Mapellido_per").val(json['apellido_per']);
			var fecha = json['fecha_nac_per'].split("-");
			var fecha_cadena = fecha[2]+'/'+fecha[1]+'/'+fecha[0];
			$("#Mfecha_nac_per").val(fecha_cadena);
			
			if(json['sexo_per']=='F')
			{
				document.getElementById('Msexo_per1').checked=true;
			}else
			{
				document.getElementById('Msexo_per2').checked=true;
			}
			$("#Mlicencia_per option").each(function(){
   				if($(this).attr('value') == json['licencia_per'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});
			$("#Mid_Cargo option").each(function(){
   				if($(this).attr('value') == json['id_Cargo'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});
			$("#Mid_Estado option").each(function(){
   				if($(this).attr('value') == json['id_Estado'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});

			$("#Mid_Ciudad").html('<option value="'+json['id_Ciudad']+'" selected="selected">'+json['ciudad']+'</option>');
			$("#Mid_Municipio").html('<option value="'+json['id_Municipio']+'" selected="selected">'+json['municipio']+'</option>');
			$("#Mid_Parroquia").html('<option value="'+json['id_Parroquia']+'" selected="selected">'+json['parroquia']+'</option>');
			$("#Mdireccion_per").val(json['direccion_per']);

			$("#Mtelefono_fijo_per").val(json['telefono_fijo_per']);
			$("#Mtelefono_movil_per").val(json['telefono_movil_per']);
			$("#Mcorreo_per").val(json['correo_per']);	
		}
	});	
}

function editarCliente(id)
{
	//aqui falta la funcion para eliminar los mensaje de error
	//alert('entro');
	$('#respuesta').removeClass('alert alert-info alert-dismissable');
	$('#respuesta').html('');
	borrarEstilo($('#form_modificar_cliente_ajax'));
    $("#modal_modificar_cliente").modal("show" );
    
	$.ajax({
		url : 'index.php?controlador=Cliente&accion=mostrar_editar_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{
			//alert(data);
			var html = ''
			json = eval('(' + data + ')');
			
			$("#Mid_Cliente").val(json['id_Cliente']);
			$("#Mcedula_per").val(json['cedula_per']);
			$("#Mnombre_per").val(json['nombre_per']);
			$("#Mapellido_per").val(json['apellido_per']);
			var fecha = json['fecha_nac_per'].split("-");
			var fecha_cadena = fecha[2]+'/'+fecha[1]+'/'+fecha[0];
			$("#Mfecha_nac_per").val(fecha_cadena);
			
			if(json['sexo_per']=='F')
			{
				document.getElementById('Msexo_per1').checked=true;
			}else
			{
				document.getElementById('Msexo_per2').checked=true;
			}
			$("#Mlicencia_per option").each(function(){
   				if($(this).attr('value') == json['licencia_per'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});
			
			$("#Mid_Estado option").each(function(){
   				if($(this).attr('value') == json['id_Estado'] )
   				{
   					$(this).attr('selected', 'selected');
   				}
			});

			$("#Mid_Ciudad").html('<option value="'+json['id_Ciudad']+'" selected="selected">'+json['ciudad']+'</option>');
			$("#Mid_Municipio").html('<option value="'+json['id_Municipio']+'" selected="selected">'+json['municipio']+'</option>');
			$("#Mid_Parroquia").html('<option value="'+json['id_Parroquia']+'" selected="selected">'+json['parroquia']+'</option>');
			$("#Mdireccion_per").val(json['direccion_per']);

			$("#Mtelefono_fijo_per").val(json['telefono_fijo_per']);
			$("#Mtelefono_movil_per").val(json['telefono_movil_per']);
			$("#Mcorreo_per").val(json['correo_per']);
		}
	});	
	
}

function eliminarTransporte(id)
{
	//var resul = prompt('Eliminar el siguiente registro.');
	var resul = confirm('Eliminar el siguiente registro.');
	if(resul) 
	{
		$.ajax({
			url : 'index.php?controlador=Transporte&accion=eliminar_ajax&dato='+id+'',
			type : 'get',
			success: function(data)
			{
				if (data == id) 
				{
					alert("Registro eliminado correctamente.");
					$('#tr_Transporte_'+data+'').remove();
				}	
			}
		});
		//alert("El registro fue eliminado.");
	}
}

function eliminarCliente(id)
{
	//var resul = prompt('Eliminar el siguiente registro.');
	var resul = confirm('Eliminar el siguiente registro.');
	if(resul) 
	{
		$.ajax({
			url : 'index.php?controlador=Cliente&accion=eliminar_ajax&dato='+id+'',
			type : 'get',
			success: function(data)
			{
				if (data == id) 
				{
					alert("Registro eliminado correctamente.");
					alert('#tr_Cliente_'+data+'');
					$('#tr_Cliente_'+data+'').html('');
					
					$('#tr_Cliente_'+data+'').remove();
				}	
			}
		});
		//alert("El registro fue eliminado.");
	}
}

function eliminarEmpleado(id)
{
	//var resul = prompt('Eliminar el siguiente registro.');
	var resul = confirm('Eliminar el siguiente registro.');
	if(resul) 
	{
		$.ajax({
			url : 'index.php?controlador=Empleado&accion=eliminar_ajax&dato='+id+'',
			type : 'get',
			success: function(data)
			{
				if (data == id) 
				{
					alert("Registro eliminado correctamente.");
					alert('#tr_'+data+'');
					$('#tr_Empleado_'+data+'').html('');
					$('#tr_Empleado_'+data+'').remove();
				}	
			}
		});
		//alert("El registro fue eliminado.");
	}
}

function eliminarRuta(id)
{
	//var resul = prompt('Eliminar el siguiente registro.');
	var resul = confirm('Eliminar el siguiente registro.');
	if(resul) 
	{
		$.ajax({
			url : 'index.php?controlador=Ruta&accion=eliminar_ajax&dato='+id+'',
			type : 'get',
			success: function(data)
			{
				if (data == id) 
				{
					alert("Registro eliminado correctamente.");
					//alert('#tr_'+data+'');
					$('#tr_Ruta_'+data+'').html('');
					$('#tr_Ruta_'+data+'').remove();
				}	
			}
		});
		//alert("El registro fue eliminado.");
	}
}

function actualizar_estado_pedido_ajax(id, cod_factura)
{
	//alert(cod_factura);
	$('#respueta_cambiar_estatus').removeClass('alert alert-info alert-dismissable');
	$('#respueta_cambiar_estatus').html('');
	//$("#estado_ped").val('');
	//$("#estado_ped option").attr("selected", "");
	$("#estado_ped option").prop('selected', false).change();
	$("#estado_ped").html('');
	$('#estado_ped').append(new Option('Seleccione ...', '', true, true));
	$('#estado_ped').append(new Option('ENVIADO', 'ENVIADO', false, false));
	$('#estado_ped').append(new Option('ENTREGADO', 'ENTREGADO', false, false));
	$('#estado_ped').append(new Option('ACCIDENTADO', 'ACCIDENTADO', false, false));
	$('#estado_ped').append(new Option('DISPONIBLE', 'DISPONIBLE', false, false));

	borrarEstilo($('#form_cambiar_estatus_ajax'));
	$("#modal_titulo_estatus_ajax").html("PEDIDO:["+cod_factura+"]");
	$.ajax({
			url : 'index.php?controlador=Guia&accion=mostrar_estatus_pedido_ajax&dato='+id+'',
			type : 'get',
			success: function(data)
			{
				json = eval('(' + data + ')');
				//alert(data);
				//$("#estado_ped option").prop('selected', false).change();
				$("#id_Pedido").val(json['id_Pedido']);
				$("#estado_ped option").change();
				//alert(json["estado_ped"]);
				$('#estado_ped option[value='+json["estado_ped"]+']').remove();
				/*
				$("#estado_ped option").each(function(){
					alert($(this).attr('value')+'=='+json['estado_ped']);
	   				if($(this).attr('value') == json['estado_ped'] )
	   				{
	   					//$(this).attr('selected', 'selected');
	   					//$("#estado_ped option:selected").remove();
	   					$('#estado_ped option[value='+json["estado_ped"]+']').remove();
	   					//option[value=val2]
	   					//$($this).remove();
	   					//option[value='option1']"
	   				}
				});	*/
			}
		});
    $("#modal_cambiar_estatus").modal("show" );
}

function ver_factura(id)
{
	//alert(cod_factura);
	$('#respueta_ver_factura').removeClass('alert alert-info alert-dismissable');
	$('#respueta_ver_factura').html('');
	$("#modal_ver_factura").modal("show" );
	$.ajax({
		url : 'index.php?controlador=Guia&accion=ver_factura_ajax&dato='+id+'',
		type : 'get',
		success: function(data)
		{	
			//alert('wdwdwd');
			$('#respueta_ver_factura').html(data);
		}
	});
}

function anular_factura(id_Factura, id_Pedido)
{
	$('#respueta_ver_factura').removeClass('alert alert-info alert-dismissable');
	$('#respueta_ver_factura').html('');
	//$("#modal_ver_factura").modal("show" );

	if(confirm("¿ESTA SEGURO QUE QUIERE ANULAR LA SIGUIENETE FACTURA. ?"))
	{
		$.ajax({
		url : 'index.php?controlador=Guia&accion=anular_factura_ajax&dato='+id_Factura+'',
		type : 'get',
		success: function(data)
		{	
			$("#contador_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#td_cliente_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#td_transporte_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#td_ruta_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#td_pago_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#td_estado_ped_"+id_Pedido+"").css({ "background-color": "#efd9d9", "border-left": "5px solid #ccc" });
			$("#div_estado_ped_"+id_Pedido+"").html("<center><b>ANULDA</b></center>");
			$("#div_factura_"+id_Pedido+"").html("<center><b>ANULDA</b></center>");

			alert("FACTURA ANULADA EXITOSAMENTE.");
			//$('#respueta_ver_factura').html(data);
		}
		});
	}
    
}
