<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Filtrado por mes y año
$mes = isset($_GET['mes']) ? $_GET['mes'] : '';
$anio = isset($_GET['anio']) ? $_GET['anio'] : '';

$condiciones = [];
if ($mes != '') {
    $condiciones[] = "MONTH(fecha) = $mes";
}
if ($anio != '') {
    $condiciones[] = "YEAR(fecha) = $anio";
}

$where = count($condiciones) > 0 ? "WHERE " . implode(" AND ", $condiciones) : "";
$ventas = $conexion->query("SELECT * FROM ventas $where ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-boleta {
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            margin-bottom: 20px;
            padding: 20px 25px;
            transition: all 0.2s ease-in-out;
            border-left: 4px solid #0d6efd;
        }

        .card-boleta:hover {
            transform: scale(1.01);
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }

        .form-select, .btn {
            border-radius: 10px;
        }

        .filtros {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="bi bi-cash-coin"></i> Ventas realizadas</h2>
        <div>
            <a href="registrar.php" class="btn btn-success me-2">
                <i class="bi bi-plus-circle-fill"></i> Nueva venta
            </a>
            <a href="../dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>
    </div>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'venta_registrada'): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            Venta registrada correctamente.
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <form method="GET" class="row g-3 filtros">
        <div class="col-md-4">
            <select name="mes" class="form-select">
                <option value="">-- Filtrar por mes --</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($mes == $i) ? 'selected' : '' ?>>
                        <?= DateTime::createFromFormat('!m', $i)->format('F') ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-4">
            <select name="anio" class="form-select">
                <option value="">-- Filtrar por año --</option>
                <?php
                $anios = $conexion->query("SELECT DISTINCT YEAR(fecha) AS anio FROM ventas ORDER BY anio DESC");
                while ($a = $anios->fetch_assoc()):
                ?>
                    <option value="<?= $a['anio'] ?>" <?= ($anio == $a['anio']) ? 'selected' : '' ?>>
                        <?= $a['anio'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel-fill"></i> Aplicar filtro
            </button>
        </div>
    </form>

    <!-- Listado tipo boleta -->
    <?php if ($ventas->num_rows > 0): ?>
        <?php while ($v = $ventas->fetch_assoc()): ?>
            <div class="card-boleta">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-1 text-dark">
                            <i class="bi bi-receipt-cutoff text-primary me-2"></i> Boleta #<?= str_pad($v['id'], 6, '0', STR_PAD_LEFT) ?>
                        </h5>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event text-secondary me-1"></i>
                            <strong>Fecha:</strong> <?= date("d/m/Y", strtotime($v['fecha'])) ?>
                            <span class="text-muted"> <?= date("H:i", strtotime($v['fecha'])) ?> h</span>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-cash-coin text-success me-1"></i>
                            <strong>Total:</strong>
                            <span class="badge bg-light text-success fs-6">S/ <?= number_format($v['total'], 2) ?></span>
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="ver_detalle.php?id=<?= $v['id'] ?>" class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-eye-fill me-1"></i> Ver detalle
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i> No se encontraron ventas para el filtro seleccionado.
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
