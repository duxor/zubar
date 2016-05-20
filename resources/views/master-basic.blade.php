<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zubolog</title>
    {!!Html::style('/bootstrap-3.3.5-dist/css/bootstrap.min.css')!!}
    {!!Html::script('/bootstrap-3.3.5-dist/js/jquery-3.0.js')!!}
    {!!Html::script('/bootstrap-3.3.5-dist/js/bootstrap.min.js')!!}

</head>

<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    @if (!Auth::check())
                        <li><a href="{{route('admin.login')}}">Prijava</a></li>
                        <li><a href="/registracija">Registracija</a></li>
                    @else
                    <li><a href="/odjava">Odjava</a></li>
                    @endif

                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<div class="container">@yield('container')</div>
@yield('body')
</body>
</html>