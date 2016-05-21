@extends('master-basic')

@section('title', '| Forgot my Password')

@section('body')

    <div class="row" xmlns="http://www.w3.org/1999/html">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>

				<div class="panel-body">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
                {!! Form::open(['url' => 'password/email', 'method' => "POST"]) !!}
                    <div class="form-group has-feedback">
                        {!! Form::label('email','Email Address:',['class'=>'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    </br></br></br>
                    <div class="form-group has-feedback">
                        {{ Form::submit('Reset Password', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}

				</div>
			</div>
		</div>
	</div>

@endsection