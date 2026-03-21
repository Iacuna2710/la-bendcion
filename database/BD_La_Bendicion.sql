-- crea la Base de Datos
CREATE DATABASE IF NOT EXISTS la_bendicion
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE la_bendicion;

-- tabla roles
CREATE TABLE roles (
    id_roles    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(50)  NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla users
CREATE TABLE users (
    id_user              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre               VARCHAR(100) NOT NULL,
    email                VARCHAR(150) NOT NULL UNIQUE,
    password             VARCHAR(255) NOT NULL,
    telefono             VARCHAR(20)  NULL,
    identificacion       VARCHAR(30)  NULL,
    is_active            TINYINT(1)   NOT NULL DEFAULT 1,
    password_es_temporal TINYINT(1)   NOT NULL DEFAULT 0,
    email_verified_at    TIMESTAMP    NULL,
    remember_token       VARCHAR(100) NULL,
    deleted_at           TIMESTAMP    NULL,
    created_at           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla user_roles
CREATE TABLE user_roles (
    id_user    INT UNSIGNED NOT NULL,
    id_roles   INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_user, id_roles),
    CONSTRAINT fk_ur_user  FOREIGN KEY (id_user)  REFERENCES users(id_user)  ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ur_roles FOREIGN KEY (id_roles) REFERENCES roles(id_roles) ON DELETE CASCADE ON UPDATE CASCADE
);

-- tabla categorias
CREATE TABLE categorias (
    id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    descripcion  TEXT         NULL,
    slug         VARCHAR(120) NOT NULL UNIQUE,
    imagen       VARCHAR(255) NULL,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla: productos
CREATE TABLE productos (
    id_producto  INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(150)  NOT NULL,
    descripcion  TEXT          NULL,
    precio       DECIMAL(10,2) NOT NULL,
    stock        INT           NOT NULL DEFAULT 0,
    stock_minimo INT           NOT NULL DEFAULT 5,
    sku          VARCHAR(80)   NULL UNIQUE,
    ingredientes TEXT          NULL,
    beneficios   TEXT          NULL,
    es_destacado TINYINT(1)    NOT NULL DEFAULT 0,
    deleted_at   TIMESTAMP     NULL,
    created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla producto_categoria
CREATE TABLE producto_categoria (
    id_producto  INT UNSIGNED NOT NULL,
    id_categoria INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_producto, id_categoria),
    CONSTRAINT fk_pc_producto  FOREIGN KEY (id_producto)  REFERENCES productos(id_producto)   ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pc_categoria FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE ON UPDATE CASCADE
);

-- tabla imagenes_productos
CREATE TABLE imagenes_productos (
    id_img_prod  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_producto  INT UNSIGNED NOT NULL,
    url          VARCHAR(255) NOT NULL,
    alt_text     VARCHAR(150) NULL,
    orden        INT          NOT NULL DEFAULT 0,
    es_principal TINYINT(1)   NOT NULL DEFAULT 0,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ip_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE ON UPDATE CASCADE
);


-- tabla provincias
CREATE TABLE provincias (
    id_provincia INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla cantones
CREATE TABLE cantones (
    id_canton    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_provincia INT UNSIGNED NOT NULL,
    nombre       VARCHAR(100) NOT NULL,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ca_provincia FOREIGN KEY (id_provincia) REFERENCES provincias(id_provincia) ON DELETE CASCADE ON UPDATE CASCADE
);


-- tabla distritos
CREATE TABLE distritos (
    id_distrito INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_canton   INT UNSIGNED NOT NULL,
    nombre      VARCHAR(100) NOT NULL,
    is_active   TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_di_canton FOREIGN KEY (id_canton) REFERENCES cantones(id_canton) ON DELETE CASCADE ON UPDATE CASCADE
);

-- tabla direcciones
CREATE TABLE direcciones (
    id_direccion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user      INT UNSIGNED NOT NULL,
    id_distrito  INT UNSIGNED NOT NULL,
    es_principal TINYINT(1)   NOT NULL DEFAULT 0,
    detalle      TEXT         NOT NULL,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_dir_user     FOREIGN KEY (id_user)     REFERENCES users(id_user)         ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_dir_distrito FOREIGN KEY (id_distrito) REFERENCES distritos(id_distrito) ON UPDATE CASCADE
);

-- tabla metodos_pago
CREATE TABLE metodos_pago (
    id_met_pago INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(80)  NOT NULL,
    descripcion TEXT         NULL,
    is_active   TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla estados_pedido
CREATE TABLE estados_pedido (
    id_estado_ped INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(80)  NOT NULL,
    color         VARCHAR(20)  NOT NULL DEFAULT '#6c757d',
    orden         INT          NOT NULL DEFAULT 0,
    is_active     TINYINT(1)   NOT NULL DEFAULT 1,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tabla carritos
CREATE TABLE carritos (
    id_carrito INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_user    INT UNSIGNED  NOT NULL UNIQUE,
    descuento  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    subtotal   DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_car_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);


-- tabla cart_items
CREATE TABLE cart_items (
    id_c_item       INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_carrito      INT UNSIGNED  NOT NULL,
    id_producto     INT UNSIGNED  NOT NULL,
    cantidad        INT           NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal        DECIMAL(10,2) NOT NULL,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ci_carrito  FOREIGN KEY (id_carrito)  REFERENCES carritos(id_carrito)   ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ci_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON UPDATE CASCADE
);


-- tabla pedidos
CREATE TABLE pedidos (
    id_pedido              INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_estado_ped          INT UNSIGNED  NOT NULL,
    id_user                INT UNSIGNED  NOT NULL,
    id_direccion           INT UNSIGNED  NOT NULL,
    num_pedido             VARCHAR(30)   NOT NULL UNIQUE,
    subtotal               DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descuento              DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    impuesto               DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    costo_envio            DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total                  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    notas                  TEXT          NULL,
    fecha_entrega_esperada DATE          NULL,
    fecha_entrega_real     DATE          NULL,
    deleted_at             TIMESTAMP     NULL,
    created_at             TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at             TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ped_estado    FOREIGN KEY (id_estado_ped) REFERENCES estados_pedido(id_estado_ped) ON UPDATE CASCADE,
    CONSTRAINT fk_ped_user      FOREIGN KEY (id_user)       REFERENCES users(id_user)                ON UPDATE CASCADE,
    CONSTRAINT fk_ped_direccion FOREIGN KEY (id_direccion)  REFERENCES direcciones(id_direccion)     ON UPDATE CASCADE
);

-- tabla pedido_items
CREATE TABLE pedido_items (
    id_ped_item     INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_pedido       INT UNSIGNED  NOT NULL,
    id_producto     INT UNSIGNED  NOT NULL,
    cantidad        INT           NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal        DECIMAL(10,2) NOT NULL,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pi_pedido   FOREIGN KEY (id_pedido)   REFERENCES pedidos(id_pedido)     ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pi_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON UPDATE CASCADE
);

-- tabla pagos
CREATE TABLE pagos (
    id_pago             INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_met_pago         INT UNSIGNED  NOT NULL,
    id_pedido           INT UNSIGNED  NOT NULL,
    monto               DECIMAL(10,2) NOT NULL,
    estado              VARCHAR(50)   NOT NULL DEFAULT 'pendiente',
    referencia          VARCHAR(150)  NULL,
    detalles            TEXT          NULL,
    fecha_procesamiento TIMESTAMP     NULL,
    created_at          TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pag_metodo FOREIGN KEY (id_met_pago) REFERENCES metodos_pago(id_met_pago) ON UPDATE CASCADE,
    CONSTRAINT fk_pag_pedido FOREIGN KEY (id_pedido)   REFERENCES pedidos(id_pedido)        ON UPDATE CASCADE
);

-- tabla facturas
CREATE TABLE facturas (
    id_factura     INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_pedido      INT UNSIGNED  NOT NULL UNIQUE,
    numero_factura VARCHAR(30)   NOT NULL UNIQUE,
    fecha_emision  DATE          NOT NULL,
    subtotal       DECIMAL(10,2) NOT NULL,
    impuesto       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total          DECIMAL(10,2) NOT NULL,
    estado_factura VARCHAR(50)   NOT NULL DEFAULT 'emitida',
    observaciones  TEXT          NULL,
    deleted_at     TIMESTAMP     NULL,
    created_at     TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fac_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON UPDATE CASCADE
);


-- tabla factura_items
CREATE TABLE factura_items (
    id_fac_item     INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    id_factura      INT UNSIGNED  NOT NULL,
    id_producto     INT UNSIGNED  NOT NULL,
    cantidad        INT           NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal        DECIMAL(10,2) NOT NULL,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fi_factura  FOREIGN KEY (id_factura)  REFERENCES facturas(id_factura)   ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_fi_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON UPDATE CASCADE
);

-- Carga de datos
-- Roles
INSERT INTO roles (nombre, descripcion) VALUES
('admin',      'Administrador con control total del sistema'),
('trabajador', 'Empleado interno con acceso a gestión operativa'),
('cliente',    'Usuario registrado que realiza compras');

-- Estados de pedido
INSERT INTO estados_pedido (nombre, color, orden) VALUES
('Pendiente',  '#ffc107', 1),
('En proceso', '#17a2b8', 2),
('Enviado',    '#007bff', 3),
('Entregado',  '#28a745', 4),
('Cancelado',  '#dc3545', 5);

-- Métodos de pago
INSERT INTO metodos_pago (nombre, descripcion) VALUES
('Transferencia SINPE',  'Pago mediante SINPE Móvil'),
('Depósito bancario',    'Depósito en cuenta bancaria'),
('Efectivo al entregar', 'Pago en efectivo al momento de la entrega');

INSERT INTO metodos_pago (nombre, descripcion) VALUES ('Tarjeta Debito/Credito ', 'Pago en Tarjeta de Debito o Credito' );

-- Provincias de Costa Rica
INSERT INTO provincias (nombre) VALUES
('San José'),
('Alajuela'),
('Cartago'),
('Heredia'),
('Guanacaste'),
('Puntarenas'),
('Limón');

-- Cantones de San José
INSERT INTO cantones (id_provincia, nombre) VALUES
(1, 'San José'),(1, 'Escazú'),(1, 'Desamparados'),(1, 'Puriscal'),
(1, 'Tarrazú'),(1, 'Aserrí'),(1, 'Mora'),(1, 'Goicoechea'),
(1, 'Santa Ana'),(1, 'Alajuelita'),(1, 'Vásquez de Coronado'),
(1, 'Acosta'),(1, 'Tibás'),(1, 'Moravia'),(1, 'Montes de Oca'),
(1, 'Turrubares'),(1, 'Dota'),(1, 'Curridabat'),
(1, 'Pérez Zeledón'),(1, 'León Cortés Castro');

-- Cantones de Alajuela
INSERT INTO cantones (id_provincia, nombre) VALUES
(2, 'Alajuela'),(2, 'San Ramón'),(2, 'Grecia'),(2, 'San Mateo'),
(2, 'Atenas'),(2, 'Naranjo'),(2, 'Palmares'),(2, 'Poás'),
(2, 'Orotina'),(2, 'San Carlos'),(2, 'Zarcero'),(2, 'Sarchí'),
(2, 'Upala'),(2, 'Los Chiles'),(2, 'Guatuso'),(2, 'Río Cuarto');

-- Cantones de Cartago
INSERT INTO cantones (id_provincia, nombre) VALUES
(3, 'Cartago'),(3, 'Paraíso'),(3, 'La Unión'),(3, 'Jiménez'),
(3, 'Turrialba'),(3, 'Alvarado'),(3, 'Oreamuno'),(3, 'El Guarco');

-- Cantones de Heredia
INSERT INTO cantones (id_provincia, nombre) VALUES
(4, 'Heredia'),(4, 'Barva'),(4, 'Santo Domingo'),(4, 'Santa Bárbara'),
(4, 'San Rafael'),(4, 'San Isidro'),(4, 'Belén'),(4, 'Flores'),
(4, 'San Pablo'),(4, 'Sarapiquí');

-- Cantones de Guanacaste
INSERT INTO cantones (id_provincia, nombre) VALUES
(5, 'Liberia'),(5, 'Nicoya'),(5, 'Santa Cruz'),(5, 'Bagaces'),
(5, 'Carrillo'),(5, 'Cañas'),(5, 'Abangares'),(5, 'Tilarán'),
(5, 'Nandayure'),(5, 'La Cruz'),(5, 'Hojancha');

-- Cantones de Puntarenas
INSERT INTO cantones (id_provincia, nombre) VALUES
(6, 'Puntarenas'),(6, 'Esparza'),(6, 'Buenos Aires'),(6, 'Montes de Oro'),
(6, 'Osa'),(6, 'Quepos'),(6, 'Golfito'),(6, 'Coto Brus'),
(6, 'Parrita'),(6, 'Corredores'),(6, 'Garabito');

-- Cantones de Limón
INSERT INTO cantones (id_provincia, nombre) VALUES
(7, 'Limón'),(7, 'Pococí'),(7, 'Siquirres'),
(7, 'Talamanca'),(7, 'Matina'),(7, 'Guácimo');

-- Distritos de San José (cantón 1)
INSERT INTO distritos (id_canton, nombre) VALUES
(1, 'Carmen'),(1, 'Merced'),(1, 'Hospital'),(1, 'Catedral'),
(1, 'Zapote'),(1, 'San Francisco de Dos Ríos'),(1, 'Uruca'),
(1, 'Mata Redonda'),(1, 'Pavas'),(1, 'Hatillo'),(1, 'San Sebastián');

-- Distritos de Escazú (cantón 2)
INSERT INTO distritos (id_canton, nombre) VALUES
(2, 'Escazú'),(2, 'San Antonio'),(2, 'San Rafael');

-- Distritos de Desamparados (cantón 3)
INSERT INTO distritos (id_canton, nombre) VALUES
(3, 'Desamparados'),(3, 'San Miguel'),(3, 'San Juan de Dios'),
(3, 'San Rafael Arriba'),(3, 'San Antonio'),(3, 'Frailes'),
(3, 'Patarrá'),(3, 'San Cristóbal'),(3, 'Rosario'),
(3, 'Damas'),(3, 'San Rafael Abajo'),(3, 'Gravilias'),(3, 'Los Guido');

-- Distritos de Alajuela (cantón 21)
INSERT INTO distritos (id_canton, nombre) VALUES
(21, 'Alajuela'),(21, 'San José'),(21, 'Carrizal'),(21, 'San Antonio'),
(21, 'Guácima'),(21, 'San Isidro'),(21, 'Sabanilla'),(21, 'San Rafael'),
(21, 'Río Segundo'),(21, 'Desamparados'),(21, 'Turrúcares'),
(21, 'Tambor'),(21, 'La Garita'),(21, 'Sarapiquí');

-- Distritos de Cartago (cantón 29)
INSERT INTO distritos (id_canton, nombre) VALUES
(29, 'Oriental'),(29, 'Occidental'),(29, 'Carmen'),(29, 'San Nicolás'),
(29, 'Aguacaliente'),(29, 'Guadalupe'),(29, 'Corralillo'),
(29, 'Tierra Blanca'),(29, 'Dulce Nombre'),(29, 'Llano Grande'),
(29, 'Quebradilla');

-- Distritos de Heredia (cantón 37)
INSERT INTO distritos (id_canton, nombre) VALUES
(37, 'Heredia'),(37, 'Mercedes'),(37, 'San Francisco'),
(37, 'Ulloa'),(37, 'Varablanca');

-- Distritos de Liberia (cantón 45)
INSERT INTO distritos (id_canton, nombre) VALUES
(45, 'Liberia'),(45, 'Cañas Dulces'),(45, 'Mayorga'),
(45, 'Nacascolo'),(45, 'Curubandé');

-- Distritos de Puntarenas (cantón 56)
INSERT INTO distritos (id_canton, nombre) VALUES
(56, 'Puntarenas'),(56, 'Pitahaya'),(56, 'Chomes'),
(56, 'Lepanto'),(56, 'Paquera'),(56, 'Manzanillo'),
(56, 'Guacimal'),(56, 'Barranca'),(56, 'Monte Verde'),
(56, 'Isla del Coco'),(56, 'Cóbano'),(56, 'Chacarita'),
(56, 'Chira'),(56, 'Acapulco'),(56, 'El Roble'),(56, 'Arancibia');

-- Distritos de Limón (cantón 67)
INSERT INTO distritos (id_canton, nombre) VALUES
(67, 'Limón'),(67, 'Valle La Estrella'),(67, 'Río Blanco'),
(67, 'Matama');

-- USUARIO ADMINISTRADOR POR DEFECTO
-- Contraseña: Admin1234!
INSERT INTO users (nombre, email, password, is_active, email_verified_at) VALUES
('Administrador', 'admin@labendicion.cr',
'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
1, NOW());

INSERT INTO user_roles (id_user, id_roles) VALUES (1, 1);

SELECT * FROM roles;
SELECT * FROM estados_pedido;
SELECT * FROM metodos_pago;
SELECT * FROM provincias;
SELECT * FROM users;

-- ============================================================
-- SP 1: sp_agregar_al_carrito
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_agregar_al_carrito(
    IN p_id_user     INT UNSIGNED,
    IN p_id_producto INT UNSIGNED,
    IN p_cantidad    INT
)
BEGIN
    DECLARE v_id_carrito      INT UNSIGNED;
    DECLARE v_id_c_item       INT UNSIGNED;
    DECLARE v_precio          DECIMAL(10,2);
    DECLARE v_cantidad_actual INT;

    -- Obtener o crear el carrito del usuario
    SELECT id_carrito INTO v_id_carrito
    FROM carritos
    WHERE id_user = p_id_user
    LIMIT 1;

    IF v_id_carrito IS NULL THEN
        INSERT INTO carritos (id_user, descuento, subtotal, total, created_at, updated_at)
        VALUES (p_id_user, 0, 0, 0, NOW(), NOW());
        SET v_id_carrito = LAST_INSERT_ID();
    END IF;

    -- Obtener precio actual del producto
    SELECT precio INTO v_precio
    FROM productos
    WHERE id_producto = p_id_producto
    AND deleted_at IS NULL;

    -- Verificar si el producto ya está en el carrito
    SELECT id_c_item, cantidad INTO v_id_c_item, v_cantidad_actual
    FROM cart_items
    WHERE id_carrito = v_id_carrito
    AND id_producto  = p_id_producto
    LIMIT 1;

    IF v_id_c_item IS NOT NULL THEN
        -- Producto ya existe, actualizar cantidad y subtotal
        UPDATE cart_items
        SET cantidad   = v_cantidad_actual + p_cantidad,
            subtotal   = (v_cantidad_actual + p_cantidad) * v_precio,
            updated_at = NOW()
        WHERE id_c_item = v_id_c_item;
    ELSE
        -- Producto nuevo, insertar en el carrito
        INSERT INTO cart_items (
            id_carrito, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            v_id_carrito, p_id_producto, p_cantidad,
            v_precio, p_cantidad * v_precio, NOW(), NOW()
        );
    END IF;

    -- Recalcular subtotal y total del carrito
    UPDATE carritos
    SET subtotal   = (SELECT COALESCE(SUM(subtotal), 0)
                      FROM cart_items
                      WHERE id_carrito = v_id_carrito),
        total      = (SELECT COALESCE(SUM(subtotal), 0)
                      FROM cart_items
                      WHERE id_carrito = v_id_carrito) - descuento,
        updated_at = NOW()
    WHERE id_carrito = v_id_carrito;

END$$

DELIMITER ;


-- ============================================================
-- SP 2: sp_vaciar_carrito
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_vaciar_carrito(
    IN p_id_carrito INT UNSIGNED
)
BEGIN
    -- Eliminar todos los ítems del carrito
    DELETE FROM cart_items
    WHERE id_carrito = p_id_carrito;

    -- Resetear totales a cero
    UPDATE carritos
    SET subtotal   = 0,
        descuento  = 0,
        total      = 0,
        updated_at = NOW()
    WHERE id_carrito = p_id_carrito;

END$$

DELIMITER ;


-- ============================================================
-- SP 3: sp_confirmar_pedido
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_confirmar_pedido(
    IN  p_id_user      INT UNSIGNED,
    IN  p_id_direccion INT UNSIGNED,
    IN  p_id_met_pago  INT UNSIGNED,
    OUT p_id_pedido    INT UNSIGNED,
    OUT p_num_pedido   VARCHAR(30)
)
BEGIN
    DECLARE v_id_carrito    INT UNSIGNED;
    DECLARE v_subtotal      DECIMAL(10,2);
    DECLARE v_impuesto      DECIMAL(10,2);
    DECLARE v_total         DECIMAL(10,2);
    DECLARE v_id_estado     INT UNSIGNED;
    DECLARE v_fecha         VARCHAR(8);
    DECLARE v_prefijo       VARCHAR(15);
    DECLARE v_ultimo        VARCHAR(30);
    DECLARE v_secuencia     INT;
    DECLARE v_id_producto   INT UNSIGNED;
    DECLARE v_cantidad      INT;
    DECLARE v_precio        DECIMAL(10,2);
    DECLARE v_item_subtotal DECIMAL(10,2);
    DECLARE done            INT DEFAULT 0;

    DECLARE cur_items CURSOR FOR
        SELECT ci.id_producto, ci.cantidad, ci.precio_unitario, ci.subtotal
        FROM cart_items ci
        INNER JOIN carritos c ON c.id_carrito = ci.id_carrito
        WHERE c.id_user = p_id_user;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    START TRANSACTION;

    -- Obtener el carrito del usuario
    SELECT id_carrito, subtotal INTO v_id_carrito, v_subtotal
    FROM carritos
    WHERE id_user = p_id_user
    LIMIT 1;

    -- Calcular impuesto 13% IVA Costa Rica y total
    SET v_impuesto = ROUND(v_subtotal * 0.13, 2);
    SET v_total    = v_subtotal + v_impuesto;

    -- Obtener estado inicial Pendiente
    SELECT id_estado_ped INTO v_id_estado
    FROM estados_pedido
    WHERE nombre = 'Pendiente'
    LIMIT 1;

    -- Generar número de pedido PED-YYYYMMDD-XXXX
    SET v_fecha   = DATE_FORMAT(NOW(), '%Y%m%d');
    SET v_prefijo = CONCAT('PED-', v_fecha, '-');

    SELECT num_pedido INTO v_ultimo
    FROM pedidos
    WHERE num_pedido LIKE CONCAT(v_prefijo, '%')
    ORDER BY num_pedido DESC
    LIMIT 1;

    IF v_ultimo IS NULL THEN
        SET v_secuencia = 1;
    ELSE
        SET v_secuencia = CAST(SUBSTRING(v_ultimo, -4) AS UNSIGNED) + 1;
    END IF;

    SET p_num_pedido = CONCAT(v_prefijo, LPAD(v_secuencia, 4, '0'));

    -- Crear el pedido
    INSERT INTO pedidos (
        id_estado_ped, id_user, id_direccion, num_pedido,
        subtotal, descuento, impuesto, costo_envio, total,
        created_at, updated_at
    )
    VALUES (
        v_id_estado, p_id_user, p_id_direccion, p_num_pedido,
        v_subtotal, 0, v_impuesto, 0, v_total,
        NOW(), NOW()
    );

    SET p_id_pedido = LAST_INSERT_ID();

    -- Recorrer ítems del carrito e insertarlos en pedido_items
    OPEN cur_items;
    loop_items: LOOP
        FETCH cur_items INTO v_id_producto, v_cantidad, v_precio, v_item_subtotal;
        IF done THEN
            LEAVE loop_items;
        END IF;

        -- Insertar ítem en pedido_items
        INSERT INTO pedido_items (
            id_pedido, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            p_id_pedido, v_id_producto, v_cantidad,
            v_precio, v_item_subtotal, NOW(), NOW()
        );

        -- Descontar stock
        UPDATE productos
        SET stock      = stock - v_cantidad,
            updated_at = NOW()
        WHERE id_producto = v_id_producto;

    END LOOP loop_items;
    CLOSE cur_items;

    -- Registrar pago inicial en estado pendiente
    INSERT INTO pagos (
        id_met_pago, id_pedido, monto,
        estado, created_at, updated_at
    )
    VALUES (
        p_id_met_pago, p_id_pedido, v_total,
        'pendiente', NOW(), NOW()
    );

    -- Vaciar el carrito
    CALL sp_vaciar_carrito(v_id_carrito);

    COMMIT;

END$$

DELIMITER ;


-- ============================================================
-- SP 4: sp_cambiar_estado_pedido
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_cambiar_estado_pedido(
    IN p_id_pedido INT UNSIGNED,
    IN p_id_estado INT UNSIGNED
)
BEGIN
    DECLARE v_nombre_estado VARCHAR(80);

    -- Obtener nombre del nuevo estado
    SELECT nombre INTO v_nombre_estado
    FROM estados_pedido
    WHERE id_estado_ped = p_id_estado
    LIMIT 1;

    -- Si es Entregado registrar fecha real
    IF v_nombre_estado = 'Entregado' THEN
        UPDATE pedidos
        SET id_estado_ped      = p_id_estado,
            fecha_entrega_real = CURDATE(),
            updated_at         = NOW()
        WHERE id_pedido    = p_id_pedido
        AND   deleted_at   IS NULL;
    ELSE
        UPDATE pedidos
        SET id_estado_ped = p_id_estado,
            updated_at    = NOW()
        WHERE id_pedido  = p_id_pedido
        AND   deleted_at IS NULL;
    END IF;

END$$

DELIMITER ;


-- ============================================================
-- SP 5: sp_generar_factura
-- ============================================================
DELIMITER $$

CREATE PROCEDURE sp_generar_factura(
    IN  p_id_pedido  INT UNSIGNED,
    OUT p_id_factura INT UNSIGNED
)
BEGIN
    DECLARE v_subtotal      DECIMAL(10,2);
    DECLARE v_impuesto      DECIMAL(10,2);
    DECLARE v_total         DECIMAL(10,2);
    DECLARE v_fecha         VARCHAR(8);
    DECLARE v_prefijo       VARCHAR(15);
    DECLARE v_ultimo        VARCHAR(30);
    DECLARE v_secuencia     INT;
    DECLARE v_num_factura   VARCHAR(30);
    DECLARE v_id_producto   INT UNSIGNED;
    DECLARE v_cantidad      INT;
    DECLARE v_precio        DECIMAL(10,2);
    DECLARE v_item_subtotal DECIMAL(10,2);
    DECLARE done            INT DEFAULT 0;

    DECLARE cur_items CURSOR FOR
        SELECT id_producto, cantidad, precio_unitario, subtotal
        FROM pedido_items
        WHERE id_pedido = p_id_pedido;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Obtener totales del pedido
    SELECT subtotal, impuesto, total
    INTO v_subtotal, v_impuesto, v_total
    FROM pedidos
    WHERE id_pedido  = p_id_pedido
    AND   deleted_at IS NULL;

    -- Generar número de factura FAC-YYYYMMDD-XXXX
    SET v_fecha   = DATE_FORMAT(NOW(), '%Y%m%d');
    SET v_prefijo = CONCAT('FAC-', v_fecha, '-');

    SELECT numero_factura INTO v_ultimo
    FROM facturas
    WHERE numero_factura LIKE CONCAT(v_prefijo, '%')
    ORDER BY numero_factura DESC
    LIMIT 1;

    IF v_ultimo IS NULL THEN
        SET v_secuencia = 1;
    ELSE
        SET v_secuencia = CAST(SUBSTRING(v_ultimo, -4) AS UNSIGNED) + 1;
    END IF;

    SET v_num_factura = CONCAT(v_prefijo, LPAD(v_secuencia, 4, '0'));

    -- Crear la factura
    INSERT INTO facturas (
        id_pedido, numero_factura, fecha_emision,
        subtotal, impuesto, total,
        estado_factura, created_at, updated_at
    )
    VALUES (
        p_id_pedido, v_num_factura, CURDATE(),
        v_subtotal, v_impuesto, v_total,
        'emitida', NOW(), NOW()
    );

    SET p_id_factura = LAST_INSERT_ID();

    -- Insertar ítems de la factura desde pedido_items
    OPEN cur_items;
    loop_items: LOOP
        FETCH cur_items INTO v_id_producto, v_cantidad, v_precio, v_item_subtotal;
        IF done THEN
            LEAVE loop_items;
        END IF;

        INSERT INTO factura_items (
            id_factura, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            p_id_factura, v_id_producto, v_cantidad,
            v_precio, v_item_subtotal, NOW(), NOW()
        );

    END LOOP loop_items;
    CLOSE cur_items;

END$$

DELIMITER ;