
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingresar Mision</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

$crear_mision = mysql_real_escape_string($_POST["crear_mision"]);
$titulo = mysql_real_escape_string($_POST["titulo"]);
$contratista = mysql_real_escape_string($_POST["contratista"]);
$dificultad = mysql_real_escape_string($_POST["dificultad"]);
$descripcion = mysql_real_escape_string($_POST["descripcion"]);

if($crear_mision == 1 && strlen($titulo) > 0 && strlen($contratista) > 0 
	&& strlen($dificultad) > 0 && strlen($descripcion) > 0 ){
#	echo "<h3>Creando mision</h3>\n";
	
	//Revisar datos (opcional)
	
	//Ingresar Mision (conservar el id)
	$id_mision = crear_mision($db, $titulo, $contratista, $dificultad, $descripcion);
	
	//Leer mision desde la BD (para verificar)
	$mision = get_mision($db, $id_mision);
	
	//Presentar mision creada
	echo "<h1>Mision Creada</h1>\n";
	
	echo "<div>\n";
	
	echo "<div style=\"font-size:22px; font-weight: bold;\">\n";
	echo $mision["titulo"];
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
	
	echo "<div style=\"font-size:18px; font-weight: bold;\">\n";
	echo "<a href=\"editar_mision.php?id_mision=$id_mision\">Editar Encuentros</a>\n";
	echo "</div>\n";
	
	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";
	
	echo "</div>\n";
	
}

mysql_close($db);

?>

<h1>Creacion de Mision</h1>

<form method="post" action="ingresar_mision.php">

<div style="margin:auto; height: 30px">
Titulo:
<span style="position: absolute; left: 120px;">
<input type=text name=titulo size=40 value="">
</span>
</div>

<div style="margin:auto; height: 30px">
Contratista:
<span style="position: absolute; left: 120px">
<input type=text name=contratista size=40 value="">
</span>
</div>

<div style="margin:auto; height: 30px">
Dificultad:
<span style="position: absolute; left: 120px">
<input type=text name=dificultad size=40 value="">
</span>
</div>

<div>
<textarea rows="5" cols="80" name="descripcion">Descripcion</textarea> 
</div>

<input type="hidden" value=1 name="crear_mision" />


<input type=submit name=accion value="Agregar">

</form>

</body>















</html>









