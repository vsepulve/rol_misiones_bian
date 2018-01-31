
<?php

require_once("config.php");
require_once("funciones.php");


#$lector = fopen("nombres.txt", "r");
#while (($linea = fgets($lector)) != false) {
#	$nombre = trim($linea);
#	echo "\"$nombre\"\n";
#	
#	$consulta = "insert into nombre (texto, cultura) values (\"$nombre\", \"hualkir\")";
#	$resultado = mysql_query($consulta, $db);
#	
#}

// 39 criaturas con 13 lineas cada una :
#	Nombre: Ogro
#	DG: 4d8+16 (34 PG)
#	CA: 16
#	-1 tamaño, -1 destreza, +5 natural, +3 armadura de piel
#	Ataques: Gran Garrote (+7, 2d6+5) o Javalina (+1, 1d6+5)
#	Iniciativa: -1
#	TS: Dur +5, Ref +1, Men -2, Esp +2
#	Características: Fue 21 (+5), Des 8 (-1), Con 15 (+2), Int 6 (-1), Sab 10 (+0), Car 7 (-1).
#	VD: 2
#	Tesoro: Personal Pequeño
#	Especial: Dureza
#   Tipo
#   //linea vacia

#$lector = fopen("criaturas.txt", "r");

#for($i=0; $i<39; $i++){
#	$nombre = trim(fgets($lector));
#	$dg = trim(fgets($lector));
#	$ca = trim(fgets($lector));
#	$ca_descripcion = trim(fgets($lector));
#	$ataques = trim(fgets($lector));
#	$ini = trim(fgets($lector));
#	$ts = trim(fgets($lector));
#	$caracteristicas = trim(fgets($lector));
#	$vd = trim(fgets($lector));
#	$tesoro = trim(fgets($lector));
#	$especial = trim(fgets($lector));
#	$tipo = trim(fgets($lector));
#	fgets($lector);
#	echo "Ingresando criatura $nombre ($tipo)<br>\n";
#	crear_criatura($db, $nombre, $dg, $ca, $ca_descripcion, $ataques, $ini, $ts, $caracteristicas, $vd, $tesoro, $especial, $tipo);
#}


mysql_close($db);

















?>
