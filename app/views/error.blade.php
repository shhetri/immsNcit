<html>
<head>
    <title>
        Page Not Found
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('packages/rydurham/sentinel/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3><a href="{{ Sentry::check()? route('home') : route('view.home') }}"><img src="{{ asset('img/404.jpg') }}" class="img img-responsive"/></a></h3>
            </div>
        </div>
    </div>
</body>
</html>