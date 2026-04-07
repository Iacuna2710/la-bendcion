-- ============================================================
-- PROCEDIMIENTOS ALMACENADOS NUEVOS — SEMANA 15
-- Proyecto: La Bendición — Plataforma Macrobiótica
-- Ejecutar en MySQL Workbench sobre la base de datos la_bendicion
-- ============================================================

USE la_bendicion;


-- ============================================================
-- SP 6: sp_buscar_productos
--
-- Reemplaza los filtros inline de CatalogoController::catalogo().
-- Parametros de entrada:
--   p_busqueda       → texto libre; filtra por nombre o descripción
--   p_categoria_slug → slug de categoría; filtra por categoría activa
--   p_limite         → cantidad de filas por página (LIMIT)
--   p_offset         → desplazamiento de página (OFFSET)
-- Parámetro de salida:
--   p_total          → total de registros que coinciden (para LengthAwarePaginator)
-- Devuelve: productos activos con stock > 0 + URL imagen principal
-- ============================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_buscar_productos$$

CREATE PROCEDURE sp_buscar_productos(
    IN  p_busqueda       VARCHAR(200),
    IN  p_categoria_slug VARCHAR(150),
    IN  p_limite         INT,
    IN  p_offset         INT,
    OUT p_total          INT
)
BEGIN

    -- ── 1. Contar total de registros coincidentes (para el paginador) ──────
    SELECT COUNT(DISTINCT p.id_producto) INTO p_total
    FROM productos p
    LEFT JOIN producto_categoria pc ON pc.id_producto  = p.id_producto
    LEFT JOIN categorias          c  ON c.id_categoria  = pc.id_categoria
    WHERE p.deleted_at IS NULL
      AND p.stock > 0
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre      LIKE CONCAT('%', p_busqueda, '%')
            OR p.descripcion LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (
            p_categoria_slug IS NULL OR p_categoria_slug = ''
            OR (c.slug = p_categoria_slug AND c.is_active = 1)
          );

    -- ── 2. Devolver página de resultados con imagen principal ─────────────
    SELECT
        p.id_producto,
        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.sku,
        p.es_destacado,
        p.created_at,
        img.url      AS imagen_url,
        img.alt_text AS imagen_alt
    FROM productos p
    LEFT JOIN producto_categoria pc  ON pc.id_producto  = p.id_producto
    LEFT JOIN categorias          c  ON c.id_categoria  = pc.id_categoria
    LEFT JOIN imagenes_productos  img ON img.id_producto = p.id_producto
                                     AND img.es_principal = 1
    WHERE p.deleted_at IS NULL
      AND p.stock > 0
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre      LIKE CONCAT('%', p_busqueda, '%')
            OR p.descripcion LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (
            p_categoria_slug IS NULL OR p_categoria_slug = ''
            OR (c.slug = p_categoria_slug AND c.is_active = 1)
          )
    GROUP BY p.id_producto
    ORDER BY p.nombre
    LIMIT  p_limite
    OFFSET p_offset;

END$$

DELIMITER ;


-- ============================================================
-- SP 7: sp_obtener_dashboard
--
-- Reemplaza las 6 consultas Eloquent separadas de DashboardController.
-- Sin parámetros de entrada.
-- Devuelve: una fila con todos los KPIs del panel administrativo.
--
--   total_usuarios  → usuarios activos (is_active = 1, no eliminados)
--   total_productos → productos sin soft-delete
--   total_categorias → categorías activas
--   total_pedidos   → todos los pedidos no eliminados
--   pedidos_hoy     → pedidos creados el día de hoy
--   ingresos_mes    → suma de totales del mes en curso
-- ============================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_obtener_dashboard$$

CREATE PROCEDURE sp_obtener_dashboard()
BEGIN

    SELECT
        -- Usuarios activos (sin soft-delete)
        (SELECT COUNT(*)
         FROM users
         WHERE is_active  = 1
           AND deleted_at IS NULL)                                           AS total_usuarios,

        -- Productos activos (sin soft-delete)
        (SELECT COUNT(*)
         FROM productos
         WHERE deleted_at IS NULL)                                          AS total_productos,

        -- Categorías activas
        (SELECT COUNT(*)
         FROM categorias
         WHERE is_active = 1)                                               AS total_categorias,

        -- Total de pedidos en el sistema
        (SELECT COUNT(*)
         FROM pedidos
         WHERE deleted_at IS NULL)                                          AS total_pedidos,

        -- Pedidos creados hoy
        (SELECT COUNT(*)
         FROM pedidos
         WHERE DATE(created_at) = CURDATE()
           AND deleted_at IS NULL)                                          AS pedidos_hoy,

        -- Ingresos del mes actual (suma de totales)
        (SELECT COALESCE(SUM(total), 0)
         FROM pedidos
         WHERE MONTH(created_at) = MONTH(NOW())
           AND YEAR(created_at)  = YEAR(NOW())
           AND deleted_at IS NULL)                                          AS ingresos_mes;

END$$

DELIMITER ;


-- ============================================================
-- SP 8: sp_listar_pedidos_admin
--
-- Reemplaza los filtros inline de PedidoAdminController::index().
-- Parámetros de entrada:
--   p_busqueda  → filtra por número de pedido o nombre del cliente
--   p_id_estado → filtra por estado; 0 o NULL = sin filtro de estado
--   p_limite    → LIMIT (filas por página)
--   p_offset    → OFFSET (desplazamiento)
-- Parámetro de salida:
--   p_total     → total de pedidos coincidentes (para LengthAwarePaginator)
-- Devuelve: pedidos con datos del cliente y del estado, ordenados por fecha DESC
-- ============================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_listar_pedidos_admin$$

CREATE PROCEDURE sp_listar_pedidos_admin(
    IN  p_busqueda  VARCHAR(200),
    IN  p_id_estado INT,
    IN  p_limite    INT,
    IN  p_offset    INT,
    OUT p_total     INT
)
BEGIN

    -- ── 1. Contar total de pedidos coincidentes ───────────────────────────
    SELECT COUNT(*) INTO p_total
    FROM pedidos ped
    INNER JOIN users u ON u.id_user = ped.id_user
    WHERE ped.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR ped.num_pedido LIKE CONCAT('%', p_busqueda, '%')
            OR u.nombre      LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (p_id_estado IS NULL OR p_id_estado = 0 OR ped.id_estado_ped = p_id_estado);

    -- ── 2. Devolver página de resultados ─────────────────────────────────
    SELECT
        ped.id_pedido,
        ped.num_pedido,
        ped.subtotal,
        ped.impuesto,
        ped.costo_envio,
        ped.total,
        ped.created_at,
        ped.updated_at,
        -- Datos del cliente
        u.id_user           AS cliente_id,
        u.nombre            AS cliente_nombre,
        u.email             AS cliente_email,
        -- Datos del estado
        ep.id_estado_ped,
        ep.nombre           AS estado_nombre,
        ep.color            AS estado_color
    FROM pedidos ped
    INNER JOIN users          u  ON u.id_user       = ped.id_user
    INNER JOIN estados_pedido ep ON ep.id_estado_ped = ped.id_estado_ped
    WHERE ped.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR ped.num_pedido LIKE CONCAT('%', p_busqueda, '%')
            OR u.nombre      LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (p_id_estado IS NULL OR p_id_estado = 0 OR ped.id_estado_ped = p_id_estado)
    ORDER BY ped.created_at DESC
    LIMIT  p_limite
    OFFSET p_offset;

END$$

DELIMITER ;


-- ============================================================
-- SP 9: sp_listar_productos_admin
--
-- Reemplaza los filtros inline de ProductoAdminController::index().
-- Parámetros de entrada:
--   p_busqueda → filtra por nombre o SKU
--   p_limite   → LIMIT (filas por página)
--   p_offset   → OFFSET (desplazamiento)
-- Parámetro de salida:
--   p_total    → total de productos coincidentes (para LengthAwarePaginator)
-- Devuelve: productos (sin soft-delete) con imagen principal, ordenados
--           por fecha de creación DESC
-- ============================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_listar_productos_admin$$

CREATE PROCEDURE sp_listar_productos_admin(
    IN  p_busqueda VARCHAR(200),
    IN  p_limite   INT,
    IN  p_offset   INT,
    OUT p_total    INT
)
BEGIN

    -- ── 1. Contar total de productos coincidentes ─────────────────────────
    SELECT COUNT(*) INTO p_total
    FROM productos p
    WHERE p.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre LIKE CONCAT('%', p_busqueda, '%')
            OR p.sku    LIKE CONCAT('%', p_busqueda, '%')
          );

    -- ── 2. Devolver página de resultados con imagen principal ─────────────
    SELECT
        p.id_producto,
        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.stock_minimo,
        p.sku,
        p.es_destacado,
        p.created_at,
        p.updated_at,
        -- Imagen principal (NULL si no tiene)
        img.id_img_prod AS imagen_id,
        img.url         AS imagen_url,
        img.alt_text    AS imagen_alt
    FROM productos p
    LEFT JOIN imagenes_productos img
           ON img.id_producto  = p.id_producto
          AND img.es_principal = 1
    WHERE p.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre LIKE CONCAT('%', p_busqueda, '%')
            OR p.sku    LIKE CONCAT('%', p_busqueda, '%')
          )
    ORDER BY p.created_at DESC
    LIMIT  p_limite
    OFFSET p_offset;

END$$

DELIMITER ;


-- ============================================================
-- Verificación: listar todos los procedimientos del proyecto
-- ============================================================
SELECT
    routine_name                          AS procedimiento,
    created                               AS creado,
    last_altered                          AS modificado
FROM information_schema.routines
WHERE routine_schema = 'la_bendicion'
  AND routine_type   = 'PROCEDURE'
ORDER BY routine_name;
