async function cargarTesis() {
  try {
    const res = await fetch('/api/tesis.php');
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const data = await res.json();
    const tabla = document.getElementById('tabla-tesis');
    tabla.innerHTML = data.map(t => `
      <tr>
        <td class="p-2 border">${escapeHtml(t.titulo)}</td>
        <td class="p-2 border">${escapeHtml(t.estado)}</td>
        <td class="p-2 border">
          <button onclick="cambiarEstado(${t.id}, 'aprobado')" class="bg-blue-500 text-white p-1">Aprobar</button>
          <button onclick="eliminarTesis(${t.id})" class="border p-1">Eliminar</button>
        </td>
      </tr>
    `).join('');
  } catch (error) {
    mostrarMensaje('Error al cargar las tesis: ' + error.message);
  }
}

async function crearTesis(event) {
  event.preventDefault();
  const body = {
    titulo: document.getElementById('titulo').value.trim(),
    descripcion: document.getElementById('descripcion').value.trim(),
    estudiante_id: Number(document.getElementById('estudiante_id').value),
  };

  const res = await fetch('/api/tesis.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  });

  if (!res.ok) {
    const error = await res.json().catch(() => ({ message: `HTTP ${res.status}` }));
    mostrarMensaje(error.message || 'No fue posible crear la tesis.');
    return;
  }

  document.getElementById('form-tesis').reset();
  mostrarMensaje('Tesis creada.');
  await cargarTesis();
}

async function cambiarEstado(id, estado) {
  const res = await fetch(`/api/tesis.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ estado }),
  });
  if (!res.ok) {
    mostrarMensaje('No fue posible actualizar la tesis.');
    return;
  }
  await cargarTesis();
}

async function eliminarTesis(id) {
  const res = await fetch(`/api/tesis.php?id=${id}`, { method: 'DELETE' });
  if (!res.ok && res.status !== 204) {
    mostrarMensaje('No fue posible eliminar la tesis.');
    return;
  }
  await cargarTesis();
}

function mostrarMensaje(texto) {
  document.getElementById('mensaje').textContent = texto;
}

function escapeHtml(value) {
  return String(value ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

document.getElementById('form-tesis').addEventListener('submit', crearTesis);
document.addEventListener('DOMContentLoaded', cargarTesis);
