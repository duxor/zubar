@extends('zubar.master')
@section('container')
    {!!Html::style('/css/year-calendar.css')!!}
    {!!Html::style('/css/datetimepicker.css')!!}
    {!!Html::script('/js/year-calendar.js')!!}
    {!!Html::script('/js/moment.js')!!}
    {!!Html::script('/js/datetimepicker.js')!!}
    <h1>Neradni dani <button id="sacuvajPromjene" class="btn btn-warning"><i class="glyphicon glyphicon-floppy-disk"></i> Sačuvaj promene</button></h1>
    <hr>
    <div id="kalendar" style="margin-top:30px"></div>
    <div class="modal modal-fade in" id="event-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">
                        Pregled događaja
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
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
                    colors:"#45A597",
                    mouseOnDay: function(e){
                        if(e.events.length > 0){
                            var content = '';
                            for(var i in e.events){
                                content += '<div class="event-tooltip-content">'
                                        + '<b>' + e.events[i].vreme + '</b>'
                                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].naslov + '</div>'
                                        + '<div class="event-location">' + e.events[i].mesto + '</div>'
                                        + '</div><hr>'
                            }
                        }
                    },
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
                        startDate: new Date(nerad.currentYear, nerad.datumi[i][1], nerad.datumi[i][0]),
                        endDate: new Date(nerad.currentYear, nerad.datumi[i][1], nerad.datumi[i][0])
                    })
                return out
            },
            dodajNeradniDan:function(datum, mjesec){
                var event={
                    name: 'Neradni dan',
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