# SISTESIS-UNI

Implementación práctica basada en la guía académica **Backend, Servicios Web y Arquitectura de APIs**.

## 1. Requisitos

- Docker
- Docker Compose
- Navegador web
- Postman (para las pruebas de la API)

## 2. Iniciar el laboratorio

Desde la carpeta raíz:

```bash
docker-compose up -d --build
```

Servicios:

- Aplicación: `http://localhost:8080`
- Login: `http://localhost:8080/login`
- SPA: `http://localhost:8080/public/app_tesis.html`
- phpMyAdmin: `http://localhost:8081`

Credenciales indicadas por la guía:

- Correo: `comision@uni.edu.ni`
- Contraseña: `admin123`

También se incluye un estudiante de demostración para verificar el ejercicio MVC:

- Correo: `estudiante@uni.edu.ni`
- Contraseña: `admin123`

## 3. Sesión 1 - MVC, sesiones y seguridad

Se implementó:

- Front Controller (`Router.php` + `index.php`).
- Singleton PDO en `config/Database.php`.
- Modelo de usuario.
- `AuthController` con `HttpOnly`, `SameSite=Lax` y `session_regenerate_id(true)`.
- Protección de `/dashboard` y `/tesis`.
- Límite de 3 intentos fallidos almacenado en base de datos.
- Registro con validación de contraseña: mínimo 8 caracteres, una mayúscula y un número.
- `TesisController.php` y su vista para listar las tesis del usuario autenticado.

### Prueba solicitada

1. Abrir `http://localhost:8080/login`.
2. Ingresar `comision@uni.edu.ni / admin123`.
3. Abrir DevTools > Application > Cookies.
4. Verificar `PHPSESSID` con bandera `HttpOnly`.
5. Cerrar sesión e intentar abrir `http://localhost:8080/dashboard`; debe redirigir al login.

Para verificar el listado de tesis del estudiante, iniciar sesión con `estudiante@uni.edu.ni / admin123` y abrir `/tesis`.

## 4. Sesión 2 - API RESTful y Postman

Endpoint: `http://localhost:8080/api/tesis.php`

Operaciones disponibles:

- `GET /api/tesis.php` - listar.
- `GET /api/tesis.php?id=1` - obtener una tesis.
- `POST /api/tesis.php` - crear.
- `PUT /api/tesis.php?id=1` - actualizar estado.
- `DELETE /api/tesis.php?id=1` - eliminar.

### Prueba POST exactamente como aparece en la guía

Body > raw > JSON:

```json
{
  "titulo": "IA en Medicina",
  "descripcion": "Uso de redes neuronales",
  "estudiante_id": 1
}
```

Resultado esperado: `201 Created`.

La colección importable está en `postman/SISTESIS-UNI.postman_collection.json`.

## 5. Sesión 3 - Frontend SPA y Fetch API

1. Abrir `http://localhost:8080/public/app_tesis.html`.
2. Abrir DevTools > Network.
3. Recargar la página y verificar la petición Fetch a `/api/tesis.php`.
4. Agregar una tesis con el formulario.
5. Verificar que la tabla se actualiza sin recargar la página.

Además del botón **Aprobar** mostrado en la guía, la SPA permite eliminar registros para completar el CRUD exigido por la rúbrica.

## 6. Nota técnica sobre el SQL de la guía

La guía declara que el usuario inicial usa la contraseña `admin123`, y posteriormente el controlador utiliza `password_verify()`, pero el valor mostrado en el `INSERT` del PDF es `FW34`, que no es un hash utilizable para esa verificación. Para conservar la credencial explícitamente indicada por la guía y permitir que el laboratorio funcione, este proyecto almacena un hash generado con `password_hash('admin123', PASSWORD_DEFAULT)`.

## 7. Reiniciar la base de datos

Si se modifica `sql/init_sistesis.sql`, eliminar el volumen y levantar de nuevo:

```bash
docker-compose down -v
docker-compose up -d --build
```

## 8. Verificación de sintaxis

Los archivos PHP pueden comprobarse con:

```bash
find . -name '*.php' -print0 | xargs -0 -n1 php -l
```
