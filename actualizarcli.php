<?php 
require_once 'manipularcli.php';

$vcodigo = "";
$vnombre = "";
$vdireccion = "";
$vtelresi = "";
$vtelcel = "";
$vemail = "";

function filtrofares($dat_fares)
{
    $datos = trim($dat_fares);
    $datos = stripslashes($dat_fares);
    $datos = htmlspecialchars($dat_fares);
    return $datos;
}

if (isset($_POST["cactualizar"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
if (!empty($_POST["ccodigo"])) {

$vcodigo = filtrofares($_POST["ccodigo"]);
}
if (!empty($_POST["cnomcliente"])) {
$vnombre = filtrofares($_POST["cnomcliente"]);
}
if (!empty($_POST["cdireccion"])) {
$vdireccion = filtrofares($_POST["cdireccion"]);
}
if (!empty($_POST["ctelcasa"])) {
$vtelresi = filtrofares($_POST["ctelcasa"]);
}
if (!empty($_POST["ccelular"])) {
$vtelcel = filtrofares($_POST["ccelular"]);
}
if (!empty($_POST["cemail"])) {
$vemail = filtrofares($_POST["cemail"]);
}

$guardarcliente = new modificarcliente($vcodigo, $vnombre, $vdireccion,
$vtelresi, $vtelcel, $vemail);
$guardarcliente->actualizar();
}
header('Location: frmcliente.php');
die();