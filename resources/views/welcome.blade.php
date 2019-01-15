<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script>window.Laravel = { csrfToken: '{{csrf_token()}}'}</script>
        <title>Article App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">
        {{--<link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
    </head>
    <body>
        <div id="app">
            <div class="container">
                <articles></articles>
            </div>
        </div>
    </body>

    <script src="{{asset('js/app.js')}}"></script>
</html>
