 <?php
Class ConvertToPDF
{
    /*----------------------------------------------------------/*
        
    $path     : nombre y/o ruta del pdf (sin la extensión)
                    p.e: --> 'ejemplo' , 'pdfs/nuevo-ejemplo'
                    si se deja vacío --> se genera uno aleatorio

    $content  : contenido del pdf

    $body     : true o false.
                    true  --> Añade; <doctype>, <body>, <head> a $content
                    false --> no altera el $content
                    
    $style    : la ruta de la CSS. Puede estar vacía
                     Para cargar una css --> necesita $body = true;

    $mode     : true o false.
                    true  --> guarda el pdf en un directorio y lo muestra 
                    false --> pregunta si guarda o abre el archivo 
                
    $paper_1  : tamaño del papel[*]
    $paper_2  : estilo del papel[*]
        
        [*] como ver las opciones disponibles: 
            --> http://code.google.com/p/dompdf/wiki/Usage#Invoking_dompdf_via_the_command_line
    if ( isset($_POST['PDF_1']) )
    doPDF('ejemplo',$html,false);

    if ( isset($_POST['PDF_2']) )
        doPDF('ejemplo',$html,true,'style.css');

    if ( isset($_POST['PDF_3']) )
        doPDF('',$html,true,'style.css');
                
    if ( isset($_POST['PDF_4']) )
        doPDF('ejemplo',$html,true,'style.css',false,'letter','landscape'); 
        
    if ( isset($_POST['PDF_5']) )
        doPDF('ejemplo',$html,true,'',true); //asignamos los tags <html><head>... pero no tiene css

    if ( isset($_POST['PDF_6']) )
        doPDF('',$html,true,'style.css',true);
        
    if ( isset($_POST['PDF_7']) )
        doPDF('pdfs/nuevo-ejemplo',$html,true,'style.css',true); //lo guardamos en la carpeta pdfs   

    /*----------------------------------------------------------*/ 

    
    //require_once("librerias/dompdf/dompdf_config.inc.php");
    Public function doPDF($path='',$content='',$body=false,$style='',$mode=false,$paper_1='a4',$paper_2='portrait')
    {    
        //require_once 'libs/Configuracion.class.php';
        $nombre = Configuracion::RAZON_SOCIAL;
        $rif = Configuracion::RIF;
        $dir = Configuracion::DIRECCION;

        require_once("librerias/dompdf/dompdf_config.inc.php");

        if( $body!=true and $body!=false ) $body=false;
        if( $mode!=true and $mode!=false ) $mode=false;
        
        if( $body == true )
        {
            $content='
            <!doctype html>
            <html>
            <head>
                <link rel="stylesheet" href="'.$style.'" type="text/css" />
                <link href="plantillas/01/font-awesome/css/font-awesome.css" rel="stylesheet">
                
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               
            </head>

            <body>
            <div>
                <H3>
                    <B>'.$nombre.'</B>
                </H3>  
                <FONT size="8.4px;">
                    <I>
                        RIF:'.$rif.'<br>'.$dir.'
                    </I>
                    </FONT>
            </div>

            '
                .$content.
            '</body>
            </html>';
        }
        
        if( $content!='' )
        {        
            //Añadimos la extensión del archivo. Si está vacío el nombre lo creamos
            $path!='' ? $path .='.pdf' : $path = $this->crearNombre(10);  

            //Las opciones del papel del PDF. Si no existen se asignan las siguientes:[*]
            if( $paper_1=='' ) $paper_1='a4';
            if( $paper_2=='' ) $paper_2='portrait';
                
            $dompdf =  new DOMPDF();
            $dompdf -> set_paper($paper_1,$paper_2);
            //$dompdf -> load_html(utf8_encode($content));
            $dompdf -> load_html($content);
            //ini_set("memory_limit","32M"); //opcional 
            $dompdf -> render();
            
            //Creamos el pdf
            if($mode==false)
                $dompdf->stream($path);
                
            //Lo guardamos en un directorio y lo mostramos
            if($mode==true)
                if( file_put_contents($path, $dompdf->output()) ) header('Location: '.$path);
        }
    }

    Public function crearNombre($length)
    {
        if( ! isset($length) or ! is_numeric($length) ) $length=6;
        
        $str  = "0123456789abcdefghijklmnopqrstuvwxyz";
        $path = '';
        
        for($i=1 ; $i<$length ; $i++)
          $path .= $str{rand(0,strlen($str)-1)};

        return $path.'_'.date("d-m-Y_H-i-s").'.pdf';    
    }
}
?> 