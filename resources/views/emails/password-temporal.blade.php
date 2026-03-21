<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu contraseña temporal — La Bendición</title>
    <style>
        /* Estilos inline para máxima compatibilidad con clientes de email */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .contenedor {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .encabezado {
            background-color: #2d6a4f;
            padding: 30px 40px;
            text-align: center;
        }
        .encabezado h1 {
            color: #ffffff;
            font-size: 22px;
            margin: 0;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .encabezado p {
            color: #d8f3dc;
            margin: 6px 0 0 0;
            font-size: 13px;
        }
        .cuerpo {
            padding: 36px 40px;
        }
        .cuerpo p {
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 16px 0;
            color: #444444;
        }
        .caja-password {
            background-color: #f0faf4;
            border: 2px dashed #2d6a4f;
            border-radius: 6px;
            text-align: center;
            padding: 20px;
            margin: 24px 0;
        }
        .caja-password span {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #1b4332;
            font-family: 'Courier New', Courier, monospace;
        }
        .boton-contenedor {
            text-align: center;
            margin: 28px 0;
        }
        .boton {
            display: inline-block;
            background-color: #2d6a4f;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
        }
        .alerta {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 16px;
            border-radius: 4px;
            font-size: 13px;
            color: #555;
            margin: 20px 0 0 0;
        }
        .pie {
            background-color: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .pie p {
            font-size: 12px;
            color: #888888;
            margin: 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="contenedor">

        {{-- Encabezado con branding --}}
        <div class="encabezado">
            <h1>🌿 La Bendición</h1>
            <p>Macrobiótica Natural</p>
        </div>

        {{-- Cuerpo del mensaje --}}
        <div class="cuerpo">
            <p>Hola <strong>{{ $usuario->nombre }}</strong>,</p>

            <p>
                Recibimos una solicitud para restablecer la contraseña de tu cuenta
                en <strong>La Bendición</strong>. Tu contraseña temporal es:
            </p>

            {{-- Contraseña temporal destacada --}}
            <div class="caja-password">
                <span>{{ $passwordTemporal }}</span>
            </div>

            <p>
                Usa esta contraseña para iniciar sesión. El sistema te pedirá
                crear una nueva contraseña de forma inmediata antes de que puedas
                continuar.
            </p>

            <div class="boton-contenedor">
                <a href="{{ url('/login') }}" class="boton">
                    Ir al inicio de sesión
                </a>
            </div>

            {{-- Aviso de seguridad --}}
            <div class="alerta">
                ⚠️ <strong>Importante:</strong> Si no solicitaste este cambio, ignora
                este correo. Tu contraseña anterior permanece activa hasta que alguien
                inicie sesión con esta temporal.
            </div>
        </div>

        {{-- Pie del correo --}}
        <div class="pie">
            <p>
                Este correo fue enviado automáticamente por La Bendición.<br>
                Por favor no respondas a este mensaje.
            </p>
            <p>© {{ date('Y') }} La Bendición — Macrobiótica Natural</p>
        </div>

    </div>
</body>
</html>
