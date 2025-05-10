<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

// Total de productos
$resultadoProductos = $conexion->query("SELECT COUNT(*) AS total FROM productos");
$productos = $resultadoProductos->fetch_assoc()['total'];

// Productos con stock menor o igual a 10
$resultadoStockBajo = $conexion->query("SELECT COUNT(*) AS bajos FROM productos WHERE stock <= 10");
$stock_bajo = $resultadoStockBajo->fetch_assoc()['bajos'];

// Total de ventas
$resultadoVentas = $conexion->query("SELECT COUNT(*) AS total FROM ventas");
$ventas = $resultadoVentas->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Nova Salud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, rgb(255, 255, 255), rgb(87, 149, 242));
            font-family: 'Segoe UI', sans-serif;
            animation: fadeIn 0.5s ease-in-out;
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

        .sidebar {
            height: 100vh;
            background: linear-gradient(to bottom, #ffffff, rgb(184, 212, 254));
            border-right: 1px solid #d6e4f0;
            padding: 2rem 1.5rem;
            position: fixed;
            width: 260px;
            overflow-y: auto;
            animation: slideIn 0.4s ease;
            transition: all 0.3s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .sidebar h4 {
            font-size: 1.6rem;
            margin-bottom: 2.5rem;
            font-weight: 700;
            color: #457fca;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 12px 16px;
            margin-bottom: 12px;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: background-color 0.25s ease, transform 0.2s ease;
        }

        .sidebar a i {
            font-size: 1.25rem;
            color: rgb(6, 120, 249);
        }

        .sidebar a:hover i {
            color: #fff;
        }

        .sidebar a:hover {
            background-color: rgba(21, 141, 247, 0.86);
            transform: translateX(5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            color: #fff;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .dashboard-header {
            background: white;
            border-left: 6px solid #6fb1fc;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .dashboard-header h3 {
            margin: 0;
            font-weight: 600;
            color: #457fca;
        }

        .card-stats {
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }

        .carousel-inner img {
            object-fit: cover;
            height: 300px;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 1rem;
            border-radius: 1rem;
        }

        .dashboard-card {
            background: linear-gradient(to right, #ffffff, #f7faff);
            border-left: 5px solid #6fb1fc;
            border-radius: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.06);
        }

        h2 {
            color: #457fca;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><i class="bi bi-hospital-fill"></i>Nova Salud</h4>

        <a href="productos/listar.php"><i class="bi bi-capsule-pill"></i> Productos</a>
        <a href="ventas/listar.php"><i class="bi bi-cash-stack"></i> Ventas</a>
        <a href="reportes/index.php"><i class="bi bi-file-earmark-bar-graph"></i> Reportes</a>
        <a href="usuarios/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <div
            class="dashboard-header d-flex justify-content-between align-items-center p-4 bg-light rounded shadow-sm mb-4 border">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle text-primary fs-2 me-3"></i>
                <div>
                    <h4 class="mb-0 fw-semibold">Bienvenido, <?php echo $_SESSION['usuario']; ?></h4>
                    <small class="text-muted"> <?php echo ucfirst($_SESSION['rol']); ?></small>
                </div>
            </div>
        </div>

        <!-- Carrusel -->
        <div id="boticaCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 shadow">
                <div class="carousel-item active">
                    <img src="./img/bienvenida.jpg" class="d-block w-100" alt="Bienvenido">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Gestión eficiente</h5>
                        <p>Controla productos, stock y más desde un solo lugar.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/disponibles.jpg" class="d-block w-100" alt="Disponibilidad">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Stock en tiempo real</h5>
                        <p>Evita quiebres de stock con alertas automáticas.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/reportes.jpg" class="d-block w-100" alt="Reportes">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Reportes fáciles de entender</h5>
                        <p>Toma decisiones con datos precisos.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#boticaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#boticaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="row mb-5 text-center">
            <div class="col-md-4 mb-4">
                <div class="card card-stats p-4">
                    <i class="bi bi-box2-fill text-primary fs-2"></i>
                    <h5 class="mt-2">Productos registrados</h5>
                    <p class="text-muted"><?php echo $productos; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-stats p-4">
                    <i class="bi bi-exclamation-circle-fill text-danger fs-2"></i>
                    <h5 class="mt-2">Stock bajo</h5>
                    <p class="text-muted"><?php echo $stock_bajo; ?> productos</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-stats p-4">
                    <i class="bi bi-cart-fill text-success fs-2"></i>
                    <h5 class="mt-2">Total ventas</h5>
                    <p class="text-muted"><?php echo $ventas; ?></p>
                </div>
            </div>

        </div>

        <h2 class="module-description-title">Módulos</h2>

        <div class="card dashboard-card p-4 shadow-sm mb-4">
            <h4><i class="bi bi-capsule-pill me-2"></i>Productos</h4>
            <p>Administra todos los productos farmacéuticos de forma ordenada, con alertas automáticas y control de
                stock.</p>
        </div>

        <div class="card dashboard-card p-4 shadow-sm mb-4">
            <h4><i class="bi bi-cash-stack me-2"></i>Ventas</h4>
            <p>Registra y consulta fácilmente todas las ventas realizadas en la botica.</p>
        </div>

        <div class="card dashboard-card p-4 shadow-sm mb-4">
            <h4><i class="bi bi-file-earmark-bar-graph me-2"></i>Reportes</h4>
            <p>Visualiza informes detallados sobre productos, ventas y desempeño. Toma decisiones con base en datos en
                tiempo real y gráficos intuitivos.</p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>