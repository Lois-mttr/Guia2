<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - SISTESIS-UNI</title></head>
<body>
<h1>SISTESIS-UNI</h1>
<h2>Iniciar sesión</h2>
<?php if (!empty($error)): ?><p><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" action="/login">
  <label>Correo <input type="email" name="email" required></label><br><br>
  <label>Contraseña <input type="password" name="password" required></label><br><br>
  <button type="submit">Ingresar</button>
</form>
<p><a href="/register">Registrar estudiante</a></p>
</body>
</html>
