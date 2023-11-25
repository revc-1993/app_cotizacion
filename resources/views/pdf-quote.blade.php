<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cotización</title>
    <style>
        body {
            font-family: Roboto-Medium, sans-serif;
            /* font-size: 12px; */
        }

        .cotizacion {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            /* Fondo de la cotización */
        }

        .header {
            text-align: left;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 10px;
            line-height: 5px;
        }

        .header h3 {
            font-size: 20px;
            /* Tamaño de letra más grande para el nombre de la empresa */
        }

        .title {
            font-weight: bold;
            text-align: center;
            font-size: 12pt;
            x| margin-top: 20px;
        }

        .subtitle {
            font-weight: bold;
            text-align: left;
            font-size: 10pt;
            margin-top: 20px;
        }

        .infor {
            font-size: 8pt;
            margin-top: 20px;
            line-height: 5px;
        }

        .bold {
            font-weight: bold;
            text-align: left;
        }

        .tabla-cotizacion {
            width: 100%;
            border-collapse: collapse;
            font-size: 12pt;
            margin-top: 7px;
        }

        .tabla-cotizacion th,
        .tabla-cotizacion td {
            border: 0px solid #ccc;
            padding: 5px;
            /* Mayor espacio interno en las celdas */
            text-align: center;
        }

        .tabla-cotizacion th {
            font-weight: normal;
            border-bottom: 1px solid #000000;
        }

        .total {
            text-align: right;
        }

        .footer {
            font-size: 6pt;
            text-align: center;
        }

        .logo-image {
            width: 90px;
            height: 90px;
            float: right;
        }
    </style>
</head>

<body>
    <img src="{{ public_path() . '/storage/' . $configuration['logo'] }}" alt="Logo de empresa" class="logo-image" />
    {{-- <img src="{{ $configuration->logoUrl }}" alt="Logo de la empresa"> --}}
    <div class="header">
        <p>{{ $configuration->company_name }}</p>
        <p>RUC: {{ $configuration->ruc }}</p>
        <p>Dirección: {{ $configuration->address }}</p>
        <p>Teléfono: {{ $configuration->contact_number }}</p>
        <p>Email: {{ $configuration->email }}</p>
        <p>Categoría regimen: {{ $configuration->regime_category }}</p>
    </div>
    <div class="title">Cotización</div>
    <div class="infor">
        <p><span class="bold">Fecha de cotización:</span> {{ $quote->registration_date }}</p>
        <p><span class="bold">RUC / C.I.:</span> {{ $quote->customer->ruc }}</p>
        <p><span class="bold">Cliente:</span> {{ $quote->customer->names }}</p>
        <p><span class="bold">Dirección:</span> {{ $quote->customer->address }}</p>
    </div>
    <div class="subtitle">Detalles de carga</div>
    <table class="tabla-cotizacion">
        <thead>
            <tr>
                <th>N.</th>
                <th>Cantidad</th>
                <th>Tipo de carga</th>
                <th>Nombre de Producto</th>
                <th>Peso (ton)</th>
                <th>Volumen (m3)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quote->productDetails as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->amount_of_charge }}</td>
                    <td>{{ $quote->cargo_type }}</td>
                    <td>{{ $item->cargo_name }}</td>
                    <td>{{ $item->weight_calculated }}</td>
                    <td>{{ $item->volumen }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="subtitle">Detalles de la Cotización</div>
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
                <td colspan="3" class="bold">Subtotal 0%:</td>
                <td class="total">${{ $quote->subtotal_0 }}</td>
            </tr>
            <tr>
                <td colspan="3" class="bold">Subtotal 12%:</td>
                <td class="total">${{ $quote->subtotal_12 }}</td>
            </tr>
            <tr>
                <td colspan="3" class="bold">IVA (12%):</td>
                <td class="total">${{ $quote->iva }}</td>
            </tr>
            <tr>
                <td colspan="3" class="bold">Total:</td>
                <td class="total">${{ $quote->total }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="subtitle">Información adicional</div>
    <div class="infor">
        <p><span class="bold">Flete internacional:</span> {{ $quote->international_freight_information }}</p>
        <p><span class="bold">Más detalles:</span> {{ $quote->additional_information }}</p>
        <p><span class="bold">Tiempo de tránsito:</span> {{ $quote->transitTime }} días</p>
        <p><span class="bold">Validez de cotización:</span> {{ $quote->quoteValidity }} días</p>
        <p><span class="bold">Usuario:</span> {{ $quote->user->name }}</p>
    </div>
    <div class="footer">
        <p>{{ $quote->comments }}</p>
    </div>
</body>

</html>
