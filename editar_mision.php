
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Edicion de Mision</title>
</head>

<body>

<?php

require_once("config.php");
require_once("funciones.php");

$min_criaturas = 15;

$id_mision = mysql_real_escape_string($_GET["id_mision"]);
if( !ctype_digit($id_mision) ){
	$id_mision = 0;
}

$n_criaturas = mysql_real_escape_string($_GET["n_criaturas"]);
if( !ctype_digit($n_criaturas) ){
	$n_criaturas = 0;
}
if($n_criaturas < $min_criaturas){
	$n_criaturas = $min_criaturas;
}

$editar_mision = mysql_real_escape_string($_POST["editar_mision"]);
if($editar_mision == 1){
	echo "<h3>Editando Mision $id_mision</h3>";
	$titulo = mysql_real_escape_string($_POST["titulo"]);
	$contratista = mysql_real_escape_string($_POST["contratista"]);
	$dificultad = mysql_real_escape_string($_POST["dificultad"]);
	$estado = mysql_real_escape_string($_POST["estado"]);
	$descripcion = mysql_real_escape_string($_POST["descripcion"]);
	if(strlen($titulo) > 0 && strlen($contratista) > 0 
		&& strlen($dificultad) > 0 && strlen($descripcion) > 0 ){
		echo "<h3>Editando...</h3>";
		editar_mision($db, $id_mision, $titulo, $contratista, $dificultad, $estado, $descripcion);
	}
}

$eliminar_encuentro = mysql_real_escape_string($_GET["eliminar_encuentro"]);
if( !ctype_digit($eliminar_encuentro) ){
	$eliminar_encuentro = 0;
}
if($eliminar_encuentro > 0){
	echo "<h3>Elimnando encuentro $eliminar_encuentro</h3>";
	eliminar_encuentro($db, $eliminar_encuentro);
}

//Tomar informacion del encuentro para ingresarlo

$crear_encuentro = mysql_real_escape_string($_POST["crear_encuentro"]);
#echo "<h3>crear_encuentro: $crear_encuentro</h3>\n";
if($crear_encuentro == 1){
	$nombre = mysql_real_escape_string($_POST["nombre"]);
	$notas = mysql_real_escape_string($_POST["notas"]);
	$id_encuentro = crear_encuentro($db, $nombre, $notas, $id_mision);
	if($id_encuentro > 0){
		//Tomar cada criatura para asociarla al encuentro
		for($i = 0; $i < $n_criaturas; $i++){
			$id_criatura = mysql_real_escape_string($_POST["select_criatura_$i"]);
#			echo "<h3>Agragando criatura id $id_criatura</h3>\n";
			if($id_criatura > 0){
				enlazar_encuentro_criatura($db, $id_encuentro, $id_criatura);
			}
		}//for... cada criatura
	}//if... encuentro valido
}

$mision = get_mision($db, $id_mision);

#$criaturas = get_criaturas($db, NULL);
$criaturas = get_criaturas($db, "all");

mysql_close($db);

?>

<h1>Edición de Mision</h1>


<?php
	
	echo "<div style=\"font-size:24px; font-weight: bold;\"><a href=\"listar_misiones.php\">Volver a Lista</a></div>\n";
	echo "<div style=\"height: 15px;\">&nbsp;</div><hr>\n";
	
	echo "<form method=\"post\" action=\"editar_mision.php?id_mision=".$id_mision."\">\n";
	echo "<input type=\"hidden\" value=1 name=\"editar_mision\" />\n";
	
	echo "<div>\n";
		
	echo "<div style=\"font-size:22px; font-weight: bold;\">\n";
	echo $mision["titulo"];
#	echo "&nbsp;&nbsp;&nbsp;(<a href=?id_mision=$id_mision>Eliminar</a>)";
	echo "</div>\n";
	
	echo "<div style=\"height: 15px;\">&nbsp;</div>\n";
#	
#	echo "<div> Contratista: \n";
#	echo "<span style=\"font-style: italic;\">".$mision["contratista"]."</span>\n";
#	echo "</div>\n";

#	echo "<div> Dificultad: \n";
#	echo "<span style=\"font-style: italic;\">".$mision["dificultad"]."</span>\n";
#	echo "</div>\n";

#	echo "<div style=\"margin: 0 auto; width:90%;\">\n";
#	echo $mision["descripcion"];
#	echo "</div>\n";
	
	echo "<div style=\"margin:auto; height: 30px\">\n";
	echo "Titulo:\n";
	echo "<span style=\"position: absolute; left: 120px;\">\n";
	echo "<input type=text name=titulo size=40 value=\"".$mision["titulo"]."\">\n";
	echo "</span>\n";
	echo "</div>\n";

	echo "<div style=\"margin:auto; height: 30px\">\n";
	echo "Contratista:\n";
	echo "<span style=\"position: absolute; left: 120px\">\n";
	echo "<input type=text name=contratista size=40 value=\"".$mision["contratista"]."\">\n";
	echo "</span>\n";
	echo "</div>\n";

	echo "<div style=\"margin:auto; height: 30px\">\n";
	echo "Dificultad:\n";
	echo "<span style=\"position: absolute; left: 120px\">\n";
	echo "<input type=text name=dificultad size=40 value=\"".$mision["dificultad"]."\">\n";
	echo "</span>\n";
	echo "</div>\n";

	echo "<div style=\"margin:auto; height: 30px\">\n";
	echo "Estado:\n";
	echo "<span style=\"position: absolute; left: 120px\">\n";
	
	echo "<select name=estado >\n";
	echo "<option value = 0 ".(($mision["estado"]==0)?"selected":"")." >Disponible</option>\n";
	echo "<option value = 1 ".(($mision["estado"]==1)?"selected":"").">Ofrecida</option>\n";
	echo "<option value = 2 ".(($mision["estado"]==2)?"selected":"").">Cumplida</option>\n";
	echo "<option value = 3 ".(($mision["estado"]==3)?"selected":"").">Expirada</option>\n";
	echo "</select>\n";

	echo "</span>\n";
	
	echo "<span style=\"font-style: italic;position: absolute; left: 220px\">".$estado_mision[$mision["estado"]]."</span>\n";
	
	echo "</div>\n";




	echo "<div>\n";
	echo "<textarea rows=\"10\" cols=\"80\" name=\"descripcion\">".$mision["descripcion"]."</textarea>\n";
	echo "</div>\n";


	
	echo "<div style=\"height: 15px;\">&nbsp;</div>\n";
	echo "<input type=submit name=accion value=\"Editar Mision\">\n";
	
	$encuentros = $mision["encuentros"];
	
	foreach($encuentros as $encuentro){
		echo "<div style=\"height: 15px;\">&nbsp;</div>\n";
		echo "<div style=\"font-size:18px; font-weight: bold;\">\n";
		echo $encuentro["nombre"];
		echo "&nbsp;&nbsp;&nbsp;(<a href=\"editar_mision.php?id_mision=$id_mision&eliminar_encuentro=".$encuentro["id_encuentro"]."\">Eliminar</a>)\n";
		
		foreach($encuentro["criaturas"] as $criatura){
			echo "<div style=\"margin: 0 auto; width:95%; font-size:14px\">\n";
			echo $criatura["nombre"]." [VD ".$criatura["vd"]."]\n";
			echo "</div>\n";
		}
		
		echo "</div>\n";
		
	}

	echo "<div style=\"height: 15px;\">&nbsp;</div><hr><div style=\"height: 15px;\">&nbsp;</div>\n";

	echo "</div>\n";

?>

</form>


<?php
	echo "<form method=\"post\" action=\"editar_mision.php?id_mision=$id_mision&n_criaturas=$n_criaturas\">\n";
?>

<div style="margin:auto; height: 30px">
Nombre:
<span style="position: absolute; left: 120px;">
<input type=text name=nombre size=40 value="">
</span>
</div>

<div>
<textarea rows="5" cols="80" name="notas">Notas</textarea> 
</div>

<input type="hidden" value=1 name="crear_encuentro" />

<input type=submit name=accion value="Agregar Encuentro">

<div style="height: 30px">&nbsp;</div>


<?php

for($i = 0; $i < $n_criaturas; $i++){

	echo "<div>\n";
	echo "<span style = \"float: left; width: 150px;\">Criatura ".(1+$i)."</span>\n";
	echo "<select name = \"select_criatura_$i\" >\n";
	echo "<option value = 0> -- Seleccionar Criatura -- </option>\n";
#	echo "<option value = 1> lalalalalalalalalalallalalalaalal </option>\n";
#	echo "<option value = 2> Opel </option>\n";
#	echo "<option value = 3> Audi </option>\n";

	foreach($criaturas as $criatura){
		echo "<option value = ".$criatura["id_criatura"].">";
#		echo "[VD ".$criatura["vd"]."] - ".$criatura["nombre"]." [".$criatura["tipo"]."]";
		echo "[".$criatura["tipo"]." - VD ".$criatura["vd"]."] - ".$criatura["nombre"];
		echo "</option>\n";
	}
	
	echo "</select>\n";
	echo "</div>\n";

}


?>

<div style="height: 60px">&nbsp;</div>

</form>

</body>















</html>









