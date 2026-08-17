<?php
require_once 'fclases.php';
$persona = new datospersona('0301200901786', 'Helen', 'Bo. San Sebastian');
echo $persona->get_codigo() . "<br>";
echo $persona->get_nombre() . "<br>";
echo $persona->get_direccion();