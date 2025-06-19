-- Elimina la base de datos si existe y créala de nuevo
DROP DATABASE IF EXISTS cornisk;
CREATE DATABASE cornisk;
\c cornisk;

-- Tabla de usuarios
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    email_verified_at VARCHAR(255),
    password VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    usuario VARCHAR(255) NOT NULL,
    activacion INT,
    api_token VARCHAR(150),
    fotoPerfil VARCHAR(1500),
    telefonos VARCHAR(50),
    ciudad INT,
    id_provincia INT
);

-- Tabla de aseguradoras
CREATE TABLE aseguradoras (
    id SERIAL PRIMARY KEY,
    aseguradora VARCHAR(255),
    id_ramo INT
);

-- Tabla de ramos
CREATE TABLE ramos (
    id SERIAL PRIMARY KEY,
    ramo VARCHAR(255),
    campo1 VARCHAR(255)
);

-- Tabla de brokers
CREATE TABLE brokers (
    id SERIAL PRIMARY KEY,
    broker VARCHAR(255),
    campo1 VARCHAR(255)
);

-- Tabla de causas
CREATE TABLE causas (
    id SERIAL PRIMARY KEY,
    id_ramo INT,
    causa VARCHAR(255)
);

-- Tabla de casos
CREATE TABLE casos (
    id SERIAL PRIMARY KEY,
    id_CFR VARCHAR(255),
    aseguradora INT REFERENCES aseguradoras(id),
    ramo INT REFERENCES ramos(id),
    broker INT REFERENCES brokers(id),
    reclamo_aseguradora VARCHAR(255),
    no_reporte VARCHAR(255),
    asegurado BIGINT,
    poliza_anexo INT,
    inicio_poliza VARCHAR(10),
    fin_poliza VARCHAR(10),
    fecha_siniestro VARCHAR(10),
    fecha_asignacion VARCHAR(10),
    fecha_reporte VARCHAR(10),
    lugar_siniestro VARCHAR(255),
    sector_evento VARCHAR(255),
    hora_siniestro VARCHAR(50),
    seguro_afectado INT,
    circunstancias TEXT,
    causa INT REFERENCES causas(id),
    observaciones TEXT,
    nombre VARCHAR(255),
    ci INT,
    parentezo VARCHAR(255),
    ocupacion VARCHAR(255),
    telefonos VARCHAR(255),
    cobertura VARCHAR(255),
    compañia_de_seguros VARCHAR(255),
    inspector INT,
    ejecutivo VARCHAR(255),
    valor_de_la_reserva VARCHAR(255),
    requerimientos TEXT,
    subrogacion VARCHAR(255),
    salvamento VARCHAR(255),
    estado VARCHAR(255),
    ejecutivo2 VARCHAR(255),
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    informe_final TIMESTAMP,
    facturacion VARCHAR(255),
    nombre_asegurado VARCHAR(100),
    direccion_asegurado VARCHAR(255),
    email_asegurado VARCHAR(100),
    id_provincia INT
);

-- Tabla de bienes
CREATE TABLE bienes (
    id_bien SERIAL PRIMARY KEY,
    id_caso INT REFERENCES casos(id),
    bien_asegurado VARCHAR(150),
    objeto INT,
    tipo INT,
    caracteristicas TEXT,
    fotos TEXT,
    detalles TEXT,
    objeto_id INT
);

-- Tabla de objetos
CREATE TABLE objetos (
    id SERIAL PRIMARY KEY,
    id_ramo INT,
    descripcion VARCHAR(255)
);

-- Tabla de tipo_bienes
CREATE TABLE tipo_bienes (
    id SERIAL PRIMARY KEY,
    id_bien INT,
    tipo VARCHAR(255)
);

-- Tabla de valoraciones
CREATE TABLE valoraciones (
    id SERIAL PRIMARY KEY,
    id_bien INT REFERENCES bienes(id_bien),
    descripcion VARCHAR(255),
    cant INT,
    valor_cotizado INT,
    valor_aprobado INT,
    updated_at TIMESTAMP
);

-- Tabla de imágenes
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    id_bien INT REFERENCES bienes(id_bien),
    file_path VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de ciudades
CREATE TABLE ciudades (
    id SERIAL PRIMARY KEY,
    provincia VARCHAR(255),
    ciudad VARCHAR(255)
);

-- Tabla de provincias
CREATE TABLE provincias (
    id SERIAL PRIMARY KEY,
    provincia VARCHAR(255),
    pais VARCHAR(255)
);

-- Tabla de seguros
CREATE TABLE seguros (
    id SERIAL PRIMARY KEY,
    seguro VARCHAR(255)
);

-- Tabla de migraciones
CREATE TABLE migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

-- Tabla de oauth_access_tokens
CREATE TABLE oauth_access_tokens (
    id VARCHAR(100) PRIMARY KEY,
    user_id BIGINT,
    client_id BIGINT NOT NULL,
    name VARCHAR(255),
    scopes TEXT,
    revoked BOOLEAN NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    expires_at TIMESTAMP
);

-- Tabla de oauth_auth_codes
CREATE TABLE oauth_auth_codes (
    id VARCHAR(100) PRIMARY KEY,
    user_id BIGINT NOT NULL,
    client_id BIGINT NOT NULL,
    scopes TEXT,
    revoked BOOLEAN NOT NULL,
    expires_at TIMESTAMP
);

-- Tabla de oauth_clients
CREATE TABLE oauth_clients (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT,
    name VARCHAR(255) NOT NULL,
    secret VARCHAR(100),
    provider VARCHAR(255),
    redirect TEXT NOT NULL,
    personal_access_client BOOLEAN NOT NULL,
    password_client BOOLEAN NOT NULL,
    revoked BOOLEAN NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla de oauth_personal_access_clients
CREATE TABLE oauth_personal_access_clients (
    id BIGSERIAL PRIMARY KEY,
    client_id BIGINT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla de oauth_refresh_tokens
CREATE TABLE oauth_refresh_tokens (
    id VARCHAR(100) PRIMARY KEY,
    access_token_id VARCHAR(100) NOT NULL,
    revoked BOOLEAN NOT NULL,
    expires_at TIMESTAMP
);

-- Tabla de personal_access_tokens
CREATE TABLE personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    abilities TEXT,
    last_used_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla de websockets_statistics_entries
CREATE TABLE websockets_statistics_entries (
    id SERIAL PRIMARY KEY,
    app_id VARCHAR(255) NOT NULL,
    peak_connection_count INT NOT NULL,
    websocket_message_count INT NOT NULL,
    api_message_count INT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Función Detalle_Caso
CREATE OR REPLACE FUNCTION Detalle_Caso(id_caso INT)
RETURNS JSON AS $$
DECLARE
    json_result JSON;
BEGIN
    SELECT json_build_object(
        'case', json_agg(
            json_build_object(
                'id', c.id,
                'id_CFR', c.id_CFR,
                'Aseguradora', a.aseguradora,
                'ramo', r.ramo,
                'Broker', b.broker,
                'Reclamo_Aseguradora', c.reclamo_aseguradora,
                'No_Reporte', c.no_reporte,
                'Asegurado', c.asegurado,
                'Nombre_Asegurado', c.nombre_asegurado,
                'Direccion_Asegurado', c.direccion_asegurado,
                'Email_Asegurado', c.email_asegurado,
                'Poliza_Anexo', c.poliza_anexo,
                'Inicio_Poliza', c.inicio_poliza,
                'Fin_Poliza', c.fin_poliza,
                'Fecha_Siniestro', c.fecha_siniestro,
                'Fecha_Asignación', c.fecha_asignacion,
                'Fecha_Reporte', c.fecha_reporte,
                'Lugar_Siniestro', c.lugar_siniestro,
                'Sector_Evento', c.sector_evento,
                'Hora_Siniestro', c.hora_siniestro,
                'Seguro_Afectado', c.seguro_afectado,
                'Circunstancias', c.circunstancias,
                'Causa', ca.causa,
                'Observaciones', c.observaciones,
                'Nombre', c.nombre,
                'CI', c.ci,
                'Parentezo', c.parentezo,
                'Ocupacion', c.ocupacion,
                'Telefonos', c.telefonos,
                'Cobertura', c.cobertura,
                'Compañía_de_Seguros', c.compañia_de_seguros,
                'Inspector', c.inspector,
                'Ejecutivo', c.ejecutivo,
                'Valor_de_la_Reserva', c.valor_de_la_reserva,
                'Requerimientos', c.requerimientos,
                'Subrogación', c.subrogacion,
                'Salvamento', c.salvamento,
                'Estado', c.estado,
                'Ejecutivo2', c.ejecutivo2,
                'updated_at', c.updated_at,
                'created_at', c.created_at,
                'Informe_Final', c.informe_final,
                'Facturacion', c.facturacion,
                'Id_Provincia', c.id_provincia,
                'bienes', (
                    SELECT json_agg(
                        json_build_object(
                            'id_bien', bns.id_bien,
                            'Bien_Asegurado', bns.bien_asegurado,
                            'Objeto', o.descripcion,
                            'Tipo', t.tipo,
                            'Caracteristicas', bns.caracteristicas,
                            'Fotos', bns.fotos,
                            'Detalles', bns.detalles,
                            'objeto_id', bns.objeto_id
                        )
                    ) FROM bienes bns
                    INNER JOIN objetos o ON o.id = bns.objeto
                    INNER JOIN tipo_bienes t ON t.id = bns.tipo
                    WHERE bns.id_caso = c.id
                ),
                'ejecutivo', (
                    SELECT json_build_object(
                        'ejecutivo_nombre', ex.name,
                        'ejecutivo_email', ex.email,
                        'ejecutivo_telefono', ex.telefonos
                    ) FROM users ex
                    WHERE ex.id = c.ejecutivo
                ),
                'inspector', (
                    SELECT json_build_object(
                        'inspector_nombre', ins.name,
                        'inspector_email', ins.email,
                        'inspector_telefono', ins.telefonos
                    ) FROM users ins
                    WHERE ins.id = c.inspector
                )
            )
        )
    ) INTO json_result
    FROM casos c
    INNER JOIN aseguradoras a ON a.id = c.aseguradora
    INNER JOIN ramos r ON r.id = c.ramo
    INNER JOIN brokers b ON b.id = c.broker
    INNER JOIN causas ca ON ca.id = c.causa
    WHERE c.id = id_caso;

    RETURN json_result;
END;
$$ LANGUAGE plpgsql;

-- Vista Bandeja
CREATE VIEW bandeja AS
SELECT
    c.id,
    c.reclamo_aseguradora,
    c.no_reporte,
    c.poliza_anexo,
    c.fecha_siniestro,
    c.nombre_asegurado,
    c.fecha_asignacion,
    c.fecha_reporte,
    c.sector_evento,
    c.estado,
    c.ejecutivo,
    aa.aseguradora AS empresa_aseguradora,
    u.name AS inspector
FROM casos c
LEFT JOIN aseguradoras aa ON c.aseguradora = aa.id
LEFT JOIN users u ON c.inspector = u.id
ORDER BY c.fecha_siniestro DESC;

-- Vista Ver_Bienes
CREATE VIEW ver_bienes AS
SELECT
    b.id_bien,
    b.id_caso,
    b.objeto,
    b.tipo,
    b.caracteristicas,
    b.fotos,
    b.detalles,
    o.descripcion,
    tb.tipo AS tipo_b,
    (SELECT SUM(valor_cotizado) FROM valoraciones WHERE id_bien = b.id_bien) AS valor_cotizado,
    (SELECT SUM(valor_aprobado) FROM valoraciones WHERE id_bien = b.id_bien) AS valor_aprobado
FROM bienes b
LEFT JOIN objetos o ON o.id = b.objeto
LEFT JOIN tipo_bienes tb ON tb.id = b.tipo;

-- Procedimiento almacenado sp_ActualizarImagen
CREATE OR REPLACE FUNCTION sp_ActualizarImagen(id_bien INT, ruta VARCHAR(250))
RETURNS VOID AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM images WHERE id_bien = id_bien) THEN
        INSERT INTO images (id_bien, file_path, description, created_at, updated_at)
        VALUES (id_bien, ruta, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
    ELSE
        INSERT INTO images (id_bien, file_path, description, created_at, updated_at)
        VALUES (id_bien, ruta, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
    END IF;
END;
$$ LANGUAGE plpgsql;