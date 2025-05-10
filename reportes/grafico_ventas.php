<?php
include '../conexion.php';

$filtro = $_GET['filtro'] ?? 'mes';

switch ($filtro) {
    case 'semana':
        $ventas_query = "SELECT DATE(fecha) AS fecha, SUM(total) AS total 
                         FROM ventas 
                         WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                         GROUP BY DATE(fecha)";
        $titulo = "Ventas de la Última Semana";
        break;
    case 'año':
        $ventas_query = "SELECT DATE_FORMAT(fecha, '%Y-%m') AS fecha, SUM(total) AS total 
                         FROM ventas 
                         WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                         GROUP BY DATE_FORMAT(fecha, '%Y-%m')";
        $titulo = "Ventas por Mes del Último Año";
        break;
    default:
        $ventas_query = "SELECT DATE(fecha) AS fecha, SUM(total) AS total 
                         FROM ventas 
                         WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                         GROUP BY DATE(fecha)";
        $titulo = "Ventas del Último Mes";
        break;
}

$ventas_result = $conexion->query($ventas_query);
$fechas = [];
$totales = [];

while ($row = $ventas_result->fetch_assoc()) {
    $fechas[] = $row['fecha'];
    $totales[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body">

    <div class="w-100 bg-white rounded shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-info"><i class="bi bi-graph-up-arrow"></i> <?= $titulo ?></h4>
            <select id="filtro" class="form-select w-auto" onchange="cambiarFiltro()">
                <option value="semana" <?= $filtro == 'semana' ? 'selected' : '' ?>>Semana</option>
                <option value="mes" <?= $filtro == 'mes' ? 'selected' : '' ?>>Mes</option>
                <option value="año" <?= $filtro == 'año' ? 'selected' : '' ?>>Año</option>
            </select>
        </div>
        <canvas id="ventasChart" height="100"></canvas>
    </div>

    <script>
        function cambiarFiltro() {
            const filtro = document.getElementById('filtro').value;
            window.location.href = `grafico_ventas.php?filtro=${filtro}`;
        }

        const ctx = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($fechas) ?>,
                datasets: [{
                    label: 'Ventas (S/)',
                    data: <?= json_encode($totales) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.6)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Soles (S/)',
                            color: '#666'
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
