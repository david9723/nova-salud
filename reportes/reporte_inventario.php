<?php
include '../conexion.php';

$query = "SELECT nombre, stock, precio FROM productos";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="w-100 bg-white rounded shadow-sm p-4">
        <h3 class="mb-4 text-success"><i class="bi bi-box2-heart-fill"></i> Inventario</h3>
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Precio (S/)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td>S/ <?= number_format($row['precio'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
