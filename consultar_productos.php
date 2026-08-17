<?php
require 'consultar_productos_logic.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./imgfares/favicon.jpg" type="image/jpg" size="16x16">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/diseñocssf.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="./JScript/acciones_script.js"></script>
    <title>Consultar productos - Inventario Fares</title>
</head>
<body>
    <header id="titulo1" class="fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    <nav class="fcolor-l4">
        <ul>
            <li><a href="#">Principal</a></li>
            <li><a href="#">Libros</a></li>
            <li class="f-desplegable">
                <a href="#" class="btndesplegable">Inventario</a>
                <div class="cont-desplegable">
                    <a href="cproductos.php">Crear producto</a>
                    <a href="consultar_productos.php">Consultar y modificar productos</a>
                </div>
            </li>
            <li><a href="#">Contactos</a></li>
        </ul>
    </nav>
    <section class="fcolor-l1 seccion-form">
        <div class="s-encabezado">
            <h2>Consultar y modificar productos</h2>
        </div>

        <?php if ($editarProducto): ?>
        <div class="w3-panel w3-pale-yellow w3-border">
            <h3>Editar producto: <?php echo htmlspecialchars($editarProducto['nom_producto']); ?></h3>
            <form class="fcolor-l5" action="consultar_productos.php?pagina=<?php echo $pagina; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="actualizar">
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($editarProducto['codigo']); ?>">

                <div id="codnom">
                    <label class="codnom1">Código:<br>
                        <input type="text" name="codigo_display" value="<?php echo htmlspecialchars($editarProducto['codigo']); ?>" readonly>
                    </label>
                    <label class="codnom1">Producto:<br>
                        <input type="text" class="campof" name="nproducto" value="<?php echo htmlspecialchars($editarProducto['nom_producto']); ?>" required>
                    </label>
                </div>
                <div id="cospor">
                    <label class="codnom1">Costo:<br>
                        <input type="text" class="campof" name="costop" value="<?php echo htmlspecialchars($editarProducto['costo']); ?>" required>
                    </label>
                    <label class="codnom1">Porcentaje de venta:<br>
                        <input type="text" class="campof" name="porcentajev" value="<?php echo htmlspecialchars($editarProducto['porc_venta']); ?>" required>
                    </label>
                </div>
                <div id="prefecha">
                    <label class="codnom1">Precio de venta:<br>
                        <input type="text" class="campof" name="pventa" value="<?php echo htmlspecialchars($editarProducto['precio_venta']); ?>" required>
                    </label>
                    <label class="codnom1">Fecha:<br>
                        <input type="date" class="campof" name="fecha_creacion" value="<?php echo htmlspecialchars($editarProducto['fecha']); ?>" required>
                    </label>
                </div>
                <div id="csimagen" style="display:flex; flex-wrap:wrap; gap:10px;">
                    <label class="codnom1">Imagen actual:<br>
                        <?php if (!empty($editarProducto['imagen'])): ?>
                            <img src="imgfares/<?php echo htmlspecialchars($editarProducto['imagen']); ?>?t=<?php echo time(); ?>" alt="Imagen del producto" width="120">
                        <?php else: ?>
                            <span>No hay imagen cargada</span>
                        <?php endif; ?>
                    </label>
                    <label class="codnom1">Nueva imagen:<br>
                        <input type="file" class="campof" name="imagen_update" id="imagen_update" accept="image/*" onchange="mostrarImagen(this, document.getElementById('preview_update'))">
                    </label>
                </div>
                <div id="preview_container" style="margin-top:10px;">
                    <img id="preview_update" src="" alt="Vista previa nueva imagen" width="120" style="display:none; border:1px solid #ccc; padding:4px;">
                </div>
                <div id="botonimg" style="width:100%; text-align:center; margin-top:10px;">
                    <button type="submit" class="w3-button w3-green">Actualizar producto</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="w3-responsive">
            <table class="w3-table-all w3-card-4 w3-text-black">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Costo</th>
                        <th>% Venta</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($productos) === 0): ?>
                        <tr>
                            <td colspan="8" class="w3-center">No hay productos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nom_producto']); ?></td>
                                <td><?php echo htmlspecialchars($producto['costo']); ?></td>
                                <td><?php echo htmlspecialchars($producto['porc_venta']); ?></td>
                                <td><?php echo htmlspecialchars($producto['precio_venta']); ?></td>
                                <td><?php echo htmlspecialchars($producto['fecha']); ?></td>
                                <td>
                                    <?php if (!empty($producto['imagen'])): ?>
                                        <img src="imgfares/<?php echo htmlspecialchars($producto['imagen']); ?>?t=<?php echo time(); ?>" alt="Imagen" width="80">
                                    <?php else: ?>
                                        Sin imagen
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="consultar_productos.php?editar=<?php echo urlencode($producto['codigo']); ?>&pagina=<?php echo $pagina; ?>" class="w3-button w3-blue">Editar</a>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="eliminar">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($producto['codigo']); ?>">
                                        <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                                        <button type="submit" class="w3-button w3-red">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($numeropaginas > 1): ?>
            <div class="w3-bar w3-center w3-section">
                <?php if ($pagina > 1): ?>
                    <a href="consultar_productos.php?pagina=<?php echo $pagina - 1; ?>" class="w3-bar-item w3-button">&laquo; Anterior</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $numeropaginas; $i++): ?>
                    <a href="consultar_productos.php?pagina=<?php echo $i; ?>" class="w3-bar-item w3-button <?php echo ($pagina === $i ? 'w3-dark-grey' : ''); ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($pagina < $numeropaginas): ?>
                    <a href="consultar_productos.php?pagina=<?php echo $pagina + 1; ?>" class="w3-bar-item w3-button">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php require 'pie_pagina.php'; ?>
</body>
</html>
