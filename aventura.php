
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Aventura</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

$id_aventura = mysql_real_escape_string($_GET["id_aventura"]);
if( !ctype_digit($id_aventura) ){
	$id_aventura = 0;
}

//Aventura Seleccionada
#$aventura = get_aventura($db, $id_aventura);

//Lista de Aventuras para seleccion
#$aventuras = get_aventuras($db);

echo "<form method=\"get\" action=\"aventura.php?\">\n";
echo "<div>\n";
echo "<select name = \"select_mision\" >\n";
echo "<option value = 0> -- Seleccionar Mision -- </option>\n";
echo "</select>\n";
echo "</div>\n";
echo "</form>\n";


mysql_close($db);


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
	echo "<span style=\"font-style: italic;\">".$mision["estado"]."</span>\n";
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









