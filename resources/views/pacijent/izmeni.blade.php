@extends('pacijent.master')
@section('container')
    <section>
        <h1><center>Izmena podataka</center></h1>
        <hr>
        {!! Form::open(['files'=>true]) !!}
        <div class="col-xs-4">
            <img src="{{$pacijent->foto?$pacijent->foto:'/img/default/korisnik.jpg'}}" id="naslovnaFoto" alt="Profilna fotografija" onclick="unesiFoto()">
            {!!Form::file('foto',['onchange'=>'prikaziFoto(this)','style'=>'display:none'])!!}
        </div>
        <div class="col-xs-8">
            <div class="col-xs-12">
                <div class="label col-sm-4">Ime i Prezime</div>
                <div class="content col-sm-4">{!! Form::text('ime',$pacijent->ime,['class'=>'form-control','placeholder'=>'Ime']) !!}</div>
                <div class="content col-sm-4">{!! Form::text('prezime',$pacijent->prezime,['class'=>'form-control','placeholder'=>'Prezime']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">E-mail</div>
                <div class="content col-sm-8">{!! Form::email('email',$pacijent->email,['class'=>'form-control','placeholder'=>'E-mail']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">Telefon</div>
                <div class="content col-sm-8">{!! Form::text('telefon',$pacijent->ime,['class'=>'form-control','placeholder'=>'Ime']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">Pin</div>
                <div class="content col-sm-8">{!! Form::text('pin',$pacijent->pin,['class'=>'form-control','placeholder'=>'Pin']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">Grad</div>
                <div class="content col-sm-8">{!! Form::select('grad_id',$gradovi,$pacijent->grad,['class'=>'form-control']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">Biografija</div>
                <div class="content col-sm-8">{!! Form::textarea('bio',$pacijent->bio,['class'=>'form-control','placeholder'=>'Biografija']) !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="label col-sm-4">&nbsp;</div>
                <div class="content col-sm-8">{!! Form::button('<i class="glyphicon glyphicon-floppy-disk"></i> Sačuvaj',['class'=>'btn btn-primary','type'=>'submit'])!!}</div>
            </div>
        </div>
        {!! Form::close() !!}
        <br clear="all">
    </section>
    <style>
        *{ font-size: 110% }
        .col-xs-4 img{ 
            width: 100%;
            cursor: pointer
        }
        .content{ font-weight: bold }
        .label{ color:#333 }
    </style>
    <script>
        function unesiFoto(){ $('[name=foto]').click() }
        function prikaziFoto(fotoFajl){
            if(fotoFajl.files && fotoFajl.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) { $('#naslovnaFoto').attr('src',e.target.result) }
                reader.readAsDataURL(fotoFajl.files[0])
            }
        }
    </script>
@endsection