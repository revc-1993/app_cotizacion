<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cotización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            /* Reducir el tamaño de letra en general en -2 */
        }

        .cotizacion {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .header {
            text-align: left;
        }

        .subtitle {
            font-weight: bold;
            text-align: left;
            margin-top: 20px;
        }

        .infor {
            margin-top: 10px;
            font-size: 9px;
            /* Establecer un tamaño de letra más pequeño para la clase "infor" */
        }

        .bold {
            font-weight: bold;
        }

        .tabla-cotizacion {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabla-cotizacion th,
        .tabla-cotizacion td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="cotizacion">
        {{-- <img src="{{ asset('storage/' . $configuration->logo) }}" alt="Logo de la empresa"
            style="max-width: 100px; margin-bottom: 20px;"> --}}

        <div class="header">
            <h3>{{ $configuration->company_name }}</h3>
            <p>{{ $configuration->ruc }}</p>
            <p>{{ $configuration->address }}</p>
            <p>{{ $configuration->contact_number }}</p>
            <p>{{ $configuration->email }}</p>
        </div>
        <div class="subtitle">Cliente</div>
        <div class="infor">
            <p><span class="bold">Fecha de cotización:</span> {{ $quote->registration_date }}</p>
            <p><span class="bold">RUC/CI:</span> {{ $quote->customer->ruc }}</p>
            <p><span class="bold">Cliente:</span> {{ $quote->customer->names }}</p>
            <p><span class="bold">Dirección:</span> {{ $quote->customer->address }}</p>
        </div>
        <div class="subtitle">Detalles de cotización</div>
        <table class="tabla-cotizacion">
            <thead>
                <tr>
                    <th>N.</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Subtotal (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quote->serviceDetails as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->service }}</td>
                        <td>{{ $item->amount_of_service }}</td>
                        <td>${{ $item->subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Subtotal 0%:</td>
                    <td class="total">${{ $quote->subtotal_0 }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Subtotal 12%:</td>
                    <td class="total">${{ $quote->subtotal_12 }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">IVA (12%):</td>
                    <td class="total">${{ $quote->iva }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td class="total">${{ $quote->total }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="subtitle">Información adicional</div>
        <div class="infor">
            <p><span class="bold">Flete internacional:</span> {{ $quote->international_freight_information }}</p>
            <p><span class="bold">Más detalles:</span> {{ $quote->additional_information }}</p>
            <p><span class="bold">Tiempo de tránsito:</span> {{ $quote->transit_time }} días</p>
            <p><span class="bold">Validez de cotización:</span> {{ $quote->quote_validity }} días</p>
            <p><span class="bold">Usuario:</span> {{ $quote->user->name }}</p>
        </div>
        <div class="infor">
            <p><span class="bold">Comentarios:</span> {{ $quote->comments }}</p>
        </div>
    </div>
</body>

</html>
