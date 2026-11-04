<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["borrar"])) {
    $id = (int) $_POST["borrar"];

    $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $borrados = $stmt->affected_rows;
    $stmt->close();

    header("Location: listar.php?borrado=" . ($borrados > 0 ? $id : 0));
    exit;
}

$resultado = $conexion->query(
    "SELECT id, nombre, email, telefono, motivo, mensaje, fecha FROM contactos ORDER BY fecha DESC, id DESC"
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros - LogiCore</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="barra">
        <div>
            <strong>LOGICORE</strong>
            <span>Sistema de Almacen y Bodega</span>
        </div>
        <nav>
            <a href="index.php">Formulario</a>
            <a href="listar.php">Mensajes recibidos</a>
        </nav>
    </div>

    <div class="contenedor ancho">
        <h1>Registros guardados</h1>
        <p class="sub">Mensajes enviados desde el formulario de contacto de LogiCore: <?= $resultado->num_rows ?> en total.</p>

        <?php if (isset($_GET["borrado"])): ?>
            <?php if ((int) $_GET["borrado"] > 0): ?>
                <div class="aviso ok">Se borró el registro <?= (int) $_GET["borrado"] ?>.</div>
            <?php else: ?>
                <div class="aviso error">No se encontró el registro para borrar.</div>
            <?php endif; ?>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th><th>Nombre</th><th>Correo</th><th>Teléfono</th>
                <th>Motivo</th><th>Mensaje</th><th>Fecha</th><th></th>
            </tr>
            <?php if ($resultado->num_rows === 0): ?>
                <tr><td colspan="8" class="vacio">Todavía no hay mensajes.</td></tr>
            <?php endif; ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila["id"] ?></td>
                    <td><?= htmlspecialchars($fila["nombre"]) ?></td>
                    <td><?= htmlspecialchars($fila["email"]) ?></td>
                    <td><?= htmlspecialchars($fila["telefono"] ?? "—") ?></td>
                    <td><span class="motivo <?= htmlspecialchars($fila["motivo"]) ?>"><?= htmlspecialchars($motivos[$fila["motivo"]] ?? $fila["motivo"]) ?></span></td>
                    <td><?= nl2br(htmlspecialchars($fila["mensaje"] ?? "")) ?></td>
                    <td><?= $fila["fecha"] ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('¿Borrar el mensaje de <?= htmlspecialchars(addslashes($fila["nombre"]), ENT_QUOTES) ?>?');">
                            <input type="hidden" name="borrar" value="<?= $fila["id"] ?>">
                            <button type="submit" class="borrar">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <p class="enlaces"><a href="index.php">Volver al formulario</a></p>
    </div>

</body>
</html>
<?php $conexion->close(); ?>
