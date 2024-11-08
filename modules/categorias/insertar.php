<?php
require_once '../../lib/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../../lib/head.php'; ?>
    <title>Añadir Categoría</title>
</head>

<body class="d-flex flex-nowrap">
    <?php
    session_start();
    if (!isset($_SESSION["correo"])) {
        header("Location: ../../index.php");
        exit();
    }
    include_once '../../lib/sidebar.php';
    ?>
    <section class="p-3 w-100">
        <h1>Categorías</h1>
        <form method="POST" action="../../lib/insertarCategorias.php">
            <div class="form-group mb-3">
                <label>Nueva Categoria:</label>
                <input type="text" class="form-control" name="categoriaUsuario" id="categoriaUsuario">
            </div>
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-success">Crear</button>
            </div>
            <hr>
        </form>
    </section>
</body>

</html>
