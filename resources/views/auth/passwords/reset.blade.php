@extends('master-basic')
@section('title', '| Forgot my Password')

@section('body')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>

				<div class="panel-body">
					
					{!! Form::open(['url' => 'password/reset', 'method' => "POST"]) !!}
						
					{{ Form::hidden('token', $token) }}

					{{ Form::label('email', 'Email adresa:') }}
					{{ Form::email('email', $email, ['class' => 'form-control']) }}

					{{ Form::label('password', 'Nova lozinka:') }}
					{{ Form::password('password', ['class' => 'form-control']) }}

					{{ Form::label('password_confirmation', 'Potvrdite lozinku:') }}
					{{ Form::password('password_confirmation', ['class' => 'form-control']) }}

					{{ Form::submit('Reset', ['class' => 'btn btn-primary']) }}

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>

@endsection