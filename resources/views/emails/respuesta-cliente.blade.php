<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Contacto</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .button { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hola, {{ $contacto->nombre }}</h2>

        <p>¡Gracias por contactarte con TyT ElectroSoluciones!</p>
        <p>Hemos recibido tu mensaje y nos pondremos en contacto contigo a la brevedad.</p>
        
        <hr>

        <p>
            Por favor, para confirmar que esta dirección de correo es tuya, 
            haz clic en el siguiente enlace de verificación:
        </p>
        <p>
            <a href="{{ route('verification.verify', ['token' => $contacto->verification_token]) }}" class="button">
                Verificar mi Correo
            </a>
        </p>
        <p>Si no puedes hacer clic en el botón, copia y pega esta URL en tu navegador:</p>
        <p>{{ route('verification.verify', ['token' => $contacto->verification_token]) }}</p>
        <br>
        <p>Saludos,<br>El equipo de TyT ElectroSoluciones</p>
    </div>
</body>
</html>