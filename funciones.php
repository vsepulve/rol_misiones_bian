<?php

//Crea la mision y retorna el id (o -1 si falla)
function crear_mision($db, $titulo, $contratista, $dificultad, $descripcion){

	$consulta = "insert into mision (titulo, contratista, dificultad, descripcion) values (\"$titulo\", \"$contratista\", \"$dificultad\", \"$descripcion\")";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_mision) Fallo en Insert</h3>");
	$resultado = $db->query($consulta);
	
	$consulta = "select max(id_mision) from mision where titulo = \"$titulo\"";
	$id_mision = -1;
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_mision) Fallo en Select</h3>");
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
#		$id_mision = $fila[0];
#	}
	$resultado = $db->query($consulta);
	if( ($fila = mysqli_fetch_array($resultado)) != NULL ){
		$id_mision = $fila[0];
	}
	
	return $id_mision;
	
}

function get_mision($db, $id_mision){
	global $estado_mision;
	$consulta = "select * from mision where eliminada = 0 and id_mision = \"$id_mision\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_mision) Fallo en Select</h3>");
	$mision = array();
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	if( $fila = $resultado->fetch_assoc() ){
#		$mision["id_mision"] = $fila[0];
#		$mision["titulo"] = $fila[1];
#		$mision["contratista"] = $fila[2];
#		$mision["dificultad"] = $fila[3];
##		$mision["estado"] = $estado_mision[ $fila[4] ];
#		$mision["estado"] = $fila[4];
#		["descripcion"] = $fila[5];
		
		$encuentros = get_encuentros($db, $id_mision);
#		$mision["encuentros"] = $encuentros;
		$fila["encuentros"] = $encuentros;
		
		$mision = $fila;
		
	}
	return $mision;
}

function get_misiones($db){
	global $estado_mision;
	
	//Se pueden agregar filtros por dificultad, por id_mision (solo 1?) o por textos (usando like)
	
	$consulta = "select * from mision where eliminada = 0";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_mision) Fallo en Select</h3>");
	$misiones = array();
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
#		$mision = array();
#		$mision["id_mision"] = $fila[0];
#		$mision["titulo"] = $fila[1];
#		$mision["contratista"] = $fila[2];
#		$mision["dificultad"] = $fila[3];
##		$mision["estado"] = $estado_mision[ $fila[4] ];
#		$mision["estado"] = $fila[4];
#		$mision["descripcion"] = $fila[5];
		
		$encuentros = get_encuentros($db, $mision["id_mision"]);
		$fila["encuentros"] = $encuentros;
#		$mision["encuentros"] = $encuentros;
#		
#		$misiones[] = $mision;
		
		$misiones[] = $fila;
		
	}
	return $misiones;
}

function get_encuentros($db, $id_mision){
	
	$consulta = "select * from encuentro where id_mision = \"$id_mision\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_encuentros) Fallo en Select</h3>");
	$encuentros = array();
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
#		$encuentro = array();
#		$encuentro["id_encuentro"] = $fila[0];
#		$encuentro["nombre"] = $fila[1];
#		$encuentro["notas"] = $fila[2];
#		$encuentro["id_mision"] = $fila[3];
		
#		$criaturas = get_criaturas_encuentro($db, $encuentro["id_encuentro"]);
#		$encuentro["criaturas"] = $criaturas;
		$criaturas = get_criaturas_encuentro($db, $fila["id_encuentro"]);
		$fila["criaturas"] = $criaturas;
		
#		$encuentros[] = $encuentro;
		$encuentros[] = $fila;
		
	}
	return $encuentros;
}

function get_criaturas_encuentro($db, $id_encuentro){
	
	$consulta = "select * from link_encuentro_criatura where id_encuentro = \"$id_encuentro\"";
#	echo "<h3>get_criaturas_encuentro - sql: $consulta</h3>";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_criaturas_encuentro) Fallo en Select</h3>");
	$criaturas = array();
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
#		$id_link = $fila[0];
#		$id_encuentro = $fila[1];
#		$id_criatura = $fila[2];
		$id_criatura = $fila["id_criatura"];
#		echo "<h3>get_criaturas_encuentro - Agregando criatura $id_criatura</h3>";
		
		$criatura = get_criatura($db, $id_criatura);
		$criaturas[] = $criatura;
	}
	
#	echo "<h3>get_criaturas_encuentro - ".count($criaturas)." criaturas</h3>";
	
	return $criaturas;
}


function crear_encuentro($db, $nombre, $notas, $id_mision){

	$consulta = "insert into encuentro (nombre, notas, id_mision) values (\"$nombre\", \"$notas\", \"$id_mision\")";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_encuentro) Fallo en Insert</h3>");
	$resultado = $db->query($consulta);
	
	$consulta = "select max(id_encuentro) from encuentro where nombre = \"$nombre\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_encuentro) Fallo en Select</h3>");
	$id_encuentro = -1;
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
#		$id_encuentro = $fila[0];
#	}
	$resultado = $db->query($consulta);
	if( ($fila = mysqli_fetch_array($resultado)) != NULL ){
		$id_encuentro = $fila[0];
	}
	
	return $id_encuentro;
	
}

function enlazar_encuentro_criatura($db, $id_encuentro, $id_criatura){

	$consulta = "insert into link_encuentro_criatura (id_encuentro, id_criatura) values (\"$id_encuentro\", \"$id_criatura\")";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(enlazar_encuentro_criatura) Fallo en Insert</h3>");
	$resultado = $db->query($consulta);
	
}

function get_criaturas($db, $tipo){
	
#	echo "get_criaturas - inicio (tipo: $tipo)<br>\n";
	
	//Notar que el tipo "especial" no debe ser listado normalmente (pero si cuando se pide especificamente)
	if($tipo == NULL){
		$consulta = "select * from criatura where tipo <> \"especial\" order by tipo, vd, nombre asc";
	}
	else if($tipo == "all"){
		$consulta = "select * from criatura order by tipo, vd, nombre asc";
	}
	else{
		$consulta = "select * from criatura where tipo = \"$tipo\" order by vd, nombre asc";
	}
	
	$criaturas = array();
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_criaturas) Fallo en Select</h3>");
#	while( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	while( $fila = $resultado->fetch_assoc() ){
		
#		echo "get_criaturas - agregando ".$fila[1]."<br>\n";
		
#		$criatura = array();
#		$criatura["id_criatura"] = $fila[0];
#		$criatura["nombre"] = $fila[1];
#		$criatura["dg"] = $fila[2];
#		$criatura["ca"] = $fila[3];
#		$criatura["ca_descripcion"] = $fila[4];
#		$criatura["ataques"] = $fila[5];
#		$criatura["ini"] = $fila[6];
#		$criatura["ts"] = $fila[7];
#		$criatura["caracteristicas"] = $fila[8];
#		$criatura["habilidades"] = $fila[9];
#		$criatura["vd"] = $fila[10];
#		$criatura["tesoro"] = $fila[11];
#		$criatura["especial"] = $fila[12];
#		$criatura["tipo"] = $fila[13];
#		
#		$criaturas[] = $criatura;
		$criaturas[] = $fila;
		
	}
	
#	echo "get_criaturas - fin<br>\n";
	return $criaturas;
	
}

function get_criatura($db, $id_criatura){
	
	$consulta = "select * from criatura where id_criatura = \"$id_criatura\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(get_criatura) Fallo en Select</h3>");
	$criatura = array();
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	if( $fila = $resultado->fetch_assoc() ){
#		$criatura["id_criatura"] = $fila[0];
#		$criatura["nombre"] = $fila[1];
#		$criatura["dg"] = $fila[2];
#		$criatura["ca"] = $fila[3];
#		$criatura["ca_descripcion"] = $fila[4];
#		$criatura["ataques"] = $fila[5];
#		$criatura["ini"] = $fila[6];
#		$criatura["ts"] = $fila[7];
#		$criatura["caracteristicas"] = $fila[8];
#		$criatura["habilidades"] = $fila[9];
#		$criatura["vd"] = $fila[10];
#		$criatura["tesoro"] = $fila[11];
#		$criatura["especial"] = $fila[12];
#		$criatura["tipo"] = $fila[13];
		$criatura = $fila;
	}
	
	return $criatura;
	
}

#function calcular_vd_medio($encuentro){
#	$criaturas = $encuentro["criaturas"];
##	echo "<h3>calcular_vd_medio: ".count($criaturas)." criaturas</h3>";
#	if( count($criaturas) < 1 ){
#		return 0;
#	}
#	$vd = 0;
#	foreach($criaturas as $criatura){
#		$vd += $criatura["vd"];
#	}
#	$vd /= count($criaturas);
#	return number_format($vd, 2);
#}

function calcular_vd_suma($criaturas){
	$vd = 0;
	foreach($criaturas as $criatura){
		$vd += $criatura["vd"];
	}
	return $vd;
}

# Evitara crear una criatura con un nombre ya usado
function crear_criatura($db, $nombre, $dg, $ca, $ca_descripcion, $ataques, $ini, $ts, $caracteristicas, $habilidades, $vd, $tesoro, $especial, $tipo){
	
	//Verificacion
	$consulta = "select * from criatura where nombre = \"$nombre\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_criatura) Fallo en Select de verificacion</h3>");
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	if( $fila = $resultado->fetch_assoc() ){
		$id_criatura = $fila["id_criatura"];
		$nombre = $fila["nombre"];
		$tipo = $fila["tipo"];
		$vd = $fila["vd"];
		echo "<h3>Ya existe una criatura con ese nombre: $nombre ($tipo, VD $vd)</h3>";
		return -1;
	}
	
	$consulta = "insert into criatura (nombre, dg, ca, ca_descripcion, ataques, ini, ts, caracteristicas, habilidades, vd, tesoro, especial, tipo) values (\"$nombre\", \"$dg\", \"$ca\", \"$ca_descripcion\", \"$ataques\", \"$ini\", \"$ts\", \"$caracteristicas\", \"$habilidades\", \"$vd\", \"$tesoro\", \"$especial\", \"$tipo\")";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_criatura) Fallo en Insert</h3>");
	$resultado = $db->query($consulta);
	
	$consulta = "select max(id_criatura) from criatura where nombre = \"$nombre\"";
	$id_criatura = -1;
#	$resultado = mysql_query($consulta, $db) or die("<h3>(crear_criatura) Fallo en Select</h3>");
#	if( ($fila = mysql_fetch_row($resultado)) != NULL ){
	$resultado = $db->query($consulta);
	if( ($fila = mysqli_fetch_array($resultado)) != NULL ){
		$id_criatura = $fila[0];
	}
	
	return $id_criatura;
	
}

function editar_criatura($db, $id, $nombre, $dg, $ca, $ca_descripcion, $ataques, $ini, $ts, $caracteristicas, $habilidades, $vd, $tesoro, $especial, $tipo){
	$consulta = "update criatura set nombre = \"$nombre\", dg = \"$dg\", ca = \"$ca\", ca_descripcion = \"$ca_descripcion\", ataques = \"$ataques\", ini = \"$ini\", ts = \"$ts\", caracteristicas = \"$caracteristicas\", habilidades = \"$habilidades\", vd = \"$vd\", tesoro = \"$tesoro\", especial = \"$especial\", tipo = \"$tipo\" where id_criatura = $id";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(editar_criatura) Fallo en Update</h3>");
	$resultado = $db->query($consulta);
}

function eliminar_encuentro($db, $id_encuentro){
	$consulta = "delete from encuentro where id_encuentro = \"$id_encuentro\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(eliminar_encuentro) Fallo en Delete</h3>");
	$resultado = $db->query($consulta);
}

function editar_mision($db, $id_mision, $titulo, $contratista, $dificultad, $estado, $descripcion){
	$consulta = "update mision set titulo = \"$titulo\", contratista = \"$contratista\", dificultad = \"$dificultad\", estado = \"$estado\", descripcion = \"$descripcion\" where id_mision = $id_mision";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(editar_mision) Fallo en Update</h3>");
	$resultado = $db->query($consulta);
}

function eliminar_mision_dummy($db, $id_mision){
	$consulta = "update mision set eliminada = 1 where id_mision = \"$id_mision\"";
#	$resultado = mysql_query($consulta, $db) or die("<h3>(eliminar_mision_dummy) Fallo en Update</h3>");
	$resultado = $db->query($consulta);
}

function crear_clase($clase, $nivel){

#	$criatura["id_criatura"] = $fila[0];
#	$criatura["nombre"] = $fila[1];
#	$criatura["dg"] = $fila[2];
#	$criatura["ca"] = $fila[3];
#	$criatura["ca_descripcion"] = $fila[4];
#	$criatura["ataques"] = $fila[5];
#	$criatura["ini"] = $fila[6];
#	$criatura["ts"] = $fila[7];
#	$criatura["caracteristicas"] = $fila[8];
#	$criatura["habilidades"] = $fila[9];
#	$criatura["vd"] = $fila[10];
#	$criatura["tesoro"] = $fila[11];
#	$criatura["especial"] = $fila[12];
#	$criatura["tipo"] = $fila[13];

	global $bono;
	global $ts_pri;
	global $ts_sec;
	global $ts_ter;
		
	$criatura = array();
	$criatura["id_criatura"] = 0;
	
		//fue: 14-20, des: 12-18, con: 14-18, int: 10-12, sab: 10-12, car: 8-12 (68-92)
		//fue: 12-16, des: 10-14, con: 12-16, int: 10-14, sab: 16-20, car: 10-14 (70-94)
		//fue: 12-14, des: 16-20, con: 12-14, int: 12-16, sab: 8-12, car: 10-14 (70-90)
		//fue: 8-12, des: 12-16, con: 10-12, int: 16-20, sab: 10-14, car: 12-14 (68-88)
		
	if($clase == 1){
		//fue: 14-20, des: 12-18, con: 14-18, int: 10-12, sab: 10-12, car: 8-12 (68-92)
		$fue = 14+round( 6*$nivel/20 );
		$des = 12+round( 6*$nivel/20 );
		$con = 14+round( 4*$nivel/20 );
		$int = 10+round( 2*$nivel/20 );
		$sab = 10+round( 2*$nivel/20 );
		$car = 8+round( 4*$nivel/20 );
		
		$criatura["nombre"] = "Luchador n$nivel";
		$criatura["dg"] = $nivel."d10+".($nivel*$bono[$con])." (".round(10+$bono[$con]+(5.5+$bono[$con])*($nivel-1) )." pg)";
		
		$criatura["ca"] = 10+$bono[$des];
		$criatura["ca_descripcion"] = "$bono[$des] Des";
		
		$criatura["ataques"] = "Arma (";
		$ataque = $nivel;
		while($ataque > 5){
			$criatura["ataques"] .= "+$ataque/";
			$ataque -= 5;
		}
		$criatura["ataques"] .= "+$ataque, Daño + ".round($bono[$fue]).")";
		
		$criatura["ini"] = $bono[$des];
		
		$criatura["ts"] = "Dur ".($ts_pri[$nivel]+$bono[$con]).", Ref ".($ts_sec[$nivel]+$bono[$des]).", Men ".($ts_ter[$nivel]+$bono[$int]).", Esp ".($ts_sec[$nivel]+$bono[$sab])."";
		
		$criatura["caracteristicas"] = "Fue $fue ($bono[$fue]), Des $des ($bono[$des]), Con $con ($bono[$con]), Int $int ($bono[$int]), Sab $sab ($bono[$sab]), Car $car ($bono[$car])";
		$criatura["habilidades"] = "";
		
		if($nivel == 1){
			$criatura["vd"] = 0.3;
		}
		else if($nivel == 2){
			$criatura["vd"] = 0.5;
		}
		else{
			$criatura["vd"] = $nivel-2;
		}
		
		if($nivel < 6){
			$criatura["tesoro"] = "Personal Pequeño";
		}
		else if($nivel < 11){
			$criatura["tesoro"] = "Personal Mediano";
		}
		else{
			$criatura["tesoro"] = "Personal Grande";
		}
		
		$criatura["especial"] = "";
		$criatura["especial"] .= "<br>".floor(1+$nivel/3)." Dotes\n";
		$criatura["especial"] .= "<br>".floor(1+$nivel/2)." Dotes de Luchador\n";
		
		$criatura["tipo"] = "especial";
	}
	
	else if($clase == 2){
		//fue: 12-16, des: 10-14, con: 12-16, int: 10-14, sab: 16-20, car: 10-14 (70-94)
		
		$fue = 12+round( 4*$nivel/20 );
		$des = 10+round( 4*$nivel/20 );
		$con = 12+round( 4*$nivel/20 );
		$int = 10+round( 4*$nivel/20 );
		$sab = 16+round( 4*$nivel/20 );
		$car = 10+round( 4*$nivel/20 );
		
		$criatura["nombre"] = "Sacerdote n$nivel";
		$criatura["dg"] = $nivel."d8+".($nivel*$bono[$con])." (".round(8+$bono[$con]+(4.5+$bono[$con])*($nivel-1) )." pg)";
		
		$criatura["ca"] = 10+$bono[$des];
		$criatura["ca_descripcion"] = "";
		if($bono[$des] != 0){
			$criatura["ca_descripcion"] .= "$bono[$des] Des";
		}
		
		$criatura["ataques"] = "Arma (";
		$ataque = round($nivel*0.75-0.5);
		while($ataque > 5){
			$criatura["ataques"] .= "+$ataque/";
			$ataque -= 5;
		}
		$criatura["ataques"] .= "+$ataque, Daño + ".round($bono[$fue]).")";
		
		$criatura["ini"] = $bono[$des];
		
		$criatura["ts"] = "Dur ".($ts_sec[$nivel]+$bono[$con]).", Ref ".($ts_ter[$nivel]+$bono[$des]).", Men ".($ts_sec[$nivel]+$bono[$int]).", Esp ".($ts_pri[$nivel]+$bono[$sab])."";
		
		$criatura["caracteristicas"] = "Fue $fue ($bono[$fue]), Des $des ($bono[$des]), Con $con ($bono[$con]), Int $int ($bono[$int]), Sab $sab ($bono[$sab]), Car $car ($bono[$car])";
		$criatura["habilidades"] = "";
		
		if($nivel == 1){
			$criatura["vd"] = 0.3;
		}
		else if($nivel == 2){
			$criatura["vd"] = 0.5;
		}
		else{
			$criatura["vd"] = $nivel-2;
		}
		
		if($nivel < 6){
			$criatura["tesoro"] = "Personal Pequeño";
		}
		else if($nivel < 11){
			$criatura["tesoro"] = "Personal Mediano";
		}
		else{
			$criatura["tesoro"] = "Personal Grande";
		}
		
		$criatura["especial"] = "";
		$criatura["especial"] .= "<br>".floor(1+$nivel/3)." Dotes\n";
		$criatura["especial"] .= "<br>Magia Sagrada (".get_texto_magia(2, $nivel, $bono[$sab]).")\n";
		
		$criatura["tipo"] = "especial";
	}
	
	else if($clase == 3){
		//fue: 12-14, des: 16-20, con: 12-14, int: 12-16, sab: 8-12, car: 10-14 (70-90)
		
		$fue = 12+round( 2*$nivel/20 );
		$des = 16+round( 4*$nivel/20 );
		$con = 12+round( 2*$nivel/20 );
		$int = 12+round( 4*$nivel/20 );
		$sab = 8+round( 4*$nivel/20 );
		$car = 10+round( 4*$nivel/20 );
		
		$criatura["nombre"] = "Bribón n$nivel";
		$criatura["dg"] = $nivel."d6+".($nivel*$bono[$con])." (".round(6+$bono[$con]+(3.5+$bono[$con])*($nivel-1) )." pg)";
		
		$criatura["ca"] = 10+$bono[$des];
		$criatura["ca_descripcion"] = "";
		if($bono[$des] != 0){
			$criatura["ca_descripcion"] .= "$bono[$des] Des";
		}
		
		$criatura["ataques"] = "Arma (";
		$ataque = round($nivel*0.75-0.5);
		while($ataque > 5){
			$criatura["ataques"] .= "+$ataque/";
			$ataque -= 5;
		}
		$criatura["ataques"] .= "+$ataque, Daño + ".round($bono[$fue]).")";
		
		$criatura["ini"] = $bono[$des];
		
		$criatura["ts"] = "Dur ".($ts_sec[$nivel]+$bono[$con]).", Ref ".($ts_ter[$nivel]+$bono[$des]).", Men ".($ts_sec[$nivel]+$bono[$int]).", Esp ".($ts_pri[$nivel]+$bono[$sab])."";
		
		$criatura["caracteristicas"] = "Fue $fue ($bono[$fue]), Des $des ($bono[$des]), Con $con ($bono[$con]), Int $int ($bono[$int]), Sab $sab ($bono[$sab]), Car $car ($bono[$car])";
		$criatura["habilidades"] = "";
		
		if($nivel == 1){
			$criatura["vd"] = 0.3;
		}
		else if($nivel == 2){
			$criatura["vd"] = 0.5;
		}
		else{
			$criatura["vd"] = $nivel-2;
		}
		
		if($nivel < 6){
			$criatura["tesoro"] = "Personal Pequeño";
		}
		else if($nivel < 11){
			$criatura["tesoro"] = "Personal Mediano";
		}
		else{
			$criatura["tesoro"] = "Personal Grande";
		}
		
		$criatura["especial"] = "";
		$criatura["especial"] .= "<br>".floor(1+$nivel/3)." Dotes\n";
		
		$criatura["tipo"] = "especial";
	}
	
	else if($clase == 4){
		//fue: 8-12, des: 12-16, con: 10-12, int: 16-20, sab: 10-14, car: 12-14 (68-88)
		
		$fue = 8+round( 4*$nivel/20 );
		$des = 12+round( 4*$nivel/20 );
		$con = 10+round( 2*$nivel/20 );
		$int = 16+round( 4*$nivel/20 );
		$sab = 10+round( 4*$nivel/20 );
		$car = 12+round( 2*$nivel/20 );
		
		$criatura["nombre"] = "Hechicero n$nivel";
		$criatura["dg"] = $nivel."d4+".($nivel*$bono[$con])." (".round(4+$bono[$con]+(2.5+$bono[$con])*($nivel-1) )." pg)";
		
		$criatura["ca"] = 10+$bono[$des];
		$criatura["ca_descripcion"] = "";
		if($bono[$des] != 0){
			$criatura["ca_descripcion"] .= "$bono[$des] Des";
		}
		
		$criatura["ataques"] = "Arma (";
		$ataque = round($nivel*0.5-0.5);
		while($ataque > 5){
			$criatura["ataques"] .= "+$ataque/";
			$ataque -= 5;
		}
		$criatura["ataques"] .= "+$ataque, Daño + ".round($bono[$fue]).")";
		
		$criatura["ini"] = $bono[$des];
		
		$criatura["ts"] = "Dur ".($ts_ter[$nivel]+$bono[$con]).", Ref ".($ts_sec[$nivel]+$bono[$des]).", Men ".($ts_pri[$nivel]+$bono[$int]).", Esp ".($ts_sec[$nivel]+$bono[$sab])."";
		
		$criatura["caracteristicas"] = "Fue $fue ($bono[$fue]), Des $des ($bono[$des]), Con $con ($bono[$con]), Int $int ($bono[$int]), Sab $sab ($bono[$sab]), Car $car ($bono[$car])";
		$criatura["habilidades"] = "";
		
		if($nivel == 1){
			$criatura["vd"] = 0.3;
		}
		else if($nivel == 2){
			$criatura["vd"] = 0.5;
		}
		else{
			$criatura["vd"] = $nivel-2;
		}
		
		if($nivel < 6){
			$criatura["tesoro"] = "Personal Pequeño";
		}
		else if($nivel < 11){
			$criatura["tesoro"] = "Personal Mediano";
		}
		else{
			$criatura["tesoro"] = "Personal Grande";
		}
		
		$criatura["especial"] = "";
		$criatura["especial"] .= "<br>".floor(1+$nivel/3)." Dotes\n";
		$criatura["especial"] .= "<br>Magia Arcana (".get_texto_magia(1, $nivel, $bono[$int]).")\n";
		
		$criatura["tipo"] = "especial";
	}
	
	
	return $criatura;
}

function get_texto_magia($tipo, $nivel, $bono){
	echo "<h3>magia ($tipo, $nivel, $bono)</h3>\n";
	if($tipo == 1){
		switch($nivel){
			case 1: return "".round($bono*$nivel+10)." PM, ".round($bono)."/".round($bono-2);
			case 2: return "".round($bono*$nivel+10+3.5*1)." PM, ".round($bono+1)."/".round($bono);
			case 3: return "".round($bono*$nivel+10+3.5*2)." PM, ".round($bono+1)."/".round($bono+1)."/".round($bono-2);
			case 4: return "".round($bono*$nivel+10+3.5*3)." PM, ".round($bono+3)."/".round($bono+2)."/".round($bono);
			case 5: return "".round($bono*$nivel+10+3.5*4)." PM, ".round($bono+4)."/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 6: return "".round($bono*$nivel+10+3.5*5+4)." PM, A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 7: return "".round($bono*$nivel+10+3.5*6+10)." PM, A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 8: return "".round($bono*$nivel+10+3.5*7+18)." PM, A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 9: return "".round($bono*$nivel+10+3.5*8+28)." PM, A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 10: return "".round($bono*$nivel+10+3.5*9+41)." PM, A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 11: return "".round($bono*$nivel+10+3.5*11+49)." PM, A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 12: return "".round($bono*$nivel+10+3.5*13+59)." PM, A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 13: return "".round($bono*$nivel+10+3.5*15+72)." PM, A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 14: return "".round($bono*$nivel+10+3.5*17+87)." PM, A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 15: return "".round($bono*$nivel+10+3.5*19+94)." PM, A/A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 16: return "".round($bono*$nivel+10+3.5*22+107)." PM, A/A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 17: return "".round($bono*$nivel+10+3.5*25+122)." PM, A/A/A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 18: return "".round($bono*$nivel+10+3.5*28+139)." PM, A/A/A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 19: return "".round($bono*$nivel+10+3.5*31+158)." PM, A/A/A/A/A/A/A/A/".round($bono+3)."/".round($bono+1);
			case 20: return "".round($bono*$nivel+10+3.5*34+180)." PM, A/A/A/A/A/A/A/A/".round($bono+4)."/".round($bono+2);
			
		}
		
	}
	else if($tipo == 2){
		switch($nivel){
			case 1: return "".round($bono*$nivel+8)." PM, ".round($bono)."/".round($bono-2);
			case 2: return "".round($bono*$nivel+8+3.5*1)." PM, ".round($bono+1)."/".round($bono);
			case 3: return "".round($bono*$nivel+8+3.5*2)." PM, ".round($bono+2)."/".round($bono+1)."/".round($bono-2);
			case 4: return "".round($bono*$nivel+8+3.5*3)." PM, ".round($bono+3)."/".round($bono+2)."/".round($bono);
			case 5: return "".round($bono*$nivel+8+3.5*4)." PM, ".round($bono+4)."/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 6: return "".round($bono*$nivel+8+3.5*5+2)." PM, A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 7: return "".round($bono*$nivel+8+3.5*6+6)." PM, A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 8: return "".round($bono*$nivel+8+3.5*7+12)." PM, A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 9: return "".round($bono*$nivel+8+3.5*8+20)." PM, A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 10: return "".round($bono*$nivel+8+3.5*9+30)." PM, A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 11: return "".round($bono*$nivel+8+3.5*11+34)." PM, A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 12: return "".round($bono*$nivel+8+3.5*13+40)." PM, A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 13: return "".round($bono*$nivel+8+3.5*15+48)." PM, A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 14: return "".round($bono*$nivel+8+3.5*17+58)." PM, A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 15: return "".round($bono*$nivel+8+3.5*19+70)." PM, A/A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 16: return "".round($bono*$nivel+8+3.5*22+76)." PM, A/A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 17: return "".round($bono*$nivel+8+3.5*25+84)." PM, A/A/A/A/A/A/A/".round($bono+3)."/".round($bono+1)."/".round($bono-2);
			case 18: return "".round($bono*$nivel+8+3.5*28+94)." PM, A/A/A/A/A/A/A/".round($bono+4)."/".round($bono+2)."/".round($bono);
			case 19: return "".round($bono*$nivel+8+3.5*31+106)." PM, A/A/A/A/A/A/A/A/".round($bono+3)."/".round($bono+1);
			case 20: return "".round($bono*$nivel+8+3.5*34+120)." PM, A/A/A/A/A/A/A/A/".round($bono+4)."/".round($bono+2);
		
		}
	}
}


?>





