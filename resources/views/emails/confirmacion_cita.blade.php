<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirmación de Cita</h2>
        
        <p>Hola, <strong>{{ $user }}</strong></p>
        <p>Tu cita ha sido confirmada. A continuación, los detalles:</p>

        <div class="details">
            <p><strong>Fecha:</strong> {{ $date }}</p>
            <p><strong>Hora:</strong> {{ $time }}</p>
            <p><strong>Servicios:</strong> {{ $services }}</p>
            <p><strong>Precio Total:</strong> Gs. {{ number_format($price, 0, ',', '.') }}</p>
        </div>

        <p class="footer">¡Gracias por elegirnos! Te esperamos.</p>
    </div>
</body>
</html>
