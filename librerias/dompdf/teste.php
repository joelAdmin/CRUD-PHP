<?php
include_once("class.barcode.php");

$valor = isset($_POST['valor']) ? $_POST['valor'] : "34191183400000292011090000107160253500375000"; // Valor Inicial

$barcode = new BarCode($valor);
$barcode->drawBarCode();
?>
</p>
<form name="form1" method="post" action="">
  <font face="Arial, Helvetica, sans-serif" size="2"><b>Digite o valor do c&oacute;digo
  de barras:</b></font><br>
  <input type="text" name="valor" maxlength="50" size="50" value="<?php echo $valor ?>">
  <input type="submit" name="Submit" value="Gerar C&oacute;digo de Barrar">
</form>
<br>
</body>
</html>
