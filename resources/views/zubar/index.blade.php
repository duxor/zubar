
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
    {!!Html::style('/css/year-calendar.css')!!}
    {!!Html::script('/js/year-calendar.js')!!}
    <br clear="all">
    <h1>Rezervacija termina (samo za <b>datume>=današnji)</b></h1>
    <p>
        Funkcionalnosti u izradi:
    <ul>
        <li>Dodavanje vremena</li>
        <li>Prikaz ranije dodatih rezervacija</li>
        <li>Validacija unosa (dupli email unos, pretraga po mejlu i pinu)</li>
        <li>Pretraga postojećih korisnika u evidenciji</li>
    </ul>
    </p>
    <hr>
    <div id="kalendar" style="margin-top:30px"></div>
    <div class="modal modal-fade in" id="modalRezervacije">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">
                        Rezervacija termina
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="rezervacijeNaDan"></div>
                    {!! Form::text('ime',null,['class'=>'form-control','placeholder'=>'Ime']) !!}
                    {!! Form::text('prezime',null,['class'=>'form-control','placeholder'=>'Prezime']) !!}
                    {!! Form::select('usluga',$usluge,[],['class'=>'form-control']) !!}
                    {!! Form::hidden('idPacijenta') !!}
                    <div id="pretraziPacijenta"></div>
                    <button id="postojeciPacijent" class="btn btn-primary">Evidentirani pacijent</button>
                    <button id="noviPacijent" class="btn btn-danger">Novi pacijent</button>
                    <div id="formaNovogPacijenta">
                        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail']) !!}
                        {!! Form::password('password',['class'=>'form-control']) !!}
                        {!! Form::text('telefon',null,['class'=>'form-control','placeholder'=>'Telefon']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Zatvori</button>
                    <button id="sacuvajRezervaciju" class="btn btn-danger">Sačuvaj rezervaciju</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            var token='{{csrf_token()}}';
            radnoVr.init(token);
            Rezervacija.init(token)
        });
        var Rezervacija={
            token:'',
            elementId:'#kalendar',
            init:function(_token){
                Rezervacija.token=_token;
                $(Rezervacija.elementId).calendar({
                    enableRangeSelection: true,
                    style: 'background',
                    mouseOnDay:function(e){
                        if(e.events.length>0){
                            var content = '';
                            for(var i in e.events) {
                                content += '<div class="event-tooltip-content">'
                                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                        + '</div>';
                            }
                            $(e.element).popover({
                                trigger: 'manual',
                                container: 'body',
                                html:true,
                                content: content
                            });
                            $(e.element).popover('show');
                        }
                    },
                    mouseOutDay: function(e) {
                        if(e.events.length > 0) {
                            $(e.element).popover('hide');
                        }
                    },
                    clickDay:function(e){
                        if(e.date<new Date().setHours(0,0,0,0)) return;
                        Rezervacija.prikaziModalRezervacije(e.events,e.date)
                        /*
                        if(e.events.length>0){
                            for(var i in e.events)
                                nerad.ukloniNeradniDan(e.events[i].id,e.date.getDate(), e.date.getMonth())

                        }else{
                            nerad.dodajNeradniDan(e.date.getDate(), e.date.getMonth())
                        }*/
                    },
                    dataSource: []
                });
            },
            prikaziModalRezervacije:function(rezervacije,datum){
                $('#modalRezervacije input[name=ime]').val('');
                $('#modalRezervacije input[name=prezime]').val('');
                $('#pretraziPacijenta').hide();
                $('#formaNovogPacijenta').hide();
                var htmlRezervacije='';
                for(var i in rezervacije)
                    htmlRezervacije+='<p>R'+i+'</p>';
                $('#rezervacijeNaDan').html(htmlRezervacije);
                $('#postojeciPacijent').click(function(){ Rezervacija.pretraziPacijenta() });
                $('#noviPacijent').click(function(){ Rezervacija.prikaziFormuNovogPacijenta() });
                $('#sacuvajRezervaciju').click(function(){ Rezervacija.sacuvajRezervaciju(datum) });
                $('#modalRezervacije').modal('show')
            },
            pretraziPacijenta:function(){
                $('#pretraziPacijenta').html('1111');
            },
            prikaziFormuNovogPacijenta:function(){
                $('#modalRezervacije input[name=email]').val('');
                $('#modalRezervacije input[name=password]').val('');
                $('#modalRezervacije input[name=telefon]').val('');
                $('#formaNovogPacijenta').fadeIn()
            },
            sacuvajRezervaciju:function(datum){
                $.post('/administracija/rezervacija',{
                    _token:         Rezervacija.token,
                    idPacijenta:    $('#modalRezervacije input[name=idPacijenta]').val(),
                    pacijent:{
                        ime:        $('#modalRezervacije input[name=ime]').val(),
                        prezime:    $('#modalRezervacije input[name=prezime]').val(),
                        email:      $('#modalRezervacije input[name=email]').val(),
                        password:   $('#modalRezervacije input[name=password]').val(),
                        telefon:    $('#modalRezervacije input[name=telefon]').val()
                    },
                    rezervacija:{
                        usluga_idevi:$('#modalRezervacije select[name=usluga] option:selected').val(),
                        termin:     datum
                    }
                },function(){
                    var event={
                        name: $('#modalRezervacije input[name=ime]').val()+' '+$('#modalRezervacije input[name=prezime]').val()+' ('+$('#modalRezervacije select[name=usluga]  option:selected').text()+')',
                        color:'#FF4A32',
                        startDate: new Date(datum.getFullYear(), datum.getMonth(), datum.getDate()),
                        endDate: new Date(datum.getFullYear(), datum.getMonth(), datum.getDate())
                    }
                    var dataSource = $(Rezervacija.elementId).data('calendar').getDataSource();
                    var newId = 0;
                    for(var i in dataSource) {
                        if(dataSource[i].id > newId) {
                            newId = dataSource[i].id;
                        }
                    }
                    newId++;
                    event.id = newId;
                    dataSource.push(event);
                    $(Rezervacija.elementId).data('calendar').setDataSource(dataSource);
                    $('#modalRezervacije').modal('hide');
                })
            }
        }
    </script>
@endsection