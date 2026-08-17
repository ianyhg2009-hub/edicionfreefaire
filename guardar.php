<?php
require 'conexionf.php';

$v_ccodigo = "";
$v_nproducto = "";
$v_costop = "";
$v_porcentajev = "";
$v_pventa = "";
$v_fecha_creacion = "";
$v_simagen = "";

function filtrofares($dat_fares){
    $datos = trim($dat_fares);
$datos = stripslashes($datos);
$datos = htmlspecialchars($datos);
    return $datos;
}

function guardarimagen()
{
    if(isset($_POST['cguardar'])){

        $vcodigo = filtrofares($_POST["codigo"]);

        $archivo = $_FILES['simagen']['name'];

        if(isset($archivo) && $archivo != ""){

            $tipo = $_FILES['simagen']['type'];
            $temp = $_FILES['simagen']['tmp_name'];

            if(!(strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))){
                
                return null;

            }else{

                $extension = pathinfo($_FILES["simagen"]["name"], PATHINFO_EXTENSION);

                $nuevonombre = $vcodigo . "." . $extension;

                if(move_uploaded_file($temp, 'imgfares/' . $nuevonombre)){

                    chmod('imgfares/' . $nuevonombre, 0777);

                    return $nuevonombre;

                }else{

                    return null;
                }
            }
        }
    }
}

if(isset($_POST["cguardar"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["codigo"])){

    $v_ccodigo=filtrofares($_POST["codigo"]);
    }
    if(!empty($_POST["nproducto"])){
        $v_nproducto=filtrofares($_POST["nproducto"]);
    }
    if(!empty($_POST["costop"])){
        $v_costop=filtrofares($_POST["costop"]);
    }
    if(!empty($_POST["porcentajev"])){
        $v_porcentajev=filtrofares($_POST["porcentajev"]);
    }
    if(!empty($_POST["pventa"])){
        $v_pventa=filtrofares($_POST["pventa"]);
    }
    if(!empty($_POST["fecha_creacion"])){
    $v_fecha_creacion=filtrofares($_POST["fecha_creacion"]);
    }
    $v_simagen= guardarimagen();
    $conexion=conect();
    try{
        $sql = "INSERT INTO inventario 
(codigo, nom_producto, costo, porc_venta, precio_venta, imagen, fecha)
VALUES 
('$v_ccodigo', '$v_nproducto', '$v_costop', '$v_porcentajev',
'$v_pventa', '$v_simagen', '$v_fecha_creacion')";
        $conexion->query($sql);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $conexion=null;
    }
header('Location: cproductos.php');