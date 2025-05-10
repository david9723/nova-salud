<?php $error = isset($_GET['error']); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Nova Salud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0369a1;
            --bg-gradient: linear-gradient(135deg, #0ea5e9, #38bdf8);
            --card-bg: #ffffff;
            --text-muted: #6c757d;
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box {
            background: var(--card-bg);
            padding: 2.5rem 2rem;
            border-radius: 1.5rem;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .text-logo {
            font-weight: bold;
            color: var(--primary);
        }

        .input-group-text {
            background-color: #e9f5fc;
            border-color: #d1e9f7;
        }

        .alert-danger {
            font-size: 0.9rem;
        }

        footer {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="text-center mb-4">
            <h2 class="text-logo"><i class="bi bi-heart-pulse-fill me-2"></i>Nova Salud</h2>
            <p class="text-muted">Inicio de sesión seguro</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Usuario o contraseña incorrectos
            </div>
        <?php endif; ?>

        <form action="usuarios/login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Ingresar
            </button>
        </form>

        <footer class="text-center mt-4">
            © <?= date('Y') ?> Nova Salud. Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>
