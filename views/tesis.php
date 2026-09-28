<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Mis tesis - SISTESIS-UNI</title></head>
<body>
<h1>Mis tesis</h1>
<p><a href="/dashboard">Volver al dashboard</a></p>
<?php if (!$tesis): ?>
  <p>No hay tesis asociadas al usuario autenticado.</p>
<?php else: ?>
<table border="1" cellpadding="6">
  <thead><tr><th>ID</th><th>Título</th><th>Descripción</th><th>Estado</th></tr></thead>
  <tbody>
  <?php foreach ($tesis as $t): ?>
    <tr>
      <td><?= (int)$t['id'] ?></td>
      <td><?= htmlspecialchars($t['titulo']) ?></td>
      <td><?= htmlspecialchars($t['descripcion'] ?? '') ?></td>
      <td><?= htmlspecialchars($t['estado']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
</body>
</html>
