<?php
require 'conexionf.php';

function filtrofares($dato)
{
    return htmlspecialchars(stripslashes(trim($dato)));
}

function guardarImagenProducto($codigo)
{
    if (!isset($_FILES['imagen_update']) || $_FILES['imagen_update']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $archivo = $_FILES['imagen_update']['name'];
    $temp = $_FILES['imagen_update']['tmp_name'];
    $tipo = $_FILES['imagen_update']['type'];

    if ($archivo === '' || $temp === '') {
        return null;
    }

    if (!(strpos($tipo, 'gif') !== false || strpos($tipo, 'jpeg') !== false || strpos($tipo, 'jpg') !== false || strpos($tipo, 'png') !== false)) {
        return null;
    }

    $extension = pathinfo($archivo, PATHINFO_EXTENSION);
    $nuevoNombre = $codigo . '.' . $extension;

    if (is_uploaded_file($temp) && move_uploaded_file($temp, 'imgfares/' . $nuevoNombre)) {
        @chmod('imgfares/' . $nuevoNombre, 0777);
        return $nuevoNombre;
    }

    return null;
}

$pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$cantRegistros = 5;
$inicio = ($pagina > 1) ? (($pagina - 1) * $cantRegistros) : 0;
$conexion = conect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['action'] ?? '';
    $codigo = isset($_POST['codigo']) ? filtrofares($_POST['codigo']) : '';
    $paginaRedirect = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;

    if ($accion === 'eliminar' && $codigo !== '') {
        $stmt = $conexion->prepare('DELETE FROM inventario WHERE codigo = :codigo');
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        header('Location: consultar_productos.php?pagina=' . $paginaRedirect);
        exit;
    }

    if ($accion === 'actualizar' && $codigo !== '') {
        $nom_producto = isset($_POST['nproducto']) ? filtrofares($_POST['nproducto']) : '';
        $costo = isset($_POST['costop']) ? filtrofares($_POST['costop']) : '';
        $porcentaje = isset($_POST['porcentajev']) ? filtrofares($_POST['porcentajev']) : '';
        $pventa = isset($_POST['pventa']) ? filtrofares($_POST['pventa']) : '';
        $fecha = isset($_POST['fecha_creacion']) ? filtrofares($_POST['fecha_creacion']) : '';
        $imagenNueva = guardarImagenProducto($codigo);

        $sql = 'UPDATE inventario SET nom_producto = :nom_producto, costo = :costo, porc_venta = :porcentaje, precio_venta = :pventa, fecha = :fecha';
        if ($imagenNueva !== null) {
            $sql .= ', imagen = :imagen';
        }
        $sql .= ' WHERE codigo = :codigo';

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nom_producto', $nom_producto);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':porcentaje', $porcentaje);
        $stmt->bindParam(':pventa', $pventa);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':codigo', $codigo);
        if ($imagenNueva !== null) {
            $stmt->bindParam(':imagen', $imagenNueva);
        }
        $stmt->execute();

        header('Location: consultar_productos.php?pagina=' . $paginaRedirect);
        exit;
    }
}

$totalRegistros = 0;
if ($conexion) {
    $totalRegistros = (int) $conexion->query('SELECT COUNT(*) FROM inventario')->fetchColumn();
}

$consulta = $conexion->prepare('SELECT * FROM inventario ORDER BY nom_producto LIMIT :inicio, :cantidad');
$consulta->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$consulta->bindValue(':cantidad', $cantRegistros, PDO::PARAM_INT);
$consulta->execute();
$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
$numeropaginas = max(1, ceil($totalRegistros / $cantRegistros));

$editarProducto = null;
if (isset($_GET['editar']) && $_GET['editar'] !== '') {
    $codigoEditar = filtrofares($_GET['editar']);
    $stmt = $conexion->prepare('SELECT * FROM inventario WHERE codigo = :codigo LIMIT 1');
    $stmt->bindParam(':codigo', $codigoEditar);
    $stmt->execute();
    $editarProducto = $stmt->fetch(PDO::FETCH_ASSOC);
}
