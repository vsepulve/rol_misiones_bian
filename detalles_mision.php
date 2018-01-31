
<html>

<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
<meta charset="UTF-8">
<title>Lista de Misiones</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

#$id_mision = mysql_real_escape_string($_GET["id_mision"]);
$id_mision = 0;
if(isset($_GET["id_mision"])){
	$id_mision = $mysqli->real_escape_string($_GET["id_mision"]);
}
if( !ctype_digit($id_mision) ){
	$id_mision = 0;
}

$mision = get_mision($mysqli, $id_mision);

#mysql_close($db);
	
	echo "<div>\n";
	
	echo "<div style=\"font-size:24px; font-weight: bold;\"><a href=\"listar_misiones.php\">Volver a Lista</a></div>\n";
	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";
	
	echo "<div style=\"font-size:24px; font-weight: bold;\">\n";
#	echo "<a href = \"editar_mision.php?id_mision=".$mision["id_mision"]."\">";
	echo $mision["titulo"];
#	echo "</a>";
	
	echo "&nbsp;&nbsp;&nbsp;(";
	echo "<a href = \"editar_mision.php?id_mision=".$mision["id_mision"]."\">Editar</a>&nbsp;|&nbsp;";
	echo "<a href = \"listar_misiones.php?eliminar=1&id_mision=".$mision["id_mision"]."\">Eliminar</a>";
	echo ")\n";
	
	echo "</div>\n";
	
	echo "<div style=\"font-size:20px;\"> Contratista: \n";
	echo "<span style=\"font-style: italic;\">".$mision["contratista"]."</span>\n";
	echo "</div>\n";

	echo "<div style=\"font-size:20px;\"> Dificultad: \n";
	echo "<span style=\"font-style: italic;\">".$mision["dificultad"]."</span>\n";
	echo "</div>\n";

	echo "<div style=\"font-size:20px;\"> Estado: \n";
	echo "<span style=\"font-style: italic;\">".$estado_mision[$mision["estado"]]."</span>\n";
	echo "</div>\n";

	echo "<div style=\"margin: 0 auto; width:90%;\">\n";
	echo $mision["descripcion"];
	echo "</div>\n";
	
	$encuentros = $mision["encuentros"];
	
	foreach($encuentros as $encuentro){
		echo "<div style=\"height: 15px;\">&nbsp;</div>\n";
		echo "<div style=\"font-size:20px; font-weight: bold;\">\n";
		echo $encuentro["nombre"]." (".count($encuentro["criaturas"])." criaturas, VD total ".calcular_vd_suma($encuentro["criaturas"]).")";
		echo "</div>\n";
		
		echo "<div style=\"margin: 0 auto; width:95%;\">\n";
		echo $encuentro["notas"];
		echo "</div>\n";
			
		foreach($encuentro["criaturas"] as $criatura){
			echo "<div style=\"margin: 0 auto; width:90%; font-size:14px; font-weight: bold;\">\n";
			echo $criatura["nombre"]." [VD ".$criatura["vd"]."]\n";
			echo "</div>\n";
		}
		
	}

	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

	echo "</div>\n";
	

?>


</body>















</html>









