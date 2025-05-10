<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$ventas = $conexion->query("SELECT * FROM ventas ORDER BY fecha DESC");
?>

<h2>Historial de Ventas</h2>
<a href="../dashboard.php">← Volver al Dashboard</a><br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total (S/)</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($venta = $ventas->fetch_assoc()): ?>
            <tr>
                <td><?= $venta['id'] ?></td>
                <td><?= $venta['fecha'] ?></td>
                <td>S/ <?= number_format($venta['total'], 2) ?></td>
                <td><a href="ver_detalle.php?id=<?= $venta['id'] ?>">Ver Detalle</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>