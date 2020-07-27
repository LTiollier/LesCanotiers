<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix("js/admin/manifest.js") }}" defer></script>
    <script src="{{ mix("js/admin/vendor.js") }}" defer></script>
    <script src="{{ mix('/js/admin/app.js') }}" defer></script>
</head>
<body>
@inertia
@routes
</body>
</html>
