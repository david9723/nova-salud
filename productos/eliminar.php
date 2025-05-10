<?php
// Eliminar producto

include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'];
$conexion->query("DELETE FROM productos WHERE id = $id");
header("Location: listar.php");
