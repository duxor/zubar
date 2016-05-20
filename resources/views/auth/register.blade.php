@extends('master-basic')
@section('body')
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#tab1default" data-toggle="tab">Registracija zubara</a></li>
                    <li><a href="#tab2default" data-toggle="tab">Registracija pacijenta</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1default">
                        @if (Session::has('poruka'))
                            <h3 class="alert alert-success alert-autocloseable-success" align="center">{{ Session::get('poruka') }}</h3>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-autocloseable-success">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                        @endif
                        <script>
                            $(".alert-autocloseable-success").fadeTo(5000, 500).slideUp(500, function(){
                                $(".alert-autocloseable-success").alert('close');
                            });
                        </script>
                        {!! Form::open(['url'=>'/registracija','class'=>'form-horizontal']) !!}
                        {!!Form::hidden("zubar_pacijent",3)!!}
                        <div class="form-group has-feedback">
                            {!! Form::label('ime','Ime',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('ime',Request::old('ime'),['placeholder'=>'Ime','class'=>'form-control','id'=>'ime']) !!}
                                @if ($errors->has('ime'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ime') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('prezime','Prezime',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('prezime',Request::old('prezime'),['placeholder'=>'Prezime','class'=>'form-control','id'=>'prezime']) !!}
                                @if ($errors->has('prezime'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prezime') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('password','Password',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::password('password', ['placeholder'=>'Šifra','class'=>'form-control','id'=>'password']) !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('email','Email',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('email', Request::old('email'),['placeholder'=>'Email','class'=>'form-control']) !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('telefon','Telefon',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('telefon', Request::old('telefon'),['placeholder'=>'Telefon','class'=>'form-control']) !!}
                                @if ($errors->has('telefon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('grad','Grad',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('grad', $grad,1,['placeholder'=>'Grad','class'=>'form-control']) !!}
                                @if ($errors->has('grad'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('grad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('username','Korisničko ime',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('username',Request::old('username'),['placeholder'=>'Korisničko ime','class'=>'form-control','id'=>'username']) !!}
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('naziv_ordinacije','Naziv ordinacije',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('naziv_ordinacije',Request::old('naziv_ordinacije'),['placeholder'=>'Korisničko ime','class'=>'form-control','id'=>'username']) !!}
                                @if ($errors->has('naziv_ordinacije'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('naziv_ordinacije') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                {!!Form::button('<span class="glyphicon glyphicon-ok"></span> Registracija', ['id'=>'button_unesi','class'=>'btn3d btn btn-lg btn-info ','type'=>'submit'])!!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
    {{--Registracija pacijenta--------------------------------------}}
                    <div class="tab-pane fade" id="tab2default">
                        @if (Session::has('poruka'))
                            <h3 class="alert alert-success alert-autocloseable-success" align="center">{{ Session::get('poruka') }}</h3>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-autocloseable-success">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <script>
                            $(".alert-autocloseable-success").fadeTo(5000, 500).slideUp(500, function(){
                                $(".alert-autocloseable-success").alert('close');
                            });
                        </script>
                            {!! Form::open(['url'=>'/registracija','class'=>'form-horizontal']) !!}
                            {!!Form::hidden("zubar_pacijent",2)!!}
                            <div class="form-group has-feedback">
                                {!! Form::label('ime','Ime',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('ime',Request::old('ime'),['placeholder'=>'Ime','class'=>'form-control','id'=>'ime']) !!}
                                    @if ($errors->has('ime'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ime') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('prezime','Prezime',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('prezime',Request::old('prezime'),['placeholder'=>'Prezime','class'=>'form-control','id'=>'prezime']) !!}
                                    @if ($errors->has('prezime'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('prezime') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('password','Password',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::password('password', ['placeholder'=>'Šifra','class'=>'form-control','id'=>'password']) !!}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('email','Email',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('email', Request::old('email'),['placeholder'=>'Email','class'=>'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('telefon','Telefon',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('telefon', Request::old('telefon'),['placeholder'=>'Telefon','class'=>'form-control']) !!}
                                    @if ($errors->has('telefon'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('telefon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('grad','Grad',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('grad', $grad,1,['placeholder'=>'Grad','class'=>'form-control']) !!}
                                    @if ($errors->has('grad'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('grad') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('username','Korisničko ime',['class'=>'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('username',Request::old('username'),['placeholder'=>'Korisničko ime','class'=>'form-control','id'=>'username']) !!}
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    {!!Form::button('<span class="glyphicon glyphicon-ok"></span> Registracija', ['id'=>'button_unesi','class'=>'btn3d btn btn-lg btn-info ','type'=>'submit'])!!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>//script za zadržavanje aktivnog taba
        $(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });
    </script>
@endsection