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
    <h1>Rezervacija termina</h1>
    <hr>
    <div id="kalendar" style="margin-top:30px"><center><i class="icon-spin6 animate-spin" style="font-size: 350%"></i></center></div>
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
                    <button id="postojeciPacijent" class="btn btn-primary">Evidentirani pacijent</button>
                    <button id="noviPacijent" class="btn btn-danger">Novi pacijent</button>
                    <hr>
                    <div id="formaPostojecegPacijenta">
                        {!! Form::email('email_pretraga',null,['class'=>'form-control','placeholder'=>'E-mail']) !!}
                        {!! Form::text('pin_pretraga',null,['class'=>'form-control','placeholder'=>'Korisnički pin']) !!}
                        <button id="pronadjiPacijenta" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Pronadji</button>
                        {!! Form::hidden('idPacijenta') !!}
                        <hr>
                    </div>
                    <div id="pretraziPacijenta"></div>
                    <div id="formaNovogPacijenta">
                        {!! Form::text('ime',null,['class'=>'form-control','placeholder'=>'Ime']) !!}
                        {!! Form::text('prezime',null,['class'=>'form-control','placeholder'=>'Prezime']) !!}
                        {!! Form::select('usluga',$usluge,[],['class'=>'form-control']) !!}
                        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail']) !!}
                        {!! Form::password('password',['class'=>'form-control']) !!}
                        {!! Form::text('telefon',null,['class'=>'form-control','placeholder'=>'Telefon']) !!}
                    </div>
                    {!! Form::text('termin',null,['class'=>'form-control','placeholder'=>'termin']) !!}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Zatvori</button>
                    <button id="sacuvajRezervaciju" class="btn btn-danger">Sačuvaj rezervaciju</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-fade in" id="modalDaLiSteSigurni">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Odustajem</button>
                    <button id="daSiguranSam" class="btn btn-danger">Siguran sam!</button>
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
                $.post('/administracija/rezervacije-ucitaj',{ _token:Rezervacija.token }, function(data){
                    data=JSON.parse(data);
                    var rezerve=[];
                    for(var i in data){
                        var datumm=new Date(data[i].termin);
                        datumm=new Date(datumm.getFullYear(),datumm.getMonth(),datumm.getDate());
                        rezerve.push({
                            id:data[i].id,
                            naziv:data[i].ime+' '+data[i].prezime,
                            usluga:data[i].usluga,
                            termin:data[i].termin,
                            dijagnoza:data[i].dijagnoza,
                            startDate:datumm,
                            endDate:datumm
                        })
                    }
                    $(Rezervacija.elementId).calendar({
                        enableRangeSelection: true,
                        mouseOnDay:function(e){
                            if(e.events.length>0){
                                var content = '';
                                for(var i in e.events) {
                                    content+='<div class="event-tooltip-content">'
                                                +'<div class="event-name" style="color:'+ e.events[i].color+'">'+e.events[i].naziv+' ('+e.events[i].usluga+')</div>'
                                            +'</div>';
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
                            //if(e.date<new Date().setHours(0,0,0,0)) return;
                            Rezervacija.prikaziModalRezervacije(e.events,e.date);
                        },
                        dataSource: rezerve
                    })
                })
                $('#modalRezervacije input[name=termin]').datetimepicker({ format: 'HH:mm' })
            },
            prikaziModalRezervacije:function(rezervacije,datum){
                $('#modalRezervacije input[name=ime]').val('');
                $('#modalRezervacije input[name=prezime]').val('');
                $('#modalRezervacije input[name=idPacijenta]').val('');
                $('#pretraziPacijenta').hide();
                $('#formaNovogPacijenta').hide();
                var htmlRezervacije='';
                for(var i in rezervacije)
                    htmlRezervacije+='<p class="rezervacija-'+rezervacije[i].id+'">'+rezervacije[i].naziv+' ('+rezervacije[i].usluga+') <i class="glyphicon glyphicon-time"></i>'+rezervacije[i].termin.substr(10)+(rezervacije[i].dijagnoza==0?' <button class="btn btn-xs btn-danger ponistiRezervaciju" data-toggle="tooltip" title="Poništi rezervaciju" data-id="'+rezervacije[i].id+'"><i class="glyphicon glyphicon-trash"></i></button> <button class="btn btn-xs btn-primary promijeniTermin" data-toggle="tooltip" title="Izmeni termin" data-id="'+rezervacije[i].id+'" data-termin="'+rezervacije[i].termin+'"><i class="glyphicon glyphicon-pencil"></i></button> <button class="btn btn-xs btn-success unesiDijagnozu" data-toggle="tooltip" title="Unesi dijagnozu nakon odrađenog posla" data-id="'+rezervacije[i].id+'"><i class="glyphicon glyphicon-ok"></i></button>':'')+'</p>';
                $('#rezervacijeNaDan').html(htmlRezervacije);
                $('#postojeciPacijent').click(function(){ Rezervacija.pretraziPacijenta() });
                $('#pronadjiPacijenta').click(function(){ Rezervacija.pretraziPacijenta(1) });
                $('#noviPacijent').click(function(){ Rezervacija.prikaziFormuNovogPacijenta() });
                $('#sacuvajRezervaciju').click(function(){
                    if(!$(this).data('u-toku') || $(this).data('u-toku')==0)
                        Rezervacija.sacuvajRezervaciju(datum)
                });
                $('[data-toggle=tooltip]').tooltip();
                $('.ponistiRezervaciju').click(function(){ Rezervacija.ponistiRezervaciju($(this).data('id')) })
                $('.promijeniTermin').click(function(){ Rezervacija.promijeniTermin($(this).data('id'),$(this).data('termin')) })
                $('.unesiDijagnozu').click(function(){ Rezervacija.unesiDijagnozu($(this).data('id')) })
                $('#modalRezervacije').modal('show')
            },
            pretraziPacijenta:function(pretraga){
                if(!pretraga){
                    $('#modalRezervacije input[name=email_pretraga]').val(''),
                    $('#modalRezervacije input[name=pin_pretraga]').val('')
                    $('#formaPostojecegPacijenta').slideDown();
                    $('#formaNovogPacijenta').fadeOut();
                    return
                }
                $.post('/administracija/rezervacija-pronadji-pacijenta',{
                    _token:Rezervacija.token,
                    email:$('#modalRezervacije input[name=email_pretraga]').val(),
                    pin:$('#modalRezervacije input[name=pin_pretraga]').val()
                },function(data){
                    data=JSON.parse(data);
                    if(data){
                        $('#formaPostojecegPacijenta').slideUp();
                        $('#modalRezervacije input[name=idPacijenta]').val(data['id']);
                        $('#pretraziPacijenta').html('<div class="alert alert-primary">'+data['ime']+' '+data['prezime']+'</div>');
                        $('#modalRezervacije input[name=ime]').val(data['ime']);
                        $('#modalRezervacije input[name=prezime]').val(data['prezime']);
                    }
                    else $('#pretraziPacijenta').html('<div class="alert alert-danger">U evidenciji ne postoji pacijent sa tim podacima. Proverite podatke i pokušajte ponovo.</div>');
                    $('#pretraziPacijenta').fadeIn()
                })
            },
            prikaziFormuNovogPacijenta:function(){
                $('#modalRezervacije input[name=email]').val('');
                $('#modalRezervacije input[name=password]').val('');
                $('#modalRezervacije input[name=telefon]').val('');
                $('#formaPostojecegPacijenta').slideUp();
                $('#formaNovogPacijenta').fadeIn()
            },
            sacuvajRezervaciju:function(datum){
                $('#sacuvajRezervaciju').data('u-toku',1);
                var formatiranDatum=datum.getFullYear()+'-'+(datum.getMonth()+1<10?'0':'')+(datum.getMonth()+1)+'-'+datum.getDate()+' '+$('#modalRezervacije input[name=termin]').val();
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
                        usluga_idevi:[$('#modalRezervacije select[name=usluga] option:selected').val()],
                        termin:     formatiranDatum
                    }
                },function(id){
                    var dataSource = $(Rezervacija.elementId).data('calendar').getDataSource();
                    dataSource.push({
                        id:id,
                        naziv: $('#modalRezervacije input[name=ime]').val()+' '+$('#modalRezervacije input[name=prezime]').val(),
                        usluga:$('#modalRezervacije select[name=usluga]  option:selected').text(),
                        termin:$('#modalRezervacije input[name=termin]').val(),
                        dijagnoza:0,
                        startDate: new Date(datum.getFullYear(), datum.getMonth(), datum.getDate()),
                        endDate: new Date(datum.getFullYear(), datum.getMonth(), datum.getDate())
                    });
                    $(Rezervacija.elementId).data('calendar').setDataSource(dataSource);
                    $('#modalRezervacije').modal('hide');
                    $('#sacuvajRezervaciju').data('u-toku',0);
                })
            },
            ponistiRezervaciju:function(id,ponisti){
                if(ponisti){
                    $.post('/administracija/rezervacija-ponisti',{
                        _token: Rezervacija.token,
                        id:id
                    },function(){
                        var dataSource = $(Rezervacija.elementId).data('calendar').getDataSource();
                        for(var i in dataSource){
                            if(dataSource[i].id == id){
                                dataSource.splice(i, 1);
                                break
                            }
                        }
                        $('#modalRezervacije #rezervacijeNaDan .rezervacija-'+id).remove();
                        $(Rezervacija.elementId).data('calendar').setDataSource(dataSource);
                        $('#modalDaLiSteSigurni').modal('hide');
                        return
                    })
                    return
                }
                $('#modalDaLiSteSigurni .modal-title').html('Poništi rezervaciju');
                $('#modalDaLiSteSigurni .modal-body').html('<h3 class="alert alert-danger">Nakon što rezervacija bude poništena, u evidenciju će biti unesena vrednost nerealizovana što negativno utiče na ocenu pacijenta na koga se odnosila. Da li ste sigurni da želite da poništite rezervaciju?</h3>');
                $('#modalDaLiSteSigurni #daSiguranSam').click(function(){ Rezervacija.ponistiRezervaciju(id,1) });
                $('#modalDaLiSteSigurni').modal('show');
            },
            promijeniTermin:function(id,stariTermin,noviTermin){
                if(noviTermin){
                    noviTermin=$('#izmeniTermin').data("DateTimePicker").viewDate().format('YYYY-MM-DD HH:mm').toString();
                    $.post('/administracija/rezervacija-promijeni-termin',{
                        _token: Rezervacija.token,
                        id:id,
                        termin:noviTermin
                    },function(){
                        var dataSource = $(Rezervacija.elementId).data('calendar').getDataSource();
                        for(var i in dataSource){
                            if(dataSource[i].id == id){
                                dataSource[i].termin=noviTermin;
                                noviTermin=new Date(noviTermin);
                                noviTermin=new Date(noviTermin.getFullYear(),noviTermin.getMonth(),noviTermin.getDate());
                                dataSource[i].startDate=noviTermin;
                                dataSource[i].endDate=noviTermin;
                                break
                            }
                        }
                        $(Rezervacija.elementId).data('calendar').setDataSource(dataSource);
                        $('#modalRezervacije').modal('hide');
                        $('#modalDaLiSteSigurni').modal('hide');
                        return
                    })
                    return
                }
                $('#modalDaLiSteSigurni .modal-title').html('Promeni termin');
                $('#modalDaLiSteSigurni .modal-body').html(
                        '<h3>Izaberite novi termin za izabranu rezervaciju</h3>' +
                        '<div style="overflow:hidden;">' +
                            '<div class="form-group">' +
                                '<div class="row">' +
                                    '<div class="col-md-8">' +
                                        '<div id="izmeniTermin"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>');
                $('#izmeniTermin').datetimepicker({
                    inline: true,
                    sideBySide: true,
                    format: 'YYYY-MM-DD HH:mm',
                    defaultDate: stariTermin
                });
                $('#modalDaLiSteSigurni #daSiguranSam').click(function(){ Rezervacija.promijeniTermin(id,null,1) });
                $('#modalDaLiSteSigurni').modal('show')
            },
            unesiDijagnozu:function(id,dijagnoza){
                if(dijagnoza){
                    $.post('/administracija/rezervacija-dijagnoza',{
                        _token: Rezervacija.token,
                        id:id,
                        dijagnoza:$('#dijagnoza').val()
                    },function(){
                        var dataSource = $(Rezervacija.elementId).data('calendar').getDataSource();
                        for(var i in dataSource){
                            if(dataSource[i].id == id){
                                dataSource[i].dijagnoza=1;
                                $('.ponistiRezervaciju[data-id='+id+']').remove();
                                $('.promijeniTermin[data-id='+id+']').remove();
                                $('.unesiDijagnozu[data-id='+id+']').remove();
                                break
                            }
                        }
                        $(Rezervacija.elementId).data('calendar').setDataSource(dataSource);
                        $('#modalDaLiSteSigurni').modal('hide');
                        return
                    })
                    return
                }
                $('#modalDaLiSteSigurni .modal-title').html('Unesi dijagnozu');
                $('#modalDaLiSteSigurni .modal-body').html('<h3>Unesite šta ste sve uradili i lična zapažanja, a sve to će biti vidljivo u pacijentovom zubnom kartonu.</h3><textarea id="dijagnoza" class="form-control"></textarea>');
                $('#modalDaLiSteSigurni #daSiguranSam').click(function(){ Rezervacija.unesiDijagnozu(id,1) });
                $('#modalDaLiSteSigurni').modal('show')
            }
        }
    </script>
@endsection