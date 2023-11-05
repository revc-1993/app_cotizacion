<!DOCTYPE html>
<html>

<head>
    <title>Notificación de Cotización</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div
        style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

        <h2 style="font-size: 24px; color: #333; margin: 0; padding: 0;">Notificación de Nueva Cotización</h2>

        <p style="font-size: 16px; color: #555; margin-top: 10px;">Estimado/a {{ $quote->customer->names }},</p>

        <p style="font-size: 16px; color: #555;">Te informamos que se ha creado una nueva cotización en nuestro sistema.
            A continuación, encontrarás los detalles:</p>

        <div style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; margin-top: 20px;">
            <p style="font-size: 16px; color: #555; margin: 0;">Fecha de Creación:
                <strong>{{ $quote->registration_date }}</strong>
            </p>
            <p style="font-size: 16px; color: #555; margin: 0;">Total: <strong>${{ $quote->total }}</strong>
            </p>
        </div>

        <p style="font-size: 16px; color: #555; margin-top: 20px;">Si deseas ver los detalles completos de la cotización,
            puedes revisar el archivo adjunto.</p>

        <p style="font-size: 16px; color: #555; margin-top: 20px;">¡Gracias por confiar en nuestros servicios!</p>

        <p style="font-size: 16px; color: #555;">Saludos cordiales,</p>
        <p style="font-size: 16px; color: #555;"><strong>{{ $configuration->company_name }}</strong></p>
    </div>

</body>

</html>
