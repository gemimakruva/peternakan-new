<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Kandang Module - {{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="{{ $description ?? '' }}">
        <meta name="keywords" content="{{ $keywords ?? '' }}">
        <meta name="author" content="{{ $author ?? '' }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Vite CSS --}}
        <style>
            .drop-zone {
                border: 2px dashed #6c757d;
                border-radius: 10px;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                transition: .3s;
            }

            .drop-zone.dragover {
                background-color: #f1f1f1;
                border-color: #0d6efd;
            }

            .preview-img {
                max-width: 100%;
                margin-top: 1rem;
                display: none;
            }
        </style>
        {{-- {{ module_vite('build-kandang', 'resources/assets/sass/app.scss') }} --}}
    </head>

    <body>
        {{ $slot }}

        {{-- Vite JS --}}
        {{-- {{ module_vite('build-kandang', 'resources/assets/js/app.js') }} --}}
        
    </body>
</html>
