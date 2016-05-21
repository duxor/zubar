@extends('pacijent.master')
@section('container')
    <section>
        <h1><center>Zubarski karton</center></h1>
        <hr>
        <div class="col-xs-4">
            <img src="{{$pacijent->foto?$pacijent->foto:'/img/default/korisnik.jpg'}}">
        </div>
        <div class="col-xs-8">
            <div class="ime prezime col-xs-12">
                <div class="label col-sm-4">Ime i Prezime</div>
                <div class="content col-sm-8">{{$pacijent->ime}} {{$pacijent->prezime}}</div>
            </div>
            <div class="email col-xs-12">
                <div class="label col-sm-4">E-mail</div>
                <div class="content col-sm-8">{{$pacijent->email}}</div>
            </div>
            <div class="telefon col-xs-12">
                <div class="label col-sm-4">Telefon</div>
                <div class="content col-sm-8">{{$pacijent->telefon?$pacijent->telefon:'Nije definisan'}}</div>
            </div>
            <div class="pin col-xs-12">
                <div class="label col-sm-4">Pin</div>
                <div class="content col-sm-8">{{$pacijent->pin?$pacijent->pin:'Nije definisan'}}</div>
            </div>
            <div class="grad col-xs-12">
                <div class="label col-sm-4">Grad</div>
                <div class="content col-sm-8">{{$pacijent->grad}}</div>
            </div>
            <div class="bio col-xs-12">
                <div class="label col-sm-4">Biografija</div>
                <div class="content col-sm-8">{{$pacijent->bio?$pacijent->bio:'Nije definisana'}}</div>
            </div>
        </div>
        <br clear="all">
    </section>

    <hr>
    <h2><center>Intervencije zubara</center></h2>
    @if($intervencije)
        @foreach($intervencije as $intervencija)
            <div class="col-xs-12 alert alert-{{$intervencija->ocena>0?'success':'danger'}}">
                <h4>{{$intervencija->ordinacija}}</h4>
                <p>{{$intervencija->dijagnoza}}</p>
            </div>
        @endforeach
    @else
        Nema ni jedna evidentirana intervencija.
    @endif
    <style>
        *{ font-size: 110% }
        .col-xs-4 img{ width: 100% }
        .content{ font-weight: bold }
        .label{ color:#333 }
    </style>
    <script>

    </script>
@endsection