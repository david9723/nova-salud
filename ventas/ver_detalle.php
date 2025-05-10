<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);

// Consulta segura
$detalle = $conexion->query("
    SELECT p.nombre, d.cantidad, d.precio_unitario
    FROM detalle_venta d
    JOIN productos p ON p.id = d.id_producto
    WHERE d.id_venta = $id
");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detalle-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="bi bi-clipboard2-data"></i> Detalle de venta</h2>
            <a href="listar.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>

        <div class="detalle-container">
            <?php if ($detalle && $detalle->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario (S/)</th>
                                <th>Subtotal (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0;
                            while ($row = $detalle->fetch_assoc()):
                                $subtotal = $row['cantidad'] * $row['precio_unitario'];
                                $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                                    <td><?= $row['cantidad'] ?></td>
                                    <td><?= number_format($row['precio_unitario'], 2) ?></td>
                                    <td><?= number_format($subtotal, 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="fw-bold text-success">S/ <?= number_format($total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> No se encontraron productos en esta venta.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>