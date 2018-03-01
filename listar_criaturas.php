<!DOCTYPE html>
<html>

<head >
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
<meta charset="UTF-8">
<title>Lista de Criaturas</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

$tipo = NULL;
if(isset($_GET["tipo"])){
	$tipo = $mysqli->real_escape_string($_GET["tipo"]);
}

if($tipo != NULL && strlen($tipo) > 0){
	$criaturas = get_criaturas($mysqli, $tipo);
}
else{
	$criaturas = get_criaturas($mysqli, NULL);
}

#mysql_close($db);

foreach($criaturas as $criatura){
	
	echo "<div>\n";
	
	echo "<div style=\"font-size:20px;\">";
	echo "<span style=\"font-weight: bold;\">Nombre: </span>";
	echo $criatura["nombre"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">DG: </span>";
	echo $criatura["dg"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">CA: </span>";
	echo $criatura["ca"]." (".$criatura["ca_descripcion"].")";
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Ataques: </span>";
	echo $criatura["ataques"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Iniciativa: </span>";
	echo $criatura["ini"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">TS: </span>";
	echo $criatura["ts"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Características: </span>";
	echo $criatura["caracteristicas"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Habilidades: </span>";
	echo $criatura["habilidades"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">VD: </span>";
	echo $criatura["vd"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Tesoro: </span>";
	echo $criatura["tesoro"];
	echo "</div>";
	
	echo "<div>";
	echo "<span style=\"font-weight: bold;\">Especial: </span>";
	echo "<span style=\"position: relative; left: 20px\">".$criatura["especial"]."</span>";
	echo "</div>";

	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

	echo "</div>\n";
	
	
}

?>

<!--
<div>

<div style="font-size:22px; font-weight: bold;">
Mision de Prueba
</div>

<div style="font-size:16px;"> Contratista: 
<span style="font-style: italic;">Contratista de Prueba</span>
</div>

<div style="font-size:16px;"> Dificultad: 
<span style="font-style: italic;">Media (grupo n5)</span>
</div>

<div style="font-size:16px;"> Estado: 
<span style="font-style: italic;">Ofrecida</span>
</div>

<div style="margin: 0 auto; width:90%;">
Texto descriptivo de la mision
</div>

<div style="font-size:18px; font-weight: bold;"><a href="#">Encuentro 1</a></div>

<div style="height: 15px;">&nbsp;</div>
<hr>

</div>

-->

</body>















</html>









