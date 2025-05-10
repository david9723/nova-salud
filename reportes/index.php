<?php
// index.php - Página de acceso a los reportes dinámicos
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reportes - Nova Salud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --main-bg: #f1f5f9;
            --sidebar-bg: #1E293B;
            --text-light: #cbd5e1;
            --text-white: #ffffff;
            --accent: #0ea5e9;
            --hover-bg: #334155;
            --active-bg: #0ea5e9;
            --active-text: #ffffff;
            --iframe-bg: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--main-bg);
            transition: all 0.3s ease-in-out;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--text-white);
            padding: 30px 20px;
            transition: all 0.3s ease-in-out;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
            z-index: 1000;
        }

        .sidebar h4 {
            color: var(--text-white);
            margin-bottom: 40px;
            font-weight: bold;
            font-size: 1.6rem;
        }

        .sidebar a {
            color: var(--text-light);
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: var(--hover-bg);
            color: var(--text-white);
        }

        .sidebar a.active {
            background-color: var(--active-bg);
            color: var(--active-text);
            font-weight: bold;
        }

        .content {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease-in-out;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        iframe {
            width: 100%;
            height: 80vh;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            background: var(--iframe-bg);
            transition: all 0.3s ease-in-out;
        }

        .menu-link i {
            margin-right: 10px;
        }

        h2 {
            font-weight: 600;
            color: #1e293b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 220px;
            }

            iframe {
                height: 60vh;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4><i class="bi bi-bar-chart-line me-2 text-info"></i> Reportes</h4>
        <a href="#" class="menu-link active" data-url="grafico_ventas.php"><i class="bi bi-graph-up-arrow"></i> Gráfico
            de Ventas</a>
        <a href="#" class="menu-link" data-url="reporte_ventas.php"><i class="bi bi-file-earmark-text"></i> Reporte de
            Ventas</a>
        <a href="#" class="menu-link" data-url="reporte_inventario.php"><i class="bi bi-box-seam"></i> Inventario</a>
        <hr class="text-light">
        <a href="../dashboard.php" class="inicio-link"><i class="bi bi-arrow-left-circle me-2"></i> Volver al inicio
        </a>
        
    </div>

    <div class="content">
        <h2><i class="bi bi-heart-pulse-fill text-danger me-2"></i> NOVA SALUD</h2>
        <br>
        <iframe id="report-frame" src="grafico_ventas.php"></iframe>
    </div>

    <script>
        // Interacción dinámica con el menú
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const url = this.getAttribute('data-url');
                const frame = document.getElementById('report-frame');

                frame.style.opacity = 0;
                setTimeout(() => {
                    frame.src = url;
                    frame.style.opacity = 1;
                }, 300);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>