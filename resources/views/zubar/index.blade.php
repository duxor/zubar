@extends('zubar.master')
@section('container')
    <h1>ZuboPanel</h1>
    <hr>
    <div class="col-sm-4">
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
                    {!! Form::button('Ukloni sve',['class'=>'btn btn-success','id'=>'izbrisiSve']) !!}
                    <div id="radnoVrijemeSacuvanoModal"></div>
                    <div id="radnoVrijemeForma">
                        {!! Form::select('dan0',['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],0,['class'=>'form-control']) !!}
                        {!! Form::select('dan1',['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],0,['class'=>'form-control']) !!}
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
        $(function(){
            radnoVr.init();
            /*$('.vreme').click(function(){
                $('#editVremena').remove();
                $(this).after('<div id="editVremena" style="overflow:hidden;"><div class="form-group"><div class="row"><div class="col-md-8"><div id="datetimepicker12" value="2012-05-15 21:05"></div></div></div></div><button class="btn btn-primary" onclick="sacuvajVreme()"><i class="glyphicon glyphicon-floppy-disk"></i></button></div>');

                $('#datetimepicker12').datetimepicker({
                    inline: true,
                    sideBySide: true,
                    format: 'HH:mm',
                    defaultDate: '2016-05-17 '+$(this).html()
                });
            });*/
        });
        function sacuvajVreme(){
            $('.timepicker-hour').html();
            $('.timepicker-minute').html();

            console.log($('.timepicker-hour').html(),$('.timepicker-minute').html())
        }
        var radnoVr={
            token:'{{csrf_token()}}',
            sacuvajNiz:[],
            privremenoSacuvajNiz:[],
            dani:['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],
            init:function(){
                $.post('/administracija/index-init',{_token:radnoVr.token},function(data){
                    radnoVr.sacuvajNiz=JSON.parse(data);
                    $('#radnoVrijemeSacuvano').html(radnoVr.prikazi);
                    $('.radnoVrijeme').click(function(){
                        radnoVr.privremenoSacuvajNiz=radnoVr.sacuvajNiz;
                        $('#radnoVrijemeSacuvanoModal').html($('#radnoVrijemeSacuvano').html());
                        $('#radnoVrijeme').modal('show')
                    });
                    $('#dodajRadnoVrijeme').click(function(){
                        radnoVr.dodajRadnoVrijeme()
                    });
                    $('#izbrisiSve').click(function(){
                        radnoVr.ukloniSvePrethodno()
                    });
                    $('.sacuvajPromjene').click(function(){
                        radnoVr.sacuvajPodatke()
                    });
                })
            },
            prikazi:function(){
                var ispis='';
                for(var i=0,max=radnoVr.sacuvajNiz.length; i<max; i++)
                    ispis+=radnoVr.vremenskiOkvir(radnoVr.sacuvajNiz[i].opseg,radnoVr.sacuvajNiz[i].vrijeme);
                return ispis;
            },
            vremenskiOkvir:function(danOpseg,vrijemeOpseg){
                return '<div class="col-xs-12">'+
                            '<div class="col-xs-7">'+
                                radnoVr.dani[danOpseg[0]]+(danOpseg[1]?'-'+radnoVr.dani[danOpseg[1]]:'')+
                            '</div>'+
                            '<div class="col-xs-5">'+
                                vrijemeOpseg[0]+'-'+vrijemeOpseg[1]+
                            '</div>'+
                        '</div>';
            },
            dodajRadnoVrijeme:function(){
                var novi={
                    opseg:[$('select[name=dan0]').val(),$('select[name=dan1]').val()],
                    vrijeme:['11:11','22:22']
                };
                radnoVr.privremenoSacuvajNiz.push(novi);
                $('#radnoVrijemeSacuvanoModal').append(radnoVr.vremenskiOkvir(novi.opseg,novi.vrijeme));
            },
            sacuvajPodatke:function(){
                $.post('/administracija/radno-vrijeme-sacuvaj',
                        {
                            _token:radnoVr.token,
                            radno_vrijeme:JSON.stringify(radnoVr.privremenoSacuvajNiz)
                        }
                        ,function(){console.log(radnoVr.privremenoSacuvajNiz);
                            radnoVr.sacuvajNiz=radnoVr.privremenoSacuvajNiz;
                            radnoVr.privremenoSacuvajNiz=[];
                            $('#radnoVrijemeSacuvano').html(radnoVr.prikazi());
                            $('#radnoVrijeme').modal('hide')
                })
            },
            ukloniSvePrethodno:function(){
                radnoVr.privremenoSacuvajNiz=[];
                $('#radnoVrijemeSacuvanoModal').html('');
            }
        }
    </script>
@endsection