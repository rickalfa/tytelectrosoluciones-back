<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Contacto</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 90%; margin: auto; padding: 20px; border: 1px solid #ddd; }
        strong { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Nuevo Mensaje de Contacto desde la Web!</h2>
        <p>Has recibido un nuevo mensaje de un potencial cliente. Un registro ha sido creado en la base de datos.</p>
        <hr>
        <h3>Detalles del Contacto:</h3>
        <ul>
            <li><strong>Nombre:</strong> {{ $contacto->nombre }}</li>
            <li><strong>Email:</strong> {{ $contacto->email }}</li>
            <li>
                <strong>Teléfono:</strong> 
                {{ $contacto->telefono ? $contacto->telefono : 'No proporcionado' }}
            </li>
        </ul>
        <h3>Mensaje:</h3>
        <p>{!! nl2br(e($contacto->mensaje)) !!}</p>
        
        <hr>
        <p>
            <strong>Estado:</strong> 
            El correo de auto-respuesta de verificación ya fue enviado al cliente.
        </p>
    </div>
</body>
</html>