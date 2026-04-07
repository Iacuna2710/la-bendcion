

USE la_bendicion;



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



DELIMITER $$

DROP PROCEDURE IF EXISTS sp_obtener_dashboard$$

CREATE PROCEDURE sp_obtener_dashboard()
BEGIN

    SELECT
        
        (SELECT COUNT(*)
         FROM users
         WHERE is_active  = 1
           AND deleted_at IS NULL)                                           AS total_usuarios,

        
        (SELECT COUNT(*)
         FROM productos
         WHERE deleted_at IS NULL)                                          AS total_productos,

        
        (SELECT COUNT(*)
         FROM categorias
         WHERE is_active = 1)                                               AS total_categorias,

        
        (SELECT COUNT(*)
         FROM pedidos
         WHERE deleted_at IS NULL)                                          AS total_pedidos,

        
        (SELECT COUNT(*)
         FROM pedidos
         WHERE DATE(created_at) = CURDATE()
           AND deleted_at IS NULL)                                          AS pedidos_hoy,

        
        (SELECT COALESCE(SUM(total), 0)
         FROM pedidos
         WHERE MONTH(created_at) = MONTH(NOW())
           AND YEAR(created_at)  = YEAR(NOW())
           AND deleted_at IS NULL)                                          AS ingresos_mes;

END$$

DELIMITER ;



DELIMITER $$




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

    
    SELECT
        ped.id_pedido,
        ped.num_pedido,
        ped.subtotal,
        ped.impuesto,
        ped.costo_envio,
        ped.total,
        ped.created_at,
        ped.updated_at,
        
        u.id_user           AS cliente_id,
        u.nombre            AS cliente_nombre,
        u.email             AS cliente_email,
        
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



DELIMITER $$

DROP PROCEDURE IF EXISTS sp_listar_productos_admin$$

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_listar_productos_admin$$

CREATE PROCEDURE sp_listar_productos_admin(
    IN  p_busqueda VARCHAR(200),
    IN  p_limite   INT,
    IN  p_offset   INT,
    OUT p_total    INT
)
BEGIN

    
    SELECT COUNT(*) INTO p_total
    FROM productos p
    WHERE p.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre LIKE CONCAT('%', p_busqueda, '%')
            OR p.sku    LIKE CONCAT('%', p_busqueda, '%')
          );

    
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



SELECT
    routine_name                          AS procedimiento,
    created                               AS creado,
    last_altered                          AS modificado
FROM information_schema.routines
WHERE routine_schema = 'la_bendicion'
  AND routine_type   = 'PROCEDURE'
ORDER BY routine_name;
