# Consultas Postman - API REST CRUD de Pedidos (Reservas)

## Configuración Previa

### Variables de Entorno (Environment)
```
BASE_URL: http://127.0.0.1:8000/api
TOKEN_ADMIN: <token_obtenido_del_login_admin>
TOKEN_CLIENTE: <token_obtenido_del_login_cliente>
ID_CLIENTE: <id_del_cliente>
ID_PEDIDO: <id_de_una_reserva_existente>
```

---

## 🔐 AUTENTICACIÓN PREVIA

### Login ADMIN
```http
POST {{BASE_URL}}/login
Content-Type: application/json

{
    "email": "admin@hotel.com",
    "password": "password123"
}
```

### Login CLIENTE
```http
POST {{BASE_URL}}/cliente/login
Content-Type: application/json

{
    "email": "cliente@ejemplo.com",
    "password": "password123"
}
```

---

# 👨‍💼 ADMIN - CONSULTAS PARA ADMINISTRADOR

## 1. Listar todos los pedidos
```http
GET {{BASE_URL}}/reservas
Authorization: Bearer {{TOKEN_ADMIN}}
```
**Descripción:** Retorna todas las reservas del sistema.

---

## 2. Ver detalle de un pedido por ID
```http
GET {{BASE_URL}}/reservas/{{ID_PEDIDO}}
Authorization: Bearer {{TOKEN_ADMIN}}
```
**Descripción:** Retorna los detalles de una reserva específica.

---

## 3. Cancelar pedido por ID
```http
PUT {{BASE_URL}}/reservas/{{ID_PEDIDO}}
Authorization: Bearer {{TOKEN_ADMIN}}
Content-Type: application/json

{
    "estado": "cancelado"
}
```
**Descripción:** Actualiza el estado de una reserva a "cancelado".

---

## 4. Ver historial de pedidos de un cliente
```http
GET {{BASE_URL}}/admin/clientes/{{ID_CLIENTE}}/pedidos
Authorization: Bearer {{TOKEN_ADMIN}}
```
**Descripción:** Retorna todas las reservas de un cliente específico.

---

## 5. Ver detalle de pedido de un cliente
```http
GET {{BASE_URL}}/admin/clientes/{{ID_CLIENTE}}/pedidos/{{ID_PEDIDO}}
Authorization: Bearer {{TOKEN_ADMIN}}
```
**Descripción:** Retorna los detalles de una reserva específica de un cliente.

---

# 👤 CLIENTE - CONSULTAS PARA CLIENTE

## 1. Crear pedido (reserva)
```http
POST {{BASE_URL}}/cliente/pedidos
Authorization: Bearer {{TOKEN_CLIENTE}}
Content-Type: application/json

{
    "id_habitacion": 1,
    "fecha_inicio": "2026-05-01",
    "fecha_fin": "2026-05-05"
}
```
**Descripción:** Crea una nueva reserva para el cliente autenticado.

---

## 2. Cancelar pedido por cliente
```http
DELETE {{BASE_URL}}/cliente/pedidos/{{ID_PEDIDO}}
Authorization: Bearer {{TOKEN_CLIENTE}}
```
**Descripción:** Cancela una reserva propia (cambia estado a "cancelado").

---

## 3. Ver historial de pedidos del cliente
```http
GET {{BASE_URL}}/cliente/pedidos
Authorization: Bearer {{TOKEN_CLIENTE}}
```
**Descripción:** Retorna todas las reservas del cliente autenticado.

---

## 4. Ver detalle de pedido del cliente
```http
GET {{BASE_URL}}/cliente/pedidos/{{ID_PEDIDO}}
Authorization: Bearer {{TOKEN_CLIENTE}}
```
**Descripción:** Muestra los detalles de una reserva específica del cliente.

---

# 📋 CÓMO IMPORTAR A POSTMAN

1. Abrir Postman
2. Click en **Import**
3. Seleccionar la opción **Raw text**
4. Pegar el contenido de este archivo
5. Configurar las variables de entorno
6. Ejecutar las consultas en orden

---

# 🔄 FLUJO COMPLETO DE PRUEBA

## Paso 1: Autenticación
```
1. POST /login (Admin) → Guardar token en TOKEN_ADMIN
2. POST /cliente/login (Cliente) → Guardar token en TOKEN_CLIENTE
```

## Paso 2: ADMIN - Gestión de Pedidos
```
3. GET /reservas (Listar todos)
4. GET /reservas/{id} (Ver detalle)
5. PUT /reservas/{id} (Cancelar pedido)
6. GET /reservas?id_cliente=X (Historial cliente)
7. GET /reservas/{id} (Detalle pedido cliente)
```

## Paso 3: CLIENTE - Gestión de Propios Pedidos
```
8. POST /cliente/pedidos (Crear pedido)
9. GET /cliente/pedidos (Ver historial)
10. GET /cliente/pedidos/{id} (Ver detalle)
11. DELETE /cliente/pedidos/{id} (Cancelar pedido)
```

---

# 📌 NOTAS

- Los pedidos en este sistema se llaman **Reservas**
- El modelo tiene: id_reserva, id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado
- Estados posibles: pendiente, confirmado, cancelado, completado
- El ID del cliente se obtiene del token JWT después del login