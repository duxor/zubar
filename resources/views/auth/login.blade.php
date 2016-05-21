@extends('master-basic')

@section('container')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-c">
                <div class="panel-heading">Prijava</div>
                <div class="panel-body">
                    @if(Session::has('fail'))
                        <div class="alert alert-danger alert-autocloseable-success">
                            <h3>{{Session::get('fail')}}</h3>
                        </div>
                    @endif
                    <script>
                        $(".alert-autocloseable-success").fadeTo(5000, 500).slideUp(500, function(){
                            $(".alert-autocloseable-success").alert('close');
                        });
                    </script>
                    <form action="{{route('admin.login')}}" class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Korisničko ime">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Šifra</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" placeholder="Šifra">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Prijavi se
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Zaboravili ste šifru?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {!! Html::style('/css/login.css') !!}
@endsection