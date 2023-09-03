<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cotización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .cotizacion {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            font-size: 9;
            text-align: center;
            margin: 0 auto;
        }

        .subtitle {
            font-size: 5;
            margin: 0 auto;
            text-align: left;
        }

        .infor {
            font-size: 7;
            margin: 0 auto;
        }

        .bold {
            font-weight: bold;
        }

        .tabla-cotizacion {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10;
            font-size: 7;
        }

        .tabla-cotizacion th,
        .tabla-cotizacion td {
            border: 1px solid #ccc;
            padding: 3px;
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
        <div class="header">
            <h3><span class="bold">{{ $configuration->company_name }}</span></h3>
        </div>
        <div class="infor">
            <p><span class="bold">RUC:</span> {{ $configuration->ruc }}</p>
            <p><span class="bold">Dirección:</span> {{ $configuration->address }}</p>
            <p><span class="bold">Teléfono:</span> {{ $configuration->contact_number }}</p>
            <p><span class="bold">Email:</span> {{ $configuration->email }}</p>
        </div>
        <div class="subtitle">
            <h3><span class="bold">Cliente</span></h3>
        </div>
        <div class="infor">
            <p><span class="bold">Fecha de cotización: </span> {{ $quote->registration_date }}</p>
            <p><span class="bold">RUC/CI: </span> {{ $quote->customer->ruc }}</p>
            <p><span class="bold">Cliente: </span> {{ $quote->customer->names }}</p>
            <p><span class="bold">Dirección: </span> {{ $quote->customer->address }}</p>
        </div>
        <div class="subtitle">
            <h3><span class="bold">Detalles de cotización</span></h3>
        </div>
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
                        <td>{{ $item->subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Subtotal 0%: </td>
                    <td class="total">$ {{ $quote->subtotal_0 }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Subtotal 12%: </td>
                    <td class="total">$ {{ $quote->subtotal_12 }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">IVA (12%): </td>
                    <td class="total">$ {{ $quote->iva }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total: </td>
                    <td class="total">$ {{ $quote->total }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="subtitle">
            <h3><span class="bold">Información adicional</span></h3>
        </div>
        <div class="infor">
            <p><span class="bold">Flete internacional: </span> {{ $quote->international_freight_information }}</p>
            <p><span class="bold">Más detalles: </span> {{ $quote->additional_information }}</p>
            <p><span class="bold">Tiempo de tránsito: </span> {{ $quote->transit_time }}</p>
            <p><span class="bold">Validez de cotización: </span> {{ $quote->quote_validity }}</p>
            <p><span class="bold">Usuario: </span> {{ $quote->user->name }}</p>
        </div>
        <div class="infor">
            <p><span class="bold">Comentarios: </span> {{ $quote->comments }}</p>
        </div>

    </div>
</body>

</html>
