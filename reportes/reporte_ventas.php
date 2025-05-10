<?php
include '../conexion.php';

$fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');

$query = "SELECT DATE(fecha) as fecha, SUM(total) as total 
          FROM ventas 
          WHERE DATE(fecha) BETWEEN '$fecha_inicio' AND '$fecha_fin'
          GROUP BY DATE(fecha)
          ORDER BY fecha DESC";

$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Nova Salud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .badge {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary mb-0">
            <i class="bi bi-calendar-week-fill"></i> Ventas
        </h4>
        <span class="badge bg-secondary">
            Rango: <?= $fecha_inicio ?> al <?= $fecha_fin ?>
        </span>
    </div>

    <form method="get" class="row gy-2 gx-3 align-items-end mb-4">
        <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Desde</label>
            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?= $fecha_inicio ?>">
        </div>
        <div class="col-md-4">
            <label for="fecha_fin" class="form-label">Hasta</label>
            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?= $fecha_fin ?>">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-primary w-100">
                <i class="bi bi-funnel-fill"></i> Filtrar
            </button>
        </div>
    </form>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Total (S/)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_general = 0;
                    while ($row = $resultado->fetch_assoc()):
                        $total_general += $row['total'];
                    ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($row['fecha'])) ?></td>
                            <td><strong class="text-success">S/ <?= number_format($row['total'], 2) ?></strong></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th>Total General</th>
                        <th class="text-primary">S/ <?= number_format($total_general, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">
            <i class="bi bi-info-circle-fill"></i> No se encontraron ventas en el rango seleccionado.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
