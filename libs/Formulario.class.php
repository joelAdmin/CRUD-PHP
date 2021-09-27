<?php
//header("Content-Type: text/html;charset=utf-8");
class Formulario
{
	
	/************************ CODIGOS PERSONALIZADOS ************************************/
	Public function texto_buscar($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo, $boton, $evento)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div id="div_'.$id.'" class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div id="div_'.$id.'" class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' input-group">
		<input type="'.$tipo.'" value="'.$value.'" '; if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);} echo' name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'" aria-describedby="inputSuccess2Status">';
		
		echo '<div class="input-group-addon">'.$boton.'</div>';
		if($error[0] != null ) {echo '<span id="span_text_'.$id.'" class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div>
		
  		</div>';
	}

	Public function lista_transportes($id, $nombre, $etiqueta, $evento=null, $placeholder, $ayuda,  $post=null, $opciones=null, $obligatorio, $error=array(), $size)
	{
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';
		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';
		//if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);};

		echo '<div class="col-sm-'.$size.' "><select class="form-control" '; if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);} echo' name="'.$nombre.'" id="'.$id.'" title="'.$ayuda.'" >';
		
		echo '<option value="">'.$placeholder.'</option>';
		//echo '<option value="'.$key.'">'.$opciones->fetch().'</option>';
		if($opciones != null)
		{
			//echo '<option value="">wd33r</option>';
			while ($row = $opciones->fetch()) 
			{
				# code...

				echo '<option value="'.$row["id_Transporte"].'">'.$row["tipo_tra"].'  ['.$row["marca_tra"].'-'.$row["modelo_tra"].'] <b>Bs:</b>'.$row["precio_tra"].' / Placa:['.$row["matricula_tra"].']</option>';
			}
			/*foreach($opciones as $key => $value)
			{

				if((!Empty($post)) && ($post==$key))
				{
					echo '<option value="'.$key.'" selected>'.$value.'</option>';
				}else
				{ 
					echo '<option value="'.$key.'">'.$value.'</option>';
				}
			}*/
		}
		
		echo '</select>';

		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>
		</div></div>';
	}

	/************************* FIN DE CODIGO PERSONALIZADOS ****************************/

	Public function login()
	{
		return 0;
	}

	Public function iniciarForm($id, $metodo, $action, $tipo=null)
	{
		echo '<form action="'.$action.'" onsubmit="" class="form-horizontal" method="'.$metodo.'" name="form_'.$id.'" id="'.$id.'" accept-charset="utf-8" enctype="'.$tipo.'">';
	}

	Public function inicioForm($id, $metodo, $action, $tipo=null)
	{
		echo '<form action="'.$action.'" onsubmit="" class="form-horizontal" method="'.$metodo.'" name="'.$id.'" id="'.$id.'" accept-charset="utf-8" enctype="'.$tipo.'">';
	}

	Public function cerrarForm()
	{
		echo '</form>';
	}

	Public function iniciarFieldset($clase, $titulo)
	{
		  echo'<div class="panel panel-default legend">
                  <div class="panel-body">
                      <fieldset class="scheduler-border"><legend class="scheduler-border legend"><i class="'.$clase.'"></i>  '.$titulo.'</legend>';

	}

	Public function cerrarFieldset()
	{
		echo '</fieldset></div></div>';
	}

	Public function botonSubmit($nombre, $clase, $etiqueta)
	{
		echo '<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="'.$clase.'">'.$etiqueta.'</button>
				</div>
			 </div>';
	}

	Public function boton($nombre, $clase, $etiqueta)
	{
		echo '<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button name="'.$nombre.'" id="'.$nombre.'" type="botton" class="'.$clase.'">'.$etiqueta.'</button>
				</div>
			 </div>';
	}

	Public function campoOculto($nombre, $valor)
	{
		echo '<input type="hidden" id="'.$nombre.'" name="'.$nombre.'" value="'.$valor.'" />';
	}

	Public function textArea($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' ">';
		echo '<textarea class="form-control" value="" cols="5" id="'.$id.'" name="'.$nombre.'" rows="5" title="'.$ayuda.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
		///<input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		 
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	Public function textArea_js($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
			echo '<div id="div_texto_'.$id.'" class="form-group ">';
		

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' ">
		<textarea class="form-control" value="" cols="5" id="'.$id.'" name="'.$nombre.'" rows="5" title="'.$ayuda.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
		 
		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>
		 
		</div></div>';
	}

	Public function texto_image($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		//echo '<div class="col-sm-'.$size.' "><input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		echo '<input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div>';
	}

	Public function texto_image_js($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';
		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		//echo '<div class="col-sm-'.$size.' "><input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		echo '<input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>';
		echo '</div>';
	}

	Public function texto_js($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';
		

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' "><input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		 
		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>
		 
		</div></div>';
	}

	Public function radioBoton($id, $nombre, $etiqueta, $ayuda,  $post=null, $opciones, $obligatorio, $error=array(), $size)
	{
		
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo'<div class="col-sm-'.$size.' ">';
		$i=0;
		foreach ($opciones as $key => $value) 
		{
			$i++;
			//echo '<script type="text/javascript">alert("'.$key.'='.$post.'");</script>';
			//if((!Empty($post)) && ($post == $key))
			if($post == $key)
			{
				echo '<input type="radio" name="'.$nombre.'" id="'.$id.''.$i.'" value="'.$key.'" checked />'.$value.'&nbsp;&nbsp;';
			}else
			{
				echo '<input type="radio" name="'.$nombre.'" id="'.$id.''.$i.'" value="'.$key.'" />'.$value.'&nbsp;&nbsp;';
				
			}
		}
		
		

		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	Public function radioBoton_js($id, $nombre, $etiqueta, $ayuda,  $post=null, $opciones, $obligatorio, $error=array(), $size)
	{
		
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';
		

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo'<div class="col-sm-'.$size.' ">';
		$i=0;
		foreach ($opciones as $key => $value) 
		{
			$i++;
			//echo '<script type="text/javascript">alert("'.$key.'='.$post.'");</script>';
			//if((!Empty($post)) && ($post == $key))
			if($post == $key)
			{
				echo '<input type="radio" name="'.$nombre.'" id="'.$id.''.$i.'" value="'.$key.'" checked />'.$value.'&nbsp;&nbsp;';
			}else
			{
				echo '<input type="radio" name="'.$nombre.'" id="'.$id.''.$i.'" value="'.$key.'" />'.$value.'&nbsp;&nbsp;';
				
			}
		}
		
		

		echo '<br><span id="span_texto_'.$id.'" class="help-inline"></span>';
		 
		echo '</div></div>';
	}

	Public function textArea_ck($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		/*echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';*/

		echo '<div class="col-sm-'.$size.' "><textarea class="form-control ckeditor" value="" cols="80" id="'.$id.'" name="'.$nombre.'" rows="10" title="'.$ayuda.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
		 
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	Public function textArea_ck_js($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		echo '<div id="div_texto_'.$id.'" class="form-group ">';

		/*echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';*/

		echo '<div class="col-sm-'.$size.' "><textarea class="form-control ckeditor" value="" cols="80" id="'.$id.'" name="'.$nombre.'" rows="10" title="'.$ayuda.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
		 
		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>';
		 
		echo '</div></div>';
	}

    Public function texto_calendar($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		echo '<script>
      $(function() {
      $( "#'.$id.'" ).datepicker({dateFormat: \'dd/mm/yy\', \'changeYear\': true, \'changeMonth\':true, \'option\': false});
    
      });
    	</script>';
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' "><input type="'.$tipo.'"  onfocus="this.blur()" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		 
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	 Public function texto_calendar_js($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		echo '<script>
      $(function() {
      $( "#'.$id.'" ).datepicker({dateFormat: \'dd/mm/yy\', \'changeYear\': true, \'changeMonth\':true, \'option\': false});
    
      });
    	</script>';
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' "><input type="'.$tipo.'"  onfocus="this.blur()" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		 
		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>';
		 
		echo '</div></div>';
	}

	Public function texto($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.'">
		<input type="'.$tipo.'" value="'.$value.'" name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	Public function texto_2($id, $nombre, $etiqueta, $placeholder, $ayuda,  $value=null, $obligatorio, $error=array(), $size, $tipo, $boton, $evento)
	{
		//echo $error[0];
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div id="div_'.$id.'" class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div id="div_'.$id.'" class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' input-group">
		<input type="'.$tipo.'" value="'.$value.'" '; if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);} echo' name="'.$nombre.'" class="form-control" id="'.$id.'"  title="'.$ayuda.'" placeholder="'.$placeholder.'">';
		
		echo '<div class="input-group-addon">'.$boton.'</div>';
		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		 
		echo '</div></div>';
	}

	Public function lista_js($id, $nombre, $etiqueta, $evento=null, $placeholder, $ayuda,  $post=null, $opciones=null, $obligatorio, $error=array(), $size)
	{
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		
		echo '<div id="div_texto_'.$id.'" class="form-group ">';
		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';
		//if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);};

		echo '<div class="col-sm-'.$size.' "><select class="form-control" '; if ($evento != null) {require_once 'libs/Funciones.class.php';$Funcion = new Funcion('libs/Funciones.class.php');echo $Funcion->evento($evento);} echo' name="'.$nombre.'" id="'.$id.'" title="'.$ayuda.'" >';
		
		echo '<option value="">'.$placeholder.'</option>';
		if($opciones != null)
		{
			foreach($opciones as $key => $value)
			{

				if((!Empty($post)) && ($post==$key))
				{
					echo '<option value="'.$key.'" selected>'.$value.'</option>';
				}else
				{ 
					echo '<option value="'.$key.'">'.$value.'</option>';
				}
			}
		}
		
		echo '</select>';

		echo '<span id="span_texto_'.$id.'" class="help-inline"></span>
		</div></div>';
	}

	Public function lista($id, $nombre, $etiqueta, $placeholder, $ayuda,  $post=null, $opciones=array(), $obligatorio, $error=array(), $size)
	{
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';

		echo '<div class="col-sm-'.$size.' "><select class="form-control" name="'.$nombre.'" id="'.$id.'" title="'.$ayuda.'" >';
		echo '<option value="">'.$placeholder.'</option>';
		foreach($opciones as $key => $value)
		{

			if((!Empty($post)) && ($post==$key))
			{
				echo '<option value="'.$key.'" selected>'.$value.'</option>';
			}else
			{ 
				echo '<option value="'.$key.'">'.$value.'</option>';
			}
		}

		echo '</select>';

		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		echo '</div></div>';
	}

	Public function lista_2($id, $nombre, $etiqueta, $evento=null, $placeholder, $ayuda,  $post=null, $opciones=array(), $obligatorio, $error=array(), $size)
	{
		$mensaje_error = $nombre.'_error';
		if($size==null){$size=10;}
		if($error[0] != null ) {
			echo '<div class="form-group has-error has-feedback alert alert-danger alert-dismissable">';
		}else{
			echo '<div class="form-group ">';
		}

		if ($evento != null) {
				$event = '';
				require_once 'libs/Funciones.class.php';
				$Funcion = new Funcion('libs/Funciones.class.php');
				$event .= $Funcion->evento($evento);
		} 
		
		echo '<label for="inputEmail3" class="col-sm-2 control-label">'.$etiqueta;
		if($obligatorio == 1) {echo '<b style="color:red;"> *</b>';}
		echo '</label>';
		
		echo '<div class="col-sm-'.$size.' "><select class="form-control" '.@$event.' name="'.$nombre.'" id="'.$id.'" title="'.$ayuda.'">';
		echo '<option value="">'.$placeholder.'</option>';
		foreach($opciones as $key => $value)
		{

			if((!Empty($post)) && ($post==$key))
			{
				echo '<option value="'.$key.'" selected>'.$value.'</option>';
			}else
			{ 
				echo '<option value="'.$key.'">'.$value.'</option>';
			}
		}

		echo '</select>';

		if($error[0] != null ) {echo '<span class="help-inline">'.$error[0].'</span>';}
		echo '</div></div>';
	}

}
?>
