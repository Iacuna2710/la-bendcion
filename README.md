# 🌿 La Bendición 

Plataforma web de comercialización de productos macrobióticos desarrollada con Laravel 12, Bootstrap 5 y MySQL.

---

## 🛠️ Tecnologías

| Tecnología | Versión |
|---|---|
| PHP | 8.2.12 |
| Laravel | 12.53.0 |
| Laravel Breeze | 2.3.8 |
| MySQL | 8.x (XAMPP) |
| Bootstrap | 5.3.3 |
| Node.js | 24.14.0 |
| NPM | 11.9.0 |

---

## ⚙️ Requisitos previos

- PHP 8.2 o superior
- Composer 2.x
- Node.js 18.x o superior
- XAMPP (Apache + MySQL)
- Git

---

## 🚀 Instalación

**1. Clonar el repositorio**
```bash
git clone https://github.com/usuario/la-bendicion.git
cd la-bendicion
```

**2. Instalar dependencias PHP**
```bash
composer install
```

**3. Instalar dependencias JavaScript**
```bash
npm install
```

**4. Configurar el archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configurar la base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=la_bendicion
DB_USERNAME=root
DB_PASSWORD=
```

**6. Configurar correo en .env (Mailtrap)**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=df49bcd264a3bd
MAIL_PASSWORD=653cc3e4fba699
MAIL_FROM_ADDRESS="noreply@labendicion.cr"
MAIL_FROM_NAME="La Bendición"
```

**7. Crear la base de datos en MySQL**

Abrir MySQL Workbench y ejecutar el script `database/la_bendicion.sql` que incluye todas las tablas, relaciones, procedimientos almacenados y datos iniciales.

**8. Crear el enlace de almacenamiento**
```bash
php artisan storage:link
```

**9. Instalar traducciones en español**
```bash
composer require laravel-lang/common --dev
php artisan lang:publish
```

**10. Compilar assets y levantar el servidor**
```bash
npm run dev
php artisan serve
```

Abrir el navegador en: `http://127.0.0.1:8000`

---

## 🗄️ Base de datos

La base de datos `la_bendicion` contiene 20 tablas con sus relaciones y 5 procedimientos almacenados:

| Procedimiento | Descripción |
|---|---|
| sp_agregar_al_carrito | Agrega o actualiza un producto en el carrito |
| sp_vaciar_carrito | Vacía todos los ítems del carrito |
| sp_confirmar_pedido | Crea el pedido, descuenta stock y vacía el carrito |
| sp_cambiar_estado_pedido | Actualiza el estado del pedido |
| sp_generar_factura | Genera la factura automáticamente al confirmar el pago |

---

## 👥 Usuarios del sistema

| Usuario | Correo | Contraseña | Rol |
|---|---|---|---|
| Administrador | admin@labendicion.cr | Admin1234! | admin |
| Juan Perez | juan.perez22@outlook.com | Juan2026! | cliente |
| Daniel Valverde | daniel.valverde@labendicion.cr | Daniel2026! | trabajador |
| Fabricio Quesada | fabricio.quesada@labendicion.cr | Fabricio2026! | trabajador |
| Pablo Zuniga | pablo.zuniga@labendicion.cr | Pablo2026! | trabajador |
| Isaac Acuna | isaac.acuna@labendicion.cr | Isaac2026! | trabajador |
| Marcelo Quevedo | marcelo.quevedo@labendicion.cr | Marcelo2026! | trabajador |

---

## 🏗️ Arquitectura

El proyecto sigue el patrón **MVC (Modelo-Vista-Controlador)** de Laravel:

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controladores del panel admin
│   │   ├── Auth/           # Controladores de autenticación
│   │   ├── CarritoController.php
│   │   ├── CatalogoController.php
│   │   ├── DireccionController.php
│   │   ├── FacturaController.php
│   │   └── PedidoController.php
│   └── Middleware/
│       └── CheckRole.php   # Middleware de roles personalizado
├── Mail/
│   ├── CambioEstadoPedidoMail.php
│   └── PasswordTemporalMail.php
└── Models/                 # 18 modelos Eloquent
resources/views/            # Vistas Blade con Bootstrap 5
routes/
└── web.php                 # Rutas organizadas por roles
```

---

## 🔐 Roles y permisos

| Rol | Acceso |
|---|---|
| **Visitante** | Catálogo público y detalle de productos |
| **Cliente** | Carrito, pedidos, direcciones y facturas |
| **Trabajador** | Panel admin: productos, categorías y pedidos |
| **Administrador** | Control total: usuarios, roles, métodos de pago y todo lo anterior |

---

## 📧 Notificaciones por correo

El sistema envía correos automáticos en dos situaciones:

- **Contraseña temporal:** cuando un usuario solicita recuperar su contraseña
- **Cambio de estado de pedido:** cuando el admin actualiza el estado de un pedido

Los correos se prueban con **Mailtrap** en el entorno de desarrollo.

---

## 📁 Estructura del proyecto

```
la-bendicion/
├── app/
├── bootstrap/
├── config/
├── database/
│   └── la_bendicion.sql    # Script completo de la base de datos
├── public/
├── resources/
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php
├── storage/
└── .env.example
```

---

## 👨‍💻 Equipo de desarrollo

Pablo Andrés Castillo Zuñiga
Marcelo Quevedo Ramírez
Erick Daniel Valverde Durán
Fabricio José Quesada Araya
Isaac Gilberto Acuña León

Proyecto Ambiente Web - Universidad Fidelitas
Plataforma web para La Bendición, tienda de productos macrobióticos en Costa Rica.
