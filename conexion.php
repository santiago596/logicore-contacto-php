<?php
// conexion.php
// "Puente" entre las páginas del formulario de contacto de LogiCore y su base de datos.

$servidor  = "localhost";
$usuario   = "root";
$clave     = "";
$baseDatos = "logicore_contacto";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $clave, $baseDatos);

// Comprobar si hubo error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Usar UTF-8 para que funcionen las tildes y la ñ
$conexion->set_charset("utf8mb4");

// Motivos del mensaje (Reto 2): valor que se guarda => texto que se muestra.
// Se usan en index.php, guardar.php y listar.php.
$motivos = [
    "demostracion" => "Solicitar una demostración",
    "consulta"     => "Consulta",
    "queja"        => "Queja",
    "sugerencia"   => "Sugerencia",
];
?>
