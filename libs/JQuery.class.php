<?php
class JQuery 
{
	Public function  galeriaImagen_01($id, $ancho, $alto,  $arreglo, $efecto)
	{
		echo '
		<style type="text/css" media="screen">
		
  			@import "librerias/lof_jquery/css/style1.css";
		</style>
		<script type="text/javascript">
                     $(document).ready( function(){ 
                        // buttons for next and previous item            
                        var buttons = { previous:$("#'.$id.' .button-previous") ,
                                next:$("#'.$id.' .button-next") };     
                         $("#'.$id.'").lofJSidernews( { interval : 4000,
                                          direction   : "opacitys", 
                                          easing      : "'.$efecto.'", //"easeInOutExpo",
                                          duration    : 1200,
                                          auto      : true,
                                          maxItemDisplay  : 4,
                                          navPosition     : "horizontal", // horizontal
                                          navigatorHeight : 32,
                                          navigatorWidth  : 80,
                                          mainWidth   : '.$ancho.',
                                          buttons     : buttons } );  
                      });
                  </script>';

		echo '
				<div id="'.$id.'" class="lof-slidecontent1 modal_galeria" style="width:'.$ancho.'px; height:'.$alto.'px;">
                      <div class="preload">
                        <div>
                          
                        </div>
                      </div>
                             <!-- MAIN CONTENT --> 
                      <div class="main-slider-content" style="width:'.$ancho.'px; height:'.$alto.'px;">
                        <ul class="sliders-wrap-inner">
                         ';
                         	$j=0;
                            foreach ($arreglo as $key => $value) 
			                {
			                	
			                	if (is_array($value)) 
			                	{
			                		if ($j==$key) {
			                			//echo $j.'='.$key.'<br>';
			                			echo '
			                			<li>
				                            <img id="imagen_01'.$j.'" src="" title="imagen" width="'.$ancho.'px;"  height="'.$alto.'px;">           
				                          	<div id="slider-description'.$j.'" class="slider-description">';
				                          	
				                          	echo'
					                            <div id="titulo__01'.$j.'" class="slider-meta"><a target="_parent" title="logo" href="#Category-1" id="titulo_01'.$j.'">/ /</a> <i></i></div>
					                            <h4></h4>
					                            <p id="html_01'.$j.'"> 
					                            <a class="readmore" href="#"></a>
					                            </p>
				                         	</div>
			                    		</li>
			                    		';
			                			foreach ($value as $key2 => $value2) {
			                				if ($key2 == 'imagen') {
			                					//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
			                					echo '<script type="text/javascript">$("#imagen_01'.$j.'").attr("src", "'.$value2.'");</script>';
			                				}elseif ($key2=='titulo'){
			                					echo '<script type="text/javascript">$("#titulo_01'.$j.'").text("'.$value2.'");</script>';
			                				}elseif ($key2=='html') {
			                					echo '<script type="text/javascript">$("#html_01'.$j.'").html("'.$value2.'");</script>';
			                				}
			                				
			                			}
			                		}
			                		
			                		 
			                	}
			                	$j++;
			                	
			                }
                           
                          echo'    
                        </ul>   
                      </div>
                      <div class="navigator-content">
                        <div class="button-next">Âïåðåä</div>
                          <div class="navigator-wrapper">
                                <ul class="navigator-wrap-inner">';
                                	$k=0;
			                        foreach ($arreglo as $key => $value) 
			                		{
			                			if (is_array($value)) 
			                			{
			                				if ($k==$key) 
			                				{
                                   				echo'<li><img id="imagen_01min'.$k.'" src="librerias/lof_jquery/images/thumbs/thumbl_980x340.png" /></li>';
                                   			}

                                   			foreach ($value as $key2 => $value2) 
					                        {
					                			if ($key2 == 'imagen') {
					                				//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
					                				echo '<script type="text/javascript">$("#imagen_01min'.$k.'").attr("src", "'.$value2.'");</script>';
					                			}
				                			}
                                   		}
                                   		$k++;
                                   	}

                              echo'        
                                </ul>
                          </div>
                        <div  class="button-previous">atras</div>
                      </div>
                      <div class="button-control"><span></span>
                      </div>
                        <!-- END OF BUTTON PLAY-STOP -->
                    </div>
               ';
	}
	Public function galeriaImagen_03($id, $ancho, $alto, $arreglo, $efecto, $activar)
	{
		echo 
		'<style type="text/css" media="screen">
		
  			@import "librerias/lof_jquery/css/style3.css";
		</style>
		<script type="text/javascript">
			 $(document).ready( function(){ 
			        var buttons = { previous:$("#'.$id.' .button-previous") ,
			                        next:$("#'.$id.' .button-next") };
			        $("#'.$id.'").lofJSidernews( { interval:5000,

			                                                easing:"'.$efecto.'", //"easeOutBounce",
			                                                //direction:"opacity",
			                                                duration:1200,
			                                                auto:false,
			                                                mainWidth:980,
			                                                mainHeight:300,
			                                                navigatorHeight     : 100,
			                                                navigatorWidth      : 340,
			                                                maxItemDisplay:3,
			                                                buttons:buttons} );                     
			    });

		</script>';
		echo
		'<!------------------------------------- THE CONTENT ------------------------------------------------->
			<div id="'.$id.'" class="lof-slidecontent modal_galeria" style="width:'.$ancho.'px; height:'.$alto.'px;">
				<div class="preload"><div></div></div>
			            
			            
			            <div  class="button-previous">Íàçàä</div>
			                   
			    		 <!-- MAIN CONTENT --> 
			              <div class="main-slider-content" style="width:'.$ancho.'px; height:'.$alto.'px;">
			                <ul class="sliders-wrap-inner">';
			               
			                $long = count($arreglo);
			                $j=0;
			                foreach ($arreglo as $key => $value) 
			                {
			                	
			                	if (is_array($value)) 
			                	{
			                		if ($j==$key) {
			                			//echo $j.'='.$key.'<br>';
			                			echo '
			                			<li>
				                            <img id="imagen'.$j.'" src="" title="imagen" >           
				                          	<div class="slider-description">
					                            <div class="slider-meta"><a target="_parent" title="logo" href="#Category-1" id="titulo'.$j.'">/ /</a> <i></i></div>
					                            <h4></h4>
					                            <p id="html'.$j.'"> 
					                            <a class="readmore" href="#"></a>
					                            </p>
				                         	</div>
			                    		</li>';
			                			foreach ($value as $key2 => $value2) {
			                				if ($key2 == 'imagen') {
			                					//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
			                					echo '<script type="text/javascript">$("#imagen'.$j.'").attr("src", "'.$value2.'");</script>';
			                				}elseif ($key2=='titulo') {
			                					echo '<script type="text/javascript">$("#titulo'.$j.'").text("'.$value2.'");</script>';
			                				}elseif ($key2=='html') {
			                					echo '<script type="text/javascript">$("#html'.$j.'").html("'.$value2.'");</script>';
			                				}
			                				
			                			}
			                		}
			                		
			                		 
			                	}
			                	$j++;
			                	
			                }

			                echo'
			                  </ul>  	
			            </div>
			 		   <!-- END MAIN CONTENT --> 
			           <!-- NAVIGATOR -->
			           ';
			           if (!is_null($activar)) {
			           	# code...
			           
			           echo '
			           	<div class="navigator-content">
			                  <div class="navigator-wrapper">
			                        <ul class="navigator-wrap-inner">';
			                        $k=0;
			                        foreach ($arreglo as $key => $value) 
			                		{
			                			if (is_array($value)) 
			                			{
			                				if ($k==$key) 
			                				{
			                					echo ' 
			                					<li>
					                                <div>
					                                    <img id="imagen_min'.$k.'" src="" width="70px" height="25px"/>
					                                    <h3 id="titulo_min'.$k.'" > Misi&oacute;n </h3>
					                                    <span></span>
					                                </div>    
					                            </li>';
					                            foreach ($value as $key2 => $value2) 
					                            {
					                				if ($key2 == 'imagen') {
					                					//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
					                					echo '<script type="text/javascript">$("#imagen_min'.$k.'").attr("src", "'.$value2.'");</script>';
					                				}elseif ($key2=='titulo') {
					                					echo '<script type="text/javascript">$("#titulo_min'.$k.'").text("'.$value2.'");</script>';
					                				}
				                				}
			                				}
			                			}
			                			$k++;
			                		}

			                        /*
			                          <li>
			                                <div>
			                                    <img src="librerias/lof_jquery/images/thumbs/thumbl_980x340_008.png" />
			                                    <h3> Misi&oacute;n </h3>
			                                    <span></span>
			                                </div>    
			                            </li>*/
			                              
			                        echo'    	
			                        </ul>
			                  </div>
			   
			            </div> 
			            ';
			        }
			            echo '
			          <!----------------- END OF NAVIGATOR --------------------->
			                            <div class="button-next">Âïåðåä</div>
			</div> 

		<!------------------------------------- END OF THE CONTENT ------------------------------------------------->
		';
	}

	Public function galeriaImagen_02($id, $ancho, $alto, $arreglo, $efecto, $activar)
	{
		echo 
		'<style type="text/css" media="screen">
		
  			@import "librerias/lof_jquery/css/style2.css";
		</style>
		<script type="text/javascript">
			 $(document).ready( function(){ 
			        var buttons = { previous:$("#'.$id.' .button-previous") ,
			                        next:$("#'.$id.' .button-next") };
			        $("#'.$id.'").lofJSidernews( { interval:5000,

			                                                easing:"'.$efecto.'", //"easeOutBounce",
			                                                //direction:"opacity",
			                                                duration:1200,
			                                                auto:true,
			                                                mainWidth:980,
			                                                mainHeight:300,
			                                                navigatorHeight     : 100,
			                                                navigatorWidth      : 340,
			                                                maxItemDisplay:3,
			                                                buttons:buttons} );                     
			    });

		</script>';
		echo
		'<!------------------------------------- THE CONTENT ------------------------------------------------->
			<div id="'.$id.'" class="lof-slidecontent modal_galeria" style="width:'.$ancho.'px; height:'.$alto.'px;">
				<div class="preload"><div></div></div>
			            
			            
			            <div  class="button-previous">Íàçàä</div>
			                   
			    		 <!-- MAIN CONTENT --> 
			              <div class="main-slider-content" style="width:'.$ancho.'px; height:'.$alto.'px;">
			                <ul class="sliders-wrap-inner">';
			               
			                $long = count($arreglo);
			                $j=0;
			                foreach ($arreglo as $key => $value) 
			                {
			                	
			                	if (is_array($value)) 
			                	{
			                		if ($j==$key) {
			                			//echo $j.'='.$key.'<br>';
			                			echo '
			                			<li>
				                            <img id="imagen'.$j.'" src="" title="imagen" >           
				                          	<div class="slider-description">
					                            <div class="slider-meta"><a target="_parent" title="logo" href="#Category-1" id="titulo'.$j.'">/ /</a> <i></i></div>
					                            <h4></h4>
					                            <p id="html'.$j.'"> 
					                            <a class="readmore" href="#"></a>
					                            </p>
				                         	</div>
			                    		</li>';
			                			foreach ($value as $key2 => $value2) {
			                				if ($key2 == 'imagen') {
			                					//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
			                					echo '<script type="text/javascript">$("#imagen'.$j.'").attr("src", "'.$value2.'");</script>';
			                				}elseif ($key2=='titulo') {
			                					echo '<script type="text/javascript">$("#titulo'.$j.'").text("'.$value2.'");</script>';
			                				}elseif ($key2=='html') {
			                					echo '<script type="text/javascript">$("#html'.$j.'").html("'.$value2.'");</script>';
			                				}
			                				
			                			}
			                		}
			                		
			                		 
			                	}
			                	$j++;
			                	
			                }

			                echo'
			                  </ul>  	
			            </div>
			 		   <!-- END MAIN CONTENT --> 
			           <!-- NAVIGATOR -->
			           ';
			           if (!is_null($activar)) 
			           {
			           	# code...
			           
			           echo '
			           	<div class="navigator-content">
			                  <div class="navigator-wrapper">
			                        <ul class="navigator-wrap-inner">';
			                        $k=0;
			                        foreach ($arreglo as $key => $value) 
			                		{
			                			if (is_array($value)) 
			                			{
			                				if ($k==$key) 
			                				{
			                					echo ' 
			                					<li>
					                                <div>
					                                    <img id="imagen_min'.$k.'" src="" width="70px" height="25px"/>
					                                    <h3 id="titulo_min'.$k.'" > Misi&oacute;n </h3>
					                                    <span></span>
					                                </div>    
					                            </li>';
					                            foreach ($value as $key2 => $value2) 
					                            {
					                				if ($key2 == 'imagen') {
					                					//echo $j.'='.$key.'/'.$key2.'='.$value2.'<br>';
					                					echo '<script type="text/javascript">$("#imagen_min'.$k.'").attr("src", "'.$value2.'");</script>';
					                				}elseif ($key2=='titulo') {
					                					echo '<script type="text/javascript">$("#titulo_min'.$k.'").text("'.$value2.'");</script>';
					                				}
				                				}
			                				}
			                			}
			                			$k++;
			                		}

			                        /*
			                          <li>
			                                <div>
			                                    <img src="librerias/lof_jquery/images/thumbs/thumbl_980x340_008.png" />
			                                    <h3> Misi&oacute;n </h3>
			                                    <span></span>
			                                </div>    
			                            </li>*/
			                              
			                        echo'    	
			                        </ul>
			                  </div>
			   
			            </div> 
			            ';
			        }
			            echo '
			          <!----------------- END OF NAVIGATOR --------------------->
			                            <div class="button-next">Âïåðåä</div>
			</div> 

		<!------------------------------------- END OF THE CONTENT ------------------------------------------------->
		';
	}

	Public function banner_carrusel()
	{
		echo'
			<div id="intro" class="sliderBanner">
				<div class="sliderBanner-nav"> 
						<a href="#" class="left notext">1</a> <a href="#" class="left notext">2</a> <a href="#" class="left notext">3</a> <a href="#" class="left notext">4</a>
						<a href="#" class="left notext">5</a><a href="#" class="left notext">6</a>
						<div class="cl">&nbsp;</div>
				</div>
					
				<ul>
					<li>
						<div class="item">
							<div class="text">
								<h3><em></em></h3>
								<h2><em></em></h2>
							</div>
							<br><br><br><br>
							<p><span style="color:#000000"><span style="font-size:28px"><strong><span style="font-family:arial,helvetica,sans-serif">Unas 6.500 personas desfilan este &nbsp;</span></strong></span></span></p>

						<p><span style="color:#000000"><span style="font-size:28px"><strong><span style="font-family:arial,helvetica,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; martes por los 229 a&ntilde;os del natalicio de Jos&eacute; Mar&iacute;a Vargas</span></strong></span></span></p>

							<!--<a href="http://canaima.softwarelibre.gob.ve/descargas/canaima-popular/versiones/4.0" target="_blank" ><img id="image" src="plantillas/01/css/imageBanner/bannerCanaima4.0.png" alt="satelite"></a>
							-->
			            </div>
					</li>
						
					<li>
						<div class="item">
							<div class="text">
							  	<h3><em></em></h3>
							  	<h2><em></em></h2>
							</div>
								<a href="index.php?controlador=Sistema&accion=indexMostrarInfoBanner" ><img id="image" src="plantillas/01/css/imageBanner/bannerChavez.png" alt="satelite"></a>
			            </div>
					</li>
						
					<li>
						<div class="item">
							<div class="text">
							  <h3><em></em></h3>
							  <h2><em></em></h2>
							</div>
							 <a href="http://www.mppee.gob.ve/inicio/ministerio/ahorro-energetico" target="_blank" ><img id="image" src="plantillas/01/css/imageBanner/banner_consumo_eficiente_top.png" alt="satelite"></a>
			            </div>
					</li>
				</ul> 
			</div>
			   <!--end intro-->
			<header class="group_bannner_left"></header>';
	}

	Public function calendarioDatepicker(){
		echo'
			 <script type="text/javascript">
	                    /* Inicialización en español para la extensión \'UI date picker\' para jQuery. */
	        /* Traducido por Vester (xvester [en] gmail [punto] com). */
	        jQuery(function($){
	           $.datepicker.regional[\'es\'] = {
	              closeText: \'Cerrar\',
	              prevText: \'<Ant\',
	              nextText: \'Sig>\',
	              currentText: \'Hoy\',
	              monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
	              monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
	              dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Miércoles\', \'Jueves\', \'Viernes\', \'Sábado\'],
	              dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mié\',\'Juv\',\'Vie\',\'Sáb\'],
	              dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sá\'],
	              weekHeader: \'Sm\',
	              dateFormat: \'dd/mm/yy\',
	              firstDay: 1,
	              isRTL: false,
	              showMonthAfterYear: false,
	              /*
	              option:true,
	              changeMonth: true,
	              changeYear: true,*/

	              yearSuffix: \'\'};
	           $.datepicker.setDefaults($.datepicker.regional[\'es\']);
	        });
	    </script>
	    <div id="calendario"></div>
	  
	    <script>
	    	$(function() {
				$( "#calendario" ).datepicker({
					dateFormat: \'dd/mm/yy\',
					inline: true,
					
					  \'option\': false});
				});
		</script>';

	}
}

?>