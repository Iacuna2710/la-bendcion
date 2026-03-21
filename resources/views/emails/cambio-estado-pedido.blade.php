<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de tu pedido — La Bendición</title>
    <style>
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
            padding: 28px 40px;
            text-align: center;
        }
        .encabezado h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            font-weight: bold;
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
            color: #444444;
            margin: 0 0 16px 0;
        }
        .caja-estado {
            text-align: center;
            padding: 24px;
            border-radius: 8px;
            margin: 24px 0;
            background-color: #f0faf4;
            border: 2px solid #2d6a4f;
        }
        .caja-estado .etiqueta {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
        }
        .caja-estado .estado {
            font-size: 26px;
            font-weight: bold;
            color: #1b4332;
        }
        .datos-pedido {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .datos-pedido table {
            width: 100%;
            border-collapse: collapse;
        }
        .datos-pedido td {
            padding: 6px 0;
            font-size: 14px;
            color: #555;
        }
        .datos-pedido td:first-child {
            font-weight: bold;
            color: #333;
            width: 45%;
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

        {{-- Encabezado --}}
        <div class="encabezado">
            <h1>🌿 La Bendición</h1>
            <p>Macrobiótica Natural — Actualización de Pedido</p>
        </div>

        {{-- Cuerpo del correo --}}
        <div class="cuerpo">
            <p>Hola <strong>{{ $pedido->user->nombre ?? 'Cliente' }}</strong>,</p>

            <p>
                Queremos informarte que el estado de tu pedido ha sido actualizado.
                A continuación encontrarás los detalles:
            </p>

            {{-- Estado destacado --}}
            <div class="caja-estado">
                <div class="etiqueta">Estado actual de tu pedido</div>
                <div class="estado">{{ $pedido->estadoPedido->nombre ?? 'Actualizado' }}</div>
            </div>

            {{-- Datos del pedido --}}
            <div class="datos-pedido">
                <table>
                    <tr>
                        <td>Número de pedido:</td>
                        <td><strong>{{ $pedido->num_pedido }}</strong></td>
                    </tr>
                    <tr>
                        <td>Fecha del pedido:</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>₡{{ number_format($pedido->total, 2) }}</td>
                    </tr>
                    @if($pedido->fecha_entrega_esperada)
                    <tr>
                        <td>Entrega estimada:</td>
                        <td>{{ \Carbon\Carbon::parse($pedido->fecha_entrega_esperada)->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <p>
                Puedes revisar el detalle completo de tu pedido ingresando a tu cuenta:
            </p>

            <div class="boton-contenedor">
                <a href="{{ route('pedidos.detalle', $pedido->id_pedido) }}" class="boton">
                    Ver mi pedido
                </a>
            </div>

            <p style="font-size: 13px; color: #888;">
                Si tienes alguna pregunta, puedes contactarnos respondiendo a este correo o
                visitando nuestra tienda.
            </p>
        </div>

        {{-- Pie --}}
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
