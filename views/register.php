<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Registro - SISTESIS-UNI</title></head>
<body>
<h1>Registro de usuario</h1>
<?php if (!empty($error)): ?><p><?= htmlspecialchars($error) ?></p><?php endif; ?>
<?php if (!empty($success)): ?><p><?= htmlspecialchars($success) ?></p><?php endif; ?>
<form method="post" action="/register">
  <label>Nombre <input type="text" name="nombre" required></label><br><br>
  <label>Correo <input type="email" name="correo" required></label><br><br>
  <label>Contraseña <input type="password" name="password" required></label><br>
  <small>Mínimo 8 caracteres, una mayúscula y un número.</small><br><br>
  <button type="submit">Registrar</button>
</form>
<p><a href="/login">Volver al login</a></p>
</body>
</html>
