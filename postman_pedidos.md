# 📡 Consultas Postman - API de Pedidos (Reservas)

> **Base URL:** `http://localhost:8000/api`

---

## 🔐 PRIMERO: Autenticación

### Login ADMIN
```
POST http://localhost:8000/api/login
Content-Type: application/json

{
    "email": "admin@hotel.com",
    "password": "password123"
}
```

### Login CLIENTE
```
POST http://localhost:8000/api/cliente/login
Content-Type: application/json

{
    "email": "cliente@ejemplo.com",
    "password": "password123"
}
```

> **Nota:** Guardar el token que devuelve en el header `Authorization: Bearer <TOKEN>`

---

# 👨‍💼 ADMIN - Pedidos

## 1. Listar todos los pedidos
```
GET http://localhost:8000/api/reservas
Authorization: Bearer <TOKEN_ADMIN>
```

## 2. Ver detalle de un pedido por id
```
GET http://localhost:8000/api/reservas/{id}
Authorization: Bearer <TOKEN_ADMIN>
```

## 3. Cancelar pedido por id
```
PUT http://localhost:8000/api/reservas/{id}
Authorization: Bearer <TOKEN_ADMIN>
Content-Type: application/json

{
    "estado": "cancelado"
}
```

## 4. Ver historial de pedidos de un cliente
```
GET http://localhost:8000/api/admin/clientes/{id_cliente}/pedidos
Authorization: Bearer <TOKEN_ADMIN>
```

## 5. Ver detalle de pedido de un cliente
```
GET http://localhost:8000/api/admin/clientes/{id_cliente}/pedidos/{id_reserva}
Authorization: Bearer <TOKEN_ADMIN>
```

---

# 👤 CLIENTE - Mis Pedidos

## 1. Crear pedido
```
POST http://localhost:8000/api/cliente/pedidos
Authorization: Bearer <TOKEN_CLIENTE>
Content-Type: application/json

{
    "id_habitacion": 1,
    "fecha_inicio": "2026-05-01",
    "fecha_fin": "2026-05-05"
}
```

## 2. Cancelar pedido
```
DELETE http://localhost:8000/api/cliente/pedidos/{id}
Authorization: Bearer <TOKEN_CLIENTE>
```

## 3. Ver historial de pedidos
```
GET http://localhost:8000/api/cliente/pedidos
Authorization: Bearer <TOKEN_CLIENTE>
```

## 4. Ver detalle de pedido
```
GET http://localhost:8000/api/cliente/pedidos/{id}
Authorization: Bearer <TOKEN_CLIENTE>
```

---

## 📌 Headers para todas las peticiones protegidas

| Header | Valor |
|--------|-------|
| Content-Type | application/json |
| Authorization | Bearer <TOKEN> |