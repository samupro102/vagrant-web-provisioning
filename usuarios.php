<?php
$host = "192.168.56.11";  // IP privada de la máquina db
$port = "5432";
$dbname = "ejemplo_db";
$user = "samuel";
$password = "1234";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("<h2 style='color:red;'>❌ Error al conectar a la base de datos.</h2>");
}

$result = pg_query($conn, "SELECT * FROM usuarios");
if (!$result) {
    die("<h2 style='color:red;'>❌ Error en la consulta.</h2>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background-color: #f5f5f5;
      color: #333;
      padding: 40px;
    }
    h1 {
      color: #0077b6;
    }
    table {
      width: 60%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #0077b6;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #e9f5f9;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #0077b6;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
    a:hover {
      background-color: #00b4d8;
    }
  </style>
</head>
<body>
  <h1>Usuarios Registrados</h1>
  <table>
    <tr><th>ID</th><th>Nombre</th><th>Correo</th></tr>
    <?php while ($row = pg_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= htmlspecialchars($row['correo']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
  <a href="index.html">⬅ Volver al inicio</a>
</body>
</html>
<?php pg_close($conn); ?>
