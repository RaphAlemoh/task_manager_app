<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{env('APP_NAME')}}</title>
    <!-- @vite('resources/css/app.css') -->
    <style>
        html {
            scroll-padding-top: 3.5rem;
        }

        header {
            padding-top: 9.5rem;
            padding-bottom: 6rem;
        }

        section {
            padding-top: 9rem;
            padding-bottom: 9rem;
        }
    </style>
</head>

<body id="page-top">
    <div id="app">
        <app></app>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
