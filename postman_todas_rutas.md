# 📡 Todas las Rutas de la API - Formato Postman

> **Base URL:** `http://localhost:8000/api`

---

## 🔐 AUTENTICACIÓN (Públicas)

| Método | Endpoint | Descripción | Body (JSON) |
|--------|----------|--------------|-------------|
| POST | `/register` | Registrar usuario admin | `{"name": "", "email": "", "password": ""}` |
| POST | `/login` | Login usuario admin | `{"email": "", "password": ""}` |
| POST | `/cliente/register` | Registrar cliente | `{"nombre": "", "email": "", "password": ""}` |
| POST | `/cliente/login` | Login cliente | `{"email": "", "password": ""}` |

---

## 👨‍💼 ADMIN - CRUD Completo (Requiere Token)

### 🔹 Hoteles
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/hoteles` | Listar todos los hoteles |
| POST | `/hoteles` | Crear hotel |
| GET | `/hoteles/{id}` | Ver detalle de hotel |
| PUT | `/hoteles/{id}` | Actualizar hotel |
| DELETE | `/hoteles/{id}` | Eliminar hotel |

### 🔹 Usuarios
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/usuarios` | Listar todos los usuarios |
| POST | `/usuarios` | Crear usuario |
| GET | `/usuarios/{id}` | Ver detalle de usuario |
| PUT | `/usuarios/{id}` | Actualizar usuario |
| DELETE | `/usuarios/{id}` | Eliminar usuario |

### 🔹 Productos
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/productos` | Listar todos los productos |
| POST | `/productos` | Crear producto |
| GET | `/productos/{id}` | Ver detalle de producto |
| PUT | `/productos/{id}` | Actualizar producto |
| DELETE | `/productos/{id}` | Eliminar producto |

### 🔹 Tareas
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/tareas` | Listar todas las tareas |
| POST | `/tareas` | Crear tarea |
| GET | `/tareas/{id}` | Ver detalle de tarea |
| PUT | `/tareas/{id}` | Actualizar tarea |
| DELETE | `/tareas/{id}` | Eliminar tarea |

### 🔹 Ciudades
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/ciudades` | Listar todas las ciudades |
| POST | `/ciudades` | Crear ciudad |
| GET | `/ciudades/{id}` | Ver detalle de ciudad |
| PUT | `/ciudades/{id}` | Actualizar ciudad |
| DELETE | `/ciudades/{id}` | Eliminar ciudad |

### 🔹 Clientes
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/clientes` | Listar todos los clientes |
| POST | `/clientes` | Crear cliente |
| GET | `/clientes/{id}` | Ver detalle de cliente |
| PUT | `/clientes/{id}` | Actualizar cliente |
| DELETE | `/clientes/{id}` | Eliminar cliente |

### 🔹 Tipos de Habitación
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/tipo_habitaciones` | Listar todos los tipos |
| POST | `/tipo_habitaciones` | Crear tipo de habitación |
| GET | `/tipo_habitaciones/{id}` | Ver detalle de tipo |
| PUT | `/tipo_habitaciones/{id}` | Actualizar tipo |
| DELETE | `/tipo_habitaciones/{id}` | Eliminar tipo |

### 🔹 Habitaciones
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/habitaciones` | Listar todas las habitaciones |
| POST | `/habitaciones` | Crear habitación |
| GET | `/habitaciones/{id}` | Ver detalle de habitación |
| PUT | `/habitaciones/{id}` | Actualizar habitación |
| DELETE | `/habitaciones/{id}` | Eliminar habitación |

### 🔹 Reservas (Pedidos) - ADMIN
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/reservas` | Listar todos los pedidos |
| POST | `/reservas` | Crear pedido |
| GET | `/reservas/{id}` | Ver detalle de pedido |
| PUT | `/reservas/{id}` | Actualizar/cancelar pedido |
| DELETE | `/reservas/{id}` | Eliminar pedido |

### 🔹 Pagos
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/pagos` | Listar todos los pagos |
| POST | `/pagos` | Crear pago |
| GET | `/pagos/{id}` | Ver detalle de pago |
| PUT | `/pagos/{id}` | Actualizar pago |
| DELETE | `/pagos/{id}` | Eliminar pago |

### 🔹 Gestión de Pedidos de Clientes - ADMIN
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/admin/clientes/{id_cliente}/pedidos` | Historial de pedidos de un cliente |
| GET | `/admin/clientes/{id_cliente}/pedidos/{id_reserva}` | Detalle de pedido específico de cliente |

### 🔹 Cerrar Sesión - ADMIN
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | `/logout` | Cerrar sesión de admin |

---

## 👤 CLIENTE - Endpoints (Requiere Token)

### 🔹 Perfil
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/cliente/profile` | Ver perfil del cliente |
| PUT | `/cliente/profile` | Actualizar perfil |
| PUT | `/cliente/password` | Cambiar contraseña |

### 🔹 Pedidos (Reservas)
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/cliente/pedidos` | Ver historial de mis pedidos |
| POST | `/cliente/pedidos` | Crear nuevo pedido |
| GET | `/cliente/pedidos/{id}` | Ver detalle de mi pedido |
| DELETE | `/cliente/pedidos/{id}` | Cancelar mi pedido |

### 🔹 Cerrar Sesión - CLIENTE
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | `/cliente/logout` | Cerrar sesión de cliente |

---

## 📌 Ejemplo de Uso en Postman

### Headers requeridos para rutas protegidas:
```
Content-Type: application/json
Authorization: Bearer <TOKEN>
```

### Crear Producto (ADMIN):
```
POST http://localhost:8000/api/productos
Headers:
  Content-Type: application/json
  Authorization: Bearer eyJ0eXAiOiJKV1Q...

Body (JSON):
{
  "nombre": "Producto 1",
  "descripcion": "Descripción del producto",
  "precio": 100.00,
  "stock": 50
}
```

### Listar Productos (ADMIN):
```
GET http://localhost:8000/api/productos
Headers:
  Authorization: Bearer <TOKEN>
```

---

## 🔄 Resumen Visual

```
http://localhost:8000/api/
├── /register                    (público)
├── /login                       (público)
├── /cliente/register            (público)
├── /cliente/login               (público)
├── /hoteles                     (admin)
├── /usuarios                    (admin)
├── /productos                   (admin)
├── /tareas                      (admin)
├── /ciudades                    (admin)
├── /clientes                    (admin)
├── /tipo_habitaciones           (admin)
├── /habitaciones                (admin)
├── /reservas                    (admin)
├── /pagos                       (admin)
├── /admin/clientes/{id}/pedidos (admin)
├── /logout                      (admin)
├── /cliente/profile             (cliente)
├── /cliente/password            (cliente)
├── /cliente/pedidos             (cliente)
└── /cliente/logout              (cliente)
```