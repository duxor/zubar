@extends('zubar.master')
@section('container')
    <h1>ZuboPanel</h1>
    <hr>
    <div class="col-sm-5">
        <h2><center>Radno vreme <button class="btn btn-xs btn-warning radnoVrijeme"><i class="glyphicon glyphicon-pencil"></i></button></center></h2>
        <div id="radnoVrijemeSacuvano">
            <center><i class="icon-spin6 animate-spin" style="font-size: 350%"></i></center>
        </div>
    </div>
    <div class="modal fade" id="radnoVrijeme">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h2>Izmena radnog vremena</h2>
                </div>
                <div class="modal-body">
                    {!! Form::button('Ukloni sve',['class'=>'btn btn-danger','id'=>'izbrisiSve']) !!}
                    {!! Form::button('Dodaj opseg',['class'=>'btn btn-default','id'=>'dodajOpseg']) !!}
                    <div id="radnoVrijemeSacuvanoModal"></div>
                    <div id="radnoVrijemeForma">
                        {!! Form::select('dan0',['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],0,['class'=>'form-control']) !!}
                        {!! Form::select('dan1',['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],0,['class'=>'form-control']) !!}
                        <div style="overflow:hidden"><div class="form-group"><div class="row"><div class="col-md-8"><div id="vrijemeOd"></div></div></div></div></div>
                        <div style="overflow:hidden"><div class="form-group"><div class="row"><div class="col-md-8"><div id="vrijemeDo"></div></div></div></div></div>
                        {!! Form::button('Dodaj',['class'=>'btn btn-success','id'=>'dodajRadnoVrijeme']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Otkaži promene</button>
                    <button class="btn btn-danger sacuvajPromjene"><i class="glyphicon glyphicon-floppy-disk"></i> Sačuvaj</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function(){ radnoVr.init('{{csrf_token()}}') });
    </script>
@endsection