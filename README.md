# GUÍA ACADÉMICA BACKEND SERVICIOS WEB Y ARQUITECT - Realizado por Luisa Téllez y Stephanie Tenorio

# SISTESIS-UNI

En este proyecto desarrollo una implementación práctica basada en la guía académica **Backend, Servicios Web y Arquitectura de APIs**.

## 1. Requisitos

- Docker
- Docker Compose
- Navegador web
- Postman (para las pruebas de la API)

## 2. Iniciar el laboratorio

Desde la carpeta raíz, ejecuto:

```bash
docker-compose up -d --build
```

Servicios:

- Aplicación: `http://localhost:8080`
- Login: `http://localhost:8080/login`
- SPA: `http://localhost:8080/public/app_tesis.html`
- phpMyAdmin: `http://localhost:8081`

Utilizo las siguientes credenciales, indicadas en la guía:

- Correo: `comision@uni.edu.ni`
- Contraseña: `admin123`

También incluyo un estudiante de demostración para verificar el ejercicio MVC:

- Correo: `estudiante@uni.edu.ni`
- Contraseña: `admin123`

## 3. Sesión 1 - MVC, sesiones y seguridad

En esta sesión implementé:

- Front Controller (`Router.php` + `index.php`).
- Singleton PDO en `config/Database.php`.
- Un modelo de usuario.
- `AuthController` con `HttpOnly`, `SameSite=Lax` y `session_regenerate_id(true)`.
- Protección de `/dashboard` y `/tesis`.
- Un límite de tres intentos fallidos, almacenado en la base de datos.
- Un registro con validación de contraseña: un mínimo de ocho caracteres, una letra mayúscula y un número.
- `TesisController.php` y su vista para listar las tesis del usuario autenticado.

### Prueba solicitada

1. Abro `http://localhost:8080/login`.
2. Ingreso con `comision@uni.edu.ni / admin123`.
3. Abro DevTools > Application > Cookies.
4. Verifico que `PHPSESSID` tenga la bandera `HttpOnly`.
5. Cierro sesión e intento acceder a `http://localhost:8080/dashboard`; la aplicación debe redirigirme al inicio de sesión.

Para verificar el listado de tesis del estudiante, inicio sesión con `estudiante@uni.edu.ni / admin123` y abro `/tesis`.

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

Incluyo la colección importable en `postman/SISTESIS-UNI.postman_collection.json`.

## 5. Sesión 3 - Frontend SPA y Fetch API

1. Abro `http://localhost:8080/public/app_tesis.html`.
2. Abro DevTools > Network.
3. Recargo la página y verifico la petición Fetch a `/api/tesis.php`.
4. Agrego una tesis mediante el formulario.
5. Verifico que la tabla se actualice sin recargar la página.

Además del botón **Aprobar** mostrado en la guía, incorporé en la SPA la opción de eliminar registros para completar el CRUD exigido por la rúbrica.

## 6. Nota técnica sobre el SQL de la guía

La guía indica que el usuario inicial utiliza la contraseña `admin123` y, posteriormente, emplea `password_verify()` en el controlador. Sin embargo, el valor mostrado en el `INSERT` del PDF es `FW34`, que no es un hash válido para esa verificación. Para conservar la credencial indicada en la guía y garantizar el funcionamiento del laboratorio, almaceno un hash generado con `password_hash('admin123', PASSWORD_DEFAULT)`.

## 7. Reiniciar la base de datos

Si modifico `sql/init_sistesis.sql`, elimino el volumen y vuelvo a levantar los servicios:

```bash
docker-compose down -v
docker-compose up -d --build
```

## 8. Verificación de sintaxis

Compruebo la sintaxis de los archivos PHP con:

```bash
find . -name '*.php' -print0 | xargs -0 -n1 php -l
```
