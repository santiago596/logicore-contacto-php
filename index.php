<?php require "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - LogiCore</title>
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

    <div class="contenedor">
        <h1>Contáctanos</h1>
        <p class="sub">¿Quieres LogiCore para tu negocio o tienes una duda? Déjanos tus datos y te respondemos.</p>

        <form action="guardar.php" method="POST">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" required>

            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" maxlength="150" required>

            <label for="telefono">Teléfono: <small>(opcional)</small></label>
            <input type="tel" id="telefono" name="telefono" maxlength="20" placeholder="Ej: 314 524 6615">

            <label for="motivo">Motivo:</label>
            <select id="motivo" name="motivo" required>
                <?php foreach ($motivos as $valor => $texto): ?>
                    <option value="<?= $valor ?>"><?= $texto ?></option>
                <?php endforeach; ?>
            </select>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos qué necesitas..."></textarea>

            <button type="submit">Enviar</button>
        </form>

        <p class="enlaces"><a href="listar.php">Ver registros guardados</a></p>
    </div>

</body>
</html>
<?php $conexion->close(); ?>
