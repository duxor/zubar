<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zubolog</title>
    {!!Html::style('/css/bootstrap.min.css')!!}
    {!!Html::style('/css/datetimepicker.css')!!}
    {!!Html::style('/css/basic-admin.css')!!}
    {!!Html::style('/css/fontello.css')!!}
    {!!Html::style('/css/animation.css')!!}
    {!!Html::script('/js/jquery-1.9.1.js')!!}
    {!!Html::script('/js/bootstrap.min.js')!!}
    {!!Html::script('/js/moment.js')!!}
    {!!Html::script('/js/datetimepicker.js')!!}
</head>
<body data-target=".vertikalni-nav">
<div class="col-sm-2 vertikalni-nav">
    <div class="panel-group">
        <div class="panel panel-default panel-title">
            <a class="collapsed" data-toggle="collapse" href="#profilNav">
                <div class="panel-heading" style="padding: 1px">
                    <h3 class="text-center">Dobro došli!</h3>
                </div>
            </a>
        </div>
    </div>
    <div class="panel-group">
        <div class="panel panel-default panel-title">
            <a href="/">
                <div class="panel-heading" id="headingOne">
                    <h4><i class="glyphicon glyphicon-chevron-left"></i> Na sajt</h4>
                </div>
            </a>
        </div>
    </div>
    <div class="panel-group">
        <div class="panel panel-default panel-title">
            <a href="/administracija">
                <div class="panel-heading" id="headingOne">
                    <h4><i class="glyphicon glyphicon-home"></i> Administracija</h4>
                </div>
            </a>
        </div>
    </div>
    <div class="panel-group">
        <div class="panel panel-default panel-title">
            <a href="/administracija/termini">
                <div class="panel-heading" id="headingOne">
                    <h4><i class="glyphicon glyphicon-time"></i> Termini</h4>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="col-sm-10 bw">
    @yield('container')
    <br clear="all">
    <br clear="all">
    <br clear="all">
    <div class="text-center col-sm-11 copy">
        <p>Copyright © {{date('Y')}} Zubolog. Zadržavamo sva prava.</p>
    </div>
</div>
<i class="icon-spin6 animate-spin" style="font-size: 1px;rgba(0,0,0,0)"></i>
</body>
</html>