<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'];
$result = $conexion->query("SELECT * FROM productos WHERE id = $id");
$producto = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $stock_minimo = $_POST['stock_minimo'];

    $stmt = $conexion->prepare("UPDATE productos SET nombre=?, descripcion=?, stock=?, precio=?, stock_minimo=? WHERE id=?");
    $stmt->bind_param("ssidii", $nombre, $descripcion, $stock, $precio, $stock_minimo, $id);
    $stmt->execute();

    header("Location: listar.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-primary"><i class="bi bi-pencil-square"></i> Editar producto</h2>
        <form method="POST" class="card p-4 shadow-sm rounded">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"><?= $producto['descripcion'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_minimo" class="form-control" value="<?= $producto['stock_minimo'] ?>"
                    required>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="listar.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>

        </form>
    </div>
    
</body>

</html>