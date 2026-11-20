-- tiendaclic.cache definition

create table `cache` (
  `key` varchar(255) not null,
`value` mediumtext not null,
`expiration` int(11) not null,
primary key (`key`),
key `cache_expiration_index` (`expiration`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.cache_locks definition

create table `cache_locks` (
  `key` varchar(255) not null,
`owner` varchar(255) not null,
`expiration` int(11) not null,
primary key (`key`),
key `cache_locks_expiration_index` (`expiration`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.categorias definition

create table `categorias` (
  `id` bigint(20) unsigned not null auto_increment,
`nombre` varchar(80) not null,
`descripcion` varchar(255) default null,
`activa` tinyint(1) not null default 1,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `categorias_nombre_unique` (`nombre`)
) engine = InnoDB auto_increment = 4 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.failed_jobs definition

create table `failed_jobs` (
  `id` bigint(20) unsigned not null auto_increment,
`uuid` varchar(255) not null,
`connection` text not null,
`queue` text not null,
`payload` longtext not null,
`exception` longtext not null,
`failed_at` timestamp not null default current_timestamp(),
primary key (`id`),
unique key `failed_jobs_uuid_unique` (`uuid`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.job_batches definition

create table `job_batches` (
  `id` varchar(255) not null,
`name` varchar(255) not null,
`total_jobs` int(11) not null,
`pending_jobs` int(11) not null,
`failed_jobs` int(11) not null,
`failed_job_ids` longtext not null,
`options` mediumtext default null,
`cancelled_at` int(11) default null,
`created_at` int(11) not null,
`finished_at` int(11) default null,
primary key (`id`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.jobs definition

create table `jobs` (
  `id` bigint(20) unsigned not null auto_increment,
`queue` varchar(255) not null,
`payload` longtext not null,
`attempts` tinyint(3) unsigned not null,
`reserved_at` int(10) unsigned default null,
`available_at` int(10) unsigned not null,
`created_at` int(10) unsigned not null,
primary key (`id`),
key `jobs_queue_index` (`queue`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.migrations definition

create table `migrations` (
  `id` int(10) unsigned not null auto_increment,
`migration` varchar(255) not null,
`batch` int(11) not null,
primary key (`id`)
) engine = InnoDB auto_increment = 15 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.password_reset_tokens definition

create table `password_reset_tokens` (
  `email` varchar(255) not null,
`token` varchar(255) not null,
`created_at` timestamp null default null,
primary key (`email`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.sessions definition

create table `sessions` (
  `id` varchar(255) not null,
`user_id` bigint(20) unsigned default null,
`ip_address` varchar(45) default null,
`user_agent` text default null,
`payload` longtext not null,
`last_activity` int(11) not null,
primary key (`id`),
key `sessions_user_id_index` (`user_id`),
key `sessions_last_activity_index` (`last_activity`)
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.users definition

create table `users` (
  `id` bigint(20) unsigned not null auto_increment,
`name` varchar(255) not null,
`email` varchar(255) not null,
`email_verified_at` timestamp null default null,
`password` varchar(255) not null,
`rol` enum('cliente', 'colaborador', 'propietario') not null default 'cliente',
`activo` tinyint(1) not null default 1,
`acepta_politica_datos` tinyint(1) not null default 0,
`fecha_autorizacion_datos` datetime default null,
`remember_token` varchar(100) default null,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `users_email_unique` (`email`),
key `users_rol_index` (`rol`)
) engine = InnoDB auto_increment = 3 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.carritos definition

create table `carritos` (
  `id` bigint(20) unsigned not null auto_increment,
`usuario_id` bigint(20) unsigned not null,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `carritos_usuario_id_unique` (`usuario_id`),
constraint `carritos_usuario_id_foreign` foreign key (`usuario_id`) references `users` (`id`) on
delete
    cascade
) engine = InnoDB auto_increment = 3 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.clientes definition

create table `clientes` (
  `usuario_id` bigint(20) unsigned not null,
`telefono` varchar(20) default null,
`direccion` varchar(200) default null,
`ciudad` varchar(80) default null,
`preferencia_notificacion` enum('correo', 'sms') not null default 'correo',
primary key (`usuario_id`),
constraint `clientes_usuario_id_foreign` foreign key (`usuario_id`) references `users` (`id`) on
delete
    cascade
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.colaboradores definition

create table `colaboradores` (
  `usuario_id` bigint(20) unsigned not null,
`cargo` varchar(80) default null,
primary key (`usuario_id`),
constraint `colaboradores_usuario_id_foreign` foreign key (`usuario_id`) references `users` (`id`) on
delete
    cascade
) engine = InnoDB default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.pedidos definition

create table `pedidos` (
  `id` bigint(20) unsigned not null auto_increment,
`numero_orden` varchar(20) default null,
`usuario_id` bigint(20) unsigned not null,
`estado` enum('recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado') not null default 'recibido',
`total` decimal(12, 2) not null default 0.00,
`metodo_pago` enum('transferencia', 'pasarela') not null,
`nombre_destinatario` varchar(120) not null,
`direccion_envio` varchar(200) not null,
`ciudad_envio` varchar(80) not null,
`telefono_contacto` varchar(20) not null,
`motivo_cancelacion` varchar(255) default null,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `pedidos_numero_orden_unique` (`numero_orden`),
key `pedidos_estado_index` (`estado`),
key `pedidos_created_at_index` (`created_at`),
key `pedidos_usuario_id_foreign` (`usuario_id`),
constraint `pedidos_usuario_id_foreign` foreign key (`usuario_id`) references `users` (`id`),
constraint `ck_pedidos_total` check (`total` >= 0)
) engine = InnoDB auto_increment = 6 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.productos definition

create table `productos` (
  `id` bigint(20) unsigned not null auto_increment,
`categoria_id` bigint(20) unsigned not null,
`nombre` varchar(150) not null,
`descripcion` text default null,
`precio` decimal(12, 2) not null,
`stock` int(10) unsigned not null default 0,
`stock_minimo` int(10) unsigned not null default 0,
`imagen` varchar(255) default null,
`activo` tinyint(1) not null default 1,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
`deleted_at` timestamp null default null,
primary key (`id`),
key `productos_nombre_index` (`nombre`),
key `productos_activo_precio_index` (`activo`,
`precio`),
key `productos_categoria_id_foreign` (`categoria_id`),
constraint `productos_categoria_id_foreign` foreign key (`categoria_id`) references `categorias` (`id`),
constraint `ck_productos_precio` check (`precio` >= 0)
) engine = InnoDB auto_increment = 3 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.carrito_items definition

create table `carrito_items` (
  `id` bigint(20) unsigned not null auto_increment,
`carrito_id` bigint(20) unsigned not null,
`producto_id` bigint(20) unsigned not null,
`cantidad` int(10) unsigned not null,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `carrito_items_carrito_id_producto_id_unique` (`carrito_id`,
`producto_id`),
key `carrito_items_producto_id_foreign` (`producto_id`),
constraint `carrito_items_carrito_id_foreign` foreign key (`carrito_id`) references `carritos` (`id`) on
delete
    cascade,
    constraint `carrito_items_producto_id_foreign` foreign key (`producto_id`) references `productos` (`id`),
    constraint `ck_carrito_items_cantidad` check (`cantidad` > 0)
) engine = InnoDB auto_increment = 6 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.historial_estados_pedido definition

create table `historial_estados_pedido` (
  `id` bigint(20) unsigned not null auto_increment,
`pedido_id` bigint(20) unsigned not null,
`estado_anterior` enum('recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado') default null,
`estado_nuevo` enum('recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado') not null,
`usuario_id` bigint(20) unsigned not null,
`created_at` timestamp null default null,
primary key (`id`),
key `historial_estados_pedido_pedido_id_foreign` (`pedido_id`),
key `historial_estados_pedido_usuario_id_foreign` (`usuario_id`),
constraint `historial_estados_pedido_pedido_id_foreign` foreign key (`pedido_id`) references `pedidos` (`id`),
constraint `historial_estados_pedido_usuario_id_foreign` foreign key (`usuario_id`) references `users` (`id`)
) engine = InnoDB auto_increment = 16 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.pagos definition

create table `pagos` (
  `id` bigint(20) unsigned not null auto_increment,
`pedido_id` bigint(20) unsigned not null,
`metodo` enum('transferencia', 'pasarela') not null,
`estado` enum('pendiente', 'confirmado', 'rechazado') not null default 'pendiente',
`monto` decimal(12, 2) not null,
`referencia_transaccion` varchar(100) default null,
`comprobante_ruta` varchar(255) default null,
`verificado_por` bigint(20) unsigned default null,
`fecha_pago` datetime default null,
`created_at` timestamp null default null,
`updated_at` timestamp null default null,
primary key (`id`),
unique key `pagos_referencia_transaccion_unique` (`referencia_transaccion`),
key `pagos_estado_index` (`estado`),
key `pagos_pedido_id_foreign` (`pedido_id`),
key `pagos_verificado_por_foreign` (`verificado_por`),
constraint `pagos_pedido_id_foreign` foreign key (`pedido_id`) references `pedidos` (`id`),
constraint `pagos_verificado_por_foreign` foreign key (`verificado_por`) references `users` (`id`),
constraint `ck_pagos_monto` check (`monto` >= 0)
) engine = InnoDB auto_increment = 7 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
-- tiendaclic.pedido_items definition

create table `pedido_items` (
  `id` bigint(20) unsigned not null auto_increment,
`pedido_id` bigint(20) unsigned not null,
`producto_id` bigint(20) unsigned not null,
`nombre_producto` varchar(150) not null,
`precio_unitario` decimal(12, 2) not null,
`cantidad` int(10) unsigned not null,
`subtotal` decimal(12, 2) not null,
primary key (`id`),
key `pedido_items_pedido_id_foreign` (`pedido_id`),
key `pedido_items_producto_id_foreign` (`producto_id`),
constraint `pedido_items_pedido_id_foreign` foreign key (`pedido_id`) references `pedidos` (`id`),
constraint `pedido_items_producto_id_foreign` foreign key (`producto_id`) references `productos` (`id`),
constraint `ck_pedido_items_cantidad` check (`cantidad` > 0)
) engine = InnoDB auto_increment = 6 default CHARSET = utf8mb4 collate = utf8mb4_unicode_ci;
