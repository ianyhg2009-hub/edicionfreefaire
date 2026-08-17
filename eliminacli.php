<?php
require_once 'manipularcli.php';
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$Clientes = new modificarcliente($id, null, null, null, null, null);
$Clientes->eliminarcliente();
header('Location: frmcliente.php');
die();