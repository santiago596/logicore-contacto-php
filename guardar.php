<?php
require "conexion.php";

// Solo aceptamos datos que vengan del formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// 1. Recoger los datos y quitar espacios sobrantes
$nombre   = trim($_POST["nombre"] ?? "");
$email    = trim($_POST["email"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$motivo   = trim($_POST["motivo"] ?? "");
$mensaje  = trim($_POST["mensaje"] ?? "");

// 2. Validar
$errores = [];

if ($nombre === "" || mb_strlen($nombre) > 100) {
    $errores[] = "Escribe tu nombre (máximo 100 caracteres).";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Escribe un correo válido.";
}
// Reto 1: el teléfono es opcional, pero si se escribe debe tener solo números, espacios o +
if ($telefono !== "" && !preg_match('/^\+?[0-9 ]{7,20}$/', $telefono)) {
    $errores[] = "El teléfono solo puede tener números, espacios y +.";
}
// Reto 2: el motivo debe ser uno de la lista
if (!array_key_exists($motivo, $motivos)) {
    $errores[] = "Elige un motivo de la lista.";
}

$guardado = false;

if (!$errores) {
    // 3. Guardar con una consulta preparada (segura contra inyección SQL)
    $sql  = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $telefonoGuardar = $telefono === "" ? null : $telefono;
    $stmt->bind_param("sssss", $nombre, $email, $telefonoGuardar, $motivo, $mensaje); // s = texto (string)

    if ($stmt->execute()) {
        $guardado = true;
    } else {
        $errores[] = "Error al guardar: " . $stmt->error;
    }
    $stmt->close();
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar - LogiCore</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="barra">
        <div>
            <strong>LOGICORE</strong>
            <span>Sistema de Almacen y Bodega</span>
        </div>
    </div>

    <div class="contenedor">
        <?php if ($guardado): ?>
            <div class="aviso ok"><strong>Datos guardados correctamente.</strong>
                Gracias, <?= htmlspecialchars($nombre) ?>. Te responderemos pronto.</div>
        <?php else: ?>
            <div class="aviso error"><strong>Datos no válidos.</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <a class="boton secundario" href="index.php">Volver al formulario</a>
        <a class="boton" href="listar.php">Ver registros</a>
    </div>

</body>
</html>
