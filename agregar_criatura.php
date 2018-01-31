
<html>

<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
<meta charset="UTF-8">
<title>Agregar Criatura</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

#$id_base = mysql_real_escape_string($_GET["id_base"]);
$id_base = NULL;
if(isset($_GET["id_base"])){
	$id_base = $mysqli->real_escape_string($_GET["id_base"]);
}

#$clase_base = mysql_real_escape_string($_GET["clase_base"]);
$clase_base = NULL;
if(isset($_GET["clase_base"])){
	$clase_base = $mysqli->real_escape_string($_GET["clase_base"]);
}

#$nivel_base = mysql_real_escape_string($_GET["nivel_base"]);
$nivel_base = NULL;
if(isset($_GET["nivel_base"])){
	$nivel_base = $mysqli->real_escape_string($_GET["nivel_base"]);
}

if($id_base != NULL && strlen($id_base) > 0){
	echo "<h3>Cargando Criatura Base $id_base</h3>\n";
	$criatura_base = get_criatura($mysqli, $id_base);
}
else if($clase_base != NULL && $nivel_base != NULL){
	echo "<h3>Cargando Clase Base $clase_base / $nivel_base</h3>\n";
	$criatura_base = crear_clase($clase_base, $nivel_base);
}
else{
#	echo "<h3>Sin Base</h3>\n";
	$criatura_base = NULL;
}

#$nombre = mysql_real_escape_string($_POST["nombre"]);
#$dg = mysql_real_escape_string($_POST["dg"]);
#$ca = mysql_real_escape_string($_POST["ca"]);
#$ca_descripcion = mysql_real_escape_string($_POST["ca_descripcion"]);
#$ataques = mysql_real_escape_string($_POST["ataques"]);
#$ini = mysql_real_escape_string($_POST["ini"]);
#$ts = mysql_real_escape_string($_POST["ts"]);
#$caracteristicas = mysql_real_escape_string($_POST["caracteristicas"]);
#$habilidades = mysql_real_escape_string($_POST["habilidades"]);
#$vd = mysql_real_escape_string($_POST["vd"]);
#$tesoro = mysql_real_escape_string($_POST["tesoro"]);
#$tipo = mysql_real_escape_string($_POST["tipo"]);
#$especial = mysql_real_escape_string($_POST["especial"]);
#$agregar_criatura = mysql_real_escape_string($_POST["agregar_criatura"]);

$nombre = $_POST["nombre"];
$dg = $_POST["dg"];
$ca = $_POST["ca"];
$ca_descripcion = $_POST["ca_descripcion"];
$ataques = $_POST["ataques"];
$ini = $_POST["ini"];
$ts = $_POST["ts"];
$caracteristicas = $_POST["caracteristicas"];
$habilidades = $_POST["habilidades"];
$vd = $_POST["vd"];
$tesoro = $_POST["tesoro"];
$tipo = $_POST["tipo"];
$especial = $_POST["especial"];
$agregar_criatura = $_POST["agregar_criatura"];

if($agregar_criatura == 1){
	echo "<h3>Agregando Criatura \"$nombre\"</h3>\n";
	
	crear_criatura($mysqli, $nombre, $dg, $ca, $ca_descripcion, $ataques, $ini, $ts, $caracteristicas, $habilidades, $vd, $tesoro, $especial, $tipo);
	
}

$criaturas = get_criaturas($mysqli, NULL);

#mysql_close($db);

?>


<h1>Agregar Criatura</h1>

<?php

echo "<form method=\"get\" action=\"agregar_criatura.php\">";

echo "<div style=\"margin:auto; height: 30px\">\n";
#echo "<span style = \"float: left; width: 150px;\">Criatura Base</span>\n";
echo "<select name = \"id_base\" >\n";
echo "<option value = 0> -- Seleccionar Criatura -- </option>\n";
#	echo "<option value = 1> lalalalalalalalalalallalalalaalal </option>\n";
#	echo "<option value = 2> Opel </option>\n";
#	echo "<option value = 3> Audi </option>\n";

foreach($criaturas as $criatura){
	echo "<option value = ".$criatura["id_criatura"].">";
#	echo "[VD ".$criatura["vd"]."] - ".$criatura["nombre"]." [".$criatura["tipo"]."]";
	echo "[".$criatura["tipo"]." - VD ".$criatura["vd"]."] - ".$criatura["nombre"];
	echo "</option>\n";
}

echo "</select>\n";
echo "</div>\n";

echo "<input type=submit name=accion value=\"Definir Clase Base\">";
	
echo "</form>";

echo "<form method=\"get\" action=\"agregar_criatura.php\">";

echo "<div style=\"margin:auto; height: 30px\">\n";
#echo "<span style = \"float: left; width: 150px;\">Criatura Base</span>\n";

echo "<select name = \"clase_base\" >\n";
echo "<option value = 0> -- Seleccionar Clase -- </option>\n";
echo "<option value = 1> Luchador </option>\n";
echo "<option value = 2> Sacerdote </option>\n";
echo "<option value = 3> Bribon </option>\n";
echo "<option value = 4> Hechicero </option>\n";
echo "</select>\n";

echo "<select name = \"nivel_base\" >\n";
echo "<option value = 0> -- Seleccionar Nivel -- </option>\n";

for($i=1; $i<=20; $i++){
	echo "<option value = $i> $i </option>\n";
}

echo "</select>\n";


echo "</div>\n";

echo "<input type=submit name=accion value=\"Definir Clase Base\">";
	
echo "</form>";



echo "<form method=\"post\" action=\"agregar_criatura.php\">\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Nombre:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=nombre size=50 value=\"".$criatura_base["nombre"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "DG:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=dg size=50 value=\"".$criatura_base["dg"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "CA:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ca size=50 value=\"".$criatura_base["ca"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "CA Detalle:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ca_descripcion size=50 value=\"".$criatura_base["ca_descripcion"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Ataques:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ataques size=50 value=\"".$criatura_base["ataques"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Iniciativa:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ini size=50 value=\"".$criatura_base["ini"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "TS:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ts size=50 value=\"".$criatura_base["ts"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Caract.:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=caracteristicas size=50 value=\"".$criatura_base["caracteristicas"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Habilidades:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=habilidades size=50 value=\"".$criatura_base["habilidades"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "VD:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=vd size=50 value=\"".$criatura_base["vd"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Tesoro:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=tesoro size=50 value=\"".$criatura_base["tesoro"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Tipo:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=tipo size=50 value=\"".$criatura_base["tipo"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Habilidades Especiales:\n";
echo "</div>\n";

echo "<div>\n";
echo "<textarea rows=\"5\" cols=\"80\" name=\"especial\">".$criatura_base["especial"]."</textarea>\n";
echo "</div>\n";

echo "<input type=\"hidden\" value=1 name=\"agregar_criatura\"/>\n";

echo "<input type=submit name=accion value=\"Agregar\">\n";

echo "</form>\n";



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









