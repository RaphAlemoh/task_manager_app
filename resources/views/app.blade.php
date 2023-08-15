<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        window.Laravel = <?php echo json_encode([
                                'csrfToken' => csrf_token(),
                            ]); ?>
    </script>
    <title>{{env('APP_NAME')}}</title>
    @vite('resources/css/app.css')
</head>

<body>
    @if (Auth::check())
    <script>
        window.Laravel = <?php echo json_encode([
                                'isLoggedin' => true,
                                'user' => Auth::user()
                            ]); ?>
    </script>
    @else
    <script>
        window.Laravel = <?php echo json_encode([
                                'isLoggedin' => false
                            ]); ?>
    </script>
    @endif
    <div id="app"></div>

    @vite('resources/js/app.js')
</body>

</html>