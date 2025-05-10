<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM productos WHERE stock <= stock_minimo");
?>

<h2>Alertas de Stock Bajo</h2>
<a href="dashboard.php">← Volver al Dashboard</a><br><br>

<?php if ($resultado->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Producto</th>
            <th>Stock Actual</th>
            <th>Stock Mínimo</th>
        </tr>
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nombre'] ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['stock_minimo'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No hay productos con stock bajo.</p>
<?php endif; ?>
