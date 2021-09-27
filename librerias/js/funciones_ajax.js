function limpiar_todo(form_name)
{
	$("#"+form_name+"").find(':input').each(function() 
	{
		var elemento = this;
		$("#div_texto_"+elemento.id+"").attr('class', 'form-group');
		$("#span_texto_"+elemento.id+"").text('');
		$('#'+elemento.id+'').val('');
    });
    $("#respuesta").attr('class', '');
	$("#respuesta").html('');
}

function limpiar_form(form_name)
{
	$("#"+form_name+"").find(':input').each(function() 
	{
		var elemento = this;
		$('#'+elemento.id+'').val('');
    });
}

function mostrarContenidoAjax(id)
{
	var id = parseInt(id.split('_')[1]);
	//$.noConflict();
	//jQuery('#contenido').html('<b>rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr</b>');
	$.ajax({
		url : 'index.php?controlador=Noticia&accion=mostrar_contenido_ajax&dato='+id+'',
		type : 'GET',
		success: function(data)
		{
			var html = ''
			//alert('entro='+data+'');
			json = eval('(' + data + ')');
			//$('#contenido_interno').html('<article class="holder_gallery"><br>'+data+'<br></article>');
		
			$('#contenido').html('<h4 id="h4Ajax" class="tituloH4"><i class="fa fa-bars fa-fw"></i> '+json['etiqueta_sub']+'<hr></h4>'+json['contenido_sub']+'<br><span id="volver"><a href="index.php"><b><i class="fa fa-reply fa-fw"></i>  Volver</b></a></span><br>');
			$('#h4Ajax').attr('class', 'tituloH4');
		}
	});
}

function mostrarContenidoAjaxMenu(id)
{
	
	var id = parseInt(id.split('_')[1]);
	//$.noConflict();
	//jQuery('#contenido').html('<b>rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr</b>');
	$.ajax({
		url : 'index.php?controlador=Noticia&accion=mostrar_contenido_ajax_menu&dato='+id+'',
		type : 'GET',
		success: function(data)
		{
			var html = ''
			//alert('entro='+data+'');
			json = eval('(' + data + ')');
			//$('#contenido_interno').html('<article class="holder_gallery"><br>'+data+'<br></article>');
		
			$('#contenido').html('<h4 id="h4Ajax" class="tituloH4"><i class="fa fa-bars fa-fw"></i> '+json['etiqueta_men']+'<hr></h4>'+json['contenido_men']+'<br><span id="volver"><a href="index.php"><b><i class="fa fa-reply fa-fw"></i>  Volver</b></a></span><br>');
			$('#h4Ajax').attr('class', 'tituloH4');
		}
	});
}

function modal_js(form_name, div_modal)
{
	if(form_name) 
	{
		limpiar_todo(form_name);
	}
	$('#'+div_modal+'').modal("show");
}

$(function() 
{
	$('#btn_enviar_msj').click(function()
	{
		//$('#respuesta').removeClass('alert alert-info alert-dismissable');
		$.ajax({
			type:'POST',
			url:'index.php?controlador=Pagina&accion=procesar_enviar_msj_ajax',
			data: $('#form_enviar_msj').serialize(),
			success: function(data)
			{
				var hatml = ''
				$("#respuesta").html(data);
				limpiar_form('form_enviar_msj');
			}
		});
		return false;
	});
	
});
