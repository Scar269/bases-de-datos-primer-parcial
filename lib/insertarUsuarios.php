<?php 
    require_once 'db.php';
    $consulta = "ALTER TABLE usuarios ADD UNIQUE (correo)";
    mysqli_query($enlace, $consulta);

    extract($_POST);
    $consulta = "INSERT IGNORE INTO usuarios (nombre, telefono, correo, password, status) VALUES ('$nombreUsuario','$telefonoUsuario','$correoUsuario','$passwordUsuario','$statusUsuario')";
    mysqli_query($enlace, $consulta);
    header("Location: ../modules/usuarios/index.php");
?>