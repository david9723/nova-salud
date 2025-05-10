<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$productos = $conexion->query("SELECT * FROM productos WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .total-display {
            font-size: 1.3rem;
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="bi bi-receipt-cutoff"></i> Registrar nueva venta</h2>
        <a href="../dashboard.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>

    <div class="form-container">
        <form id="ventaForm" method="POST" action="registrar_venta.php">

            <!-- Buscador -->
            <div class="mb-3">
                <input type="text" id="buscadorProducto" class="form-control" placeholder="Buscar producto por nombre...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="tablaProductos">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio (S/)</th>
                            <th>Stock</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($p = $productos->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($p['nombre']) ?>
                                    <input type="hidden" name="productos[]" value="<?= $p['id'] ?>">
                                </td>
                                <td>
                                    <?= number_format($p['precio'], 2) ?>
                                    <input type="hidden" name="precios[]" value="<?= $p['precio'] ?>">
                                </td>
                                <td><?= $p['stock'] ?></td>
                                <td>
                                    <input type="number" class="form-control text-center" name="cantidades[]" value="0" min="0" max="<?= $p['stock'] ?>">
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mb-3 total-display">
                Total: S/ <span id="total">0.00</span>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2-circle"></i> Registrar venta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
    document.getElementById("ventaForm").addEventListener("input", () => {
        const precios = document.getElementsByName("precios[]");
        const cantidades = document.getElementsByName("cantidades[]");
        let total = 0;
        for (let i = 0; i < precios.length; i++) {
            total += parseFloat(precios[i].value) * parseInt(cantidades[i].value || 0);
        }
        document.getElementById("total").textContent = total.toFixed(2);
    });

    document.getElementById('buscadorProducto').addEventListener('keyup', function () {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll("#tablaProductos tbody tr");

        filas.forEach(function (fila) {
            let nombre = fila.cells[0].textContent.toLowerCase();
            fila.style.display = nombre.includes(filtro) ? '' : 'none';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
