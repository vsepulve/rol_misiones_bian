
<html>

<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Editar Criatura</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

$id = mysql_real_escape_string($_POST["id"]);
$nombre = mysql_real_escape_string($_POST["nombre"]);
$dg = mysql_real_escape_string($_POST["dg"]);
$ca = mysql_real_escape_string($_POST["ca"]);
$ca_descripcion = mysql_real_escape_string($_POST["ca_descripcion"]);
$ataques = mysql_real_escape_string($_POST["ataques"]);
$ini = mysql_real_escape_string($_POST["ini"]);
$ts = mysql_real_escape_string($_POST["ts"]);
$caracteristicas = mysql_real_escape_string($_POST["caracteristicas"]);
$habilidades = mysql_real_escape_string($_POST["habilidades"]);
$vd = mysql_real_escape_string($_POST["vd"]);
$tesoro = mysql_real_escape_string($_POST["tesoro"]);
$tipo = mysql_real_escape_string($_POST["tipo"]);
$especial = mysql_real_escape_string($_POST["especial"]);
$editar_criatura = mysql_real_escape_string($_POST["editar_criatura"]);

if($editar_criatura == 1){
	echo "<h3>Editando Criatura \"$nombre\" ($id)</h3>\n";
	
	editar_criatura($db, $id, $nombre, $dg, $ca, $ca_descripcion, $ataques, $ini, $ts, $caracteristicas, $habilidades, $vd, $tesoro, $especial, $tipo);
	
	
}

$id_criatura = mysql_real_escape_string($_GET["id_criatura"]);

if($id_criatura != NULL && strlen($id_criatura) > 0){
	echo "<h3>Cargando Criatura Base $id_criatura</h3>\n";
	$criatura = get_criatura($db, $id_criatura);
	
	//preparar $especial
#	echo "<h3>Revisando Especial (\"".$criatura["especial"]."\")</h3>\n";
	$arr_especial = explode("<br>", $criatura["especial"]);
	$especial = "";
	for($i=0; $i < count($arr_especial); $i++){
		if(strlen($arr_especial[$i]) > 0){
			$especial .= "<br>".$arr_especial[$i];
			if($especial{strlen($especial)-1} != "\n" ){
				$especial .= "\n";
			}
		}
	}
	$criatura["especial"] = $especial;
	
}

mysql_close($db);

?>


<h1>Editar Criatura</h1>

<?php
	
echo "<div style=\"font-size:24px; font-weight: bold;\"><a href=\"listar_criaturas.php\">Volver a Lista</a></div>\n";
echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";

echo "<form method=\"post\" action=\"editar_criatura.php?id_criatura=$id_criatura\">\n";

echo "<input type=\"hidden\" value=$id_criatura name=\"id\"/>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Nombre:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=nombre size=50 value=\"".$criatura["nombre"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "DG:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=dg size=50 value=\"".$criatura["dg"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "CA:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ca size=50 value=\"".$criatura["ca"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "CA Detalle:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ca_descripcion size=50 value=\"".$criatura["ca_descripcion"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Ataques:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ataques size=50 value=\"".$criatura["ataques"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Iniciativa:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ini size=50 value=\"".$criatura["ini"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "TS:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=ts size=50 value=\"".$criatura["ts"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Caract.:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=caracteristicas size=50 value=\"".$criatura["caracteristicas"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Habilidades:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=habilidades size=50 value=\"".$criatura["habilidades"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "VD:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=vd size=50 value=\"".$criatura["vd"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Tesoro:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=tesoro size=50 value=\"".$criatura["tesoro"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Tipo:\n";
echo "<span style=\"position: absolute; left: 120px;\">\n";
echo "<input type=text name=tipo size=50 value=\"".$criatura["tipo"]."\">\n";
echo "</span>\n";
echo "</div>\n";

echo "<div style=\"margin:auto; height: 30px\">\n";
echo "Habilidades Especiales:\n";
echo "</div>\n";

echo "<div>\n";
echo "<textarea rows=\"5\" cols=\"80\" name=\"especial\">".$criatura["especial"]."</textarea>\n";
echo "</div>\n";

echo "<input type=\"hidden\" value=1 name=\"editar_criatura\"/>\n";

echo "<input type=submit name=accion value=\"Editar\">\n";

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









