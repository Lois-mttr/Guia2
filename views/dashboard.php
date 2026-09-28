<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard - SISTESIS-UNI</title></head>
<body>
<h1>Dashboard</h1>
<p>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>.</p>
<nav>
  <a href="/tesis">Mis tesis</a> |
  <a href="/public/app_tesis.html">SPA de tesis</a> |
  <a href="/logout">Cerrar sesión</a>
</nav>
</body>
</html>
