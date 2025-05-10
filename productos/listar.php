<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM productos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .text-center-td {
            text-align: center;
        }

        .descripcion-columna {
            max-width: 350px;
            white-space: normal;
            word-wrap: break-word;
        }

        .acciones-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="bi bi-box-seam"></i> Lista de productos</h2>
            <div>
                <a href="../dashboard.php" class="btn btn-outline-secondary btn-icon">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <a href="agregar.php" class="btn btn-success btn-icon">
                    <i class="bi bi-plus-circle-fill"></i> Agregar nuevo
                </a>
            </div>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="descripcion-columna">Descripción</th>
                            <th class="text-center-td">Stock</th>
                            <th class="text-center-td">Precio</th>
                            <th class="text-center-td">Stock mínimo</th>
                            <th class="text-center-td">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td class="descripcion-columna"><?= htmlspecialchars($row['descripcion']) ?></td>
                            <td class="text-center-td"><?= $row['stock'] ?></td>
                            <td class="text-center-td">S/ <?= number_format($row['precio'], 2) ?></td>
                            <td class="text-center-td"><?= $row['stock_minimo'] ?></td>
                            <td class="text-center-td">
                                <div class="acciones-btns">
                                    <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary btn-icon">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-icon" onclick="return confirm('¿Seguro de eliminar?')">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
