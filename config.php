<?php

$user = "lobo";
$pass = "alhazred";
$host = "localhost";
$database = "Rol";
#$db = mysql_connect($host, $user, $pass) or die ("No se puede conectar al servidor");
#mysql_select_db($database, $db) or die ("La base de datos no puede ser seleccionada");
$mysqli = new mysqli($host, $user, $pass, $database);


$estado_mision[0] = "<font style=\"color:blue;font-weight:bold;\">Disponible</font>";
$estado_mision[1] = "<font style=\"color:yellow;font-weight:bold;\">Ofrecida</font>";
$estado_mision[2] = "<font style=\"color:green;font-weight:bold;\">Cumplida</font>";
$estado_mision[3] = "<font style=\"color:red;font-weight:bold;\">Expirada</font>";

$bono[0] = 0;
$bono[1] = -3;
$bono[2] = -3;
$bono[3] = -3;
$bono[4] = -3;
$bono[5] = -3;
$bono[6] = -2;
$bono[7] = -2;
$bono[8] = -1;
$bono[9] = -1;
$bono[10] = 0;
$bono[11] = 0;
$bono[12] = "+1";
$bono[13] = "+1";
$bono[14] = "+2";
$bono[15] = "+2";
$bono[16] = "+3";
$bono[17] = "+3";
$bono[18] = "+4";
$bono[19] = "+4";
$bono[20] = "+5";
$bono[21] = "+5";
$bono[22] = "+6";
$bono[23] = "+6";
$bono[24] = "+7";
$bono[25] = "+7";
$bono[26] = "+8";
$bono[27] = "+8";
$bono[28] = "+9";
$bono[29] = "+9";
$bono[30] = "+10";
$bono[31] = "+10";
$bono[32] = "+11";
$bono[33] = "+11";
$bono[34] = "+12";
$bono[35] = "+12";
$bono[36] = "+13";
$bono[37] = "+13";
$bono[38] = "+14";
$bono[39] = "+14";
$bono[40] = "+15";

$ts_pri[0] = "+1";
$ts_pri[1] = "+2";
$ts_pri[2] = "+3";
$ts_pri[3] = "+3";
$ts_pri[4] = "+4";
$ts_pri[5] = "+5";
$ts_pri[6] = "+6";
$ts_pri[7] = "+6";
$ts_pri[8] = "+7";
$ts_pri[9] = "+8";
$ts_pri[10] = "+9";
$ts_pri[11] = "+9";
$ts_pri[12] = "+10";
$ts_pri[13] = "+11";
$ts_pri[14] = "+12";
$ts_pri[15] = "+12";
$ts_pri[16] = "+13";
$ts_pri[17] = "+14";
$ts_pri[18] = "+15";
$ts_pri[19] = "+15";
$ts_pri[20] = "+16";

$ts_sec[0] = "+0";
$ts_sec[1] = "+1";
$ts_sec[2] = "+2";
$ts_sec[3] = "+2";
$ts_sec[4] = "+3";
$ts_sec[5] = "+3";
$ts_sec[6] = "+4";
$ts_sec[7] = "+4";
$ts_sec[8] = "+5";
$ts_sec[9] = "+6";
$ts_sec[10] = "+6";
$ts_sec[11] = "+7";
$ts_sec[12] = "+7";
$ts_sec[13] = "+8";
$ts_sec[14] = "+9";
$ts_sec[15] = "+9";
$ts_sec[16] = "+10";
$ts_sec[17] = "+10";
$ts_sec[18] = "+11";
$ts_sec[19] = "+11";
$ts_sec[20] = "+12";

$ts_ter[0] = "+0";
$ts_ter[1] = "+0";
$ts_ter[2] = "+0";
$ts_ter[3] = "+1";
$ts_ter[4] = "+1";
$ts_ter[5] = "+2";
$ts_ter[6] = "+2";
$ts_ter[7] = "+3";
$ts_ter[8] = "+3";
$ts_ter[9] = "+3";
$ts_ter[10] = "+4";
$ts_ter[11] = "+4";
$ts_ter[12] = "+5";
$ts_ter[13] = "+5";
$ts_ter[14] = "+5";
$ts_ter[15] = "+6";
$ts_ter[16] = "+6";
$ts_ter[17] = "+7";
$ts_ter[18] = "+7";
$ts_ter[19] = "+8";
$ts_ter[20] = "+8";














?>
