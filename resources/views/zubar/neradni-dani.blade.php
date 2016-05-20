@extends('zubar.master')
@section('container')
    {!!Html::style('/css/year-calendar.css')!!}
    {!!Html::script('/js/year-calendar.js')!!}
    <h1>Neradni dani <button id="sacuvajPromjene" class="btn btn-warning"><i class="glyphicon glyphicon-floppy-disk"></i> Sačuvaj promene</button></h1>
    <hr>
    <div id="kalendar" style="margin-top:30px"></div>
    <script>
        var nerad={
            currentYear: new Date().getFullYear(),
            datumi: [],
            elementID: '#kalendar',
            token:'',
            init:function(_datumi,_token){
                $('#sacuvajPromjene').click(function(){ nerad.sacuvajPromjene() });
                nerad.datumi=_datumi;
                nerad.token=_token;
                $(nerad.elementID).calendar({
                    enableRangeSelection: true,
                    style: 'background',
                    clickDay:function(e){
                        if(e.events.length > 0){
                            for(var i in e.events)
                                nerad.ukloniNeradniDan(e.events[i].id,e.date.getDate(), e.date.getMonth())

                        }else{
                            nerad.dodajNeradniDan(e.date.getDate(), e.date.getMonth())
                        }
                    },
                    dataSource: nerad.generisiDataSource()
                });
            },
            generisiDataSource:function(){
                var out=[];
                for(var i=0, max=nerad.datumi.length; i<max; i++)
                    out.push({
                        id:i,
                        name:'Neradni dan',
                        color:'#FF4A32',
                        startDate: new Date(nerad.currentYear, nerad.datumi[i][1], nerad.datumi[i][0]),
                        endDate: new Date(nerad.currentYear, nerad.datumi[i][1], nerad.datumi[i][0])
                    })
                return out
            },
            dodajNeradniDan:function(datum, mjesec){
                var event={
                    name: 'Neradni dan',
                    color:'#FF4A32',
                    startDate: new Date(nerad.currentYear, mjesec, datum),
                    endDate: new Date(nerad.currentYear, mjesec, datum)
                }
                var dataSource = $(nerad.elementID).data('calendar').getDataSource();
                var newId = 0;
                for(var i in dataSource) {
                    if(dataSource[i].id > newId) {
                        newId = dataSource[i].id;
                    }
                }
                newId++;
                event.id = newId;
                nerad.datumi.push([datum,mjesec]);
                dataSource.push(event);
                $(nerad.elementID).data('calendar').setDataSource(dataSource);
            },
            ukloniNeradniDan:function(id, datum, mjesec){
                var dataSource = $(nerad.elementID).data('calendar').getDataSource();
                for(var i in dataSource) {
                    if(dataSource[i].id == id) {
                        dataSource.splice(i, 1);
                        for(var j in nerad.datumi)
                            if(nerad.datumi[j][0]==datum && nerad.datumi[j][1]==mjesec){
                                nerad.datumi.splice(j,1);
                                break
                            }
                        break
                    }
                }
                $(nerad.elementID).data('calendar').setDataSource(dataSource);
            },
            sacuvajPromjene:function(){
                $.post('/administracija/neradni-dani-sacuvaj',{
                    _token:nerad.token,
                    neradni_dani:JSON.stringify(nerad.datumi)
                },function(){
                    $('#poruka').hide();
                    $('#sacuvajPromjene').after('<div id="poruka" class="alert alert-success">Uspešno ste sačuvali promene!</div>')
                })
            }
        }
        $(function(){ nerad.init({!! $neradni_dani?$neradni_dani:json_encode([]) !!},'{{csrf_token()}}') });
    </script>
@endsection