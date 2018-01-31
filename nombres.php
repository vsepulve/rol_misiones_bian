
<html>

<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
<meta charset="UTF-8">
<title>Lista de Nombres</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

#$crear_nombre = mysql_real_escape_string($_POST["crear_nombre"]);
$crear_nombre = 0;
if(isset($_GET["crear_nombre"])){
	$crear_nombre = $mysqli->real_escape_string($_GET["crear_nombre"]);
}
if($crear_nombre == 1){
	$texto = mysql_real_escape_string($_POST["texto"]);
	$cultura = mysql_real_escape_string($_POST["cultura"]);
	$uso = mysql_real_escape_string($_POST["uso"]);
	if( strlen($texto) > 0 && strlen($cultura) > 0 && strlen($uso) > 0 ){
		crear_nombre($db, $texto, $cultura, $uso);
	}
}

# Verifica si existe un nombre identico
# De ser el caso, solo agrega el uso
function crear_nombre($db, $texto, $cultura, $uso){
	
	$consulta = "select * from nombre where texto = \"$texto\"";
#	$resultado = mysql_query($consulta, $db);
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	if( $fila = $resultado->fetch_assoc() ){
		//Update en lugar de insert
		$id_nombre = $fila["id_nombre"];
		$uso_original = $fila["uso"];
		if(strlen($uso_original) > 0){
			$uso_nuevo = $uso_original.". ".$uso;
		}
		else{
			$uso_nuevo = $uso;
		}
		$consulta = "update nombre set uso = \"$uso_nuevo\" where id_nombre = \"$id_nombre\"";
#		echo "<h3>Ejecutando \"$consulta\"</h3>";
#		$resultado = mysql_query($consulta, $db);
		$resultado = $db->query($consulta);
	}
	else{
		//Insert
		$consulta = "insert into nombre (texto, cultura, uso) values (\"$texto\", \"$cultura\", \"$uso\") ";
#		$resultado = mysql_query($consulta, $db);
		$resultado = $db->query($consulta);
	}
	
}

function get_nombres_usados($db, $numero){
	$consulta = "select * from nombre where not isnull(uso) order by tiempo_mod desc limit $numero";
#	$resultado = mysql_query($consulta, $db);
	$nombres = array();
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
#		$nombre = array();
#		$nombre["id_nombre"] = $fila[0];
#		$nombre["texto"] = $fila[1];
#		$nombre["cultura"] = $fila[2];
#		$nombre["uso"] = $fila[3];
#		$nombres[] = $nombre;
		$nombres[] = $fila;
	}
	return $nombres;
}

function get_nombres_nuevos($db, $numero){
	$consulta = "select * from nombre where isnull(uso) order by rand() limit $numero";
#	$resultado = mysql_query($consulta, $db);
	$nombres = array();
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
#		$nombre = array();
#		$nombre["id_nombre"] = $fila[0];
#		$nombre["texto"] = $fila[1];
#		$nombre["cultura"] = $fila[2];
#		$nombre["uso"] = $fila[3];
#		$nombres[] = $nombre;
		$nombres[] = $fila;
	}
	return $nombres;
}

$nombres_usados = get_nombres_usados($mysqli, 10);
$nombres_nuevos = get_nombres_nuevos($mysqli, 5);

#mysql_close($db);

echo "<h3>Ultimos nombres usados</h3>\n";

$par = false;
foreach($nombres_usados as $nombre){
	if( $par ){
		$color = "#f0f0f0;";
	}
	else{
		$color = "#c0c0c0;";
	}
	$par = !$par;
	echo "<div style=\"font-size:16px; background-color: $color;\">";
	echo "<span style=\"font-weight: bold; display: inline-block; width: 200px; vertical-align: top;\">";
	echo $nombre["texto"];
	echo "</span>";
	echo "<span style=\"display: inline-block; width: 130px; vertical-align: top;\">";
	echo $nombre["cultura"];
	echo "</span>";
	echo "<span style=\"display: inline-block; width: 500px; vertical-align: top;\">";
	if( strlen($nombre["uso"]) < 1 ){
		echo "Sin Uso";
	}
	else{
		echo $nombre["uso"];
	}
	echo "</span>\n";
	echo "</div>";
	
}
echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

echo "<h3>Nombres disponibles</h3>\n";
foreach($nombres_nuevos as $nombre){
	if( $par ){
		$color = "#f0f0f0;";
	}
	else{
		$color = "#c0c0c0;";
	}
	$par = !$par;
	echo "<div style=\"font-size:16px; background-color: $color;\">";
	echo "<span style=\"font-weight: bold; display: inline-block; width: 200px; vertical-align: top;\">";
	echo $nombre["texto"];
	echo "</span>";
	echo "<span style=\"display: inline-block; width: 130px; vertical-align: top;\">";
	echo $nombre["cultura"];
	echo "</span>";
	echo "<span style=\"display: inline-block; width: 500px; vertical-align: top;\">";
	if( strlen($nombre["uso"]) < 1 ){
		echo "Sin Uso";
	}
	else{
		echo $nombre["uso"];
	}
	echo "</span>";
	echo "</div>";
	
}
echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

echo "<form method=\"post\" action=\"nombres.php\">";

echo "<div style=\"font-size:18px; font-weight: bold;\">";
echo "<span >Nombre</span>";
echo "<span style=\"position: absolute; left: 150px;\">Cultura</span>";
echo "<span style=\"position: absolute; left: 300px;\">Uso</span>";
echo "</div>";
	
echo "<div >";
echo "<input type=text name=texto size=10 value=\"\">";
echo "<span style=\"position: absolute; left: 150px;\">";
echo "<input type=text name=cultura size=10 value=\"hualkir\">";
echo "</span>";
echo "<span style=\"position: absolute; left: 300px;\">";
echo "<input type=text name=uso size=40 value=\"\">";
echo "</span>";
echo "</div>";

echo "<div style=\"height: 5px;\">&nbsp;</div>\n";
echo "<div >";
echo "<input type=submit name=accion value=\"Agregar Nombre\">";
echo "</div>";

echo "<input type=\"hidden\" value=1 name=\"crear_nombre\" />";

echo "</form>";

echo "<div style=\"height: 30px;\">&nbsp;</div><hr>\n";

?>


</body>















</html>









