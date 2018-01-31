
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

#$eliminar = mysql_real_escape_string($_GET["eliminar"]);
$eliminar = 0;
if(isset($_GET["eliminar"])){
	$eliminar = $mysqli->real_escape_string($_GET["eliminar"]);
}
if($eliminar != 1){
	$eliminar = 0;
}

#$id_mision = mysql_real_escape_string($_GET["id_mision"]);
$id_mision = 0;
if(isset($_GET["id_mision"])){
	$id_mision = $mysqli->real_escape_string($_GET["id_mision"]);
}
if( !ctype_digit($id_mision) ){
	$id_mision = 0;
}

if($eliminar == 1 && $id_mision > 0){
	echo "<h3>Eliminando Mision $id_mision</h3>\n";
	eliminar_mision_dummy($db, $id_mision);
}

$misiones = get_misiones($mysqli);

#mysql_close($db);


foreach($misiones as $mision){
	
	echo "<div>\n";
	
	echo "<div style=\"font-size:22px; font-weight: bold;\">\n";
#	echo "<a href = \"editar_mision.php?id_mision=".$mision["id_mision"]."\">";
	echo $mision["titulo"];
#	echo "</a>";
	
	echo "&nbsp;&nbsp;&nbsp;(";
	echo "<a href = \"detalles_mision.php?id_mision=".$mision["id_mision"]."\">Detalles</a>&nbsp;|&nbsp;";
	echo "<a href = \"editar_mision.php?id_mision=".$mision["id_mision"]."\">Editar</a>&nbsp;|&nbsp;";
	echo "<a href = \"listar_misiones.php?eliminar=1&id_mision=".$mision["id_mision"]."\">Eliminar</a>";
	echo ")\n";
	
	echo "</div>\n";
	
	echo "<div> Contratista: \n";
	echo "<span style=\"font-style: italic;\">".$mision["contratista"]."</span>\n";
	echo "</div>\n";

	echo "<div> Dificultad: \n";
	echo "<span style=\"font-style: italic;\">".$mision["dificultad"]."</span>\n";
	echo "</div>\n";

	echo "<div> Estado: \n";
	echo "<span style=\"font-style: italic;\">".$estado_mision[$mision["estado"]]."</span>\n";
	echo "</div>\n";

	echo "<div style=\"margin: 0 auto; width:90%;\">\n";
	echo $mision["descripcion"];
	echo "</div>\n";
	
	$encuentros = $mision["encuentros"];
#	echo "encuentros: ".count($encuentros)."<br>\n";
	
	foreach($encuentros as $encuentro){
		echo "<div style=\"font-size:16px; font-weight: bold;\">\n";
		echo $encuentro["nombre"]." (".count($encuentro["criaturas"])." criaturas, VD total ".calcular_vd_suma($encuentro["criaturas"]).")";
		echo "</div>\n";
	}

	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

	echo "</div>\n";
	
	
}

?>


</body>















</html>









