<?php
/*
*******************************************************************************************************************************
*	Rotina para gerar códigos de barra padrão 2of5 .
*	Luciano Lima Silva 09/01/2003
*	netdinamica@netdinamica.com.br
*	Site: www.netdinamica.com.br
*
* Classe por: Glauber Portella Ornelas de Melo (22/11/2004)
*/

class BarCode
{
	var $valor;					// número do código de barra (valor do código 2of5)
	var $barra_preta;		// arquivo de imagem para barra preta
	var $barra_branca;	// arquivo de imagem para barra branca

	// constantes para o padrão 2 of 5
	var $fino = 1 ;
	var $largo = 3 ;
	var $altura = 50 ;

	var $html; // privado

	function BarCode($val, $bpreta="p.gif", $bbranca="b.gif", $gerar=false)
	{
		$this->setValor($val);
		$this->setBarraPreta($bpreta);
		$this->setBarraBranca($bbranca);

		if ($gerar) {
			$this->drawBarCode();
		}
	}
	
	function setValor($val)
	{
		$this->valor = $val;
	}
	
	function getValor()
	{
		return $this->valor;
	}
	
	function setBarraPreta($val)
	{
		$this->barra_preta = $val;
	}
	
	function getBarraPreta()
	{
		return $this->barra_preta;
	}
	
	function setBarraBranca($val)
	{
		$this->barra_branca = $val;
	}
	
	function getBarraBranca()
	{
		return $this->barra_branca;
	}
	
	function getHtml()
	{
		return $this->html;
	}
	
	function parseBarCode($draw=false)
	{
	  $barcodes[0] = "00110" ;
  	$barcodes[1] = "10001" ;
	  $barcodes[2] = "01001" ;
	  $barcodes[3] = "11000" ;
	  $barcodes[4] = "00101" ;
	  $barcodes[5] = "10100" ;
	  $barcodes[6] = "01100" ;
	  $barcodes[7] = "00011" ;
	  $barcodes[8] = "10010" ;
	  $barcodes[9] = "01010" ;
  
		for($f1=9;$f1>=0;$f1--) { 
	    for($f2=9;$f2>=0;$f2--){  
  	    $f = ($f1 * 10) + $f2 ;
	      $texto = "" ;
	      for($i=1;$i<6;$i++){ 
  		     $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      	}
	      $barcodes[$f] = $texto;
  	  }
	  }
		// guarda inicial
		$this->html = "
		<img src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		";
		
		$texto = $this->valor ;
		if((strlen($texto) % 2) <> 0){
			$texto = "0" . $texto;
		}

		// Draw dos dados
		while (strlen($texto) > 0) {
		  $i = round($this->_esquerda($texto,2));
		  $texto = $this->_direita($texto,strlen($texto)-2);
		  $f = $barcodes[$i];
		  for($i=1;$i<11;$i+=2){
		    if (substr($f,($i-1),1) == "0") {
		      $f1 = $this->fino ;
		    }else{
		      $f1 = $this->largo ;
		    }

				$this->html .= "src='" . $this->barra_preta . "' width='" . $f1 . "' height='" . $this->altura . "' border='0'><img \n";

	  	  if (substr($f,$i,1) == "0") {
  	  	  $f2 = $this->fino ;
		    }else{
		      $f2 = $this->largo ;
		    }

				$this->html .= "src='" . $this->barra_branca . "' width='" . $f2 . "' height='" . $this->altura . "' border='0'><img \n";
			}
		}

		// Draw guarda final
		$this->html .= "
		src='". $this->barra_preta . "' width='" . $this->largo . "' height='" . $this->altura . "' border='0'><img
		src='". $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img
		src='". $this->barra_preta . "' width='1' height='" . $this->altura . "' border=0>
		";

		if ($draw) {
			echo $this->html;
		}
	} // função parseBarCode

	function drawBarCode()
	{
		$this->parseBarCode(true);
	}
	
	// privadas
	function _esquerda($entra,$comp)
	{
		return substr($entra,0,$comp);
	}

	function _direita($entra,$comp)
	{
		return substr($entra,strlen($entra)-$comp,$comp);
	}

} // classe BarCode
?>
