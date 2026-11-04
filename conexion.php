<?php

$servidor  = "localhost";
$usuario   = "root";
$clave     = "";
$baseDatos = "logicore_contacto";

$conexion = new mysqli($servidor, $usuario, $clave, $baseDatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

$motivos = [
    "demostracion" => "Solicitar una demostración",
    "consulta"     => "Consulta",
    "queja"        => "Queja",
    "sugerencia"   => "Sugerencia",
];
?>
