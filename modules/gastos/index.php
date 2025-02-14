<?php
require_once '../../lib/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../../lib/head.php'; ?>
    <title>Gastos</title>
</head>

<body class="d-flex flex-nowrap">
    <?php
    session_start();
    if (!isset($_SESSION["correo"])) {
        header("Location: ../../lib/login.php");
        exit();
    }
    $idUsuario = $_SESSION['id'];
    $rolUsuario = $_SESSION['rol'];
    include_once '../../lib/sidebar.php';
    ?>
    <section class="p-3 w-100">
        <h1>Gastos
            <a href="insertar.php" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
            </a>
        </h1>
        <div class="d-inline-flex flex-column align-items-start">                 
            <form method="GET" action="index.php" class="d-inline">
                <label for="orderSelect" class="form-label text-muted">Ordenar por usuario:</label> 
                <select name="order" id="orderSelect" class="form-select w-auto" onchange="this.form.submit()">             
                    <option value="" disabled selected>Selecciona una opción...</option>             
                    <option value="ascendente" <?php if (isset($_GET['order']) && $_GET['order'] === 'ascendente') echo 'selected'; ?>>Ascendente</option>             
                    <option value="descendente" <?php if (isset($_GET['order']) && $_GET['order'] === 'descendente') echo 'selected'; ?>>Descendente</option>         
                </select>
            </form>
        </div>
        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Categoría</th>
                    <th>Tipo</th>
                    <?php if ($rolUsuario != 2) { ?>
                        <th>Usuario</th>
                    <?php } ?>
                    <th>Fecha de creación</th>
                    <th>Fecha de modificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    $order = 'ASC'; 
                    if (isset($_GET['order']) && ($_GET['order'] == 'ascendente' || $_GET['order'] == 'descendente')) {
                        $order = $_GET['order'] === 'descendente' ? 'DESC' : 'ASC';
                    }
                    if ($rolUsuario == 1) {
                        $consulta = "SELECT g.id, g.descripcion, g.creacion, g.modificacion, g.cantidad, u.nombre AS usuario, t.nombre AS tipo, c.nombre AS categoria FROM gastos g JOIN usuarios u ON g.usuario = u.id JOIN tipos t ON g.tipo = t.id JOIN categorias c ON g.categoria = c.id ORDER BY u.nombre $order";
                    } else {
                        $consulta = "SELECT g.id, g.descripcion, g.creacion, g.modificacion, g.cantidad, u.nombre AS usuario, t.nombre AS tipo, c.nombre AS categoria FROM gastos g JOIN usuarios u ON g.usuario = u.id JOIN tipos t ON g.tipo = t.id JOIN categorias c ON g.categoria = c.id WHERE g.usuario = $idUsuario ORDER BY u.nombre $order";
                    }
                    $resultado = mysqli_query($enlace, $consulta);
                    while ($registro = mysqli_fetch_object($resultado)) {
                ?>
                    <tr>
                        <td><?php echo $registro->id; ?></td>
                        <td><?php echo $registro->descripcion; ?></td>
                        <td><?php echo $registro->cantidad; ?></td>
                        <td><?php echo $registro->categoria; ?></td>
                        <td><?php echo $registro->tipo; ?></td>
                        <?php if ($rolUsuario != 2) { ?>
                            <td><?php echo $registro->usuario; ?></td>
                        <?php } ?>
                        <td><?php echo $registro->creacion; ?></td>
                        <td><?php echo $registro->modificacion; ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $registro->id; ?>" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                            <a href="eliminar.php?id=<?php echo $registro->id; ?>" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </section>
</body>

</html>
