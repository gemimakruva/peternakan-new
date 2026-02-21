<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Print Report')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Print-specific styles */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .print-header h1 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .print-header .subtitle {
            font-size: 12px;
            color: #666;
        }

        .print-filter-info {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .print-filter-info strong {
            color: #555;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .card-header {
            background: #f5f5f5;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        .chart-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .chart-container img {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .catatan-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 15px;
            background: #fff;
            page-break-inside: avoid;
        }

        .catatan-section h4 {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .catatan-content {
            font-size: 12px;
        }

        .page-break {
            page-break-before: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        /* Row and column fixes */
        .row {
            margin: 0 -10px;
        }

        .col-12, .col-6 {
            padding: 0 10px;
        }

        .col-6 {
            width: 50%;
            float: left;
        }

        .col-12 {
            width: 100%;
            clear: both;
        }

        /* Print footer */
        .print-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        @media print {
            body {
                padding: 0;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h1>@yield('title', 'Report')</h1>
        <div class="subtitle">@yield('subtitle', '')</div>
    </div>

    @yield('content')

    <div class="print-footer">
        <p>Generated on {{ now()->format('d/m/Y H:i') }} | {{ config('app.name') }}</p>
    </div>

    @yield('scripts')
</body>
</html>
